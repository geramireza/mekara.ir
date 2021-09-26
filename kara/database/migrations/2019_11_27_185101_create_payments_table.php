<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('payments');
         Schema::create('payments', function (Blueprint $table) {
            $table->collation = "utf8_general_ci";
             $table->charset = "utf8";
             $table->bigIncrements('id');
            $table->integer("post_id");
            $table->integer("user_id");
            $table->tinyInteger("status")->default(0);
            $table->integer("amount");
             $table->tinyInteger('post_life')->default(0);  // value 7 means post life is a week and value 30 means post life is a month
             $table->boolean('is_emergency')->default(0);
             $table->boolean('is_extended')->default(0);
             $table->boolean('is_ladder')->default(0);
            $table->string("gate")->collation("utf8_general_ci");
            $table->string("transaction_id")->collation("utf8_general_ci");
            $table->string("reference_id")->nullable()->collation("utf8_general_ci");
            $table->timestamp("created_at")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp("updated_at")->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
