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
use Cake\Datasource\Exception\RecordNotFoundException;

use Rhino\Model\Table\PagesTable;

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

		if ($this->request->getQuery('modal')) {
			$this->viewBuilder()->disableAutoLayout();
		}
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
		$this->viewBuilder()->disableAutoLayout();

		$content = $this->Contents->newEntity([
			'page_id' => $pageId,
			'html' => ''
		]);
		$content = $this->Contents->save($content);

		return $this->getElement($content, true);
	}

	public function update($id) {
		$content = $this->Contents->get($id);
		$content = $this->Contents->patchEntity($content, $this->request->getData());

		if ($this->Contents->save($content)) {
			$response = $this->response->withType('application/json')
				->withStringBody(json_encode([
					'status' => 200,
					'message' => __('The content has been saved.')
			]));
		} else {
			$response = $this->response->withType('application/json')
				->withStringBody(json_encode([
					'status' => 500,
					'message' => __('The content could not be saved. Please, try again.')
			]));
		}			
	
		return $response;
	}

	public function read($id) {
		$this->viewBuilder()->disableAutoLayout();
		$content = $this->Contents->get($id);
		$content = $this->Contents->patchEntity($content, $this->request->getData());
		$this->Contents->save($content);
		return $this->getElement($content, true);
	}

	public function delete($id) {
		if (!$this->request->is(['patch', 'post', 'put', 'delete'])) {
			return;
		}
		
		$entry = $this->Contents->get($id);
			
		if ($this->Contents->delete($entry)) {
			$response = $this->response->withType('application/json')
				->withStringBody(json_encode([
					'status' => 200,
					'message' => __('The element has been deleted.')
			]));
		} else {
			$response = $this->response->withType('application/json')
				->withStringBody(json_encode([
					'status' => 500,
					'message' => __('The element could not be deleted. Please, try again.')
			]));
		}

		return $response;
    }

	private function getElement($content, $layoutMode = false) {
		$this->setPlugin(null);
		
		$elementId = $content->element_id ?? 1;

		if (empty($content->element)) {
			$content->element = $this->Contents->Elements->get($elementId);
		}

		if ($layoutMode) {
			$elements = $this->Contents->Elements->list();
			$this->set(['elements' => $elements]);
		}

		$this->set([
			'content' => $content,
			'layoutmode' => $layoutMode
		]);

		try {
            return $this->render('Rhino.element');
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }

            throw new NotFoundException();
        }
	}


	// public function new(int $pageId) {
	// 	$entry = $this->Contents->getEntry();
	// 	$elements = $this->Contents->Elements->find('list');

	// 	if ($this->request->is(['patch', 'post', 'put'])) {
	// 		$content = $this->Contents->patchEntity($entry, $this->request->getData());
    //         $content['page_id'] = $pageId;
    //         $content['position'] = $this->Contents->find()->where(['page_id' => $pageId])->all()->count();
	
	// 		if ($this->Contents->save($content)) {
	// 			// $this->Flash->success(__('The table has been saved.'));
	// 			// If you want a json response
	// 			$response = $this->response->withType('application/json')
	// 				->withStringBody(json_encode([
	// 					'status' => 200,
	// 					'message' => __('The table has been saved.')
	// 			]));
	// 			return $response;
    //         }
			
    //         // $this->Flash->error(__('The table could not be saved. Please, try again.'));
	// 		$response = $this->response->withType('application/json')
	// 			->withStringBody(json_encode([
	// 				'status' => 500,
	// 				'message' => __('The table could not be saved. Please, try again.')
	// 		]));
	// 		return $response;
    //     }

	// 	$this->set([
	// 		'entry' => $entry,
	// 		'elements' => $elements,
	// 		'pageId' => $pageId,
	// 	]);
	// }

	// public function change($id) {
	// 	$params = $this->request->getParam('?');
	// 	$entry = $this->Contents->get($id);

	// 	$entry[$params['key']] = $params['value'];
	// 	$this->Contents->save($entry);

	// 	if ($this->request->is(['ajax'])) {
	// 		$response = $this->response->withType('application/json')
	// 			->withStringBody(json_encode([
	// 				'status' => 200,
	// 				'message' => __('The entry has been changed.')
	// 		]));
	// 		return $response;
	// 	}

	// 	$referer = $this->request->getEnv('HTTP_REFERER');
	// 	return $this->redirect($referer);
	// }

	public function element($id = null) {
		$this->viewBuilder()->disableAutoLayout();
		$this->setPlugin(null);
		$elementId = $this->request->getQuery('elementId') ?? null;

		try {
			if (!empty($id)) {
				$entry = $this->Contents->get($id, ['contain' => 'Elements']);
			} else {
				$entry = $this->Contents->find()->contain(["Elements"])->first();
			}

			if (!empty($elementId)) {
				$entry->element = $this->Contents->Elements->get($elementId);
			}

			$this->set([
				'entry' => $entry,
				'layoutmode' => $this->request->getQuery('layoutmode') ?? false
			]);
		} catch(RecordNotFoundException $e) {
			exit();
		}

		try {
            return $this->render('Rhino.element');
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
	}
}
