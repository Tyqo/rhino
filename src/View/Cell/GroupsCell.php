<?php

declare(strict_types=1);

namespace Rhno\View\Cell;

use Cake\View\Cell;

/**
 * Sidebar cell
 */
class GroupsCell extends Cell {
	/**
	 * List of valid options that can be passed into this
	 * cell's constructor.
	 *
	 * @var array<string, mixed>
	 */
	protected array $_validCellOptions = [];

	/**
	 * Initialization logic run at the end of object construction.
	 *
	 * @return void
	 */
	public function initialize(): void {
		$this->Groups = $this->fetchTable('Rhno.Groups');
		$this->Roles = $this->fetchTable('Rhno.Roles');
	}

	/**
	 * Default display method.
	 *
	 * @return void
	 */
	public function display() {
		$this->user = $this->request->getAttribute('authentication')->getIdentity();

		// ToDo: Contain bricks new installs?
		$_groups = $this->Groups->find('all')->contain(['Applications'])->all();
		$_apps = $this->Groups->Applications->find('all')->toArray();
		$groups = [];

		$handledApps = [];
		foreach ($_groups as $group) {
			$apps = [];
			foreach ($group['applications'] as $app) {
				$apps[] = [
					'name' => isset($app['alias']) ? $app['alias'] : $app["name"],
					'icon' => null,
					'link' => ['controller' => 'Tables', "action" => "index", $app['name']],
					'rights' => $app['name']
				];
				$handledApps[] = $app['name'];
			}

			$groups[] = [
				'name' => $group["name"],
				'icon' => null,
				'buttons' => $apps
			];
		}

		foreach ($_apps as $app) {
			if (in_array($app['name'], $handledApps)) {
				continue;
			}

			$groups[] = [
				'name' => isset($app['alias']) ? $app['alias'] : $app["name"],
				'icon' => null,
				'link' => ['controller' => 'Tables', "action" => "index", $app['name']],
				'rights' => $app['name']
			];
		}

		$navs = [
			[
				'heading' => 'Angemeldet als ' . $this->user->name,
				"buttons" => [
					[
						'name' => 'Dashboard',
						'link' => ['controller' => 'Overview', 'action' => 'display', 'home'],
						'icon' => "Rhno.home"
					]
				]
			],
			[
				'heading' => 'Standartfunktionen',
				"buttons" => [
					[
						'name' => 'Seiten',
						'link' => ['controller' => 'Pages', 'action' => 'index'],
						'icon' => "Rhno.file",
						'rights' => 'rhno_pages'
					],
					[
						'name' => 'Medien',
						'link' => ['controller' => 'Media', 'action' => 'index'],
						'icon' => "Rhno.image",
						'rights' => 'rhno_media'
					],
					[
						'name' => 'Widgets',
						'link' => ['controller' => 'Widgets', 'action' => 'index'],
						'icon' => "Rhno.sidebar",
						'rights' => 'rhno_widgets'
					]
				]
			],
			[
				'heading' => 'Zusatzfunktionen',
				'buttons' => $groups
			],
			[
				'heading' => 'Einstellungen',
				"buttons" => [
					[
						'name' => 'Templates',
						'icon' => "Rhno.table",
						'buttons' => [
							[
								'name' => 'Elements',
								'icon' => "Rhno.book",
								'link' => ['controller' => 'Tables', 'action' => 'index', 'rhno_elements'],
								'rights' => 'rhno_elements'
							],
							[
								'name' => 'Layouts',
								'icon' => "Rhno.book",
								'link' => ['controller' => 'Tables', 'action' => 'index', 'rhno_layouts'],
								'rights' => 'rhno_layouts'
							]
						]
					],
					[
						'name' => 'Admin',
						'icon' => "Rhno.settings",
						'buttons' => [
							[
								'name' => 'Applikation-Manager',
								'icon' => "Rhno.unlock",
								'link' => ['controller' => 'Applications', "action" => "index"],
								'rights' => 'rhno_apps'
							],
							[
								'name' => 'Nutzerverwaltung',
								'icon' => "Rhno.users",
								'link' => ['controller' => 'Users', 'action' => 'index'],
								'rights' => 'rhno_users'
							],
							[
								'name' => 'Rechteverwaltung',
								'icon' => "Rhno.lock",
								'link' => ['controller' => 'Roles', 'action' => 'index'],
								'rights' => 'rhno_roles'
							]
						]
					],
					[
						'name' => 'Profil',
						'icon' => "Rhno.user",
						'buttons' => [
							[
								'name' => 'Profil bearbeiten',
								'icon' => "Rhno.edit",
								'link' => ["controller" => "Users", "action" => "edit", $this->user->id]
							],
							[
								'name' => 'log-out',
								'icon' => "Rhno.log-out",
								'link' => ["controller" => "Users", "action" => "logout"]
							]
						]
					]
				],
			]
		];


		$this->set([
			"navs" => $this->cleanNav($navs),
			"user" => $this->user
		]);
	}

	private function cleanNav($navs) {
		$checkRights = function ($button) {
			if (!isset($button['rights'])) {
				return $button;
			}

			$access = $this->Roles->checkGroupRights($this->user->role_id, $button['rights'], 'view');
			if (!$access) {
				return;
			}

			return $button;
		};

		$isEmpty = function ($group) {
			if (isset($group['buttons'])) {
				$values = array_filter($group['buttons']);
				if (empty($values)) {
					return;
				}
			}

			return $group;
		};

		$navs = array_map(function ($nav) use ($checkRights, $isEmpty) {
			$nav['buttons'] = array_map(function ($group) use ($checkRights) {
				if (isset($group['buttons'])) {
					$group['buttons'] = array_map($checkRights, $group['buttons']);
				}

				return $group;
			}, $nav['buttons']);

			$nav['buttons'] = array_map($checkRights, $nav['buttons']);
			$nav['buttons'] = array_map($isEmpty, $nav['buttons']);

			return $nav;
		}, $navs);

		$navs = array_map($isEmpty, $navs);
		$navs = array_filter($navs);
		return $navs;
	}
}
