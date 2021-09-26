<?php

use App\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    private $data = [
      "سمنان",
      "شاهرود",
      "دامغان",
      "گرمسار",
      "مهدی شهر",
      "ایوانکی",
      "شهمیرزاد",
      "سرخه",
      "بسطام",
        "آرادان",
        "مجن",
        "کلاته خیج",
        "میامی",
        "امیریه",
        "رودیان",
        "بیارجمند",
        "کهن آباد",
        "کلاته",
        "دیباج",
        "درجزین",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < count($this->data); $i++)
            City::create([
                "title" => $this->data[$i]
            ]);
    }
}
