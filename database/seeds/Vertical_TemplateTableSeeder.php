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
      $table = DB::table('vertical_template');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'template_id' => 1,
      ]);
    }
}
