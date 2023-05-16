<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'A voir en priorité',
            'En cours de visionnage',
            'Dès que possible',
            'Plus tard',
            'A revoir',
            'Fini'
        ];

        foreach ($categories as $category) {
            Category::create([
                'title' => $category
            ]);
        }
    }
}
