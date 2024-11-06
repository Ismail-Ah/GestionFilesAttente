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
        Schema::table('files_attentes', function (Blueprint $table) {
            // Drop the foreign key constraint
            $table->dropForeign(['service_id']);
            
            // Drop the unique index
            $table->dropUnique(['service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files_attentes', function (Blueprint $table) {
            // Recreate the unique index
            $table->unique('service_id');
            
            // Recreate the foreign key constraint
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }
};
