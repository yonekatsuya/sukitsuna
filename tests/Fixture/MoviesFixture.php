<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MoviesFixture
 */
class MoviesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'link' => ['type' => 'string', 'length' => 1000, 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'title' => ['type' => 'string', 'length' => 1000, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 5000, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'channel_title' => ['type' => 'string', 'length' => 1000, 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'view_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'like_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'dislike_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'comment_count' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created_at' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'updated_at' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => '', 'precision' => null],
        'group_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_unicode_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'link' => '<iframe></iframe>',
                'title' => 'test1',
                'description' => 'this is test1',
                'channel_title' => 'test_channnel',
                'view_count' => 100,
                'like_count' => 100,
                'dislike_count' => 100,
                'comment_count' => 100,
                'created_at' => '2020-07-25 14:27:38',
                'updated_at' => '2020-07-25 14:27:38',
                'group_name' => '乃木坂46',
            ],
            [
                'id' => 2,
                'link' => '<iframe></iframe>',
                'title' => 'test2',
                'description' => 'this is test2',
                'channel_title' => 'test_channnel',
                'view_count' => 100,
                'like_count' => 100,
                'dislike_count' => 100,
                'comment_count' => 100,
                'created_at' => '2020-07-25 14:27:39',
                'updated_at' => '2020-07-25 14:27:39',
                'group_name' => '欅坂46',
            ],
            [
                'id' => 3,
                'link' => '<iframe></iframe>',
                'title' => 'test3',
                'description' => 'this is test3',
                'channel_title' => 'test_channnel',
                'view_count' => 100,
                'like_count' => 100,
                'dislike_count' => 100,
                'comment_count' => 100,
                'created_at' => '2020-07-25 14:27:40',
                'updated_at' => '2020-07-25 14:27:40',
                'group_name' => '日向坂46',
            ],
        ];
        parent::init();
    }
}
