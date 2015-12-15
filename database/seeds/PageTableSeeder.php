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
      $table = DB::table('Page');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'Page_Data_ID' => 1,
        'Page_Index' => 1,
        'Advert_ID' => 1,
        'Vertical_ID' => 1,
        'Horizontal_ID' => 1,
		    'Deleted' => 0
      ]);
    }
}
