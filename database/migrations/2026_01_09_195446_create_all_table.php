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
        // 1. Update Users Table (Add columns from your updates)
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->string('role')->default('user')->after('phone'); // Default role
        });

        // 2. Create Students Table (Inherits from User)
        Schema::create('students', function (Blueprint $table) {
            $table->id()->primary();
            $table->integer('matricNo')->unique()->nullable();
            $table->timestamps();

            // Foreign Key linking to Users
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });

        // 3. Create Staff Table (Inherits from User)
        Schema::create('staff', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('staffID', 50)->unique()->nullable();
            $table->string('role', 50)->nullable(); // Specific staff role (distinct from user role)
            $table->timestamps();

            // Foreign Key linking to Users
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });

        // 4. Create Admin Table (Inherits from User)
        Schema::create('admins', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('adminID', 50)->unique()->nullable();
            $table->timestamps();

            // Foreign Key linking to Users
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });

        // 5. Create Venue Table (With Kuliyyah included)
        Schema::create('venues', function (Blueprint $table) {
            $table->string('venueID', 50)->primary();
            $table->string('name', 100);
            $table->string('kuliyyah')->nullable(); // Included directly
            $table->string('location', 255)->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('available')->default(true);
            $table->timestamps();
        });

        // 6. Create Reservation Table (Final Structure)
        Schema::create('reservations', function (Blueprint $table) {
            $table->string('reservationID', 50)->primary();
            
            // Date & Time Columns (Final state from file 5)
            $table->date('startDate');
            $table->date('endDate');
            $table->time('startTime');
            $table->time('endTime');
            
            $table->string('reason')->nullable(); // Included directly
            $table->string('status', 20)->default('Pending');
            
            // Foreign Keys
            $table->string('venueID', 50)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('venueID')->references('venueID')->on('venues')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Drop Tables in reverse order to avoid FK constraints
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('venues');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('staff');
        Schema::dropIfExists('students');

        // 2. Revert changes to Users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role']);
        });
    }
};