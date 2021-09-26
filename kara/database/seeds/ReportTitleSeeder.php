<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportTitleSeeder extends Seeder
{
    private $data = [
      "محتوای آگهی نامناسب هست",
      "اطلاعات تماس آگهی نادرست است",
      "میزان حقوق مشخص شده نادرست و ناعادلانه است",
      "شیوه برخورد صاحب آگهی مناسب نیست",
      "اطلاعات آگهی گمراه کننده و یا دروغ هست",
      "آگهی در دسته بندی نادرست قرار دارد",
      "دلایل دیگر",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->data);$i++):
            DB::table("reports_title")->insert([
                "title" => $this->data[$i]
            ]);
        endfor;
    }
}
