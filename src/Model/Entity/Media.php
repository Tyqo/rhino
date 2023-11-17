<?php
declare(strict_types=1);

namespace Rhino\Model\Entity;

use Cake\ORM\Entity;

/**
 * Media Entity
 *
 * @property int $id
 * @property string|null $filename
 * @property string|null $description
 * @property string|null $filetype
 * @property int|null $position
 * @property int|null $media_category_id
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \Rhino\Model\Entity\MediaCategory $rhino_media_category
 */
class Media extends Entity
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
        'filename' => true,
        'description' => true,
        'type' => true,
        'position' => true,
        'media_category_id' => true,
        'created' => true,
        'modified' => true,
    ];
}
