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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id();
            $table->string('buyer_name')->index();
            $table->string('contact_person')->nullable();
            $table->string('email')->nullable();
            $table->string('status', 20)->default('Active')->index();
            $table->timestamps();
        });

        Schema::create('styles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('buyers')->onDelete('cascade');
            $table->string('style_no')->index();
            $table->string('description')->nullable();
            $table->string('status', 20)->default('Active')->index();
            $table->timestamps();

            $table->index(['buyer_id', 'style_no']);
        });

        Schema::create('sewing_lines', function (Blueprint $table) {
            $table->id();
            $table->string('line_name')->index();
            $table->string('floor', 50)->nullable();
            $table->unsignedInteger('capacity')->default(1000);
            $table->string('status', 20)->default('Active')->index();
            $table->timestamps();
        });

        Schema::create('production_bundles', function (Blueprint $table) {
            $table->id();
            $table->string('bundle_no', 100)->unique();
            $table->foreignId('buyer_id')->constrained('buyers')->onDelete('cascade');
            $table->foreignId('style_id')->constrained('styles')->onDelete('cascade');
            $table->foreignId('line_id')->constrained('sewing_lines')->onDelete('cascade');
            $table->string('color', 50)->index();
            $table->string('size', 20)->index();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('completed_qty')->default(0);
            $table->unsignedInteger('rejected_qty')->default(0);
            $table->string('operator_name', 100)->nullable()->index();
            $table->date('production_date')->index();
            $table->text('remarks')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // High-performance composite indexes for large datasets (50,000+ records)
            $table->index(['production_date', 'buyer_id']);
            $table->index(['buyer_id', 'style_id']);
            $table->index(['line_id', 'production_date']);
            $table->index(['deleted_at', 'production_date']);
            $table->index(['deleted_at', 'created_at']);
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bundle_id')->nullable()->index();
            $table->string('action', 50)->index();
            $table->text('description');
            $table->string('user_name', 100)->default('System User');
            $table->json('changes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent()->index();

            $table->index(['bundle_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('production_bundles');
        Schema::dropIfExists('sewing_lines');
        Schema::dropIfExists('styles');
        Schema::dropIfExists('buyers');
    }
};
