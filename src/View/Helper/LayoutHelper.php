<?php
namespace Rhino\View\Helper;

use Cake\Collection\Iterator\UniqueIterator;
use Cake\View\Helper;
use Cake\View\StringTemplateTrait;
use Cake\Utility\Inflector;
use Cake\View\Helper\IdGeneratorTrait;

use Rhino\Handlers\FieldHandler;
use Rhino\Handlers\FileHandler;
use Rhino\Model\Table\PagesTable;
use Rhino\Model\Table\ComponentsTable;
use Rhino\Model\Table\MediaCategoriesTable;

class LayoutHelper extends Helper
{
	use StringTemplateTrait;

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

	public function initialize(array $config): void
	{
		$this->layoutMode = true;
		$this->Templater = $this->templater();

		$this->page = $this->_View->get('page');
	}

	protected array $helpers = ['Form', 'Html', 'Icon', 'Url'];

	public function parseEditor(?string $json = '[]', ?bool $edit = false): string
	{
		return '<div class="editor"></div>' . '<textarea name="content" hidden>' . $json . '</textarea>';
	}

	public function parseMedia($content = null, $id = null)
	{
		// $content .= '<button class="rhino-button select-media" name="media" value="//tusk.localhost:3000/rhino/files/get">Edit</button>';

		$url = $this->Url->build([
			'controller' => 'MediaCategories',
			'action' => 'select',
		]);

		$content .= $this->Templater->format('tag', [
			'content' => 'Edit',
			'tag' => 'button',
			'attrs' => $this->Templater->formatAttributes([
				'class' => 'rhino-button select-media',
				'name' => "mediaButton",
				'value' => $url
			]),
		]);

		$content .= '<input type="text" name="media" hidden value="' . $id . '" />';

		return $content;
	}

	public function getPages(int $baseId = 0): array
	{
		$this->Pages = new PagesTable();
		$_pages = $this->Pages->find('all')->toArray();
		return $this->Pages->getChildren($baseId, $_pages);
	}

	public function pageLink(int $id, array $options = []): string
	{
		$this->Pages = new PagesTable();
		$page = $this->Pages->get($id);
		return $this->Html->link($page["name"], ['plugin' => null, 'controller' => 'Pages', 'action' => 'display', urlencode($page["name"])], $options);
	}

	public function region($name, $id = null) {
		if (empty($id)) {
			$id = $this->page->id;
		}

		$url = $this->Url->build([
			'controller' => 'Components',
			'action' => 'new',
			$id,
			$name
		]);

		$content = $this->Templater->format('tag', [
			'content' => 'New',
			'tag' => 'button',
			'attrs' => $this->Templater->formatAttributes([
				'class' => 'rhino-button',
				'name' => "new-component",
				'value' => $name,
				'data-url' => $url,
				'data-id' => $id
			]),
		]);

		$content .= $this->_View->fetch($name);

		$content = $this->Templater->format('tag', [
			'content' => $content,
			'tag' => 'div',
			'attrs' => $this->Templater->formatAttributes([
				'class' => 'layout-container',
				'name' => $name,
				'value' => $id
			]),
		]);

		return $content;
	}

	public function component($component) {
		$this->counter[$component->id] = 0;
		$element = $this->_View->element('Rhino.' . '../Components/element', ['component' => $component]);
		return $element;
	}

	public function slot(int $parentId, string $content) {
		$name = uniqid();
		if (empty($content)) {
			$content = $this->Templater->format('tag', [
				'content' => 'New',
				'tag' => 'button',
				'attrs' => $this->Templater->formatAttributes([
					'class' => 'rhino-button',
					'name' => "new-component",
					'value' => $name,
					'data-id' => $parentId
				]),
			]);
		}

		$content = $this->Templater->format('tag', [
			'content' => $content,
			'tag' => 'div',
			'attrs' => $this->Templater->formatAttributes([
				'class' => 'layout-slot',
				'name' => $name,
				'value' => $parentId
			]),
		]);

		return $content;
	}
}