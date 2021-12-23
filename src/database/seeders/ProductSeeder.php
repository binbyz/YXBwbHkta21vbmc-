<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 100) as $number) {
            DB::table('kmong_products')->insert([
                'goodsname' => Str::random(7),
                'display' => 1,
                'price' => 70000,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
