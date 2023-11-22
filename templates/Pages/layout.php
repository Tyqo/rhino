<?php 
	$this->append('meta', $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')));
	$this->append('css', $this->Html->css('Rhino.layout')); 
	$this->append('script', $this->Html->script(['Rhino.layout'], ["type" => "module"]));
	$this->append('script', $this->Html->script(['Rhino./vendor/editorjs/dist/editor.js']));
	$this->append('script', $this->Html->script(['Rhino./vendor/header/dist/bundle.js']));
	$this->append('script', $this->Html->script(['Rhino./vendor/list/dist/bundle.js']));
	$this->assign('title', $page["name"]); 
	$this->assign('Rhino', $this->element('Rhino.layout-menu'));
?>

<div id="layout-container">
	<?php foreach ($page["contents"] as $content) : ?>
		<?php if (empty($content['element'])) continue; ?>
	
		<?= $this->element('Rhino.' . '../Contents/element', ['content' => $content]) ?>
	<?php endforeach ?>
</div>