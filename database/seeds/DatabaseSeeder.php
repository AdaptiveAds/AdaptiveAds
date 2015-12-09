<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        $this->call(TransitionTableSeeder::class);
        $this->call(DurationTableSeeder::class);
        $this->call(TemplateTableSeeder::class);
        $this->call(AdvertTableSeeder::class);
        $this->call(PageDataTableSeeder::class);
        $this->call(Horizontal_TemplateTableSeeder::class);
        $this->call(Vertical_TemplateTableSeeder::class);
        $this->call(PageTableSeeder::class);

        Model::reguard();
    }
}
