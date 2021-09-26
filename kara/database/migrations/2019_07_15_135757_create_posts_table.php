<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->collation = "utf8_general_ci";
            $table->charset = "utf8";
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('post_token')->collation("utf8_general_ci");
            $table->string('title')->collation("utf8_general_ci");
            $table->string('slug');
            $table->text('body')->collation("utf8mb4_general_ci");
            $table->integer('fee')->default(0);
            $table->integer('fee_type')->default(0); //value 0 means free and value 1 means daily and 2 means monthly
            $table->string('city')->collation("utf8_general_ci");
            $table->tinyInteger('post_type')->default(0); // value 0 means karfarma and value 1 means karjoo
            $table->integer('view_count')->default(0);
            $table->tinyInteger('post_life')->default(0);  // value 7 means post life is a week and value 30 means post life is a month
            $table->tinyInteger("day_of_post_life")->default(0);
            $table->boolean('is_extended')->default(0);
            $table->boolean('is_enable')->default(0);
            $table->boolean('is_pay')->default(0);
            $table->boolean('is_emergency')->default(0);
            $table->boolean('is_update')->default(0);
            $table->boolean('is_delete')->default(0);
            $table->boolean('is_expired')->default(0);
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->string('img3')->nullable();
            $table->timestamp("published_at")->nullable();
            $table->timestamp("deleted_at")->nullable();
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
        Schema::dropIfExists('posts');
    }
}
