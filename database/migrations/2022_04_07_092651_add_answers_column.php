<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnswersColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('psp_remarks', function (Blueprint $table) {
            $table->text('answer4b')->after('answer3');
            $table->text('answer4a')->after('answer3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('psp_remarks', function (Blueprint $table) {
            $table->dropColumn('answer4a');
            $table->dropColumn('answer4b');
        });
    }
}
