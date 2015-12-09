<?php

use Illuminate\Database\Seeder;

class Vertical_TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('Vertical_Template');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'Template_ID' => 1,
      ]);
    }
}
