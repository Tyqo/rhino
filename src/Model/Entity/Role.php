<?php
// src/Model/Entity/Article.php
namespace Tusk\Model\Entity;

use Cake\ORM\Entity;

class Role extends Entity
{
	protected array $_virtual = [
		'accessData'
	];

	protected function _getAccessData() {
		if (empty($this->access)) {
			return null;
		}
		
		return json_decode($this->access, true);
	}
}