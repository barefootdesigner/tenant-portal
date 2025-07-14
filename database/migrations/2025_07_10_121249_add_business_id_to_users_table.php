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
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('business_id')->nullable()->constrained()->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
 public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['business_id']);
        $table->dropColumn('business_id');
    });
}
};
