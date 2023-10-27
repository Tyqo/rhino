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
namespace Tusk\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Tusk\Controller\AppController as BaseController;
use Cake\Datasource\Exception\RecordNotFoundException;

use Tusk\Model\Table\PagesTable;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class ContentsController extends BaseController {

	public function initialize(): void {
		parent::initialize();
		$this->Pages = new PagesTable();
    }

	public function edit(int $id) {
		$entry = $this->Contents->getEntry($id);
		$elements = $this->Contents->Elements->find('list');

		if ($this->request->is(['patch', 'post', 'put'])) {
			$content = $this->Contents->patchEntity($entry, $this->request->getData());
            
			if ($this->Contents->save($content)) {
				// $this->Flash->success(__('The table has been saved.'));
				// If you want a json response
				$response = $this->response->withType('application/json')
					->withStringBody(json_encode([
						'status' => 200,
						'message' => __('The table has been saved.')
				]));
				return $response;
            }
			
            // $this->Flash->error(__('The table could not be saved. Please, try again.'));
			$response = $this->response->withType('application/json')
				->withStringBody(json_encode([
					'status' => 500,
					'message' => __('The table could not be saved. Please, try again.')
			]));
			return $response;
        }
		
		$this->set([
			'entry' => $entry,
			'elements' => $elements,
		]);
	}

	public function new(int $pageId) {
		$entry = $this->Contents->getEntry();
		$elements = $this->Contents->Elements->find('list');

		if ($this->request->is(['patch', 'post', 'put'])) {
			$content = $this->Contents->patchEntity($entry, $this->request->getData());
            $content['page_id'] = $pageId;
            $content['position'] = $this->Contents->find()->where(['page_id' => $pageId])->all()->count();
	
			if ($this->Contents->save($content)) {
				// $this->Flash->success(__('The table has been saved.'));
				// If you want a json response
				$response = $this->response->withType('application/json')
					->withStringBody(json_encode([
						'status' => 200,
						'message' => __('The table has been saved.')
				]));
				return $response;
            }
			
            // $this->Flash->error(__('The table could not be saved. Please, try again.'));
			$response = $this->response->withType('application/json')
				->withStringBody(json_encode([
					'status' => 500,
					'message' => __('The table could not be saved. Please, try again.')
			]));
			return $response;
        }
		
		$this->set([
			'entry' => $entry,
			'elements' => $elements,
			'pageId' => $pageId,
		]);
	}

	public function change($id) {
		$params = $this->request->getParam('?');
		$entry = $this->Contents->get($id);

		$entry[$params['key']] = $params['value'];
		$this->Contents->save($entry);

		if ($this->request->is(['ajax'])) {
			$response = $this->response->withType('application/json')
				->withStringBody(json_encode([
					'status' => 200,
					'message' => __('The entry has been changed.')
			]));
			return $response;
		}

		$referer = $this->request->getEnv('HTTP_REFERER');
		return $this->redirect($referer);
	}

	public function delete($id) {
		$entry = $this->Contents->get($id, ['contain' => 'Elements']);
		if ($this->request->is(['patch', 'post', 'put', 'delete'])) {
			if ($this->Contents->delete($entry)) {
				// $this->Flash->success(__('The table has been deleted.'));
				$response = $this->response->withType('application/json')
					->withStringBody(json_encode([
						'status' => 200,
						'message' => __('The table has been deleted.')
				]));
				return $response;
			} else {
				// $this->Flash->error(__('The table could not be deleted. Please, try again.'));
				$response = $this->response->withType('application/json')
					->withStringBody(json_encode([
						'status' => 500,
						'message' => __('The table could not be deleted. Please, try again.')
				]));
				return $response;
			}
		}
		$this->set(['entry' => $entry]);
    }

	public function element($id) {
		$this->setPlugin(null);
		try {
			$entry = $this->Contents->get($id, ['contain' => 'Elements']);
			$this->set(['entry' => $entry]);
		} catch(RecordNotFoundException $e) {
			exit();
		}

		try {
            return $this->render('Tusk.element');
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
	}
}
