<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $equipmentNumber
 * @property int|null $sapNumber
 * @property string|null $street
 * @property string|null $district
 * @property string|null $city
 * @property string|null $postcode
 * @property string|null $houseNumber
 * @property int $salutation_id
 */
class Customer extends Entity
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
        'created' => true,
        'modified' => true,
        'equipmentNumber' => true,
        'sapNumber' => true,
        'street' => true,
        'district' => true,
        'city' => true,
        'postcode' => true,
        'houseNumber' => true,
        'salutation_id' => true,
    ];
}
