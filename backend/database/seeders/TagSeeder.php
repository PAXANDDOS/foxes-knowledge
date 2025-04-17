<?php

namespace Database\Seeders;

use App\Models\Tag;
use Database\Factories\TagFactory;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
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
                'name' => 'JS',
                'color' => '#F7DF1E',
            ],
            [
                'tag_id' => 1,
                'name' => 'React.js',
                'color' => '#61DAFB',
            ],
            [
                'tag_id' => 1,
                'name' => 'Next.js',
                'color' => '#000000',
            ],
            [
                'name' => 'PHP',
                'color' => '#777BB4',
            ],
            [
                'tag_id' => 4,
                'name' => 'Laravel',
                'color' => '#FF2D20',
            ],
            [
                'tag_id' => 4,
                'name' => 'Symfony',
                'color' => '#000000',
            ],
            [
                'name' => 'PostgreSQL',
                'color' => '#4169E1',
            ],
            [
                'name' => 'MySQL',
                'color' => '#4479A1',
            ],
        ];

        foreach ($data as $tag) {
            Tag::create($tag);
        }

        Tag::factory()->count(TagFactory::NUMBER + count($data))->create();
    }
}
