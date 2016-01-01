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
        'template_name' => 'firstTemplate',
        'template_overrides_skin' => 0,
        'duration_id' => 1,
        'transition_id' => 1,
		    'is_vertical' => 0
      ]);
    }
}
