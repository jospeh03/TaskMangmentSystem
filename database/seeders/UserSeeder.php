<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // إنشاء مستخدم Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),  // تأكد من استخدام هاش لكلمة المرور
            'role' => 'admin'
        ]);

        // إنشاء مستخدم Manager
        User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('manager123'),  // تأكد من استخدام هاش لكلمة المرور
            'role' => 'manager'
        ]);
    }
}
