<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;

class BooksTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }


//    use DatabaseMigrations;

//    public function testBasicExample1()
//    {
//        $this->browse(function ($browser) {
//            $browser->visit('/')
//                ->see('Laravel 5');
//        });
//    }

//    public function testAddBook()
//    {
//        $this->visit('/add_book/complete')
//            ->type('Some book', 'name')
//            ->type('Irvin Yalom', 'author')
//            ->select('2', 'genre')
////            ->type('', 'photo')
//            ->press('Add_book')
//            ->see("Book created!");
//    }

    public function testIndex()
    {
        $response = $this->call('GET', '/');
        $this->assertEquals(200, $response->status());
    }



}
