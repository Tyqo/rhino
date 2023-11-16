<?php
declare(strict_types=1);

namespace Rhino\Model\Entity;

use Cake\ORM\Entity;

/**
 * RhinoMediaCategory Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 *
 * @property \Rhino\Model\Entity\Media[] $rhino_media
 */
class MediaCategory extends Entity
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
        'description' => true,
        'rhino_media' => true,
    ];
}
