<?php

use Illuminate\Database\Seeder;

class PrivilageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('privilage');

      //Empty table
      $table->delete();

    }
}
