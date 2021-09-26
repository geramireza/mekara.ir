<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private $data = [
        "کامپیوتر و اینترنت",
        "عمران و ساختمان",
        "اداری و مدیریت",
        "فروشگاه و رستوران",
        "خدمات فنی و مهندسی",
        "آموزشی",
        "هنر و موسیقی",
        "پزشکی و سلامت",
        "مالی، حسابداری و حقوقی",
        "کشاورزی و باغبانی",
        "بازاریابی و فروش",
        "سرایداری و نظافت",
        "حمل و نقل",
        "سایر خدمات",
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < count($this->data); $i ++)
            Category::create([
                "title" => $this->data[$i]
            ]);
    }
}
