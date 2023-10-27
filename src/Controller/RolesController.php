<?php
declare(strict_types=1);

namespace Tusk\Controller;

use Tusk\Controller\AppController;

/**
 * Tables Controller
 *
 * @method \Tusk\Model\Entity\Table[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RolesController extends AppController {
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

	public function preCompose() {
		$applications = $this->Roles->Applications->getList(["phinxlog", "tusk_phinxlog"], false);
		$this->set([
			'accessTypes' => $this->Roles->accessTypes,
			'applications' => $applications
		]);
	}
}