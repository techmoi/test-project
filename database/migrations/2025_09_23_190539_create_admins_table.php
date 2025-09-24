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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phonenumber')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('otp', 50)->nullable();
            $table->dateTime('otp_sent_on')->nullable();
            $table->string('token')->nullable();
            $table->string('image')->nullable();
            $table->integer('created_by')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('address')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
