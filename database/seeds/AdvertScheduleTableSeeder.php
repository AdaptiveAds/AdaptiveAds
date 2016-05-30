<?php

use Illuminate\Database\Seeder;

class AdvertScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('advert_schedule');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'playlist_id' => 1, // Global
        'advert_id' => 1,
        'schedule_id' => 1
      ]);
    }
}
