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
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // single user
        $table->foreignId('business_id')->nullable()->constrained()->nullOnDelete(); // to a business
        $table->boolean('is_global')->default(false); // for everyone
        $table->foreignId('reply_to_id')->nullable()->constrained('messages')->nullOnDelete(); // threaded reply
        $table->string('type'); // Issue, Parcel, Notice, etc.
        $table->string('subject')->nullable();
        $table->text('message')->nullable();
        $table->string('status')->nullable(); // Open, Closed, etc.
        $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // admin
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
