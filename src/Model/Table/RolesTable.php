<?php
declare(strict_types=1);

namespace Tusk\Model\Table;

use Cake\ORM\Table;

class RolesTable extends Table {

	public $accessTypes = [
		'view',
		'edit',
		'add',
		'delete'
	];

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('tusk_roles');
		$this->setDisplayField('id');
		$this->setPrimaryKey('id');

		$this->addBehavior('Timestamp');

		$this->belongsToMany('Users', ['className' => 'Tusk.Users']);
		$this->hasMany('Applications', ['className' => 'Tusk.Applications']);
	}

	public function beforeMarshal($event, $data, $options) {
		$blacklist = ["id", "name", "access", "modified", "created"];
		$access = [];
		foreach ($data as $key => $value) {
			$access[$key] = $value;
		}
		
		foreach ($blacklist as $value) {
			if (isset($access[$value])) {
				unset($access[$value]);
			}
		}
		
		foreach ($access as $key => $value) {
			unset($data[$key]);
		}

		$data['access'] = json_encode($access);
	}

	public function checkGroupRights($id, $app, $type = null) {
		$role = $this->get($id);
		$rights = $this->getRights($role->accessData, $app);

		if (empty($type)) {
			return $rights;
		}

		if (!in_array($type, $this->accessTypes)) {
			return true;
		}

		return in_array($type, $rights);
	}

	private function getRights($access, $app) {
		$rights = [];

		foreach ($this->accessTypes as $type) {
			$param = $app . '_' . $type;

			if (!isset($access[$param])) {
				$rights[] = $type;
				continue;
			}

			if ($access[$param] == '1') {
				$rights[] = $type;
			}
		}

		return $rights;
	}
}