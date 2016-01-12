<?php

use Illuminate\Database\Seeder;

class PageDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('page_data');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'page_data_name' => 'Library',
        'page_image' => 'a',
        'page_video' => 'a',
        'page_content' => 'Read books here... maybe... zzzz.'
      ]);
    }
}
