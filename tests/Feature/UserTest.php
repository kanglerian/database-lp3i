<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getUserById()
{
    // Membuat pengguna baru dalam basis data
    $user = User::factory()->create();

    // Memanggil fungsi getUserById
    $retrievedUser = User::where('identity', $user->identity);

    // Memeriksa apakah pengguna yang ditemukan adalah pengguna yang diharapkan
    $this->assertEquals($user->identity, $retrievedUser->identity);
}
}
