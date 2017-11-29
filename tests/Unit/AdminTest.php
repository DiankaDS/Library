<?php

namespace Tests\Unit;

use App\Author;
use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;


class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();
        $this->seed('UsersTableSeeder');

        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);
    }

//    --- Users tests ---

    public function testAdminUsersRoutes()
    {
        $response = $this->get('/admin_users');
        $response->assertStatus(200);
    }

    public function testAdminAddToAdmUser()
    {
        $user = User::where('admin', '=', '1')->first();
        $this->actingAs($user);

        $response = $this->post('/add_to_admin', [
            'admins_user_id' => '2',
        ]);
        $response->assertSee('User added to admin!');
    }

    public function testAdminDeleteFromAdmUser()
    {
        $response = $this->post('delete_from_admin', [
            'admins_user_id' => '2',
        ]);
        $response->assertSee('User deleted from admin!');
    }

    public function testAdminDeleteUser()
    {
        $response = $this->post('delete_user', [
            'admins_user_id' => '2',
        ]);
        $response->assertSee('Profile deleted!');
    }

//    --- Books tests ---

    public function testAdminBooksRoutes()
    {
        $response = $this->get('admin_books');
        $response->assertStatus(200);
    }

    public function testAdminDeleteBook()
    {
        $response = $this->post('admin_del_book/1', [
            'admins_book_id' => '1',
        ]);
        $response->assertSee('Book deleted!');
    }

//    --- Authors tests ---

    public function testAdminAuthorsRoutes()
    {
        $response = $this->get('admin_authors');
        $response->assertStatus(200);
    }

    public function testAdminAddDelAuthor()
    {
        $response = $this->post('admin_create_author', [
            'name' => 'Some test name',
        ]);
        $response->assertRedirect('/');

        $author_id = Author::where('name', '=', 'Some test name')->first()->id;
        $response = $this->post('admin_del_author/' . $author_id, [
            'admins_author_id' => $author_id,
        ]);
        $response->assertRedirect('/');
    }

//    --- Genres tests ---

    public function testAdminGenresRoutes()
    {
        $response = $this->get('admin_genres');
        $response->assertStatus(200);
    }

    public function testAdminAddDelGenre()
    {
        $response = $this->post('admin_create_genre', [
            'genre' => 'Some test name'
        ]);
        $response->assertRedirect('/');

        $genre_id = DB::table('genres')
            ->where('genres.name', '=', 'Some test name')
            ->first()
            ->id;
        $response = $this->post('admin_del_genre/' . $genre_id, [
            'admins_genre_id' => $genre_id,
        ]);
        $response->assertRedirect('/');
    }

//    --- Orders tests ---

    public function testAdminOrdersRoutes()
    {
        $response = $this->get('admin_orders');
        $response->assertStatus(200);
    }

    public function testAdminDeleteOrder()
    {
        $response = $this->post('delete_order', [
            'order_id' => '1',
        ]);
        $response->assertSee('Order deleted!');
    }

//    --- Reviews tests ---

    public function testAdminReviewsRoutes()
    {
        $response = $this->get('admin_reviews');
        $response->assertStatus(200);
    }

    public function testAdminDeleteReview()
    {
        $response = $this->post('admin_del_review/1', [
            'admins_review_id' => '1',
        ]);
        $response->assertSee('Review deleted!');
    }
}
