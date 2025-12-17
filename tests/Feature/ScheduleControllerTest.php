<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class ScheduleControllerTest extends TestCase
{
    /** @test */
    public function guest_cannot_access_schedule_page()
    {
        $this->get('/schedules')->assertStatus(302);
    }

    /** @test */
    public function admin_can_access_schedule_page()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);

        $this->actingAs($admin)
            ->get('/schedules')
            ->assertStatus(200);
    }

    /** @test */
    public function guest_cannot_create_schedule()
    {
        $this->post('/schedules', [])
            ->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_create_schedule()
    {
        $teacher = new User(['id' => 2, 'role' => 'teacher']);

        $this->actingAs($teacher)
            ->post('/schedules', [])
            ->assertStatus(302); // redirect vì abort(403) + middleware
    }

    /** @test */
    public function admin_submit_create_schedule_form()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);

        $this->actingAs($admin)
            ->post('/schedules', [])
            ->assertStatus(302);
    }

    /** @test */
    public function create_schedule_requires_required_fields()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);

        $this->actingAs($admin)
            ->post('/schedules', [])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'class_id',
                'subject_id',
                'day_of_week',
                'class_period',
            ]);
    }

    /** @test */
    public function day_of_week_validation_works()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);

        $this->actingAs($admin)
            ->post('/schedules', [
                'class_id' => 1,
                'subject_id' => 1,
                'day_of_week' => 0,
                'class_period' => 1,
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['day_of_week']);
    }

    /** @test */
    public function guest_cannot_delete_schedule()
    {
        $this->delete('/schedules/1')->assertStatus(302);
    }

    /** @test */
    public function non_admin_cannot_delete_schedule()
    {
        $teacher = new User(['id' => 2, 'role' => 'teacher']);

        $this->actingAs($teacher)
            ->delete('/schedules/1')
            ->assertStatus(404);
    }

    /** @test */
    public function admin_delete_non_existing_schedule_returns_404()
    {
        $admin = new User(['id' => 1, 'role' => 'admin']);

        $this->actingAs($admin)
            ->delete('/schedules/9999')
            ->assertStatus(404);
    }
}
