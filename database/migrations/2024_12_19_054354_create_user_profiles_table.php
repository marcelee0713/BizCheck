<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Constants\BusinessModels;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::create('user_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name', 255);
            $table->enum('business_model', BusinessModels::MODELS);
            $table->text('description', 5000)->nullable();
            $table->string('target_audience', 255)->nullable();
            $table->string('unique_selling_point', 255)->nullable();
            $table->text('location', 500)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('website_url', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
