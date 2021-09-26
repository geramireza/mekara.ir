<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('blogs');
        Schema::create('blogs', function (Blueprint $table) {
            $table->collation = "utf8_general_ci";
            $table->charset = "utf8";
            $table->bigIncrements('id');
            $table->integer("category_id");
            $table->string('title')->collation("utf8_general_ci");
            $table->string('slug');
            $table->text('body')->collation("utf8mb4_general_ci");
            $table->boolean('is_enable')->default(0);
            $table->integer('view_count')->default(0);
            $table->string('img')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
