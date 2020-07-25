<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MoviesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MoviesTable Test Case
 */
class MoviesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MoviesTable
     */
    public $MoviesTable;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Movies',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Movies') ? [] : ['className' => MoviesTable::class];
        $this->MoviesTable = TableRegistry::getTableLocator()->get('Movies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MoviesTable);

        parent::tearDown();
    }

    public function testMoviesTableFind() {
        $result = $this->MoviesTable->find('all')->first();
        $this->assertFalse(empty($result));
        $this->assertTrue(is_a($result,'App\Model\Entity\Movie'));
        $this->assertEquals($result->id,1);
        $this->assertStringStartsWith('this is',$result->description);
    }
}
