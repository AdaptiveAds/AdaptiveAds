<?php

use Illuminate\Database\Seeder;

class TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('template');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'firstTemplate',
        'class_name' => 'something',
        'duration' => 5
      ]);
    }
}
