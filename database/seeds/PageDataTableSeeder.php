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
      $table = DB::table('Page_Data');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'Page_Data_Name' => 'Library',
        'Page_Image' => 'a',
        'Page_Video' => 'a',
        'Page_Content' => 'Read books here... maybe... zzzz.'
      ]);
    }
}
