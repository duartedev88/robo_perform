<?php

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
        Schema::create('scheduled_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable()->unique();
            $table->string('product_name');
            $table->text('description');
            $table->string('image_url');
            $table->text('caption');
            $table->timestamp('scheduled_at')->nullable();
            $table->decimal('price', 10, 2)->nullable(); // ✅ ESSA LINHA
            $table->boolean('posted')->default(false);
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_posts');
    }
};
