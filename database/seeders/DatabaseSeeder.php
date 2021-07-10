<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'religion' => 'muslim',
            'role' => 'admin',
        ]);
        DB::table('users')->insert([
            'name' => 'Khateeb',
            'email' => 'khateeb@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'religion' => 'muslim',
            'role' => 'khateeb',
        ]);
        DB::table('users')->insert([
            'name' => 'Muslim Student',
            'email' => 'muslim@student.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'religion' => 'muslim',
            'role' => 'student',
        ]);
        DB::table('users')->insert([
            'name' => 'Non Muslim student',
            'email' => 'nonmuslim@student.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'religion' => 'non-muslim',
            'role' => 'student',
        ]);

        DB::table('courses')->insert([
            'title' => 'First Course',
            'description' => 'First Description',
        ]);

        
    }
}
