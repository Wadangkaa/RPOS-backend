<?php

use App\Models\User;

it('logs in the user successfully', function () {
    // arrange
    $user = User::factory()->create([
        'phone' => '1234567890',
        'password' => Hash::make('password'),
    ]);

    // act
    $response = $this->postJson('/api/admin/login', [
        'phone' => '1234567890',
        'password' => 'password',
    ]);

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                'token',
                'user' => [
                    'id',
                    'name',
                    'phone',
                    'email',
                ]
            ]
        ])
        ->assertJsonPath('data.user.phone', $user->phone);
});

it('fails when user does not exist', function () {
    $response = $this->postJson('/api/admin/login', [
        'phone' => '0000000000',
        'password' => 'password',
    ]);

    $response->assertStatus(404)
        ->assertJson([
            'message' => 'User not found',
        ]);
});

it('fails when password is invalid', function () {
    $user = User::factory()->create([
        'phone' => '1234567890',
        'password' => Hash::make('correct-password'),
    ]);

    $response = $this->postJson('/api/admin/login', [
        'phone' => '1234567890',
        'password' => 'wrong-password',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'Invalid credentials',
        ]);
});


it('fails when required fields are missing', function () {
    $response = $this->postJson('/api/admin/login', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['phone', 'password']);
});

it('fails when only phone is provided', function () {
    $response = $this->postJson('/api/admin/login', ['phone' => '1234567890']);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['password']);
});

it('fails when only password is provided', function () {
    $response = $this->postJson('/api/admin/login', ['password' => 'password']);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['phone']);
});
