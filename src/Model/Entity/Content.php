<?php
declare(strict_types=1);

namespace Rhino\Model\Entity;

use Cake\ORM\Entity;

/**
 * RhinoContent Entity
 *
 * @property int $id
 * @property int|null $page_id
 * @property int|null $element_id
 * @property string|null $html
 * @property bool|null $active
 * @property int|null $position
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class Content extends Entity
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
        'page_id' => true,
        'element_id' => true,
        'html' => true,
        'media' => true,
        'active' => true,
        'position' => true,
        'created' => true,
        'modified' => true,
    ];
}
