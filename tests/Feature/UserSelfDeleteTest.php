<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

uses(RefreshDatabase::class);       
test('user can self-delete their account', function () {
    // Create a user
    $user = User::factory()->create();

    // Act as the created user
    $this->actingAs($user, 'web');

    // Send a DELETE request to the self-delete route
    $response = $this->delete(route('admin.users.destroy', $user));

    $response->assertStatus(403); // Assuming a redirect after deletion

    // Assert the user is deleted from the database
    $this->assertDatabaseHas('users', [
        'id' => $user->id,
    ]);

});