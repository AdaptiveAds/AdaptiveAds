<?php

use Illuminate\Database\Seeder;

class AdvertTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('Advert');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'Advert_Name' => 'myAdvert',
        'Advert_Deleted' => 0
      ]);
    }
}
