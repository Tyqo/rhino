<?php
/* src/View/Helper/LinkHelper.php */

namespace Rhino\View\Helper;

use Cake\Collection\Iterator\UniqueIterator;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Cake\Utility\Inflector;
use Rhino\Handlers\FieldHandler;
use Rhino\Handlers\FileHandler;
use Cake\View\Helper\IdGeneratorTrait;
use Cake\Core\Configure;
use Rhino\Model\Table\MediaCategoriesTable;
use Rhino\Model\Table\WidgetsTable;
use Rhino\Model\Table\ComponentsTable;

class RhinoHelper extends Helper {
	use StringTemplateTrait;
	use IdGeneratorTrait;

	/**
	 * Undocumented variable
	 *
	 * @var array
	 */
	public $counter = [];

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
	protected array $helpers = ['Form', 'Html', 'Icon', 'Url', 'Layout'];

	public function initialize(array $config): void {
		$this->FieldHandler = new FieldHandler();
		$this->FileHandler = new FileHandler();
		$this->layoutMode = Configure::read('layoutMode') ?? false;
	}

	public function sectionHeader(string $title, ?array $options = []) {
		return $this->formatTemplate('sectionHeader', [
			'attrs' => $this->templater()->formatAttributes($options),
			'content' => $title,
		]);
	}

	public function control(string $name, ?array $options = []) {
		if (isset($options['type']) && $options['type'] === false) {
			return;
		}

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
		} else if (isset($options['type']) && $options['type'] == 'file') {
			$content = $this->file($name, $options);
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
			if ($field['name'] == 'id' && $field['extra'] == 'auto_increment') {
				continue;
			}

			$options['label'] = $field['alias'];
			$content .= $this->editField($field->name, $entity, $options);
		}

