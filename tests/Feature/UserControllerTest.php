<?php

namespace Tests\Feature;

use App\Models\PetaniProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'petani']);
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'pembeli']);
    }

    public function test_admin_can_view_users_index()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $petani = User::factory()->create();
        $petani->assignRole('petani');

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee($petani->name);
    }

    public function test_admin_cannot_self_delete()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->delete(route('admin.users.destroy', $admin));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_verify_petani_with_valid_data()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $petani = User::factory()->create([
            'status' => 'nonaktif',
            'email_verified_at' => now(),
        ]);
        $petani->assignRole('petani');

        PetaniProfile::create([
            'user_id' => $petani->id,
            'nama_kebun' => 'Kebun Test',
            'lokasi_kebun' => 'Jl. Test',
            'deskripsi_kebun' => 'Deskripsi test',
            'status_verifikasi' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.users.verify', $petani), [
            'action' => 'approve',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('petani_profiles', [
            'user_id' => $petani->id,
            'status_verifikasi' => 'approved',
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $petani->id,
            'status' => 'aktif',
        ]);
    }
}
