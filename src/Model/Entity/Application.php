<?php
// src/Model/Entity/Article.php
namespace Rhino\Model\Entity;

use Cake\ORM\Entity;

class Application extends Entity
{
	protected array $_virtual = [
		'overviewData'
	];

	protected function _getOverviewData() {
		if (empty($this->overview_fields)) {
			return [];
		}

		return json_decode($this->overview_fields, true);
	}
}
