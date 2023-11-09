<?php 
$this->assign('title', $page["name"]); 
foreach ($page["contents"] as $content) { 
		if ($content['active']) {
			echo $this->element($content['element']['element'], $content->toArray());
		}
	}
?>