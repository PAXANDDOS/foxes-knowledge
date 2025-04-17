<?php

namespace Database\Seeders;

use App\Models\Attachment;
use Database\Factories\AttachmentFactory;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Attachment::factory()->count(AttachmentFactory::NUMBER)->create();
    }
}
