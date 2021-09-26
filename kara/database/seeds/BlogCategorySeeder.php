<?php

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategorySeeder extends Seeder
{

    private $data = [
        "کسب و کار",
        "همه چیز در مورد استان سمنان",
        "موفقیت",
        "اخبار کارا",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->data); $i ++)
            DB::table("blog_categories")->insert([
                "title" => $this->data[$i]
            ]);
    }
}
