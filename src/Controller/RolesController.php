<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\RhinoController;

/**
 * Tables Controller
 *
 * @method \Rhino\Model\Entity\Table[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends RhinoController {
	public function index() {
		$roles = $this->paginate($this->Roles);
		$this->set(compact('roles'));
	}

	public function add() {
		$entry = $this->Roles->newEmptyEntity();
		$this->set(['title' => 'Add']);
		$this->compose($entry);
	}

	public function edit($id) {
		$entry = $this->Roles->get($id);
		$this->set(['title' => 'Edit']);
		$this->compose($entry);
	}

	public function preCompose(object $entity, mixed ...$params) {
		$applications = $this->Roles->Applications->getList(["phinxlog", "rhino_phinxlog"], false);
		$this->set([
			'accessTypes' => $this->Roles->accessTypes,
			'applications' => $applications
		]);
	}
}