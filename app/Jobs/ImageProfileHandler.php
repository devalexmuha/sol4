<?php

namespace App\Jobs;

use App\Models\UserProfile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ImageProfileHandler implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly UserProfile $userProfile,
        private readonly string $tmpImagePath,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // crop and store image in the storage, delete tmp image.
        $imagePath = Image::fromStorage($this->tmpImagePath, disk: 'local')
            ->cover(200, 200)
            ->toWebp()
            ->quality(80)
            ->store(path: 'avatars', disk: 'public');

        Storage::delete($this->tmpImagePath);

        // save permanent image path to db
        $media = $this->userProfile->media()->first();

        if ($media) {
            $media->update([
                'media_uri' => $imagePath,
            ]);
        } else {
            $this->userProfile->media()->create([
                'media_uri' => $imagePath,
                'media_alt' => $this->userProfile->user_name.' profile image',
            ]);
        }
    }
}
