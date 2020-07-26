<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersMoviesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UsersMoviesTable Test Case
 */
class UsersMoviesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersMoviesTable
     */
    public $UsersMovies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UsersMovies',
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
        $config = TableRegistry::getTableLocator()->exists('UsersMovies') ? [] : ['className' => UsersMoviesTable::class];
        $this->UsersMovies = TableRegistry::getTableLocator()->get('UsersMovies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersMovies);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
