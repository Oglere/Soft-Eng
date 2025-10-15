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
    Schema::create('users', function (Blueprint $table) {
        $table->id('user_id');
        $table->string('first_name');
        $table->string('last_name');
        $table->string('usn')->unique();
        $table->string('password_hash');
        $table->string('email')->unique();
        $table->string('phone_number')->nullable();
        $table->string('role');
        $table->timestamp('locked_until')->nullable(); // ✅ timestamp, replaces is_locked
        $table->integer('attempts')->default(0);
        $table->dateTime('last_login')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
