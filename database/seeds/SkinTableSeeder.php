<?php

use Illuminate\Database\Seeder;

class backgroundTableSeeder extends Seeder
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

      $table->insert([
        'name' => 'Library background',
        'image_path' => '',
        'hex_colour' => '5fd452'
      ]);
    }
}
