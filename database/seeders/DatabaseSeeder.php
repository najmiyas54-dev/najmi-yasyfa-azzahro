<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GuruSeeder::class,
            PostSeeder::class,
            CompetitionPostSeeder::class,
            CommentSeeder::class,
            StorySeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
