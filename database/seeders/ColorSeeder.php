<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed active color records
        Color::create(['name' => 'Red', 'hex_code' => '#FF0000']);
        Color::create(['name' => 'Green', 'hex_code' => '#00FF00']);
        Color::create(['name' => 'Blue', 'hex_code' => '#0000FF']);

        // Optionally soft delete a color as an example
        Color::create(['name' => 'Soft Deleted Color', 'hex_code' => '#FFFFFF'])->delete();
        // This color will b e soft-deleted
    }
}