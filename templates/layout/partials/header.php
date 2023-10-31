<header>
	<nav>
		<ul>
			<li>
				<button id="menu-button" class="button icon">
					<span class="sr-only">Toggle menu</span>
					<?= $this->Icon->svg('Rhino.menu') ?>
				</button>
			</li>
		</ul>

		<ul class="cluster">
			<li>
				<p><strong><?= $this->fetch('title') ?></strong></p>
			</li>
		</ul>

		<ul class="cluster">

			<li>
				<details role="list">
					<summary aria-haspopup="listbox" role="button" class="primary icon"><?= $this->Icon->svg('user') ?> <span>Profil</span></summary>
					<ul role="listbox">
						<li><a href="#" data-theme-switcher="auto">Theme: Auto</a></li>
						<li><a href="#" data-theme-switcher="light">Theme: Light</a></li>
						<li><a href="#" data-theme-switcher="dark">Theme: Dark</a></li>
						<li role="presentation">
							<?= $this->Html->link(
								$this->Icon->svg('user') . "<span>Profil</span>",
								["controller" => "Users", "action" => "edit", $this->Identity->get("id")],
								['class' => 'button', 'escape' => false]
							) ?>
						</li>
						<li role="presentation">
							<?= $this->Html->link(
								$this->Icon->svg('log-out') . "<span>Log-out</span>",
								['controller' => 'users', 'action' => 'logout'],
								['class' => 'button', 'escape' => false]
							) ?>
						</li>
					</ul>
				</details>
			</li>
		</ul>
	</nav>
</header>