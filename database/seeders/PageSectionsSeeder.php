<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('page_sections')->insert([
            [
                'page_id' => 1,
                'section' => 'hero',
                'name' => 'hero_main_image',
                'type' => 'image',
                'value' => 'hero_car.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'hero',
                'name' => 'hero_primary_text',
                'type' => 'text',
                'value' => 'Find Your Perfect Car at Carking – Quality, Speed, and Style',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'hero',
                'name' => 'hero_secondary_text',
                'type' => 'text',
                'value' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'finance',
                'name' => 'finance_image_1',
                'type' => 'image',
                'value' => 'finance_image1.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'finance',
                'name' => 'finance_image_2',
                'type' => 'image',
                'value' => 'finance_image2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'finance',
                'name' => 'finance_primary_text',
                'type' => 'text',
                'value' => "Flexible finance for added shine",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'finance',
                'name' => 'finance_secondary_text',
                'type' => 'text',
                'value' => "AA Car Finance allows you to get a quote without affecting your credit rating. Find a car from any dealer, and we’ll do the rest. With a large panel of 30+ lenders we can help most drivers.",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'counter',
                'name' => 'car_for_sale',
                'type' => 'text',
                'value' => '836',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'counter',
                'name' => 'forum_sections',
                'type' => 'text',
                'value' => '25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'counter',
                'name' => 'visitor_per_day',
                'type' => 'text',
                'value' => '1500',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'page_id' => 1,
                'section' => 'counter',
                'name' => 'verified_dealers',
                'type' => 'text',
                'value' => '38',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
