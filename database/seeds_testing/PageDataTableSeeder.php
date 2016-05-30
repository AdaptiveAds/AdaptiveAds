<?php

use Illuminate\Database\Seeder;

class PageDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $table = DB::table('page_data');

      //Empty table
      $table->delete();

      //Populate table
      $table->insert([
        'heading' => 'UoG Library Services',
        'image_path' => '',
        'video_path' => '',
        'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec eu elit ut risus suscipit dapibus vel ac lectus. Nam egestas justo nec odio egestas, vel tempus augue laoreet. Nulla interdum dolor eget orci tincidunt mattis. Vivamus bibendum tempus mi, convallis volutpat tortor consequat ultricies. Maecenas porttitor quis turpis in dictum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse potenti. Morbi vel mi id augue maximus varius.',
        'deleted' => 0
      ]);

      $table->insert([
        'heading' => 'Need some extra reading?',
        'image_path' => '',
        'video_path' => '',
        'content' => 'Mauris semper lorem sed mauris vestibulum tempor. In hac habitasse platea dictumst. Vestibulum molestie urna eget neque pulvinar, sit amet ultricies velit venenatis. Vivamus dictum condimentum faucibus. Phasellus in nulla neque. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis in ullamcorper velit, sit amet hendrerit leo. Phasellus pulvinar mattis odio, sit amet tincidunt risus maximus nec.',
        'deleted' => 0
      ]);

      $table->insert([
        'heading' => 'Ebooks... Ebooks everywhere!',
        'image_path' => '',
        'video_path' => '',
        'content' => 'Vestibulum in nunc accumsan tortor porta faucibus. Suspendisse at ornare sapien. Maecenas id purus at augue fermentum suscipit dictum nec leo. Donec bibendum pretium porttitor. Etiam dapibus turpis justo, ac eleifend nulla vulputate eget. Proin convallis eget elit et blandit. Suspendisse sollicitudin arcu ac nunc scelerisque iaculis. Curabitur iaculis justo ac mauris vulputate tincidunt ac eget magna. In nec risus nisl.',
        'deleted' => 0
      ]);

      $table->insert([
        'heading' => 'Looking photo fancy!',
        'image_path' => '',
        'video_path' => '',
        'content' => '',
        'deleted' => 0
      ]);

      $table->insert([
        'heading' => '(Global) Marketing: Need some un-wanted adverts?',
        'image_path' => '',
        'video_path' => '',
        'content' => 'Sed euismod accumsan lorem, pellentesque ornare felis luctus eu. Nulla pharetra lorem tellus, volutpat placerat urna congue eget. Cras mattis mattis nulla, at vestibulum sapien sollicitudin a. Morbi vitae scelerisque quam, ac mattis nisi. Vivamus consectetur ante ut orci faucibus, eget fringilla elit interdum. Donec magna justo, iaculis sed maximus vel, sollicitudin eu sapien. Duis dapibus volutpat mattis. Donec ultrices tortor eget nisi porttitor, quis porttitor dolor fermentum. Sed vel aliquam tortor, at eleifend nisl. Morbi auctor, ex ut consectetur finibus, ante est tincidunt sem, ac iaculis est nunc quis orci. Curabitur sit amet nisi eu nisi gravida rutrum in sit amet neque.',
        'deleted' => 0
      ]);

      $table->insert([
        'heading' => 'Two adverts!? Greedy!',
        'image_path' => '',
        'video_path' => '',
        'content' => 'Sed euismod accumsan lorem, pellentesque ornare felis luctus eu. Nulla pharetra lorem tellus, volutpat placerat urna congue eget. Cras mattis mattis nulla, at vestibulum sapien sollicitudin a. Morbi vitae scelerisque quam, ac mattis nisi. Vivamus consectetur ante ut orci faucibus, eget fringilla elit interdum. Donec magna justo, iaculis sed maximus vel, sollicitudin eu sapien. Duis dapibus volutpat mattis. Donec ultrices tortor eget nisi porttitor, quis porttitor dolor fermentum. Sed vel aliquam tortor, at eleifend nisl. Morbi auctor, ex ut consectetur finibus, ante est tincidunt sem, ac iaculis est nunc quis orci. Curabitur sit amet nisi eu nisi gravida rutrum in sit amet neque.',
        'deleted' => 0
      ]);
    }
}
