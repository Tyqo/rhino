<?php
declare(strict_types=1);

namespace Rhino\Model\Entity;

use Cake\ORM\Entity;

/**
 * NodeTree Entity
 *
 * @property int $id
 * @property string $name
 * @property bool|null $active
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property int $user_id
 * @property string $node_type
 * @property string|null $role
 * @property int|null $parent_id
 * @property int $lft
 * @property int $rght
 * @property int $level
 * @property int|null $template_id
 * @property string|null $language
 * @property int|null $version
 * @property string|null $config
 * @property string|null $content
 *
 * @property \Rhino\Model\Entity\ParentNodeTree $parent_node_tree
 * @property \Rhino\Model\Entity\ChildNodeTree[] $child_node_tree
 */
class Node extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'active' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'node_type' => true,
        'role' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'level' => true,
        'template_id' => true,
        'language' => true,
        'version' => true,
        'config' => true,
        'content' => true
    ];
}
