<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('location');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'Marketing',
        'department_id' => 1,
        'playlist_id' => 1 
      ]);
    }
}
