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
      $table = DB::table('Template');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'Template_Name' => 'firstTemplate',
        'Template_Overrides_Skin' => 0,
        'Duration_ID' => 1,
        'Transition_ID' => 1,
		    'Is_Vertical' => 0
      ]);
    }
}
