<?php

namespace Tests\Unit;

use App\Author;
use App\LibBook;
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

//    --- Home tests ---

//    use RefreshDatabase;


    public function testHomeRoutes()
    {
//        $response = $this->call('GET', '/');
        $response = $this->get('/');
        $this->assertEquals(200, $response->status());
        $response->assertViewIs('home');

        $response = $this->get('/home');
        $this->assertEquals(200, $response->status());

        $response = $this->json('POST', 'search_books', [
            'str_book' => 'Some book'
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([]);
    }


//    --- Books tests ---

    public function testBooksRoutes()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('add_book');
        $this->assertEquals(200, $response->status());

        $book_id = LibBook::first()->id;
        $response = $this->get('book_' . $book_id);
        $this->assertEquals(200, $response->status());

        $response = $this->post('add_book/complete', [
            'name' => 'Some test book',
            'year' => '1999',
            'author' => 'Some test author',
            'genre' => '1',
        ]);
        $this->assertEquals(302, $response->status());

        $response = $this->post('/add_review', [
            'book_id' => 1,
            'user_id' => 1,
            'text' => 'Some test review',
            'rating' => 5,
        ]);
        $this->assertEquals(302, $response->status());
    }


//    --- Profile tests ---

    public function testProfileRoutes()
    {
        $user = User::first();
        $this->actingAs($user);

        $user_id = User::first()->id;

        $response = $this->get('profile/' . $user_id);
        $response->assertStatus(200);

        $response = $this->get('/update_user');
        $response->assertStatus(200);

        $response = $this->get('/set_password');
        $response->assertStatus(200);
    }


//    --- Orders tests ---

    public function testOrdersRoutes()
    {
        $user = User::first();
        $this->actingAs($user);

        $response = $this->get('orders_to_user');
        $response->assertStatus(200);

        $response = $this->get('orders_from_user');
        $response->assertStatus(200);
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

        $response = $this->post('admin_create_author', [
            'name' => 'Some test name'
        ]);
        $this->assertEquals(302, $response->status());

        $author_id = Author::where('name', '=', 'Some test name')->first()->id;
        $response = $this->post('admin_del_author/' . $author_id, [
            'admins_author_id' => $author_id
        ]);
        $this->assertEquals(302, $response->status());
    }

    public function testAdminGenresRoutes()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->get('admin_genres');
        $response->assertStatus(200);

        $response = $this->post('admin_create_genre', [
            'genre' => 'Some test name'
        ]);
        $this->assertEquals(302, $response->status());

        $genre_id = DB::table('genres')
            ->where('genres.name', '=', 'Some test name')
            ->first()
            ->id;
        $response = $this->post('admin_del_genre/' . $genre_id, [
            'admins_genre_id' => $genre_id
        ]);
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
