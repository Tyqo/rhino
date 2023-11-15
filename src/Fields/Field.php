<?php

declare(strict_types=1);

namespace Rhino\Fields;

use Rhino\Model\ApplicationTrait;
use Cake\View\StringTemplateTrait;
use Cake\Core\InstanceConfigTrait;
use Cake\ORM\TableRegistry;

class Field {
	use ApplicationTrait;
	use InstanceConfigTrait;
	use StringTemplateTrait;

	/**
	 * field
	 *
	 * @var object
	 */
	protected object $field;

	/**
	 * options
	 *
	 * @var array
	 */
	protected array $options;

	/**
	 * Default config for this class
	 *
	 * @var array<string, mixed>
	 */
	protected array $_defaultConfig = [
		'templates' => [
			'tag' => '<{{tag}}{{attrs}}>{{content}}</{{tag}}>',
			'input' => '<input{{attrs}}/>',
			'label' => '<label{{attrs}}>{{content}}</label>',
		]
	];

	/**
	 * Undocumented variable
	 *
	 * @var object
	 */
	protected object $Templater;

	public function __construct(?object $field = null) {
		if (isset($field)) {
			$this->field = $field;

			if (isset($field->options)) {
				$this->options = $field->options;
			}
		}

		$this->Templater = $this->templater();
	}

	/**
	 * getOptions
	 *
	 * load additional information for possible Options.
	 * Used for Select Application Options.
	 * 
	 * @return array
	 */
	public function getOptions() {
		return [];
	}

	/**
	 * load
	 * 
	 * Executed when loading the input field.
	 * Executed before rendering.
	 *
	 * @param  [mixed] $value
	 * @return array
	 */
	public function load(mixed $value) {
		$displayOptions = [];
		return $displayOptions;
	}

	/**
	 * display
	 *
	 * Executed before displaying the value of the Field.
	 * can be used to set alternative output.
	 * 
	 * @param  mixed       $value
	 * @param  object|null $entity
	 * @return void
	 */
	public function display(mixed $value, ?object $entity) {
		return $value;
	}

	/**
	 * save
	 * 
	 * Will be executed before saving the value / entity.
	 * Used to edit the saved value.
	 *
	 * @param  string|mixed       $value
	 * @param  object|array|null $entity
	 * @return void
	 */
	public function save(mixed $value, array $entity) {
		return $value;
	}

	/**
	 * getTable
	 * 
	 * Get the Existing Table Class or use the Rhino default.
	 *
	 * @param  string $tableName
	 * @return \Cake\ORM\Table
	 */
	protected function getTable($tableName) {
		try {
			$Table = TableRegistry::getTableLocator()->get(ucfirst($tableName));
		} catch (\Throwable $th) {
			$Table = TableRegistry::getTableLocator()->get('Rhino.Tables');
			$Table->setTable($tableName);
		}

		return $Table;
	}

	/**
	 * getLocal
	 * 
	 * Gets the local for the Client.
	 * Used the display Dates according to the location of the client.
	 *
	 * @return string
	 */
	protected function getLocal() {
		return locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
	}
}