		return $content;
	}

	public function editField($fieldName, $entity, $options = []) {
		$displayOptions = $this->FieldHandler->loadField($fieldName, $entity);
		$options = array_merge($displayOptions ?? [], $options);
		return $this->control($fieldName, $options);
	}

	public function displayField($fieldName, $entity) {
		return $this->FieldHandler->displayField($fieldName, $entity);
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

	public function file(string $fieldName, array $options = []): string {
		if (!isset($options['id'])) {
			$options['id'] = $fieldName;
		}

		$name = $options['name'] ?? $fieldName;
		$humanName = __(Inflector::humanize(Inflector::underscore($fieldName)));
		
		$label = $this->Form->label($options["id"], $humanName);
		$text = $this->Form->input($fieldName, [
			'type' => 'text',
			'id' => $this->_domId($options["id"]),
			"value" => $options['value'] ?? null,
			'name' => $options['name'] ?? $fieldName,
			'disabled' => isset($options['disabled'])
		]);

		if (isset($options['disabled'])) {
			return $label . $text;
		}

		$fileOptions = [
			'type' => 'file',
			'id' => $this->_domId($options["id"] . "_file"),
			'name' => $name . '_file',
			'hidden'
		];

		if (isset($options['accept'])) {
			$fileOptions['accept'] = $options['accept'];
		}

		if (isset($options['multiple'])) {
			$fileOptions['multiple'] = true;
			$fileOptions['name'] .= '[]';
		}

		$file = $this->Form->input($fieldName, $fileOptions);

		$button = $this->Form->label($options["id"] . "_file", 'Upload File', ['class' => 'button']);

		$url = $this->Url->build([
			'controller' => 'files',
			'action' => 'get',
		]);

		$select = $this->Form->button(_("Select File"), [
			'name' => $fieldName,
			'type' => 'directory',
			'value' => $url,
			'data-target' => $options['id'],
			'data-dir' => $options['directory'] ?? '',
			'data-types' => $options['types'] ?? ''
		]);

		$pill = $this->templater()->format('tag', [
			'content' => $button . $file . $select,
			'tag' => 'div',
			'attrs' => $this->templater()->formatAttributes(['class' => 'cluster pill']),
		]);

		$box = $this->templater()->format('tag', [
			'content' => $text . $pill,
			'tag' => 'div',
			'attrs' => $this->templater()->formatAttributes(['class' => 'grid']),
		]);

		return $label . $box;
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

	public function post($content, $link, $options) {
		$uid = uniqid('post-');
		if (isset($options['confirm'])) {
			$options['data-modal'] = $options['confirm'];
			unset($options['confirm']);
		}

		$options['data-target'] = $uid;

		$action = $this->templater()->formatAttributes([
			'action' => $this->Url->build($link),
			'escape' => false,
			'id' => $uid,
			'method' => 'POST',
			'hidden'
		]);

		$request = $this->_View->getRequest();
		$csrfToken = $request->getAttribute('csrfToken') ?? '';

		$form = $this->Form->formatTemplate('formStart', [
			'attrs' => $this->templater()->formatAttributes([]) . $action,
		]);

		$form .= $this->Form->hidden('_csrfToken', [
			'value' => $csrfToken,
			'secure' => $this->Form->SECURE_SKIP,
		]);

		$form .= $this->Form->formatTemplate('formEnd', []);

		$button = $this->formatTemplate('tag', [
			'tag' => 'button',
			'attrs' => $this->templater()->formatAttributes($options),
			'content' => $content,
		]);
		return $form . $button;
	}

	public function humanize(string $string) : string {
		return __(Inflector::humanize(Inflector::underscore($string)));
	}

	public function escape(string $string) : string {
		return $this->_domId($string);
	}
	
	public function backLink() : string {
		return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "#";
	}

	public function getCurrent($args) : ?string {
		$request = $this->_View->getRequest();
		if (is_string($args)) {
			if ($args != $request->getEnv("REQUEST_URI")) {
				return null;
			}
		}

		if (is_array($args)) {
			foreach ($args as $key => $arg) {
				if (empty($key)) {
					$key = 'pass';
				}
				
				$value = $request->getParam((string)$key);

				if (is_array($value)) {
					$value = $value[0];
				}

				if ($arg != $value) {
					return null;
				}
			}
		}

		return 'aria-current="page"';
	}

	public function parseEditor(?string $json = '[]') : string {
		if ($this->layoutMode) {
			return $this->Layout->parseEditor($json);
		}

		$object = json_decode($json ?? '');

		if (empty($object)) {
			return $json;
		}

		$content = '';
		foreach ($object->blocks as $key => $block) {
			$data = $block->data;

			switch ($block->type) {
				case 'header':
					$level = 'h' . $data->level;
					$content .= '<' . $level . '>' . $data->text . '</' . $level . '>';
					break;

				case 'list':
					# code...
					$items = '';
					foreach ($data->items as $listItem) {
						$items .= '<li>' . $listItem . '</li>';
					}

					$style = $data->style == "ordered" ? 'ol' : 'ul';

					$content .= '<' . $style . '>' . $items . '</' . $style . '>';
					break;
				
				default:
					$content .= '<p>' . $data->text . '</p>';
					break;
			}
		}

		return $content;
	}
	
	public function parseMedia(?string $id = null) : string {
		$this->MediaCategories = new MediaCategoriesTable();
		$content = '';
		
		if (!empty($id)) {
			$media = $this->MediaCategories->Media->get($id);
			$content .= $this->displayMedia($media);
		} else {
			$content .= '<img src="" />';
		}

		if ($this->layoutMode) {
			return $this->Layout->parseMedia($content, $id);
		}

		return $content;
	}

	public function displayMedia($media) {
		$content = '<img src="/media/' . $media->filename . '" />';
		// switch ($media->type) {
		// 	case 'image':
		// 		$content .= '<img src="/media/' . $media->filename . '" />';
		// 		break;

		// 	default:
		// 		# code...
		// 		break;
		// }
		return $content;
	}

	public function parseWidget($id) {
		$this->Widgets = new WidgetsTable();
		$widget = $this->Widgets->get($id);
		$data = json_decode($widget->description, true);
		$template = str_replace('.php', '', $widget->template);
		return $this->_View->element($template, $data);
	}

	public function region(string $name, $id = null) {
		if ($this->layoutMode) {
			return $this->Layout->region($name, $id);
		}
	
		return $this->_View->fetch($name);
	}

	public function component($component) {
		$this->counter[$component->id] = 0;
		
		if ($this->layoutMode) {
			return $this->Layout->component($component);
		}

		$element = $this->_View->element($component->template->element, $component->toArray());

		return $element;
	}

	public function slot(int $parentId, string $name = null) {
		$this->Components = new ComponentsTable();
		$content = '';

		$count = isset($this->counter[$parentId]) ? $this->counter[$parentId]++ : 0;
		
		if (!empty($name)) {
			$component = $this->Components->find()
				->where(['parent_id' => $parentId, 'name' => $name])
				->contain(['Templates'])
				->first();
		} else {
			$component = $this->Components->find()
				->where(['parent_id' => $parentId])
				->contain(['Templates'])
				->offset($count)
				->orderBy(['lft' => 'ASC'])
				->first();
		}

		if (!empty($component)) {
			$content = $this->component($component);
		}

		if ($this->layoutMode) {
			return $this->Layout->slot($parentId, $content);
		}
		
		return $content;
	}
}
