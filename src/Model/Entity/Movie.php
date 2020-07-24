<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Movie Entity
 *
 * @property int $id
 * @property string $link
 * @property string $title
 * @property string $description
 * @property string $channel_title
 * @property int $view_count
 * @property int $like_count
 * @property int $dislike_count
 * @property int $comment_count
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 */
class Movie extends Entity
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
        'link' => true,
        'title' => true,
        'description' => true,
        'channel_title' => true,
        'view_count' => true,
        'like_count' => true,
        'dislike_count' => true,
        'comment_count' => true,
        'created_at' => true,
        'updated_at' => true,
    ];
}
