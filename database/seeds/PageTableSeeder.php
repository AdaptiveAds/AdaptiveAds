<?php

use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('page');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'dataID' => 1,
        'pageIndex' => 1,
        'advertID' => 1,
        'displaySettingID' => 1,
        'deleted' => 0
      ]);
    }
}
