<div class="media-select">
	<?php foreach($mediaCategories as $category) : ?>
		<details open>
			<summary><?= $category->name ?></summary>
			<ul>
				<?php foreach ($category->media as $media) : ?>
					<li>
						<figure>
							<img class="meida-image" src="<?= '/media/' . $media->filename ?>"/>

							<figcaption>
								<input id="<?= $media->id ?>" type="radio" value="<?= $media->id ?>" name="media">
								<label class="" for="<?= $media->id ?>"><?= $media->filename ?></label>
							</figcaption>
						</figure>
					</li>
				<?php endforeach ?>
			</ul>
		</details>
	<?php endforeach ?>
</div>

<details>
	<summary>debug</summary>
	<?php debug($mediaCategories) ?>
</details>