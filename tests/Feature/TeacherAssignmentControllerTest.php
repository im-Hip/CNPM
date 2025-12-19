<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class TeacherAssignmentControllerTest extends TestCase
{
    /** @test */
    public function guest_cannot_access_teacher_assignments()
    {
        $this->get('/teacher_assignments')->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_access_teacher_assignments()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->get('/teacher_assignments')
            ->assertStatus(302);
    }

    /** @test */
    public function admin_can_access_teacher_assignments()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->get('/teacher_assignments')
            ->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_create_assignment()
    {
        $this->get('/teacher_assignments/create')->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_create_assignment()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->get('/teacher_assignments/create')
            ->assertStatus(402);
    }

    /** @test */
    public function create_assignment_requires_required_fields()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/teacher_assignments', [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'teacher_id',
                'class_id',
                'subject_id',
                'status',
            ]);
    }

    /** @test */
    public function status_must_be_valid()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);
        
        $this->actingAs($admin)
            ->post('/teacher_assignments', [
                'teacher_id' => 1,
                'class_id' => 1,
                'subject_id' => 1,
                'status' => 'invalid_status',
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['status']);
    }

    /** @test */
    public function guest_cannot_delete_assignment()
    {
        $this->delete('/teacher_assignments/1')->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_delete_assignment()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->delete('/teacher_assignments/1')
            ->assertStatus(403);
    }
}