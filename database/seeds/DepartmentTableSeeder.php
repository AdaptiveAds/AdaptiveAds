<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('department');

      //Empty table
      $table->delete();

      $table->insert([
        'name' => 'Global_Marketing'
      ]);

      //Populate table
      $table->insert([
        'name' => 'Library Services'
      ]);

      $table->insert([
        'name' => 'DegreePlus'
      ]);
    }
}
