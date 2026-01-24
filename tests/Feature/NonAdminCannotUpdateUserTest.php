<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NonAdminCannotUpdateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_users_cannot_update_user_records()
    {
        // Arrange
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'doctor']);

        $nonAdmin = User::factory()->create();
        $nonAdmin->assignRole('doctor');

        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        // Act
        $response = $this->actingAs($nonAdmin)->put(
    route('admin.users.update', $user->id),
    [
        'name' => 'Hacked Name',
        'email' => 'hacked@example.com',
        'id_number' => 'ABC-123',     // ✅ OBLIGATORIO
        'roles' => [1],
    ]
);


        // Assert
        $response->assertStatus(403);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);
    }
}
