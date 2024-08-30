<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Sports', 'Finance', 'Movies'];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['name' => $category], 
                ['name' => $category]  
            );
        }
    }
}
