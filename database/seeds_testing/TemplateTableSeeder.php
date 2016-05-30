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
        'name' => 'template1',
        'class_name' => 'template1',
        'duration' => 5,
        'thumbnail_path' => '/thumbnails/template1.png'
      ]);

      $table->insert([
        'name' => 'template2',
        'class_name' => 'template2',
        'duration' => 5,
        'thumbnail_path' => '/thumbnails/template2.png'
      ]);

      $table->insert([
        'name' => 'template3',
        'class_name' => 'template3',
        'duration' => 5,
        'thumbnail_path' => '/thumbnails/template3.png'
      ]);

      $table->insert([
        'name' => 'template5',
        'class_name' => 'template5',
        'duration' => 2,
        'thumbnail_path' => '/thumbnails/template5.png'
      ]);

      $table->insert([
        'name' => 'template6',
        'class_name' => 'template6',
        'duration' => 4,
        'thumbnail_path' => '/thumbnails/template6.png'
      ]);
    }
}
