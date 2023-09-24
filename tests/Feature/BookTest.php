<?php

use App\Models\User;

test('books index screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->get('/books');

    $response->assertStatus(200);
});

it('can create a book', function () {
    $bookData = [
        'title' => 'Sample Book',
    ];

    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('books.store'), $bookData)
        ->assertRedirect(route('books.index'));

    $this->assertDatabaseHas('books', $bookData);
});
