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
        'advert_id' => 2, // Library
        'template_id' => 1,
        'page_index' => 0,
        'transition' => 'fadeIn',
		    'deleted' => 0
      ]);

      $table->insert([
        'page_data_id' => 2,
        'advert_id' => 2, // Library
        'template_id' => 2,
        'page_index' => 1,
        'transition' => 'slideInRight',
		    'deleted' => 0
      ]);

      $table->insert([
        'page_data_id' => 3,
        'advert_id' => 2, // Library
        'template_id' => 1,
        'page_index' => 2,
        'transition' => 'slideInLeft',
		    'deleted' => 0
      ]);

      $table->insert([
        'page_data_id' => 4,
        'advert_id' => 3, // Degree plus
        'template_id' => 1,
        'page_index' => 0,
        'transition' => 'fadeIn',
		    'deleted' => 0
      ]);

      $table->insert([
        'page_data_id' => 5,
        'advert_id' => 1, // Global
        'template_id' => 1,
        'page_index' => 0,
        'transition' => 'slideInDown',
		    'deleted' => 0
      ]);

      $table->insert([
        'page_data_id' => 6,
        'advert_id' => 4, // Library 2
        'template_id' => 1,
        'page_index' => 0,
        'transition' => 'bounceInUp',
		    'deleted' => 0
      ]);
    }
}
