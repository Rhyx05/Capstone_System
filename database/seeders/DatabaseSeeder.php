<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Seed Offices First
        |--------------------------------------------------------------------------
        */
        $this->call([
            OfficeSeeder::class,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Default Admin6 Account
        |--------------------------------------------------------------------------
        */
User::firstOrCreate(
    ['email' => 'recordkeeper@gmail.com'],
    [
        'first_name' => 'Record',
        'last_name'  => 'Keeper',
        'email'      => 'recordkeeper@gmail.com',
        'office_id'  => 1,
        'role'       => 'record_keeper',
        'is_active'  => true,
        'password'   => Hash::make('password'),
    ]
);
    }
}