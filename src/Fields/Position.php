<?php

declare(strict_types=1);

namespace Rhino\Fields;

class Position extends Field {

	private $arrows = [
		'up' => '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>',
		'down' => '<svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>'
	];


	public function load($value) {
		$displayOptions = [
			'hidden' => true
		];

		if (empty($value) || $value == 0) {
			$Table = $this->getTable($this->field->table_name);
			$query = $Table->find('all');
			$number = $query->count();
			$displayOptions['value'] = $number + 1;
		}

		return $displayOptions;
	}

	public function display($value, $entry) {
		$up = $this->moveLink('up', $entry->id);
		$down = $this->moveLink('down', $entry->id);

		$attrs = [
			'class' => 'cluster pill',
			'href' => $up
		];

		$value = $this->Templater->format('tag', [
			'tag' => 'span',
			'attrs' => $this->Templater->formatAttributes(['class' => 'button contrast']),
			'content' => $value
		]);

		return $this->Templater->format('tag', [
			'tag' => 'div',
			'attrs' => $this->Templater->formatAttributes($attrs),
			'content' => $up . $value . $down
		]);
	}

	public function moveLink($action, $id) {
		$link =  sprintf('/rhino/tables/move%s/%s/%s/%s', ucfirst($action), $this->field->table_name, $this->field->name, $id);

		$attrs = [
			'class' => 'button icon',
			'href' => $link,
			'title' => 'Move ' . $action
		];

		return $this->Templater->format('tag', [
			'tag' => 'a',
			'attrs' => $this->Templater->formatAttributes($attrs),
			'content' => $this->arrows[$action]
		]);
	}
}
