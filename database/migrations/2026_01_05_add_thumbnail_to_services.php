<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('services', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('expected_duration');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }
        });
    }
};
