<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user update fails with invalid data', function () {

    // Arrange
    $admin = User::factory()->create();
    $adminRole = Role::create(['name' => 'admin']);
    $admin->assignRole($adminRole);

    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@email.com',
        'id_number' => 'USER-001',
    ]);

    $this->actingAs($admin);

    $response = $this->put(route('admin.users.update', $user), [
        'name' => '',                 
        'email' => 'not-an-email',     
  
        'id_number' => 'USER-001',     
    ]);

    $response->assertSessionHasErrors([
        'name',
        'email',
        'roles',
    ]);

    // Assert user was NOT updated
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Original Name',
        'email' => 'original@email.com',
        'id_number' => 'USER-001',
    ]);
});
