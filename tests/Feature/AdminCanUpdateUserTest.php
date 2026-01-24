<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

test('authenticated admin can update another user', function () {

    // Arrange: create role
    $adminRole = Role::create(['name' => 'admin']);

    // Create users with required id_number
    $admin = User::factory()->create([
        'id_number' => 'ADMIN-001',
    ]);

    $userToUpdate = User::factory()->create([
        'id_number' => 'USER-001',
    ]);

    // Assign admin role
    $admin->assignRole('admin');

    // Authenticate
    $this->actingAs($admin);

    // Act
    $response = $this->put(route('admin.users.update', $userToUpdate), [
        'name' => 'Updated Name',
        'email' => 'updated@email.com',
        'id_number' => 'USER-UPDATED-001', // 🔥 REQUIRED
        'roles' => [$adminRole->id],
        'phone' => '9999999999',
        'address' => 'Updated address',
    ]);

    // Assert
    $response->assertStatus(302);

    $this->assertDatabaseHas('users', [
        'id' => $userToUpdate->id,
        'name' => 'Updated Name',
        'email' => 'updated@email.com',
        'id_number' => 'USER-UPDATED-001',
    ]);
});
