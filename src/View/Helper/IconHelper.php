<?php
/* src/View/Helper/LinkHelper.php */

namespace Rhino\View\Helper;

use Cake\View\Helper;
use Generator;
use Cake\Core\App;
use Cake\View\Exception\MissingElementException;
use LogicException;
use Throwable;
use Cake\Core\Plugin;

class IconHelper extends Helper {

	/**
	 * Constant for view file type 'element'
	 *
	 * @var string
	 */
	public const TYPE_ELEMENT = 'icon';

	/**
	 * File extension. Defaults to ".php".
	 *
	 * @var string
	 */
	protected string $_ext = '.svg';

	/**
	 * An array of variables
	 *
	 * @var array<string, mixed>
	 */
	protected array $viewVars = [];

	public function svg(string $name, array $data = [], array $options = []): string {
		$options += [
			'callbacks' => false,
			'cache' => null,
			'plugin' => null,
			'ignoreMissing' => false
		];

		$pluginCheck = $options['plugin'] !== false;

		$file = $this->_getElementFileName($name, $pluginCheck);

		
	
		if ($file) {
			return $this->_render($file, $data);
		}

		if ($options['ignoreMissing']) {
			return '';
		}

		[$plugin, $elementName] = $this->getView()->pluginSplit($name, $pluginCheck);
		$paths = iterator_to_array($this->getElementPaths($plugin));
		throw new MissingElementException([$name . $this->_ext, $elementName . $this->_ext], $paths);
	}

	/**
	 * Finds an element filename, returns false on failure.
	 *
	 * @param string $name The name of the element to find.
	 * @param bool $pluginCheck - if false will ignore the request's plugin if parsed plugin is not loaded
	 * @return string|false Either a string to the element filename or false when one can't be found.
	 */
	protected function _getElementFileName(string $name, bool $pluginCheck = true): string|false {
		[$plugin, $name] = $this->getView()->pluginSplit($name, $pluginCheck);

		$name .= $this->_ext;

		
		foreach ($this->getElementPaths($plugin) as $path) {
			if (is_file($path . $name)) {
				return $path . $name;
			}
		}

		return false;
	}

	/**
	 * Get an iterator for element paths.
	 *
	 * @param string|null $plugin The plugin to fetch paths for.
	 * @return \Generator
	 */
	protected function getElementPaths(?string $plugin): Generator {
		$paths = $this->getPluginPath($plugin);

		$paths = array_merge(
			[$paths],
			App::core('webroot')
		);

		foreach ($paths as $path) {
			foreach (["icon"] as $subdir) {
				yield $path . $subdir . DIRECTORY_SEPARATOR;
			}
		}
	}

	private function getPluginPath(?string $pluginName): string {

		if (empty($pluginName)) {
			return WWW_ROOT;
		}

		return Plugin::path($pluginName) . 'webroot' . DS ;
	}


	/**
	 * Renders and returns output for given template filename with its
	 * array of data. Handles parent/extended templates.
	 *
	 * @param string $templateFile Filename of the template
	 * @param array $data Data to include in rendered view. If empty the current
	 *   View::$viewVars will be used.
	 * @return string Rendered output
	 * @throws \LogicException When a block is left open.
	 * @triggers View.beforeRenderFile $this, [$templateFile]
	 * @triggers View.afterRenderFile $this, [$templateFile, $content]
	 */
	protected function _render(string $templateFile, array $data = []): string {
		if (empty($data)) {
			$data = $this->viewVars;
		}

		$content = $this->_evaluate($templateFile, $data);
	
		return $content;
	}

	/**
	 * Sandbox method to evaluate a template / view script in.
	 *
	 * @param string $templateFile Filename of the template.
	 * @param array $dataForView Data to include in rendered view.
	 * @return string Rendered output
	 */
	protected function _evaluate(string $templateFile, array $dataForView): string {
		extract($dataForView);

		$bufferLevel = ob_get_level();
		ob_start();

		try {
			// Avoiding $templateFile here due to collision with extract() vars.
			include func_get_arg(0);
		} catch (Throwable $exception) {
			while (ob_get_level() > $bufferLevel) {
				ob_end_clean();
			}

			throw $exception;
		}

		return (string)ob_get_clean();
	}
}
