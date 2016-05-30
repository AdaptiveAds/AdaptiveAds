<?php

use Illuminate\Database\Seeder;

class BackgroundTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('background');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'Global background',
        'image_path' => '',
        'hex_colour' => '0db596'
      ]);
    }
}
