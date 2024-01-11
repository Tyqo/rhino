<section class="stack">

	<h1><?= $tableName ?></h1>

	<figure class="table-wrapper">
		<table role="grid">
            <caption><?= __('Table fields') ?></caption>
            <thead>
                <tr>
                    <th scope="col"><?= __('Name'); ?></th>
                    <th scope="col"><?= __('Alias'); ?></th>
                    <th scope="col"><?= __('Type'); ?></th>
                    <th scope="col"><?= __('Default'); ?></th>
                    <!-- <th><?= __('Column'); ?></th> -->
                    <th data-cell="Actions" align="right"><?= __('Actions'); ?></th>
                </tr>
            <thead>

            <tbody>
            <?php foreach ($tableFields as $field) : ?>
                <tr>
                    <td><?= $field->name; ?></td>
                    <td><?= $field->alias; ?></td>
                    <td><?= $field->type; ?></td>
                    <td><?= $field->default_value ?? 'N&thinsp;/&thinsp;A'; ?></td>
                    <td data-cell="Actions">
                        <?php
                        $this->start('actions');
                        echo $this->element("layout-elements/actions", [
                            "edit" => [
                                "link" => ['action' => 'edit', $tableName, $field->name],
                                "valid" => in_array('edit', $rights)
                            ],
                            "duplicate" => [
                                "link" => ['action' => 'duplicate', $tableName, $field->name],
                                'valid' => true || in_array('edit', $rights)
                                // TODO: Extra rule for 'duplicate'? Else should be covered by 'new' - but does this exist?
                            ],
                            "delete" => [
                                "link" => ['action' => 'delete', $tableName, $field->name],
                                "valid" => in_array('edit', $rights),
                                "confirm" => __('Are you sure you want to delete: {0}?', $field->name),
                            ],
                        ]);
                        $this->end();
                        ?>
                        <?= $this->fetch('actions'); ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tbody>
		</table>
	</figure>

    <div class="action-area">
        <?= $this->Html->link("Add Cloumn", ["controller" => "Fields", "action" => "add", $tableName], ["class" => "button"]) ?>
        <?= $this->Html->link("Back", ['controller' => 'applications'], ["class" => "button"]); ?>
    </div>
</section>
