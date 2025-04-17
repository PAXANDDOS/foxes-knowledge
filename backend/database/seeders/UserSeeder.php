<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
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
        $data = [
            [
                'username' => 'PAXANDDOS',
                'name' => 'Paul Litovka',
                'email' => 'pashalitovka@gmail.com',
                'password' => Hash::make('123456789'),
                'bio' => 'My best bio.',
                'color' => '#5b92e5',
            ],
            [
                'username' => 'navwie',
                'name' => 'Alesia Lykhovaya',
                'email' => 'navwie@gmail.com',
                'password' => Hash::make('123456789'),
                'bio' => 'My best bio with emoji 😀.',
                'color' => '#ff6e4a',
            ],
        ];

        foreach ($data as $user) {
            User::create($user);
        }

        User::factory()->count(UserFactory::NUMBER + count($data))->create();
    }
}
