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
        'playlist_id' => 1, // Global
        'advert_id' => 1,
        'advert_index' => 0
      ]);

      $table->insert([
        'playlist_id' => 2, // Library
        'advert_id' => 2,
        'advert_index' => 0
      ]);

      $table->insert([
        'playlist_id' => 2, // Library
        'advert_id' => 4,
        'advert_index' => 0
      ]);

      $table->insert([
        'playlist_id' => 3, // DegreePlus
        'advert_id' => 3,
        'advert_index' => 0
      ]);

    }
}
