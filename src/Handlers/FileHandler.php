<?php
declare(strict_types=1);

namespace Rhino\Handlers;

class FileHandler {

	public function __construct() {
			
	}

	public function get($directory = null, $types = []) {
		if (empty($directory)) {
			$directory = WWW_ROOT;
		} else {
			$directory = WWW_ROOT . $directory . DS;
		}

		if (!is_dir($directory)) {
			return [];
		}

		$dirs = $this->subDir($directory, $types);

		return $dirs;
	}

	private function subDir($directory, $types = []) {

		$_dirs = array_diff(scandir($directory), array('..', '.'));
		$dirs = [];

		foreach ($_dirs as $dir) {			
			$path = $directory . $dir;
			
			$file = [
				'name' => $dir,
			];
				
			if (is_dir($directory . $dir)) {
				$path .= DS;
				$file['type'] = 'folder';
				$file['path'] = str_replace(WWW_ROOT, '', $path);
				$file["children"] = $this->subDir($path, $types);
			} else {
				$pathinfo = pathinfo($path);
				$file['type'] = $pathinfo['extension'];
				$file['path'] = str_replace(WWW_ROOT, '', $path);
			}

			if (!empty($types) && !in_array($file['type'], $types)) {
				if ($file['type'] != 'folder' && !in_array('file', $types)) {
					continue;
				}

				if ($file['type'] == 'folder') {
					$file['options'] = ['disabled' => true];
				}
			}

			$dirs[] = $file;
		}

		return $dirs;
	}
}