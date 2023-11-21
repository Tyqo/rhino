<?php
declare(strict_types=1);

namespace Rhino\Controller;

use App\Controller\AppController as BaseController;
use Rhino\Handlers\FieldHandler;
use Cake\Http\Response;
use Rhino\Model\Table\ApplicationsTable;
use Rhino\Model\ApplicationTrait;
use Rhino\Model\Table\RolesTable;
use Rhino\Handlers\FilterHandler;
use Cake\ORM\Exception\MissingTableClassException;

class AppController extends BaseController {
	use ApplicationTrait;
	use FilterHandler;

	/**
	 * fieldConfig
	 * 
	 * Add a Config for Field operations on Table
	 *
	 * @var array
	 */
	protected $fieldConfig = [];

	public function initialize(): void
    {
        parent::initialize();
		$this->loadComponent('Authentication.Authentication');
		$this->loadComponent('Authorization.Authorization');
		$this->user = $this->Authentication->getIdentity();

		$this->useTable = false;
		
		try {
			$this->Table = $this->fetchTable();
			$this->useTable = true;
		} catch (\Throwable $th) {}

		$this->bootstrap();

		$this->FieldHandler = new FieldHandler();
		$this->Apps = new ApplicationsTable();
		$this->Session = $this->request->getSession();
    }
	
	private function bootstrap() {
		if ($this->useTable && !empty($this->user) && !empty($this->user->role_id)) {
			$action = $this->request->getParam('action');
			$role = $this->user->role_id;
			$app = $this->Table->getTable();

			if ($app == "tables") {
				$pass = $this->request->getParam('pass');
				$app = $pass[0];
			}

			$Roles = new RolesTable();
			$right = $Roles->checkGroupRights($role, $app, $action);

			if (!$right) {
				$this->setAction('noAccess');
			}

			$rights = $Roles->checkGroupRights($role, $app);
			$this->set(['rights' => $rights]);
		}
	}

	public function setTable($tableName) {
		$alias = ucfirst($tableName);
		if (preg_match('/^rhino\_(.*)/', $tableName, $matches)) {
			$alias = 'Rhino.' . ucfirst($matches[1]);
		}
		$this->getTableLocator()->setConfig($alias, ['table' => $tableName]);
		try {
			$this->Table = $this->fetchTable($alias);
		} catch (MissingTableClassException $th) {
			$this->Table = $this->Tables->setTable($tableName);
		}
	}

	public function getTable($tableName = null) {
		if (!isset($this->Table)) {
			$this->setTable($tableName);
		}

		if (isset($this->Table->fieldConfig)) {
			$this->FieldHandler->setConfig($this->Table->fieldConfig);
		}

		return $this->Table;
	}

	public function noAccess() {
		$this->response = $this->response->withStatus(403);
		$this->set(['uri' => $this->request->getenv('REQUEST_URI')]);
		$this->useTable = false;
		
		try {
			return $this->render('Rhino.App/no_access');
		} catch (MissingTemplateException $exception) {
			if (Configure::read('debug')) {
				throw $exception;
			}
			throw new NotFoundException();
		}
	}

	/**
	 * compose
	 * 
	 * route the add and edit to the same template and handel save.
	 * use preCompose for shared operations, and preSave for operations before save.
	 * 
	 *
	 * @param  object $entry
	 * @param  array  $params
	 * @return Cake\Http\Response
	 */
	public function compose(object $entry, array $params = []) {
		$action = $this->request->getParam('action');
		$_params = [
			'success' => __('The entry has been saved.'),
			'error' => __('The entry could not be saved. Please, try again.'),
			'entity' => 'entry',
			'redirect' => ['action' => 'index'],
			'action' => $action
		];
		$params = array_merge($_params, $params);

		if (method_exists($this, 'preCompose')) {
			$pass = $this->request->getParam('pass');
			$return = $this->preCompose($entry, ...$pass);
			if (!empty($return)) {
				$entry = $return;
			}
		}

		if ($this->request->is(['patch', 'post', 'put'])) {
			$data = $this->request->getData();

			if (isset($this->Table->fieldConfig)) {
				$this->FieldHandler->setConfig($this->Table->fieldConfig);
			}

			$check = $this->save($entry, $params, $data);
			if ($check) {
				$redirect =	$this->redirect($params['redirect']); 
				return $redirect;
			}
		}

		$positions = $this->getFilterPosition($entry->id);

		$this->set([
			$params['entity'] => $entry,
			'action' => $action,
			'nextId' => $positions['next'],
			'prevId' => $positions['prev']
		]);

		try {
			return $this->render('compose');
		} catch (MissingTemplateException $exception) {
			if (Configure::read('debug')) {
				throw $exception;
			}
			throw new NotFoundException();
		}
	}

	/**
	 * preCompose
	 * 
	 * Shared function between add and edit.
	 *
	 * @param  object $entity
	 * @param  mixed  ...$params
	 * @return void|object
	 */
	// Todo: should probably be an Event
	public function preCompose(object $entity, mixed ...$params) {
		return null;
	}

	/**
	 * preSave
	 * 
	 * Shared save Operations.
	 *
	 * @param  array $data
	 * @param  array $params
	 * @return array
	 */
	public function preSave(array $data, ?array $params) {
		return $data;
	}

	/**
	 * save
	 *
	 * @param  object $entry
	 * @param  array  $params
	 * @param  array  $data
	 * @return void
	 */
	public function save(object $entry, array $params, array $data) {
		$tableName = $this->Table->getTable();
		$data = $this->FieldHandler->setFields($tableName, $data);
		
		if (method_exists($this, 'preSave')) {
			$data = $this->preSave($data, $params);
			
			if ($data == false) {
				return false;
			}
		}

		$entry = $this->Table->patchEntity($entry, $data);

		if ($this->Table->save($entry)) {
			$this->Flash->success($params['success'], ['plugin' => 'Rhino']);
			return true;
		}

		$this->Flash->error($params['error']);
		return false;
	}

	/**
	 * render
	 *
	 * @param  string|null $template
	 * @param  string|null $layout
	 * @return Response
	 */
	public function render(?string $template = null, ?string $layout = null): Response {
		if (method_exists($this, 'preRender')) {
			$this->preRender();
		}

		if ($this->useTable) {
			$tableName = $this->Table->getTable();
			$this->set([
				'currentTable' => $tableName
			]);
			
			if (isset($this->Table->fieldConfig)) {
				$this->FieldHandler->setConfig($this->Table->fieldConfig);
			}
			
			$fields = $this->FieldHandler->getFields($tableName);
			$app = $this->Apps->getByName($tableName);
			
			if (empty($app)) {
				$app = $this->Apps->newEntity(['name' => $tableName]);
			}

			$this->set([
				'fields' => $fields,
				'app' => $app
			]);
		}

		return parent::render($template, $layout);
	}
}
