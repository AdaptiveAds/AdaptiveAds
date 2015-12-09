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
      $table = DB::table('pageData');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'title' => 'Library',
        'image' => 'a',
        'video' => 'a',
        'content' => 'Read books here... maybe... zzzz.'
      ]);
    }
}
