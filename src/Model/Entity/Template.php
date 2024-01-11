<?php
// src/Model/Entity/Article.php
namespace Rhino\Model\Entity;

use Cake\ORM\Entity;

class Template extends Entity {
	protected array $_virtual = [
		'element'
	];

	public function _getElement() {
		return str_replace('.php', '', $this->file);
	}
}
