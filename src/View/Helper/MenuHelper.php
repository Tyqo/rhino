<?php
/* src/View/Helper/LinkHelper.php */

namespace Rhino\View\Helper;

use Cake\View\Helper;
use Rhino\Model\Table\PagesTable;
use Cake\View\StringTemplateTrait;
use Generator;
use Cake\Core\App;
use Cake\View\Exception\MissingElementException;
use LogicException;
use Throwable;
use Cake\Core\Plugin;

class MenuHelper extends Helper {
	use StringTemplateTrait;

	/**
     * Default config for this class
     *
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'templates' => [
			'tag' => '<{{tag}}{{attrs}}>{{content}}</{{tag}}>',
			'ul' => '<ul{{attrs}}>{{content}}</ul>',
			'li' => '<li{{attrs}}>{{content}}</li>',
			'link' => '<a href="{{url}}"{{attrs}}>{{content}}</a>',
			'summary' => '<summary{{attrs}}>{{content}}</summary>',
			'details' => '<details{{attrs}}>{{content}}</details>',
		]
	];

	/**
	 * List of helpers used by this helper
	 *
	 * @var array
	 */
	protected array $helpers = ['Url'];

	private ?int $maxLevel = null; 

	public function initialize(array $config): void {
		$this->Pages = new PagesTable();
	}

	public function get(?int $root = null, ?array $options = null) {
		$menu = $this->Pages->getMenu($root, $options['limit'] ?? null);
		unset($options['limit']);

		// if (isset($options['limit'])) {
		// 	$this->maxLevel = $menu[0]->level + $options['limit'];
		// }

		$out = $this->nestedList($menu, $options);
		return $out;
	}

	private function nestedList($items, array $options = []) {
		$out = '';

		foreach ($items as $item) {
			$out .= $this->nestedItem($item, $options);
		}

		return $this->formatTemplate('ul', [
			'attrs' => $this->templater()->formatAttributes($options['ul'] ?? []),
			'content' => $out,
		]);
	}

	private function nestedItem($item, array $options = []) {
		$itemOut = '';
		$children = '';

		if (!empty($item->children)) {
			$children .= $this->nestedList($item->children, $options);
		}

		$type = 'Page';
		// $type = $this->Pages->pageTypes[$item->page_type];
		
		switch ($type) {
			case 'Page':
				$itemOut .= $this->formatTemplate('link', [
					'attrs' => $this->templater()->formatAttributes($options['link'] ?? []),
					'content' => $item->name,
					'url' =>  $this->Url->build(['controller' => 'pages', 'action' => 'display', $item->name])
				]);
				$itemOut .= $children;
				break;
			case 'Link':
				$itemOut .= $this->formatTemplate('link', [
					'attrs' => $this->templater()->formatAttributes($options['link'] ?? []),
					'content' => $item->name,
					'url' => $item->url
				]);
				$itemOut .= $children;
				break;
			case 'Folder':
				$summary = $this->formatTemplate('summary', [
					'attrs' => $this->templater()->formatAttributes($options['summary'] ?? []),
					'content' => $item->name,
				]);

				$itemOut .= $this->formatTemplate('details', [
					'attrs' => $this->templater()->formatAttributes($options['details'] ?? []),
					'content' => $summary . $children,
				]);
				break;
		}

		return $this->formatTemplate('li', [
			'attrs' => $this->templater()->formatAttributes($options['li'] ?? []),
			'content' => $itemOut,
		]);
	}
}