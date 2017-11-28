<?php

namespace Tests\Unit;

use App\Author;
use App\LibBook;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
//use Illuminate\Contracts\Console\Kernel;
//use Illuminate\Database\Seeder;


class BooksTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

//    --- Home tests ---

    use RefreshDatabase;
//
//    use DatabaseMigrations;
//    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->artisan("db:seed", ['--class' => 'UsersTableSeeder']);
    }

//    public function testUserRegister()
//    {
////        $user = User::insertGetId([
//        $user = DB::table('users')->create([
//            'username' => 'test',
//            'name' => 'TestName',
//            'surname' => 'TestSurname',
//            'email' => 'test@test.com',
//            'phone' => '123456789',
//            'password' => bcrypt('test'),
//            'photo' => 'default_user.jpg',
//        ]);
////        $this->assertEquals($user, User::find($user)->id);
//
////        $admin = User::insertGetId([
//        $admin = DB::table('users')->create([
//            'username' => 'test_admin',
//            'name' => 'TestAdminName',
//            'surname' => 'TestAdminSurname',
//            'email' => 'test_admin@test.com',
//            'phone' => '89898989',
//            'password' => bcrypt('admin'),
//            'photo' => 'default_user.jpg',
//            'admin' => 1,
//        ]);
////        $this->assertEquals($admin, User::find($admin)->id);
//    }



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



////    --- Register tests ---
//
//    public function testUserRegister()
//    {
//        $response = $this->get('/register');
//        $response->assertStatus(200);
//
//
//
//        $response = $this->post('/register', [
//            'username' => 'test',
//            'name' => 'TestName',
//            'surname' => 'TestSurname',
//            'email' => 'test@test.com',
//            'phone' => '123456789',
//            'password' => 'test',
//            'password_confirmation' => 'test',
//        ]);
//
////        $response->assertRedirect('/home');
//        $response->assertViewIs('home');
//
//
//////        $this->assertEquals('test', User::find('test')->name);
//////        $this->assertEquals(302, $response->status());
//    }







////    --- Books tests ---
//
//    public function testBooksRoutes()
//    {
//        $user = User::first();
//        $this->actingAs($user);
//
//        $response = $this->get('add_book');
//        $this->assertEquals(200, $response->status());
//
//        $response = $this->post('add_book/complete', [
//            'name' => 'Some test book',
//            'year' => '1999',
//            'author' => 'Some test author',
//            'genre' => '1',
//        ]);
//        $this->assertEquals(302, $response->status());
//
//        $book_id = LibBook::first()->id;
//        $response = $this->get('book_' . $book_id);
//        $this->assertEquals(200, $response->status());
//
//        $response = $this->post('/add_review', [
//            'book_id' => 1,
//            'user_id' => 1,
//            'text' => 'Some test review',
//            'rating' => 5,
//        ]);
//        $this->assertEquals(302, $response->status());
//    }


////    --- Profile tests ---
//
//    public function testProfileRoutes()
//    {
//        $user = User::first();
//        $this->actingAs($user);
//
//        $user_id = User::first()->id;
//
//        $response = $this->get('profile/' . $user_id);
//        $response->assertStatus(200);
//
//        $response = $this->get('/update_user');
//        $response->assertStatus(200);
//
//        $response = $this->get('/set_password');
//        $response->assertStatus(200);
//    }
//
//
////    --- Orders tests ---
//
//    public function testOrdersRoutes()
//    {
//        $user = User::first();
//        $this->actingAs($user);
//
//        $response = $this->get('orders_to_user');
//        $response->assertStatus(200);
//
//        $response = $this->get('orders_from_user');
//        $response->assertStatus(200);
//    }
//
//
////    --- Admin tests ---
//
//    public function testAdminUsersRoutes()
//    {
//        $user = User::where('admin', '=', '1')->first();
//        $this->actingAs($user);
//
//        $response = $this->get('admin_users');
//        $response->assertStatus(200);
//    }
//
//    public function testAdminBooksRoutes()
//    {
//        $user = User::where('admin', '=', '1')->first();
//        $this->actingAs($user);
//
//        $response = $this->get('admin_books');
//        $response->assertStatus(200);
//    }
//
//    public function testAdminAuthorsRoutes()
//    {
//        $user = User::where('admin', '=', '1')->first();
//        $this->actingAs($user);
//
//        $response = $this->get('admin_authors');
//        $response->assertStatus(200);
//
//        $response = $this->post('admin_create_author', [
//            'name' => 'Some test name'
//        ]);
//        $this->assertEquals(302, $response->status());
//
//        $author_id = Author::where('name', '=', 'Some test name')->first()->id;
//        $response = $this->post('admin_del_author/' . $author_id, [
//            'admins_author_id' => $author_id
//        ]);
//        $this->assertEquals(302, $response->status());
//    }
//
//    public function testAdminGenresRoutes()
//    {
//        $user = User::where('admin', '=', '1')->first();
//        $this->actingAs($user);
//
//        $response = $this->get('admin_genres');
//        $response->assertStatus(200);
//
//        $response = $this->post('admin_create_genre', [
//            'genre' => 'Some test name'
//        ]);
//        $this->assertEquals(302, $response->status());
//
//        $genre_id = DB::table('genres')
//            ->where('genres.name', '=', 'Some test name')
//            ->first()
//            ->id;
//        $response = $this->post('admin_del_genre/' . $genre_id, [
//            'admins_genre_id' => $genre_id
//        ]);
//        $this->assertEquals(302, $response->status());
//    }
//
//    public function testAdminOrdersRoutes()
//    {
//        $user = User::where('admin', '=', '1')->first();
//        $this->actingAs($user);
//
//        $response = $this->get('admin_orders');
//        $response->assertStatus(200);
//    }
//
//    public function testAdminReviewsRoutes()
//    {
//        $user = User::where('admin', '=', '1')->first();
//        $this->actingAs($user);
//
//        $response = $this->get('admin_reviews');
//        $response->assertStatus(200);
//    }

}
