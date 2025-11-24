<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin role first
        \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        
        // Create test users
        $this->user = \App\Models\User::factory()->create();
        $this->admin = \App\Models\User::factory()->create();
        
        // Assign admin role
        $this->admin->assignRole('admin');
    }

    /**
     * Test patient index page is accessible to authenticated users.
     */
    public function test_patient_index_accessible_to_authenticated_users(): void
    {
        $response = $this->actingAs($this->user)->get(route('patients.index'));
        $response->assertStatus(200);
    }

    /**
     * Test patient index redirects unauthenticated users.
     */
    public function test_patient_index_redirects_unauthenticated_users(): void
    {
        $response = $this->get(route('patients.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test patient creation with valid data.
     */
    public function test_patient_can_be_created_with_valid_data(): void
    {
        $patientData = [
            'name' => 'John Doe',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'gender' => 'male',
            'date_of_birth' => '1990-01-01',
            'blood_group' => 'O+',
            'genotype' => 'AA',
            'marital_status' => 'single',
            'emergency_contact' => '0987654321',
            'allergies' => 'None',
            'conditions' => 'None',
            'ward' => 'General',
            'admitted' => false,
        ];

        $response = $this->actingAs($this->user)->post(route('patients.store'), $patientData);

        $response->assertRedirect(route('patients.index'));
        $response->assertSessionHas('success', 'Patient registered successfully.');
        
        $this->assertDatabaseHas('patients', [
            'name' => 'John Doe',
            'phone' => '1234567890',
        ]);
    }

    /**
     * Test patient creation fails with invalid data.
     */
    public function test_patient_creation_fails_with_invalid_data(): void
    {
        $invalidData = [
            'name' => '', // Required field
            'phone' => '', // Required field
            'gender' => 'invalid', // Invalid enum
        ];

        $response = $this->actingAs($this->user)->post(route('patients.store'), $invalidData);

        $response->assertSessionHasErrors(['name', 'phone', 'gender']);
    }

    /**
     * Test patient creation fails with duplicate phone.
     */
    public function test_patient_creation_fails_with_duplicate_phone(): void
    {
        // Create first patient
        \App\Models\Patient::factory()->create([
            'phone' => '1234567890',
            'user_id' => $this->user->id,
        ]);

        // Try to create second patient with same phone
        $patientData = [
            'name' => 'Jane Doe',
            'phone' => '1234567890', // Duplicate
            'address' => '456 Oak St',
            'gender' => 'female',
            'date_of_birth' => '1992-05-15',
            'emergency_contact' => '0987654321',
        ];

        $response = $this->actingAs($this->user)->post(route('patients.store'), $patientData);

        $response->assertSessionHasErrors(['phone']);
    }

    /**
     * Test patient can be viewed.
     */
    public function test_patient_can_be_viewed(): void
    {
        $patient = \App\Models\Patient::factory()->create(['user_id' => $this->user->id]);

        $response = $this->actingAs($this->user)->get(route('patients.show', $patient->id));

        $response->assertStatus(200);
        $response->assertSee($patient->name);
    }

    /**
     * Test patient can be updated.
     */
    public function test_patient_can_be_updated(): void
    {
        $patient = \App\Models\Patient::factory()->create(['user_id' => $this->user->id]);

        $updateData = [
            'name' => 'Updated Name',
            'phone' => $patient->phone,
            'address' => $patient->address,
            'gender' => $patient->gender,
            'date_of_birth' => $patient->date_of_birth,
            'emergency_contact' => $patient->emergency_contact,
        ];

        $response = $this->actingAs($this->user)->put(route('patients.update', $patient->id), $updateData);

        $response->assertRedirect(route('patients.index'));
        $response->assertSessionHas('success', 'Patient updated successfully.');
        
        $this->assertDatabaseHas('patients', [
            'id' => $patient->id,
            'name' => 'Updated Name',
        ]);
    }

    /**
     * Test only admin can delete patients.
     */
    public function test_only_admin_can_delete_patients(): void
    {
        $patient = \App\Models\Patient::factory()->create(['user_id' => $this->user->id]);

        // Non-admin user tries to delete
        $response = $this->actingAs($this->user)->delete(route('patients.destroy', $patient->id));
        $response->assertRedirect(route('patients.index'));
        $response->assertSessionHas('error', 'Unauthorized action. Admin access required.');
        $this->assertDatabaseHas('patients', ['id' => $patient->id]);

        // Admin user deletes
        $response = $this->actingAs($this->admin)->delete(route('patients.destroy', $patient->id));
        $response->assertRedirect(route('patients.index'));
        $response->assertSessionHas('success', 'Patient deleted successfully.');
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }
}
