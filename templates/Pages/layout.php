<?php 
	$this->append('css', $this->Html->css('Rhino.layout')); 
	$this->append('script', $this->Html->script(['Rhino.layout'], ["type" => "module"]));
	$this->append('script', $this->Html->script(['Rhino./vendor/editorjs/dist/editor.js']));
	$this->append('script', $this->Html->script(['Rhino./vendor/header/dist/bundle.js']));
	$this->append('script', $this->Html->script(['Rhino./vendor/list/dist/bundle.js']));
	$this->assign('title', $page["name"]); 
	$this->assign('Rhino', $this->element('Rhino.layout-menu')); 
?>

<?php foreach ($page["contents"] as $content) : ?>
	<div id="<?= 'element-' . $content['id'] ?>" class="layout-element" draggable="true">

		<div class="element-container">
			<?= $this->element($content['element']['elementName'], array_merge($content->toArray(), ['layoutmode' => true])) ?>
		</div>

		<div class="layout-handle">
			<?= $this->Html->Link(__('Active'),
				[
					'controller' => 'Contents',
					'action' => 'change',
					$content['id'],
					'?' => [
						'key' => 'active',
						'value' => !$content['active'],
						'modal' => true
					]
				],
				['class' => 'rhino-button']
			) ?>
			<button
				class="rhino-button open-modal"
				name="Edit Content"
				value="<?= $this->Url->build(['controller' => 'Contents', 'action' => 'edit', '?' => [
						'modal' => true
					],  $content['id']]) ?>"
				data-dispatch="updateContent"
				>
				Edit
			</button>
			<button
				class="rhino-button open-modal"
				name="Delete Content"
				value="<?= $this->Url->build(['controller' => 'Contents', 'action' => 'delete', '?' => [
						'modal' => true
					], $content['id']]) ?>"
				data-dispatch="updateContent"
				>
				Delete
			</button>
		</div>
	</div>
<?php endforeach ?>