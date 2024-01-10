<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Rhino\View;

use Cake\Core\Configure;
use App\View\AppView;

/**
 * Application View
 *
 * Your application's default view class
 *
 * @link https://book.cakephp.org/4/en/views.html#the-app-view
 */
class PageView extends AppView {
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading helpers.
     *
     * e.g. `$this->loadHelper('Html');`
     *
     * @return void
     */
    public function initialize(): void {
		parent::initialize();
		$isLayout = Configure::read('layoutMode');
		$page = $this->get('page');
		$this->assign('title', $page->name);
		$this->loadHelper('Rhino.Layout');

		if ($isLayout) {
			$this->append('meta', $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')));
			$this->append('meta', $this->Html->meta('pageId', (string)$page->id));
			$this->append('css', $this->Html->css('Rhino.layout')); 
			$this->append('script', $this->Html->script(['Rhino.layout'], ["type" => "module"]));
			$this->append('script', $this->Html->script(['Rhino./vendor/editorjs/dist/editor.js']));
			$this->append('script', $this->Html->script(['Rhino./vendor/header/dist/bundle.js']));
			$this->append('script', $this->Html->script(['Rhino./vendor/list/dist/bundle.js']));
			$this->assign('Rhino', $this->element('Rhino.layout-menu'));
		}
		
		foreach ($this->get('children') as $component) { 
			if (empty($component->template) || $component->node_type != 1) continue;
			
			if ($component->active) {
				$region = $component->name;
				$content = $this->Rhino->component($component);
				$this->append($region, $content);
			}
		}
    }
}
