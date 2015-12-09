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
        'overridesSkin' => 0,
        'duration_id' => 1,
        'transition_id' => 1
      ]);
    }
}
