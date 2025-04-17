<?php

namespace Database\Seeders;

use App\Models\Reaction;
use Database\Factories\ReactionFactory;
use Illuminate\Database\Seeder;

class ReactiontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reaction::factory()->count(ReactionFactory::NUMBER)->create();
    }
}
