<?php 
	$this->append('css', $this->Html->css('Rhno.layout')); 
	$this->append('script', $this->Html->script(['Rhno.layout'], ["type" => "module"]));
	$this->append('script', $this->Html->script(['Rhno./vendor/editorjs/dist/editor.js']));
	$this->append('script', $this->Html->script(['Rhno./vendor/header/dist/bundle.js']));
	$this->append('script', $this->Html->script(['Rhno./vendor/list/dist/bundle.js']));
	$this->assign('title', $page["name"]); 
	$this->assign('Rhno', $this->element('Rhno.layout-menu')); 
?>

<?php foreach ($page["contents"] as $content) : ?>
	<div id="<?= 'element-' . $content['id'] ?>" class="layout-element" draggable="true">

		<div class="element-container">
			<?= $this->element($content['element']['element'], $content->toArray()) ?>
		</div>

		<div class="layout-handle">
			<?= $this->Html->Link(__('Active'),
				[
					'controller' => 'Contents',
					'action' => 'change',
					$content['id'],
					'?' => [
						'key' => 'active',
						'value' => !$content['active']
					]
				],
				['class' => 'rhno-button']
			) ?>
			<button
				class="rhno-button open-modal"
				name="Edit Content"
				value="<?= $this->Url->build(['controller' => 'Contents', 'action' => 'edit',  $content['id']]) ?>"
				data-dispatch="updateContent"
				>
				Edit
			</button>
			<button
				class="rhno-button open-modal"
				name="Delete Content"
				value="<?= $this->Url->build(['controller' => 'Contents', 'action' => 'delete', $content['id']]) ?>"
				data-dispatch="updateContent"
				>
				Delete
			</button>
		</div>
	</div>
<?php endforeach ?>