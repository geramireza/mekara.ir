<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTitleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports_title', function (Blueprint $table) {
            $table->collation = "utf8_general_ci";
            $table->charset = "utf8";
            $table->bigIncrements('id');
            $table->string("title")->collation("utf8_general_ci");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports_title');
    }
}
