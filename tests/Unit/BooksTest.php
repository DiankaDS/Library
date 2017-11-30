<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BooksTest extends TestCase
{
    use RefreshDatabase;
//    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');

        $user = User::where('admin', '=', '0')->first();
        $this->actingAs($user);
    }

//    --- Auth tests ---

    public function testAuthRoutes()
    {
        $response = $this->get('/register');
        $response->assertRedirect('/home');

        $response = $this->get('/login');
        $response->assertRedirect('/home');

        $response = $this->get('/password/reset');
        $response->assertRedirect('/home');

        $response = $this->post('/password/email', []);
        $response->assertRedirect('/home');
    }

//    --- Home tests ---

    public function testHomeRoutes()
    {
        $response = $this->get('/');
        $this->assertEquals(200, $response->status());
        $response->assertViewIs('home');
        $response->assertDontSee('Welcome');

        $response = $this->get('/home');
        $this->assertEquals(200, $response->status());
        $response->assertViewIs('home');
        $response->assertDontSee('Welcome');
    }

//    --- Books tests ---

    public function testBooksRoutes()
    {
        $response = $this->get('add_book');
        $this->assertEquals(200, $response->status());

        $response = $this->get('book_1');
        $response->assertRedirect('/add_book');
    }

    public function testAddBook()
    {
        $response = $this->post('add_book/complete', [
            'name' => 'Some test book',
            'year' => '1999',
            'photo' => '',
            'author' => 'Some test author',
            'genre' => 1,
        ]);
        $response->assertRedirect('/');

        $response = $this->delete('delete/1', [
            'id' => 1,
        ]);
        $response->assertRedirect('/');
    }

    public function testAddReview()
    {
        $response = $this->post('/add_review', [
            'book_id' => 1,
            'review' => 'Some test review',
            'rating' => 5,
        ]);
        $response->assertSee('Your review saved!');

        $response = $this->post('/add_review', [
            'edit_review_id' => 1,
            'review' => 'Some test review',
        ]);
        $response->assertSee('Your review saved!');
    }

    public function testTakeBook()
    {
        $response = $this->post('/orders', [
            'date_start' => Now(),
            'date_end' => Now(),
            'book_id' => 1,
            'giving_id' => 1,
        ]);
        $response->assertSee('Order created!');
    }

//    --- Orders tests ---

    public function testOrdersRoutes()
    {
        $response = $this->get('orders_to_user');
        $response->assertStatus(200);

        $response = $this->get('orders_from_user');
        $response->assertStatus(200);
    }

    public function testAcceptOrder()
    {
        $response = $this->post('accept_order', [
            'order_id' => 1,
        ]);
        $response->assertSee('Order accepted!');
    }

    public function testRejectOrder()
    {
        $response = $this->post('delete_order', [
            'order_id' => 1,
        ]);
        $response->assertSee('Order deleted!');
    }

    public function testReturnBookOrder()
    {
        $response = $this->post('book_return', [
            'order_id' => 1,
        ]);
        $response->assertSee('Book returned!');
    }

//    --- Admin tests ---

    public function testNotIsAdminRoutes()
    {
        $response = $this->get('admin');
        $response->assertRedirect('/admin_users');

        $response = $this->get('/admin_users');
        $response->assertRedirect('/');

        $response = $this->get('/admin_books');
        $response->assertRedirect('/');

        $response = $this->get('/admin_authors');
        $response->assertRedirect('/');

        $response = $this->get('/admin_genres');
        $response->assertRedirect('/');

        $response = $this->get('/admin_orders');
        $response->assertRedirect('/');

        $response = $this->get('/admin_reviews');
        $response->assertRedirect('/');

        $response = $this->post('/admin_del_book/1');
        $response->assertRedirect('/');

        $response = $this->post('/admin_del_author/1');
        $response->assertRedirect('/');

        $response = $this->post('/admin_create_author');
        $response->assertRedirect('/');

        $response = $this->post('/admin_del_genre/1');
        $response->assertRedirect('/');

        $response = $this->post('/admin_create_genre');
        $response->assertRedirect('/');

        $response = $this->post('/admin_del_review/1');
        $response->assertRedirect('/');

        $response = $this->post('/add_to_admin');
        $response->assertRedirect('/');

        $response = $this->post('/delete_from_admin');
        $response->assertRedirect('/');
    }

    //    --- Profile tests ---

    public function testProfileRoutes()
    {
        $user_id = User::first()->id;

        $response = $this->get('profile/' . $user_id);
        $response->assertStatus(200);

        $response = $this->get('/update_user');
        $response->assertStatus(200);

        $response = $this->get('/set_password');
        $response->assertStatus(200);
    }

    public function testUpdateProfile()
    {
        $response = $this->post('/update_user/complete', [
            'name' => 'New name',
        ]);
        $response->assertRedirect('/');
    }

    public function testSetPassword()
    {
        $response = $this->post('/set_password/complete', [
            'password' => User::where('admin', '=', '0')->first()->password,
            'new_password' => '1',
            'password_confirmation' => '1',
        ]);
        $response->assertRedirect('/');
    }

    public function testDeleteProfile()
    {
        $response = $this->post('/delete_user');
        $response->assertRedirect('/');
    }
}