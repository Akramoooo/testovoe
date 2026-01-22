<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Электроника', 'description' => 'Смартфоны, ноутбуки и прочая техника'],
            ['name' => 'Одежда', 'description' => 'Мужская и женская одежда'],
            ['name' => 'Дом и сад', 'description' => 'Товары для уюта и инструменты'],
            ['name' => 'Книги', 'description' => 'Художественная и техническая литература'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
