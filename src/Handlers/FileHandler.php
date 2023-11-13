<?php
declare(strict_types=1);

namespace Rhino\Handlers;

class FileHandler {

	public function __construct() {
			
	}

	public function getSubDirs($directory = null) {
		if (empty($directory)) {
			$directory = RESOURCES;
		}

		$dirs = $this->subDir($directory);

		return $dirs;
	}

	private function subDir($directory) {
		$_dirs = array_diff(scandir($directory), array('..', '.'));
		$dirs = [];

		foreach ($_dirs as $dir) {

			if (!is_dir($directory . $dir)) {
				continue;
			}

			$path = $directory . $dir . DS;
			$children = $this->subDir($path);

			$dirs[] = [
				'name' => $dir,
				'path' => str_replace(ROOT, '', $path),
				'children' => $children
			];
		}

		return $dirs;
	}
}