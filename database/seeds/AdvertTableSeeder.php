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
      $table = DB::table('advert');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'myAdvert',
        'deleted' => 0,
        'department_id' => 1
      ]);
    }
}
