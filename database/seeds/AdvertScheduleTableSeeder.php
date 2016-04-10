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

      $table->insert([
        'playlist_id' => 2,
        'advert_id' => 2,
        'schedule_id' => 3
      ]);

      $table->insert([
        'playlist_id' => 2,
        'advert_id' => 4,
        'schedule_id' => 3
      ]);

      $table->insert([
        'playlist_id' => 3,
        'advert_id' => 3,
        'schedule_id' => 1
      ]);
    }
}
