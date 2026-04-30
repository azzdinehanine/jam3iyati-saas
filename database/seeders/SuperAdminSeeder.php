<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class SuperAdminSeeder extends Seeder {
    public function run(): void {
        User::create([
            'tenant_id' => null,
            'name' => 'Super',
            'lastname' => 'Admin',
            'email' => 'admin@jam3iyati.ma',
            'phone' => '0600000000',
            'password' => Hash::make('Admin@2026'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);
    }
}
