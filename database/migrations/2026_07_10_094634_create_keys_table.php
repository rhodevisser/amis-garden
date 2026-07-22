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
        Schema::create('keys', function (Blueprint $table) {
            $table->id();

            // The actual registration key (like a coupon code)
            // unique() ensures each key can only exist once in the database
            // Example: "SUMMER2024-ABCD-1234"
            $table->string('key')->unique();

            // When the key was used (null means not used yet)
            // This helps us track if a key has already been redeemed
            $table->timestamp('used_at')->nullable();

            // Who used this key (foreign key references the users table)
            // constrained() automatically creates the foreign key relationship
            // nullOnDelete() means if the user is deleted, this just becomes null
            $table->foreignId('used_by')->nullable()->constrained('users')->nullOnDelete();

            // Optional: when this key expires (null means never expires)
            // You can set this when creating keys to limit their validity period
            $table->timestamp('expires_at')->nullable();

            // created_at and updated_at timestamps
            // Laravel automatically manages these for us
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keys');
    }
};
