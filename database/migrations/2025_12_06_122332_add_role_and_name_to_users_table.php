<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add name column if it doesn't exist
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id');
            }
        });
        
        // Copy data from fullname to name if fullname exists (after column is created)
        if (Schema::hasColumn('users', 'fullname') && Schema::hasColumn('users', 'name')) {
            DB::statement('UPDATE users SET name = fullname WHERE name IS NULL AND fullname IS NOT NULL');
        }
        
        Schema::table('users', function (Blueprint $table) {
            // Add role column if it doesn't exist
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('customer')->after('name');
            }
        });
        
        // Copy data from roles to role if roles exists (after column is created)
        if (Schema::hasColumn('users', 'roles') && Schema::hasColumn('users', 'role')) {
            DB::statement('UPDATE users SET role = roles WHERE role = "customer" AND roles IS NOT NULL');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'role']);
        });
    }
};
