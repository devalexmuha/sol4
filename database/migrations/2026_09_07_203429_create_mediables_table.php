<?php

use App\Models\ImagePost;
use App\Models\Media;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mediables', function (Blueprint $table) {
            $table->timestamps();
            $table->morphs('mediable');
            $table->foreignIdFor(Media::class)->constrained()->cascadeOnDelete();
            $table->primary(['mediable_id', 'mediable_type', 'media_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediables');
    }
};
