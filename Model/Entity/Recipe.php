<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Recipe Entity
 *
 * @property string $recipes_name
 * @property string $category
 * @property string $preparation_method
 * @property int $id
 *
 * @property \App\Model\Entity\Ingredient[] $ingredients
 */
class Recipe extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'recipes_name' => true,
        'category' => true,
        'preparation_method' => true,
        'ingredients' => true
    ];
}
