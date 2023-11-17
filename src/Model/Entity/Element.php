<?php
// src/Model/Entity/Article.php
namespace Rhino\Model\Entity;

use Cake\ORM\Entity;

class Element extends Entity {
	protected array $_virtual = [
		'elementName'
	];

	public function _getElementName() {
		return str_replace('.php', '', $this->element);
	}
}
