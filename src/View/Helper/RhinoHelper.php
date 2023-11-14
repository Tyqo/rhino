<?php
/* src/View/Helper/LinkHelper.php */

namespace Rhino\View\Helper;

use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Cake\Utility\Inflector;
use Rhino\Handlers\FieldHandler;
use Rhino\Handlers\FileHandler;
use Cake\View\Helper\IdGeneratorTrait;

class RhinoHelper extends Helper {
	use StringTemplateTrait;
	use IdGeneratorTrait;

	/**
	 * Default config for this class
	 *
	 * @var array<string, mixed>
	 */
	protected array $_defaultConfig = [
		'templates' => [
			'tag' => '<{{tag}}{{attrs}}>{{content}}</{{tag}}>',
			'sectionHeader' => '<div class="section-header"><h3{{attrs}}>{{content}}</h3></div>',
			'control' => '<div>{{content}}{{description}}</div>',
			'tabButton' => '<li><button role="radio" name="{{tabGroup}}" class="tab-button" data-target="{{tab}}">{{content}}</button></li>',
			'tabGroup' => '<div id="{{tabGroup}}" class="tab-group"><ul class="tab-group__header">{{tabButtons}}</ul><div class="tab-group__body">{{content}}</div></div>',
			'tab' => '<div id="{{tab}}" class="tab">{{content}}</div>',
			'details' => '<details{{attrs}}><summary role>{{summary}}</summary>{{content}}</details>',
			'ul' => '<ul{{attrs}}>{{content}}</ul>',
			'li' => '<li{{attrs}}>{{content}}</li>',
		]
	];

	protected int $tabGroupCounter = 0;

	/**
	 * List of helpers used by this helper
	 *
	 * @var array
	 */
	protected array $helpers = ['Form', 'Html', 'Icon', 'Url'];

	public function initialize(array $config): void {
		$this->FieldHandler = new FieldHandler();
		$this->FileHandler = new FileHandler();
	}

	public function sectionHeader(string $title, ?array $options = []) {
		return $this->formatTemplate('sectionHeader', [
			'attrs' => $this->templater()->formatAttributes($options),
			'content' => $title,
		]);
	}

