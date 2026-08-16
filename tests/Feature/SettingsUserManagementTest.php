<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingsUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_update_user_accounts_from_settings(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@pesoagoo.gov.ph',
            'role' => 'super_admin',
            'contact_number' => '09000000000',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.users.store'), [
            'name' => 'Jane Doe',
            'username' => 'jane',
            'email' => 'jane@example.com',
            'password' => 'secret123',
            'role' => 'staff',
            'contact_number' => '09123456789',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'username' => 'jane',
            'role' => 'staff',
            'contact_number' => '09123456789',
        ]);

        $user = User::where('email', 'jane@example.com')->firstOrFail();

        $response = $this->put(route('admin.users.update', $user->id), [
            'name' => 'Jane Updated',
            'username' => 'jane_updated',
            'email' => 'jane.updated@example.com',
            'role' => 'manager',
            'contact_number' => '09987654321',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Jane Updated',
            'username' => 'jane_updated',
            'email' => 'jane.updated@example.com',
            'role' => 'manager',
            'contact_number' => '09987654321',
        ]);

        $response = $this->put(route('admin.users.update-password', $user->id), [
            'password' => 'newsecret456',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertTrue(Hash::check('newsecret456', $user->fresh()->password));
    }
}
