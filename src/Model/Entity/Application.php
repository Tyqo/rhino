<?php
// src/Model/Entity/Article.php
namespace Tusk\Model\Entity;

use Cake\ORM\Entity;

class Application extends Entity
{
	protected array $_virtual = [
		'overviewData'
	];

	protected function _getOverviewData() {
		if (empty($this->overviewFields)) {
			return [];
		}
		
		return json_decode($this->overviewFields, true);
	}
}