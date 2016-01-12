<?php

use Illuminate\Database\Seeder;

class Horizontal_TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('horizontal_template');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'template_id' => 1,
      ]);
    }
}
