<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_pending_account(): void
    {
        $this->post('/register', [
            'name' => '新同學', 'email' => 'new@example.com', 'role' => 'user',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertRedirect('/login');

        $this->assertDatabaseHas('users', ['email' => 'new@example.com', 'status' => 'pending', 'role' => 'user']);
    }

    public function test_cannot_register_as_admin(): void
    {
        $this->post('/register', [
            'name' => 'x', 'email' => 'x@example.com', 'role' => 'admin',
            'password' => 'password123', 'password_confirmation' => 'password123',
        ])->assertSessionHasErrors('role');
    }

    public function test_pending_account_cannot_login(): void
    {
        User::factory()->create(['email' => 'p@example.com', 'status' => 'pending']);

        $this->post('/login', ['email' => 'p@example.com', 'password' => 'password'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_approved_account_can_login_and_logout(): void
    {
        $user = User::factory()->create(['email' => 'ok@example.com']);

        $this->post('/login', ['email' => 'ok@example.com', 'password' => 'password'])->assertRedirect('/');
        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_admin_can_approve_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $pending = User::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch("/admin/users/{$pending->id}", ['status' => 'approved', 'role' => 'teacher'])
            ->assertRedirect();

        $this->assertSame('approved', $pending->fresh()->status);
        $this->assertSame('teacher', $pending->fresh()->role);
    }

    public function test_non_admin_cannot_open_admin_pages(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin/users')->assertForbidden();
    }

    public function test_student_cannot_open_courses(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'user']))->get('/courses')->assertForbidden();
    }
}
