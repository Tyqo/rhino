<?php

declare(strict_types=1);

namespace Tusk\View\Cell;

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
		$this->Groups = $this->fetchTable('Tusk.Groups');
		$this->Roles = $this->fetchTable('Tusk.Roles');
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
						'icon' => "Tusk.home"
					]
				]
			],
			[
				'heading' => 'Standartfunktionen',
				"buttons" => [
					[
						'name' => 'Seiten',
						'link' => ['controller' => 'Pages', 'action' => 'index'],
						'icon' => "Tusk.file",
						'rights' => 'tusk_pages'
					],
					[
						'name' => 'Medien',
						'link' => ['controller' => 'Media', 'action' => 'index'],
						'icon' => "Tusk.image",
						'rights' => 'tusk_media'
					],
					[
						'name' => 'Widgets',
						'link' => ['controller' => 'Widgets', 'action' => 'index'],
						'icon' => "Tusk.sidebar",
						'rights' => 'tusk_widgets'
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
						'icon' => "Tusk.table",
						'buttons' => [
							[
								'name' => 'Elements',
								'icon' => "Tusk.book",
								'link' => ['controller' => 'Tables', 'action' => 'index', 'tusk_elements'],
								'rights' => 'tusk_elements'
							],
							[
								'name' => 'Layouts',
								'icon' => "Tusk.book",
								'link' => ['controller' => 'Tables', 'action' => 'index', 'tusk_layouts'],
								'rights' => 'tusk_layouts'
							]
						]
					],
					[
						'name' => 'Admin',
						'icon' => "Tusk.settings",
						'buttons' => [
							[
								'name' => 'Applikation-Manager',
								'icon' => "Tusk.unlock",
								'link' => ['controller' => 'Applications', "action" => "index"],
								'rights' => 'tusk_apps'
							],
							[
								'name' => 'Nutzerverwaltung',
								'icon' => "Tusk.users",
								'link' => ['controller' => 'Users', 'action' => 'index'],
								'rights' => 'tusk_users'
							],
							[
								'name' => 'Rechteverwaltung',
								'icon' => "Tusk.lock",
								'link' => ['controller' => 'Roles', 'action' => 'index'],
								'rights' => 'tusk_roles'
							]
						]
					],
					[
						'name' => 'Profil',
						'icon' => "Tusk.user",
						'buttons' => [
							[
								'name' => 'Profil bearbeiten',
								'icon' => "Tusk.edit",
								'link' => ["controller" => "Users", "action" => "edit", $this->user->id]
							],
							[
								'name' => 'log-out',
								'icon' => "Tusk.log-out",
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
