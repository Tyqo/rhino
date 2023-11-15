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
				
			// ToDo: type should be Mime type with exception for folder and File.
			if (is_dir($directory . $dir)) {
				$path .= DS;
				$file['type'] = 'directory';
				$file['path'] = str_replace($directory, '', $path);
				$file["children"] = $this->subDir($path, $types);
			} else {
				// $pathinfo = pathinfo($path);
				$file['type'] = mime_content_type($path);
				$file['path'] = str_replace($directory, '', $path);
			}

			if (!empty($types)) {
				if ($types[0] != 'directory' && $file['type'] == 'directory') {
					$file['options'] = ['disabled' => true];
				} else if ($types[0] != 'file') {
					$skip = true;
					foreach ($types as $type) {
						$pattern = sprintf('/%s/', addcslashes(trim($type), '/'));
						if (preg_match($pattern, $file['type'])) {
							$skip = false;
						}
					}
	
					if ($skip) {
						continue;
					}
				}

			}

			$dirs[] = $file;
		}

		return $dirs;
	}
}