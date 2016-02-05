<?php

use Illuminate\Database\Seeder;

class PlaylistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('playlist');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'name' => 'Global Playlist',
        'deleted' => 0,
        'department_id' => 1,
        'isGlobal' => 1
      ]);

      $table->insert([
        'name' => 'Library Services Playlist',
        'deleted' => 0,
        'department_id' => 2
      ]);

      $table->insert([
        'name' => 'DegreePlus Playlist',
        'deleted' => 0,
        'department_id' => 3
      ]);

    }
}
