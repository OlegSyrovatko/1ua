<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddRayIndexToMemoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $exists = DB::selectOne(
            "SELECT COUNT(*) AS cnt FROM information_schema.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'Memory' AND INDEX_NAME = 'ray'"
        );

        if ($exists->cnt == 0) {
            Schema::table('Memory', function (Blueprint $table) {
                $table->index('ray', 'ray');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Memory', function (Blueprint $table) {
            $table->dropIndex('ray');
        });
    }
}
