<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;


class NotAuthUserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');
    }

//    --- Auth tests ---

    public function testAuthRoutes()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/password/reset');
        $response->assertStatus(200);

        $response = $this->post('/password/email', [
            'email' => 'ololo@user.com',
        ]);
        $response->assertRedirect('/password/reset');

        $response = $this->post('/password/email', [
            'email' => User::first()->email,
        ]);
        $response->assertRedirect('/password/reset');


        $response = $this->get('/auth/facebook');
        $response->assertStatus(302);


        $response = $this->post('/login', [
            'email' => '1',
            'password' => '1',
        ]);
        $response->assertRedirect('/auth/facebook');

        $response = $this->post('/register', [
            'username' => 'test',
            'name' => 'test',
            'surname' => 'test',
            'email' => 'test@test.com',
            'phone' => '12345678',
            'password' => '1111111',
        ]);
        $response->assertRedirect('/auth/facebook');
    }

//    --- Home tests ---

    public function testNotUserHomeRoutes()
    {
        $response = $this->get('/');
        $this->assertEquals(200, $response->status());
        $response->assertViewIs('home');
        $response->assertSee('Welcome');

        $response = $this->get('/home');
        $this->assertEquals(200, $response->status());
        $response->assertViewIs('home');
        $response->assertSee('Welcome');
    }

    public function testHomeSearch()
    {
        $response = $this->json('POST', 'search_books', [
            'str_book' => 'Some book'
        ]);
        $response
            ->assertStatus(200)
            ->assertJson([]);
    }

//    --- Books tests ---

    public function testNotUserBooksRoutes()
    {
        $response = $this->get('add_book');
        $response->assertRedirect('/login');

        $response = $this->post('add_book/complete');
        $response->assertRedirect('/login');

        $response = $this->delete('delete/1');
        $response->assertRedirect('/login');

        $response = $this->get('book_1');
        $response->assertRedirect('/login');

        $response = $this->post('/add_review');
        $response->assertRedirect('/login');

        $response = $this->post('search_value');
        $response->assertRedirect('/login');
    }

//    --- Profile tests ---

    public function testNotUserProfileRoutes()
    {
        $response = $this->get('profile/1');
        $response->assertRedirect('/login');

        $response = $this->get('/update_user');
        $response->assertRedirect('/login');

        $response = $this->post('/update_user/complete');
        $response->assertRedirect('/login');

        $response = $this->get('/set_password');
        $response->assertRedirect('/login');

        $response = $this->post('/set_password/complete');
        $response->assertRedirect('/login');

        $response = $this->post('/delete_user');
        $response->assertRedirect('/login');

        $response = $this->post('/upload_photo');
        $response->assertRedirect('/login');
    }

//    --- Orders tests ---

    public function testNotUserOrdersRoutes()
    {
        $response = $this->post('orders');
        $response->assertRedirect('/login');

        $response = $this->get('orders/1');
        $response->assertRedirect('/login');

        $response = $this->post('accept_order');
        $response->assertRedirect('/login');

        $response = $this->post('delete_order');
        $response->assertRedirect('/login');

        $response = $this->get('orders_to_user');
        $response->assertRedirect('/login');

        $response = $this->get('orders_from_user');
        $response->assertRedirect('/login');

        $response = $this->post('book_return');
        $response->assertRedirect('/login');
    }

//    --- Admin tests ---

    public function testNotUserAdminRoutes()
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
}
