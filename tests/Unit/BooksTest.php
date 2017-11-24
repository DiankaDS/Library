<?php

namespace Tests\Unit;

use App\Author;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BooksTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
//    public function testExample()
//    {
//        $this->assertTrue(true);
//    }

//    --- Home tests ---

    public function testHomeRoutes()
    {
//        $response = $this->call('GET', '/');
        $response = $this->get('/');
        $this
            ->assertEquals(200, $response->status());
        $response
            ->assertViewIs('home');

        $response = $this->get('/home');
        $this
            ->assertEquals(200, $response->status());

        $response = $this->json('POST', 'search_books', ['str_book' => 'Some book']);
        $response
            ->assertStatus(200)
            ->assertJson([]);
    }


//    public function testLogin()
//    {
//        $response = $this->get('login');
////            ->see('Welcome')
////            ->type('diana.agafonova@nixsolutions.com', 'email')
////            ->type('111111', 'password')
////            ->press('Login')
////            ->dontSee('Welcome');
//
//        $this
//            ->assertEquals(200, $response->status());
//    }

//    use WithoutMiddleware;



//    --- Books tests ---

    public function testBooksRoutes()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('add_book');
        $this->assertEquals(200, $response->status());
//        $response->assertViewIs('home');

    }


//    --- Profile tests ---

    public function testProfileRoutes()
    {
        $user = User::first();
        $this->actingAs($user);

        $this->assertTrue(true);
    }


//    --- Orders tests ---

    public function testOrdersRoutes()
    {
        $user = User::first();
        $this->actingAs($user);

        $this->assertTrue(true);
    }


//    --- Admin tests ---

    public function testAdminUsersRoutes()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->get('admin_users');
        $response->assertStatus(200);
    }

    public function testAdminBooksRoutes()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->get('admin_books');
        $response->assertStatus(200);
    }

    public function testAdminAuthorsRoutes()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->get('admin_authors');
        $response->assertStatus(200);

        $response = $this->post('admin_create_author', ['name' => 'Some test name']);
        $this->assertEquals(302, $response->status());

        $author_id = Author::where('name', '=', 'Some test name')->first()->id;
        $response = $this->post('admin_del_author/' . $author_id, ['admins_author_id' => $author_id]);
        $this->assertEquals(302, $response->status());
    }

    public function testAdminGenresRoutes()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->get('admin_genres');
        $response->assertStatus(200);

        $response = $this->post('admin_create_genre', ['genre' => 'Some test name']);
        $this->assertEquals(302, $response->status());

        $genre_id = DB::table('genres')->where('genres.name', '=', 'Some test name')->first()->id;
        $response = $this->post('admin_del_genre/' . $genre_id, ['admins_genre_id' => $genre_id]);
        $this->assertEquals(302, $response->status());
    }

    public function testAdminOrdersRoutes()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->get('admin_orders');
        $response->assertStatus(200);
    }

    public function testAdminReviewsRoutes()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->get('admin_reviews');
        $response->assertStatus(200);
    }

}
