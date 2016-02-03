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
        'name' => 'Library Skin',
        'class_name' => 'skin_blue'
      ]);
    }
}
