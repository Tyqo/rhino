<?php
// src/Model/Entity/Article.php
namespace Tusk\Model\Entity;

use Tusk\Model\Entity\AppEntity;

class Table extends AppEntity {
	// protected $_virtual = array_merge([
	// 	'accessData'
	// ], parent::$this->_virtual);
	

	protected function _getAccessData() {
		// echo '<pre>';
		// var_dump(get_class_methods($this));
		// die;
		if (empty($this->access)) {
			return null;
		}

		return json_decode($this->access, true);
	}
}
