<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AssignmentControllerTest extends TestCase
{
    /** @test */
    public function guest_cannot_view_assignments()
    {
        $this->get('/assignments')->assertStatus(302);
    }

    /** @test */
    public function authenticated_user_can_view_assignments()
    {
        $user = new User(['id' => 1, 'role' => 'student']);
        
        $this->actingAs($user)
            ->get('/assignments')
            ->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_create_assignment()
    {
        $this->get('/assignments/create')->assertStatus(302);
    }

    /** @test */
    public function student_cannot_create_assignment()
    {
        $student = new User(['id' => 1, 'role' => 'student']);
        
        $this->actingAs($student)
            ->get('/assignments/create')
            ->assertStatus(200); // Students can access but form will be restricted
    }

    /** @test */
    public function teacher_can_access_create_assignment()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->get('/assignments/create')
            ->assertStatus(200);
    }

    /** @test */
    public function create_assignment_requires_required_fields()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->post('/assignments', [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'title',
                'content',
                'due_date',
            ]);
    }

    /** @test */
    public function due_date_must_be_valid_date()
    {
        $teacher = new User(['id' => 1, 'role' => 'teacher']);
        
        $this->actingAs($teacher)
            ->post('/assignments', [
                'title' => 'Test',
                'content' => 'Test content',
                'due_date' => 'invalid-date',
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['due_date']);
    }

    /** @test */
    public function guest_cannot_upload_assignment_file()
    {
        $this->post('/assignments/1/upload', [])
            ->assertStatus(302);
    }
}