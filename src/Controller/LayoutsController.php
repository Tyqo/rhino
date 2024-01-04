<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Rhino\Controller;

use Rhino\Controller\NodesController;

use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Controller\ControllerFactory;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class LayoutsController extends NodesController {
	
	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
		// Configure the login action to not require authentication, preventing
		// the infinite redirect loop issue
		$this->Authentication->addUnauthenticatedActions(['display']);
	}

    public function index() {
		$pages = $this->Pages->find('threaded')->where(['node_type' => 0])->orderBy(["lft" => 'ASC']);

		$this->set([
			'pages' => $pages,
		]);
	}

	public function add(int $id = null) {
		$entry = $this->Pages->newEmptyEntity();
		$this->compose($entry, [
			"redirect" => ['action' => 'index'],
			'success' => __('The page has been saved.'),
			'error' => __('The page could not be saved. Please, try again.')
		]);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Node Tree id.
	 * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit(int $id) {
		$entry = $this->Pages->get($id);
		$this->compose($entry, [
			"redirect" => ['action' => 'index'],
			'success' => __('The page has been saved.'),
			'error' => __('The page could not be saved. Please, try again.')
		]);
	}

	/**
     * Delete method
     *
     * @param string|null $id Node Tree id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function delete(int $id) {
		$this->request->allowMethod(['post', 'delete']);
		$entry = $this->Pages->get($id);

		$this->Pages->removeFromTree($entry);

		if ($this->Pages->delete($entry)) {
			$this->Pages->recover();
			$this->Flash->success(__('The Page has been deleted.'), ['plugin' => 'Rhino']);
		} else {
			$this->Flash->error(__('The Page could not be deleted. Please, try again.'), ['plugin' => 'Rhino']);
		}

		return $this->redirect(['action' => 'index']);
	}

	public function preCompose($entry, ...$params) {
		$layouts = $this->Pages->Layouts->find('list')->all();
		
		$pages = $this->Pages
			->find('treeList', [
				'spacer' => str_repeat("&nbsp", 3)
			])
			->where(['node_type' => 0])
			->all();
		
		$pages = $this->Pages->root + $pages->toArray();

		$this->set([
			'pages' => $pages,
			'layouts' => $layouts,
			'roles' => $this->Pages->roles
		]);
	}

	public function preSave($data, $params) {
		$data = parent::preSave($data, $params);

		$data['node_type'] = 0; // Page

		return $data;
	}

	public function layout(int $id) {
		$this->setPlugin(null);
		$this->viewBuilder()->addHelper('Rhino.Layout');
		$page = $this->Pages->get($id, [
			'contain' => [
				'Contents' => [
					'Elements',
					'sort' => [
						'Contents.position' => 'ASC'
					]
				],
				'Layouts'
			]
		]);

		$elements = $this->Pages->Contents->Elements->list();
			
		$this->set([
			'page' => $page,
			'elements' => $elements,
			'layoutMode' => true
		]);

		Configure::write('layoutMode', true);

		$this->viewBuilder()->setLayout($page->layout->layout);
		 
		try {
            return $this->render('Rhino.layout');
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
	}

	public function addContent(int $id) {
		$page = $this->Pages->getEntry($id);
		$entry = $this->Contents->newEmptyEntity();

		if ($this->request->is(['patch', 'post', 'put'])) {
			$content = $this->Contents->patchEntity($entry, $this->request->getData());
            
			if ($this->Pages->save($content)) {
				$this->Flash->success(__('The table has been saved.'), ['plugin' => 'Rhino']);
                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The table could not be saved. Please, try again.'), ['plugin' => 'Rhino']);
        }
		
		$this->set([
			'entry' => $entry,
			'page' => $page,
		]);
	}
	/**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response {
			
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		
		$slug = $subpage = null;
		
		if (!empty($path[0])) {
			$slug = $path[0];
		}
		
		if (!empty($path[1])) {
			$lang = $path[1];
		}
		
		$this->Pages = new PagesTable();
		$page = $this->Pages->slug(urldecode($slug ?: ""));

		if ($page->page_type === 1) { // Link
			$redirect =	$this->redirect($page->url); 
			return $redirect;
		}

        $this->set(compact('page', 'subpage'));
		
        try {
			$this->viewBuilder()->setLayout($page->layout->layout);
            return $this->render('Rhino.display');
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
	}
}
