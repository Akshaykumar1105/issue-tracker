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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->unsignedInteger('trial_days')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('provider_plan_id')->nullable();
            $table->string('provider')->nullable();
            $table->unsignedInteger('duration');
            $table->enum('type', ['monthly', 'yearly']);
            $table->text('features');
            $table->unsignedInteger('hr_create_limit')->nullable();
            $table->unsignedInteger('manager_create_limit')->nullable();
            $table->unsignedInteger('issue_create_limit')->nullable();
            $table->boolean('can_manage_issues')->default(false);
            $table->unsignedBigInteger('parent_plan_id')->nullable();
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
