<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** 確認骨架的每個頁面都能打開 */
class PagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages(): void
    {
        foreach (['/', '/spaces', '/spaces/map', '/spaces/1', '/login', '/register'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/reservations')->assertRedirect('/login');
    }

    public function test_admin_pages(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();

        foreach ([
            '/reservations', '/reservations/week', '/reservations/create',
            '/courses', '/courses/calendar', '/courses/create',
            '/admin/users', '/admin/rooms', '/admin/rooms/create',
            '/admin/reservations', '/admin/courses', '/admin/courses/conflicts',
        ] as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    public function test_teacher_cannot_edit_others_course(): void
    {
        $teacher2 = User::where('email', 'teacher2@example.com')->first();

        $this->actingAs($teacher2)->get('/courses/1/edit')->assertForbidden();
    }
}
