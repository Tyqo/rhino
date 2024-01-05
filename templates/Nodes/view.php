<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $nodeTree
 */
?>
<div class="row container">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Node Tree'), ['action' => 'edit', $nodeTree->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Node Tree'), ['action' => 'delete', $nodeTree->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nodeTree->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Node Tree'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Node Tree'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="nodeTree view content">
            <h3><?= h($nodeTree->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($nodeTree->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Node Type') ?></th>
                    <td><?= h($nodeTree->node_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($nodeTree->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Parent Node Tree') ?></th>
                    <td><?= $nodeTree->hasValue('parent_node_tree') ? $this->Html->link($nodeTree->parent_node_tree->name, ['controller' => 'NodeTree', 'action' => 'view', $nodeTree->parent_node_tree->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Language') ?></th>
                    <td><?= h($nodeTree->language) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($nodeTree->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Id') ?></th>
                    <td><?= $this->Number->format($nodeTree->user_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lft') ?></th>
                    <td><?= $this->Number->format($nodeTree->lft) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rght') ?></th>
                    <td><?= $this->Number->format($nodeTree->rght) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= $this->Number->format($nodeTree->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Template Id') ?></th>
                    <td><?= $nodeTree->template_id === null ? '' : $this->Number->format($nodeTree->template_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Version') ?></th>
                    <td><?= $nodeTree->version === null ? '' : $this->Number->format($nodeTree->version) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($nodeTree->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($nodeTree->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= $nodeTree->active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Config') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($nodeTree->config)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Content') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($nodeTree->content)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Node Tree') ?></h4>
                <?php if (!empty($nodeTree->child_node_tree)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Node Type') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Lft') ?></th>
                            <th><?= __('Rght') ?></th>
                            <th><?= __('Level') ?></th>
                            <th><?= __('Template Id') ?></th>
                            <th><?= __('Language') ?></th>
                            <th><?= __('Version') ?></th>
                            <th><?= __('Config') ?></th>
                            <th><?= __('Content') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($nodeTree->child_node_tree as $childNodeTree) : ?>
                        <tr>
                            <td><?= h($childNodeTree->id) ?></td>
                            <td><?= h($childNodeTree->name) ?></td>
                            <td><?= h($childNodeTree->active) ?></td>
                            <td><?= h($childNodeTree->created) ?></td>
                            <td><?= h($childNodeTree->modified) ?></td>
                            <td><?= h($childNodeTree->user_id) ?></td>
                            <td><?= h($childNodeTree->node_type) ?></td>
                            <td><?= h($childNodeTree->role) ?></td>
                            <td><?= h($childNodeTree->parent_id) ?></td>
                            <td><?= h($childNodeTree->lft) ?></td>
                            <td><?= h($childNodeTree->rght) ?></td>
                            <td><?= h($childNodeTree->level) ?></td>
                            <td><?= h($childNodeTree->template_id) ?></td>
                            <td><?= h($childNodeTree->language) ?></td>
                            <td><?= h($childNodeTree->version) ?></td>
                            <td><?= h($childNodeTree->config) ?></td>
                            <td><?= h($childNodeTree->content) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'NodeTree', 'action' => 'view', $childNodeTree->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'NodeTree', 'action' => 'edit', $childNodeTree->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'NodeTree', 'action' => 'delete', $childNodeTree->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childNodeTree->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
