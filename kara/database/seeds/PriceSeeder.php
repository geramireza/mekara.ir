<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    private $data = [
        "monthly" => 10000,
        "weekly"  => 5000,
        "monthly_karjoo" => 5000,
        "weekly_karjoo" => 3000,
        "emergency" => 5000,
        "extended" => 5000,
        "ladder" => 5000
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("post_publish_prices")->insert([
            "monthly" => $this->data["monthly"],
            "weekly" => $this->data["weekly"],
            "monthly_karjoo" => $this->data["monthly_karjoo"],
            "weekly_karjoo" => $this->data["weekly_karjoo"],
            "emergency" => $this->data["emergency"],
            "extended" => $this->data["extended"],
            "ladder" => $this->data["ladder"],
        ]);
    }
}
