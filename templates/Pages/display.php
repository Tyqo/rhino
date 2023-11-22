<?php 
$this->assign('title', $page["name"]); 
foreach ($page["contents"] as $content) { 
		if (empty($content['element'])) continue;

		if ($content['active']) {
			echo $this->element($content['element']['elementName'], $content->toArray());
		}
	}
?>