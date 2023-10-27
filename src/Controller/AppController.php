<?php
declare(strict_types=1);

namespace Tusk\Controller;

use App\Controller\AppController as BaseController;
use Tusk\Handlers\FieldHandler;
use Cake\Http\Response;
use Tusk\Model\Table\ApplicationsTable;
use Tusk\Model\ApplicationTrait;
use Tusk\Model\Table\RolesTable;
use Tusk\Handlers\FilterHandler;
use Cake\ORM\Exception\MissingTableClassException;

class AppController extends BaseController
{
	use ApplicationTrait;
	use FilterHandler;

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
		if (!empty($this->user)) {
			$this->set(['user' => $this->user]);
		}

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
		return $this->Table;
	}

	public function noAccess() {
		$this->response = $this->response->withStatus(403);
		$this->set(['uri' => $this->request->getenv('REQUEST_URI')]);
		$this->useTable = false;
		
		try {
			return $this->render('Tusk.App/no_access');
		} catch (MissingTemplateException $exception) {
			if (Configure::read('debug')) {
				throw $exception;
			}
			throw new NotFoundException();
		}
	}

	public function compose($entry, $params = []) {
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
		
			$check = $this->save($entry, $params, $data);
			if ($check) {
				return $this->redirect($params['redirect']);
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

	public function save($entry, $params, $data) {
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
			$this->Flash->success($params['success'], ['plugin' => 'Tusk']);
			return true;
		}

		$this->Flash->error($params['error']);
		return false;
	}

	public function render(?string $template = null, ?string $layout = null): Response {
		if (method_exists($this, 'preRender')) {
			$this->preRender();
		}

		$this->viewBuilder()->addHelper('Tusk.Fields');

		if ($this->useTable) {
			// if (!$this->get('tableName')) {
				$tableName = $this->Table->getTable();
				$this->set([
					'tableName' => $tableName
				]);
			// }
			
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
