<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdvsDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('transition', function (Blueprint $table) {
				$table->engine = 'InnoDB';
        		$table->increments('id');
        		$table->string('transition_name', 20);
        	});

        Schema::create('duration', function (Blueprint $table) {
				$table->engine = 'InnoDB';
        		$table->increments('id');
        		$table->integer('duration_time');
        	});

        Schema::create('template', function (Blueprint $table) {
				    $table->engine = 'InnoDB';
        		$table->increments('id');
        		$table->string('template_name', 20);
        		$table->boolean('template_overrides_Skin');
        		$table->integer('duration_id')->unsigned();
        		$table->integer('transition_id')->unsigned();
				    $table->boolean('is_vertical');
        		$table->foreign('duration_id')
        			  	->references('id')
        				  ->on('duration')
        			  	->onUpdate('cascade')
        			  	->onDelete('cascade');
        		$table->foreign('transition_ID')
        		  		->references('id')
        		  		->on('transition')
        			  	->onUpdate('cascade')
        			  	->onDelete('cascade');
        	});

        Schema::create('horizontal_template', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')
        		  		->references('id')
        		  		->on('template')
        			  	->onUpdate('cascade')
        			  	->onDelete('cascade');
          });

        Schema::create('vertical_template', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->foreign('template_id')
          	  		->references('id')
          	  		->on('template')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
          });

        Schema::create('advert', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('advert_name', 20);
            $table->boolean('advert_deleted');
          });

        Schema::create('page_data', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('page_data_name', 20);
            $table->string('page_image');
            $table->string('page_video');
            $table->string('page_content');
          });

        Schema::create('page', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
			      $table->increments('id');
			      $table->integer('page_data_id')->unsigned();
			      $table->integer('page_index');
			      $table->integer('advert_id')->unsigned();
            $table->integer('vertical_id')->unsigned();
            $table->integer('horizontal_id')->unsigned();
            $table->boolean('deleted');
            $table->foreign('page_data_id')
          	      ->references('id')
          			  ->on('page_data')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
            $table->foreign('advert_id')
                	->references('id')
                	->on('advert')
                	->onUpdate('cascade')
                	->onDelete('cascade');
            $table->foreign('vertical_id')
                  ->references('id')
                  ->on('vertical_template')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('horizontal_id')
                	->references('id')
                	->on('horizontal_template')
                	->onUpdate('cascade')
                	->onDelete('cascade');
        	});

        Schema::create('display_timing', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->DateTime('start_date');
            $table->DateTime('end_date');
          });

        Schema::create('playlist', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
            $table->DateTime('playlist_name');
            $table->DateTime('deleted');
          });

        Schema::create('playlist_advert', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
			      $table->integer('playlist_id')->unsigned();
			      $table->integer('advert_id')->unsigned();
            $table->primary(array('playlist_id','advert_id'));
          	$table->integer('advert_index');
          	$table->integer('display_timing_id')->unsigned();
            $table->foreign('playlist_id')
            	  	->references('id')
            			->on('playlist')
            	  	->onUpdate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('advert_id')
                	->references('id')
                	->on('advert')
                	->onUpdate('cascade')
                	->onDelete('cascade');
            $table->foreign('display_timing_id')
                	->references('id')
                	->on('display_timing')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });

        Schema::create('skin', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('ID');
            $table->string('skin_name', 20);
          });

        Schema::create('location', function (Blueprint $table) {
			      $table->engine = 'InnoDB';
            $table->increments('id');
          	$table->string('location_name', 20);
          	$table->integer('parent_location');
          	$table->integer('skin_id')->unsigned();
            $table->integer('playlist_id')->unsigned();
            $table->foreign('playlist_id')
                	->references('id')
            			->on('playlist')
            	  	->onUpdate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('skin_id')
                	->references('id')
                	->on('skin')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });

        Schema::create('screen', function (Blueprint $table) {
			        $table->engine = 'InnoDB';
              $table->increments('id');
              $table->boolean('is_vertical');
              $table->integer('location_id')->unsigned();
              $table->foreign('location_id')
                  	->references('id')
              			->on('location')
              	  	->onUpdate('cascade')
              	  	->onDelete('cascade');
          });

        Schema::create('user', function (Blueprint $table) {
			       $table->engine = 'InnoDB';
             $table->increments('id');
             $table->string('username', 40)->unique();
             $table->string('password', 60);
             $table->rememberToken();
             $table->timestamps();
          });

        Schema::create('privilage', function (Blueprint $table) {
			       $table->engine = 'InnoDB';
			       $table->increments('id');
			       $table->string('privilage_level', 20);
          });

        Schema::create('user_location', function (Blueprint $table) {
      			$table->engine = 'InnoDB';
      			$table->integer('user_id')->unsigned();
      			$table->integer('location_id')->unsigned();
      			$table->primary(array('user_id','location_id'));
      			$table->integer('privilage_id')->unsigned();
      			$table->foreign('location_id')
                  ->references('id')
                  ->on('location')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
      			$table->foreign('user_id')
          				->references('id')
          				->on('user')
          				->onUpdate('cascade')
          				->onDelete('cascade');
      			$table->foreign('privilage_id')
                  ->references('id')
                  ->on('privilage')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
          });

        Schema::create('password_resets', function(Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transition', 'duration', 'template',
                     'horizontal_template', 'vertical_template',
                     'advert', 'page_data', 'page', 'display_timing',
                     'playlist', 'playlist_advert', 'skin', 'location',
                     'screen', 'user', 'privilage', 'user_location', 'password_resets');
    }
}
