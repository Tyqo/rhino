<?php
declare(strict_types=1);

namespace Tusk\Model\Entity;

use Cake\ORM\Entity;

/**
 * TuskGallery Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property int $position
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 * @property int $user_id
 */
class Gallery extends Entity
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
    protected $_accessible = [
        'name' => true,
        'active' => true,
        'position' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
    ];
}
