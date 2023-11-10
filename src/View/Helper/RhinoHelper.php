<?php
/* src/View/Helper/LinkHelper.php */

namespace Rhino\View\Helper;

use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Rhino\Handlers\FieldHandler;

class RhinoHelper extends Helper {
	use StringTemplateTrait;

	/**
	 * Default config for this class
	 *
	 * @var array<string, mixed>
	 */
	protected array $_defaultConfig = [
		'templates' => [
			'tag' => '<{{tag}}{{attrs}}>{{content}}</{{tag}}>',
			'sectionHeader' => '<div class="section-header"><h3{{attrs}}>{{content}}</h3></div>',
			'control' => '<div>{{content}}<p>{{description}}</p></div>',
			'tabButton' => '<li><button role="radio" name="{{tabGroup}}" class="tab-button" data-target="{{tab}}">{{content}}</button></li>',
			'tabGroup' => '<div id="{{tabGroup}}" class="tab-group"><ul class="tab-group__header">{{tabButtons}}</ul><div class="tab-group__body">{{content}}</div></div>',
			'tab' => '<div id="{{tab}}" class="tab">{{content}}</div>',
		]
	];

	protected int $tabGroupCounter = 0;

	/**
	 * List of helpers used by this helper
	 *
	 * @var array
	 */
	protected array $helpers = ['Form'];

	public function initialize(array $config): void {
		$this->FieldHandler = new FieldHandler();
	}

	public function sectionHeader(string $title, ?array $options = []) {
		return $this->formatTemplate('sectionHeader', [
			'attrs' => $this->templater()->formatAttributes($options),
			'content' => $title,
		]);
	}

	public function control(string $name, ?array $options = []) {
		$content = $this->Form->control($name, $options);

		return $this->formatTemplate('control', [
			'content' => $content,
			'description' => $options['description'] ?? '',
		]);
	}

	public function getTab($blocks) {
		$content = '';
		$tabButtons = '';
		$tabGroupName = sprintf("tab-group-%d", ++$this->tabGroupCounter);

		foreach ($blocks as $tabName => $block) {
			$tabButtons .= $this->formatTemplate('tabButton', [
				'content' => $tabName,
				'tab' => $block,
				'tabGroup' => $tabGroupName 
			]);
			$content .= $this->formatTemplate('tab', [
				'content' => $this->getView()->fetch($block),
				'tab' => $block
			]);
		}

		return $this->formatTemplate('tabGroup', [
			'tabButtons' => $tabButtons,
			'content' => $content,
			'tabGroup' => $tabGroupName 
		]);
	}

	public function render($fields, $options) {
		$content = '';

		foreach ($fields as $field) {
			$content .= $this->editField($field, $options);
		}

		return $content;
	}

	public function editField($field, $options = []) {
		$options['label'] = $field['alias'];
		$field = $this->FieldHandler->prepareField($field);

		$options = array_merge($field->displayOptions ?? [], $options);
		return $this->Form->control($field['name'], $options);
	}

	public function displayField($value, $field) {
		return $this->FieldHandler->display($value, $field);
	}
}
