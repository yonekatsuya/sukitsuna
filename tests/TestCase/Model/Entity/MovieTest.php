<?php
namespace App\Test\TestCase\Model\Entity;

use App\Model\Entity\Movie;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Entity\Movie Test Case
 */
class MovieTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Entity\Movie
     */
    public $Movie;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Movie = new Movie();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Movie);

        parent::tearDown();
    }

    public function testMovieInstance() {
        $this->assertTrue(is_a($this->Movie,'App\Model\Entity\Movie'));
    }
}
