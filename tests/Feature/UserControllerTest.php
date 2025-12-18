<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    /** @test */
    public function guest_cannot_access_users_page()
    {
        $this->get('/admin/users')->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_access_users_page()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->get('/admin/users')
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_users_page()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_create_user()
    {
        $this->get('/admin/users/create')->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_create_user()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->get('/admin/users/create')
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_create_user_page()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->get('/admin/users/create')
            ->assertStatus(200);
    }

    /** @test */
    public function create_user_requires_required_fields()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/admin/users', [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name',
                'email',
                'password',
                'role',
            ]);
    }

    /** @test */
    public function email_must_be_valid()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Test',
                'email' => 'invalid-email',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'student',
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['email']);
    }

    /** @test */
    public function role_must_be_valid()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/admin/users', [
                'name' => 'Test',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'role' => 'invalid_role',
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['role']);
    }

    /** @test */
    public function guest_cannot_delete_user()
    {
        $this->delete('/admin/users/1')->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_delete_user()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->delete('/admin/users/2')
            ->assertStatus(403);
    }
}