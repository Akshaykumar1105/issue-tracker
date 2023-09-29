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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->unsignedBigInteger('hr_id');
            $table->foreign('hr_id')->references('id')->on('users');
            $table->unsignedBigInteger('manager_id')->nullable();
            $table->foreign('manager_id')->references('id')->on('users');
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('email');
            $table->enum('priority', ['LOW', 'MEDIUM', 'HIGH'])->default('LOW');
            $table->date('due_date')->nullable();
            $table->enum('status', ['PENDING','OPEN', 'IN_PROGRESS','ON_HOLD','SEND_FOR_REVIEW', 'COMPLETED', 'CLOSE'])->default('OPEN');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
