<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImagePostHandler implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly User $user,
        private readonly array $postData
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // crop store delete tmp image
        $tmpImagePath = $this->postData['tmp_image_path'];
        $imagePath    = Image::fromStorage($tmpImagePath, disk: 'local')
                             ->orient()
                             ->cover(900, 1200)
                             ->toWebp()
                             ->quality(80)
                             ->storePublicly(path: 'images', disk: 'public');

        Storage::delete($tmpImagePath);

        // create new image post
        $post = $this->user->imagePosts()->create([
            'image_title' => $this->postData['image_title'],
        ]);

        $post->media()->create([
            'media_uri' => $imagePath,
            'media_alt' => $this->postData['image_title'],
        ]);

        $post->tags()->sync($this->postData['tags'] ?? []);
    }
}
