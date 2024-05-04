<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Follow;
use App\Models\Post;
use App\Models\PostAttachment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        User::factory()->create([
            'full_name' => 'Admin',
            'username' => 'admin',
            'bio' => 'tetaplah bernapas',
            'is_private' => 0
        ]);

        User::factory()->create([
            'full_name' => 'Admin2',
            'username' => 'admin2',
            'bio' => 'hidup seperti lary',
            'is_private' => 1
        ]);

        User::factory(10)->create();

        Post::factory(30)->create();

        PostAttachment::factory(20)->create();

        Follow::factory(50)->create();
    }
}
