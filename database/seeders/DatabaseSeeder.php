<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\ImagePost;
use App\Models\Media;
use App\Models\Tag;
use App\Models\TextPost;
use App\Models\User;
use App\Models\UserProfile;
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
        $tags  = Tag::factory(15)->create();
        $media = Media::factory(40)->create();

        $users = User::factory(50)->has(UserProfile::factory(), 'userProfile')->create();

        foreach ($users as $user) {
            $user->userProfile->media()->attach($media->random()->id);
        }

        $posts = collect();

        foreach ($users as $user) {
            $posts = $posts
                ->concat(TextPost::factory(rand(3, 6))->for($user)->create())
                ->concat(ImagePost::factory(rand(2, 4))->for($user)->create());
        }

        foreach ($posts as $post) {
            $post->tags()->attach($tags->shuffle()->take(rand(1, 3))->pluck('id'));

            if ($post instanceof ImagePost) {
                $post->media()->attach($media->random()->id);
            }
        }

        foreach ($posts as $post) {
            $others = $users->where('id', '!=', $post->user_id);

            Comment::factory(rand(0, 5))
                   ->recycle($others)
                   ->for($post, 'commentable')
                   ->create();

            foreach ($others->shuffle()->take(rand(0, 10)) as $liker) {
                $post->likes()->create(['user_id' => $liker->id]);
            }
        }
    }
}
