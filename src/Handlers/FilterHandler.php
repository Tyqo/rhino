<?php
namespace Tusk\Handlers;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query;
use InvalidArgumentException;

Trait FilterHandler {
	public $operators =	[
		"contains",
		"contains not",
		"==",
		"!=",
		"<",
		">",
		"<=",
		">=",
		"empty",
		"not empty",
	];

	public function filter($query) {
		$filter = $this->getFilter();
		$order = $this->getOrder();

		return $query->where($filter)->order($order);
	}

	public function paginateFilter($query) {
		$query = $this->filter($query);

		try {
			$data = $this->paginate($query);
		} catch (InvalidArgumentException $th) {
			$tableName = $this->Table->getTable();
			$this->deleteFilter($tableName);
			$data = $this->paginate($this->Table);
			$this->Flash->error($th->getMessage());
		}

		return $data;
	}

	public function setFilter($tableName) {
		if ($this->request->is("post")) {
			$data = $this->request->getData();
			$session = $this->Session->read('filter');
			
			$field = $data["field"];
			$operator = $data["operator"];
			$query = $data["query"];
			
			$session[$tableName] = [
				'field' => $field,
				'operator' => $operator,
				'query' => $query
			];
			
			$this->Session->write('filter', $session);
		}

		return $this->redirect(['action' => 'index', $tableName]);
	}

	public function clearFilter($tableName) {
		$this->deleteFilter($tableName);
		return $this->redirect(['action' => 'index', $tableName]);
	}
	
	public function deleteFilter($tableName) {
		$session = $this->Session->read('filter');

		if (isset($session[$tableName])) {
			unset($session[$tableName]);
		}

		$this->Session->write('filter', $session);
	}

	public function getFilter() {
		$filter = null;
		$field = '';
		$operator = '';
		$query = '';

		if (!$this->useTable) {
			return $filter;
		}

		$tableName = $this->Table->getTable();
		$columns = $this->FieldHandler->listColumns($tableName);
		$session = $this->Session->read('filter');

		if (isset($session[$tableName])) {
			$tableSettings = $session[$tableName];
			$field = $tableSettings['field'];
			$operator = $tableSettings['operator'];
			$query = $tableSettings['query'];
			
			$filter = $this->applyFilter(
				$columns[$field],
				$this->operators[$operator],
				$query
			);
		}
		
		$this->set([
			'field' => $field,
			'operator' => $operator,
			'query' => $query,
			'operators' => $this->operators
		]);
		
		return $filter;
	}

	public function getOrder() {
		$order = [];
		$sort = 'id';
		$direction = 'asc';
		$tableName = $this->Table->getTable();
		$session = $this->Session->read('order');

		if ($this->request->is('get')) {
			$data = $this->request->getQuery();

			if (isset($data['sort']) && isset($data['direction'])) {
				$sort = $data['sort'];
				$direction = $data['direction'];

				$session[$tableName] = [
					'sort' => $sort,
					'direction' => $direction
				];

				$this->Session->write('order', $session);
			}
		}

		if (isset($session[$tableName])) {
			$tableSettings = $session[$tableName];
			
			$sort = $tableSettings['sort'];
			$direction = $tableSettings['direction'];

			$order = [$sort => $direction];
		}

		$this->set([
			'sort' => $sort,
			'direction' => $direction,
		]);

		return $order;
	}

	public function getFilterPosition($id) {
		$this->getTable();

		$query = $this->filter($this->Table->find())->all();
		$data = $query->toList();

		$position = array_search($id, array_column($data, 'id'));

		$positions = [
			'next' => isset($data[$position + 1]['id']) ? $data[$position + 1]['id'] : null,
			'prev' => isset($data[$position - 1]['id']) ? $data[$position - 1]['id'] : null,
		];

		return $positions;
	}

	private function applyFilter($field, $operator, $query = null) {
		$filter = null;

		switch ($operator) {
			case 'contains':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					if (!is_numeric($query)) {
						$query = "%$query%";
					}
					return $exp->like($field, $query);
				};
				break;

			case 'contains not':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					if (!is_numeric($query)) {
						$query = "%$query%";
					}
					return $exp->notLike($field, $query);
				};
				break;

			case '==':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					return $exp->eq($field, $query);
				};
				break;

			case '!=':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					return $exp->notEq($field, $query);
				};
				break;

			case '<':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					return $exp->lt($field, $query);
				};
				break;

			case '>':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					return $exp->gt($field, $query);
				};
				break;

			case '<=':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					return $exp->lte($field, $query);
				};
				break;

			case '>=':
				$filter = function (QueryExpression $exp, Query $q) use ($field, $query) {
					return $exp->gte($field, $query);
				};
				break;

			case 'empty':
				$filter = function (QueryExpression $exp, Query $q) use ($field) {
					return $exp->isNull($field);
				};
				break;

			case 'not empty':
				$filter = function (QueryExpression $exp, Query $q) use ($field) {
					return $exp->isNotNull($field);
				};
				break;
		}

		return $filter;
	}
}
?>