	public function control(string $name, ?array $options = []) {
		if (isset($options['description'])) {
			$description = $this->formatTemplate('tag', [
				'content' => $options['description'],
				'tag' => 'p',
			]);

			unset($options['description']);
		}

		if (isset($options['multiple']) && $options['multiple']) {
			$content = $this->multiSelect($name, $options);
		} else if (isset($options['type']) && $options['type'] == 'directory') {
			$content = $this->directory($name, $options);
		} else {
			$content = $this->Form->control($name, $options);
		}

		return $this->formatTemplate('control', [
			'content' => $content,
			'description' => $description ?? '',
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

	public function render($fields, $entity, $options) {
		$content = '';

		foreach ($fields as $field) {
			$content .= $this->editField($field, $entity[$field->name], $options);
		}

		return $content;
	}

	public function editField($field, $value, $options = []) {
		$options['label'] = $field['alias'];
		$field = $this->FieldHandler->loadField($field, $value);

		$options = array_merge($field['displayOptions'] ?? [], $options);
		return $this->control($field['name'], $options);
	}

	public function displayField($value, $field) {
		return $this->FieldHandler->display($value, $field);
	}

	private function multiSelect(string $fieldName, array $options = []): string {
		$content = '';
		$selectOptions = $options['options'];
		$options['type'] = 'checkbox';
		$templater = $this->templater();
		$values = $options['value'] ?? [];

		$empty = $this->Form->hidden($fieldName, ['value' => '']);

		foreach ($selectOptions as $key => $value) {
			if (empty($key) && $key != 0) {
				continue;
			}

			$id = $key;
			$checkboxOptions = [
				'name' => $fieldName . '[]',
				'value' => $key,
				'checked' => in_array($key, $values),
				'id' => $id,
				'hiddenField' => false
			];

			$checkbox = $this->Form->checkbox($id, $checkboxOptions);
			$content .= $this->Form->label($id, $checkbox . $value, [
				'escape' => false
			]);
		}

		$legend = $templater->format('tag', [
			'content' => $options['label'],
			'tag' => 'legend',
		]);

		$content = $templater->format('tag', [
			'content' => $content,
			'tag' => 'div',
			'attrs' => $templater->formatAttributes(['role' => 'list']),
		]);

		$list = $templater->format('tag', [
			'content' => $legend . $empty . $content,
			'tag' => 'fieldset',
			'attrs' => $templater->formatAttributes(['role' => 'multiselect']),
		]);

		return $list;
	}

	public function directory(string $fieldName, array $options = []): string {
		if (!isset($options['id'])) {
			$options['id'] = $fieldName;
		}

		$url = $this->Url->build([
			'controller' => 'files',
			'action' => 'get',
		]);

		$templater = $this->templater();
		$input = $this->Form->input($fieldName, [
			'type' => 'text',
			'id' => $options["id"],
			"value" => $options['value'],
			'name' => $options['name'] ?? $fieldName,
		]);
		$name = __(Inflector::humanize(Inflector::underscore($fieldName)));
		$label = $this->Form->label($options["id"], $name);

		$button = $this->Form->button(_("Select " . $name), [
			'name' => $fieldName,
			'type' => 'directory',
			'value' => $url,
			'data-target' => $options['id'],
			'data-dir' => $options['directory'] ?? '',
			'data-types' => $options['types'] ?? ''
		]);

		$box = $templater->format('tag', [
			'content' => $input . $button,
			'tag' => 'div',
			'attrs' => $templater->formatAttributes(['class' => 'cluster']),
		]);

		return $templater->format('tag', [
			'content' => $label . $box,
			'tag' => 'div',
			'attrs' => $templater->formatAttributes(['class' => 'input directory']),
		]);
	}

	public function displayDirectory(array $list, array $options = [], array $itemOptions = []): string {
		$items = $this->_directoryItems($list, $options, $itemOptions);
		return $this->formatTemplate('ul', [
			'attrs' => $this->templater()->formatAttributes([]),
			'content' => $items,
		]);
	}

	protected function _directoryItems(array $items, array $options, array $itemOptions): string {
		$out = '';

		$index = 1;
		foreach ($items as $item) {
			// Form->control type radio, outputs: input with type hidden?
			// Form->radio escapes leading slash and can not be matched by label???
			$radio = $this->formatTemplate('tag', [
				'tag' => 'input',
				'attrs' => $this->templater()->formatAttributes(array_merge([
					'type' => 'radio',
					'value' => $item['path'],
					'id' => $this->_domId($item['name']),
					'name' => 'selected',
					'data-type' => $item['type']
				], $item['options'] ?? [])),
			]);
			$label = $this->Form->label($item['name'], $item['name']);
			$container = $this->formatTemplate('tag', [
				'tag' => 'div',
				'content' => $radio . $label
			]);

			if (isset($item['children']) && !empty($item['children'])) {
				$list = $this->displayDirectory($item['children'], $options, $itemOptions);
				$item = $container . $this->formatTemplate('details', [
					'attrs' => $this->templater()->formatAttributes(['role' => 'listbox', 'open' => true]),
					'summary' => $this->Icon->svg('folder-plus'),
					'content' => $list,
				]);
			} else {
				if ($item['type'] == 'folder') {
					$item = $this->Icon->svg('folder') . $container;
				} else {
					$item = $this->Icon->svg('file') . $container;
				}
			}

			if (isset($itemOptions['even']) && $index % 2 === 0) {
				$itemOptions['class'] = $itemOptions['even'];
			} elseif (isset($itemOptions['odd']) && $index % 2 !== 0) {
				$itemOptions['class'] = $itemOptions['odd'];
			}

			$out .= $this->formatTemplate('li', [
				'attrs' => $this->templater()->formatAttributes($itemOptions, ['even', 'odd']),
				'content' => $item,
			]);
			$index++;
		}

		return $out;
	}
}
