<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('page');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'page_data_id' => 1,
        'page_index' => 1,
        'advert_id' => 1,
        'template_id' => 1,
		    'deleted' => 0
      ]);
    }
}
