<?php

use Illuminate\Database\Seeder;

class DisplaySettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('displaySetting');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'verticleTemplate' => 1,
        'horizontalTemplate' => 1
      ]);
    }
}
