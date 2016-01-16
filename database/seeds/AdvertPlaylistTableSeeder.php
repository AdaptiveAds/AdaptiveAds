<?php

use Illuminate\Database\Seeder;

class AdvertPlaylistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('advert_playlist');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'playlist_id' => 1,
        'advert_id' => 1,
        'display_schedule_id' => 1,
        'advert_index' => 0
      ]);
    }
}
