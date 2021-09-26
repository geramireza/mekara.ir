<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostPublishPrice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_publish_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("monthly");
            $table->integer("weekly");
            $table->integer("monthly_karjoo");
            $table->integer("weekly_karjoo");
            $table->integer("emergency");
            $table->integer("extended");
            $table->integer("ladder");
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
        Schema::dropIfExists('post_publish_prices');
    }
}
