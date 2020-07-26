<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property int $uniqueid
 * @property string $name
 * @property string $screen_name
 * @property string|null $location
 * @property string|null $description
 * @property string|null $other_url
 * @property int $followers_count
 * @property int $friends_count
 * @property int $favourites_count
 * @property string|null $profile_image_url
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 *
 */
class User extends Entity
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
        'uniqueid' => true,
        'name' => true,
        'screen_name' => true,
        'location' => true,
        'description' => true,
        'other_url' => true,
        'followers_count' => true,
        'friends_count' => true,
        'favourites_count' => true,
        'profile_image_url' => true,
        'created_at' => true,
        'updated_at' => true,
        'movies' => true
    ];
}
