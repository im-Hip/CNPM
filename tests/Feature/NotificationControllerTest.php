<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class NotificationControllerTest extends TestCase
{
    /** @test */
    public function guest_cannot_access_notifications()
    {
        $this->get('/notifications')->assertStatus(302);
    }

    /** @test */
    public function authenticated_user_can_view_notifications()
    {
        $user = new User(['id' => 1, 'role' => 'student']);
        
        $this->actingAs($user)
            ->get('/notifications')
            ->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_create_notification()
    {
        $this->get('/notifications/create')->assertStatus(302);
    }

    /** @test */
    public function student_cannot_create_notification()
    {
        $student = new User(['id' => 1, 'role' => 'student']);
        
        $this->actingAs($student)
            ->get('/notifications/create')
            ->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_create_notification_page()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->get('/notifications/create')
            ->assertStatus(200);
    }

    /** @test */
    public function teacher_can_access_create_notification_page()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->get('/notifications/create')
            ->assertStatus(200);
    }

    /** @test */
    public function create_notification_requires_required_fields()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/notifications', [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'title',
                'content',
                'type',
                'recipient_type',
            ]);
    }

    /** @test */
    public function notification_type_validation_works()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/notifications', [
                'title' => 'Test',
                'content' => 'Test content',
                'type' => 'invalid_type',
                'recipient_type' => 'all',
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['type']);
    }

    /** @test */
    public function recipient_type_validation_works()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/notifications', [
                'title' => 'Test',
                'content' => 'Test content',
                'type' => 'exam',
                'recipient_type' => 'invalid_recipient',
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['recipient_type']);
    }

    /** @test */
    public function guest_cannot_delete_notification()
    {
        $this->delete('/notifications/1')->assertStatus(302);
    }
}