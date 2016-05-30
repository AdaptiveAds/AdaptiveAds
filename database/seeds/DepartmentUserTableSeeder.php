<?php

use Illuminate\Database\Seeder;

class DepartmentUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('department_user');

      //Empty table
      $table->delete();

    }
}
