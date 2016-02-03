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
        'heading' => 'Library',
        'image_path_1' => 'D:\test.png',
        'image_meta_1' => 'something',
        'video_path_1' => 'D:\test.mp4',
        'video_meta_1' => 'something',
        'content_1' => 'Read books here... maybe... zzzz.',
        'content_2' => 'Read books here... maybe... zzzz.',
        'deleted' => 0
      ]);
    }
}
