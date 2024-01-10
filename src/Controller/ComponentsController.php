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
use Rhino\Controller\RhinoController as BaseController;
use Cake\Datasource\Exception\RecordNotFoundException;

use Rhino\Model\Table\PagesTable;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class ComponentsController extends BaseController {

	public function initialize(): void {
		parent::initialize();
		$this->Pages = new PagesTable();

		if ($this->request->getQuery('modal')) {
			$this->viewBuilder()->disableAutoLayout();
		}
    }

	public function edit(int $id) {
		$entry = $this->Components->getEntry($id);
		$elements = $this->Components->Elements->find('list');

		if ($this->request->is(['patch', 'post', 'put'])) {
			$content = $this->Components->patchEntity($entry, $this->request->getData());
            
			if ($this->Components->save($content)) {
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

	public function new() {
		$this->viewBuilder()->disableAutoLayout();

		$data = $this->request->getData();

		$component = $this->Components->newEntity([
			'name' => $data['region'],
			'parent_id' => $data['parentId'],
			'content' => '',
			'user_id' => $this->user->id,
			'node_type' => 1,
			'template_id' => 2
		]);
		$component = $this->Components->save($component);

		return $this->getElement($component, true);
	}

	public function update() {
		$data = $this->request->getData();

		$content = $this->Components->get($data['id']);
		$content = $this->Components->patchEntity($content, $data);

		if ($this->Components->save($content)) {
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

	public function change() {
		$this->viewBuilder()->disableAutoLayout();
		$data = $this->request->getData();

		$content = $this->Components->get($data['id']);
		$content = $this->Components->patchEntity($content, $data);
		$this->Components->save($content);
		return $this->getElement($content, true);
	}

	public function delete() {
		$data = $this->request->getData();

		if (!$this->request->is(['patch', 'post', 'put', 'delete'])) {
			return;
		}
		
		$entry = $this->Components->get($data['id']);
			
		if ($this->Components->delete($entry)) {
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

	private function getElement($component, $layoutMode = false) {
		$this->setPlugin(null);

		if ($layoutMode) {
			$this->viewBuilder()->addHelper('Rhino.Layout');
			Configure::write('layoutMode', true);
		}
		
		$templateId = $component->template_id ?? 2;

		if (empty($component->template)) {
			$component->template = $this->Components->Templates->get($templateId);
		}

		if ($layoutMode) {
			$templates = $this->Components->Templates->list(1);
			$this->set(['templates' => $templates]);
		}

		$this->set([
			'component' => $component,
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
				$entry = $this->Components->get($id, ['contain' => 'Elements']);
			} else {
				$entry = $this->Components->find()->contain(["Elements"])->first();
			}

			if (!empty($elementId)) {
				$entry->element = $this->Components->Elements->get($elementId);
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
