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
        'heading' => '(Global) Marketing: Need some un-wanted adverts?',
        'image_path' => '',
        'video_path' => '',
        'content' => 'Sed euismod accumsan lorem, pellentesque ornare felis luctus eu. Nulla pharetra lorem tellus, volutpat placerat urna congue eget. Cras mattis mattis nulla, at vestibulum sapien sollicitudin a.',
        'deleted' => 0
      ]);
    }
}
