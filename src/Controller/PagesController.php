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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Rhino\Controller\AppController as BaseController;

use Rhino\Model\Table\ContentsTable;
use Rhino\Model\Table\PagesTable;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends BaseController {
	
	public function initialize(): void {
		parent::initialize();
		$this->Contents = new ContentsTable();
    }

	public function beforeFilter(\Cake\Event\EventInterface $event)
	{
		parent::beforeFilter($event);
		// Configure the login action to not require authentication, preventing
		// the infinite redirect loop issue
		$this->Authentication->addUnauthenticatedActions(['display']);
	}

    public function index() {
		$pages = $this->Pages->find('threaded')->orderBy(["lft" => 'ASC']);

		$this->set([
			'pages' => $pages,
		]);
	}

	public function moveUp($id = null) {
		// $this->request->allowMethod(['post', 'put']);
		$page = $this->Pages->get($id);
		if ($this->Pages->moveUp($page)) {
			$this->Flash->success('The category has been moved Up.');
		} else {
			$this->Flash->error('The category could not be moved up. Please, try again.');
		}
		return $this->redirect($this->referer(['action' => 'index']));
	}

	public function moveDown($id = null) {
		// $this->request->allowMethod(['post', 'put']);
		$page = $this->Pages->get($id);
		if ($this->Pages->moveDown($page)) {
			$this->Flash->success('The category has been moved down.');
		} else {
			$this->Flash->error('The category could not be moved down. Please, try again.');
		}
		return $this->redirect($this->referer(['action' => 'index']));
	}

	public function change(int $id = null) {
		$entry = $this->Pages->getEntry($id);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$page = $this->Pages->patchEntity($entry, $this->request->getData());
            
			if ($this->Pages->save($page)) {
				$this->Flash->success(__('The table has been saved.'), ['plugin' => 'Rhino']);
                return $this->redirect(['action' => 'index']);
            }
			
            $this->Flash->error(__('The table could not be saved. Please, try again.'), ['plugin' => 'Rhino']);
        }
		
		// $filter = !empty($id) ? ['id !=' => $id] : Null;
		$layouts = $this->Pages->Layouts->find('list')->all();
		$pages = $this->Pages->find('treeList', [
			'spacer' => str_repeat("&nbsp", 3)
		])->all();
		$pages = $this->Pages->root + $pages->toArray();

		$this->set([
			'entry' => $entry,
			'pages' => $pages,
			'layouts' => $layouts,
			"pageTypes" => $this->Pages->pageTypes
		]);
	}

	public function delete(int $id) {
		$entry = $this->Pages->getEntry($id);
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

	public function layout(int $id) {
		$this->setPlugin(null);
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
			
		$this->set([
			'page' => $page,
		]);
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
