<?php
namespace App\Test\TestCase\Controller;

use App\Controller\MoviesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MoviesController Test Case
 *
 * @uses \App\Controller\MoviesController
 */
class MoviesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Movies',
    ];

    /**
     * Test store method
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'link' => '<iframe></iframe>',
            'title' => 'storetest',
            'description' => 'this is storetest',
            'channel_title' => 'store',
            'view_count' => 200,
            'like_count' => 200,
            'dislike_count' => 200,
            'comment_count' => 200,
            'created_at' => '2020-07-25 14:27:40',
            'updated_at' => '2020-07-25 14:27:40',
            'groupName' => 'BiSH'
        ];
        $this->post('/movies/store',$data);
        $this->assertResponseSuccess();
        $movies = TableRegistry::get('Movies');
        $query = $movies->find()->where(['title' => $data['title']]);
        $this->assertEquals(1,$query->count());
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $id = 1;
        $movies = TableRegistry::get('Movies');
        $movie = $movies->get($id);
        $this->assertEquals('乃木坂46',$movie['group_name']);
        $result = $movies->delete($movie);
        $this->assertEquals(1,$result);
    }
}
