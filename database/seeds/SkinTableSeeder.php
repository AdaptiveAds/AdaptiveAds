<?php

use Illuminate\Database\Seeder;

class SkinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('skin');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'Global Skin',
        'image_path' => '',
        'hex_colour' => '0db596'
      ]);

      $table->insert([
        'name' => 'Library Skin',
        'image_path' => '',
        'hex_colour' => '5fd452'
      ]);
    }
}
