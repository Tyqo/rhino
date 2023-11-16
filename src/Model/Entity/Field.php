<?php
// src/Model/Entity/Article.php
namespace Rhino\Model\Entity;

use Rhino\Model\Entity\AppEntity;

class Field extends AppEntity {

	protected array $_virtual = [
		'options'
	];

	protected function _getOptions() {
		if (isset($this->conf)) {
			return $this->conf;
		}
		return json_decode($this->settings, true);
	}

	public function setOptions($options) {
		$this->conf = $options;
		// $this->options = $options;
	}
}
