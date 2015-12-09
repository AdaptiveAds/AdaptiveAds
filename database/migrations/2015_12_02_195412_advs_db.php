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
        Schema::create('Transition', function (Blueprint $table) {
				$table->engine = 'InnoDB';
        		$table->increments('Transition_ID');
        		$table->string('Transition_Name', 20);
        	});
        Schema::create('Duration', function (Blueprint $table) {
				$table->engine = 'InnoDB';
        		$table->increments('Duration_ID');
        		$table->integer('Duration_Time');
        	});
        Schema::create('Template', function (Blueprint $table) {
				$table->engine = 'InnoDB';
        		$table->increments('Template_ID');
        		$table->string('Template_Name', 20);
        		$table->boolean('Template_Overrides_Skin');
        		$table->integer('Duration_ID')->unsigned();
        		$table->integer('Transition_ID')->unsigned();
				$table->boolean('Is_Vertical');
        		$table->foreign('Duration_ID')
        			  	->references('Duration_ID')
        				->on('Duration')
        			  	->onUpdate('cascade')
        			  	->onDelete('cascade');
        		$table->foreign('Transition_ID')
        		  		->references('Transition_ID')
        		  		->on('Transition')
        			  	->onUpdate('cascade')
        			  	->onDelete('cascade');
        	});
        Schema::create('Horizontal_Template', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Horizontal_ID');
            $table->integer('Template_ID')->unsigned();
            $table->foreign('Template_ID')
        		  		->references('Template_ID')
        		  		->on('Template')
        			  	->onUpdate('cascade')
        			  	->onDelete('cascade');
          });
        Schema::create('Vertical_Template', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Vertical_ID');
            $table->integer('Template_ID')->unsigned();
            $table->foreign('Template_ID')
          	  		->references('Template_ID')
          	  		->on('Template')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
          });
        Schema::create('Advert', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Advert_ID');
            $table->string('Advert_Name', 20);
            $table->boolean('Advert_Deleted');
          });
        Schema::create('Page_Data', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Page_Data_ID');
            $table->string('Page_Data_Name', 20);
            $table->string('Page_Image');
            $table->string('Page_Video');
            $table->string('Page_Content');
          });
        Schema::create('Page', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('Page_ID');
			$table->integer('Page_Data_ID')->unsigned();
			$table->integer('Page_Index');
			$table->integer('Advert_ID')->unsigned();
            $table->integer('Vertical_ID')->unsigned();
            $table->integer('Horizontal_ID')->unsigned();
          	$table->boolean('Deleted');
            $table->foreign('Page_Data_ID')
          	  		->references('Page_Data_ID')
          	  		->on('Page_Data')
          		  	->onUpdate('cascade')
          		  	->onDelete('cascade');
            $table->foreign('Advert_ID')
                	->references('Advert_ID')
                	->on('Advert')
                	->onUpdate('cascade')
                	->onDelete('cascade');
            $table->foreign('Vertical_ID')
                  ->references('Vertical_ID')
                  ->on('Vertical_Template')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('Horizontal_ID')
                	->references('Horizontal_ID')
                	->on('Horizontal_Template')
                	->onUpdate('cascade')
                	->onDelete('cascade');
        	});
        Schema::create('Display_Timing', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Display_Timing_ID');
            $table->DateTime('Start_Date');
            $table->DateTime('End_Date');
          });
        Schema::create('Playlist', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Playlist_ID');
            $table->DateTime('Playlist_Name');
            $table->DateTime('Deleted');
          });
        Schema::create('Playlist_Advert', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->integer('Playlist_ID')->unsigned();
			$table->integer('Advert_ID')->unsigned();
            $table->primary(array('Playlist_ID','Advert_ID'));
          	$table->integer('Advert_Index');
          	$table->integer('Display_Timing_ID')->unsigned();
            $table->foreign('Playlist_ID')
            	  	->references('Playlist_ID')
            			->on('Playlist')
            	  	->onUpdate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('Advert_ID')
                	->references('Advert_ID')
                	->on('Advert')
                	->onUpdate('cascade')
                	->onDelete('cascade');
            $table->foreign('Display_Timing_ID')
                	->references('Display_Timing_ID')
                	->on('Display_Timing')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });
        Schema::create('Skin', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Skin_ID');
            $table->string('Skin_Name', 20);
          });
        Schema::create('Location', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('Location_ID');
          	$table->string('Location_Name', 20);
          	$table->integer('Parent_Location');
          	$table->integer('Skin_ID')->unsigned();
            $table->integer('Playlist_ID')->unsigned();
            $table->foreign('Playlist_ID')
                	->references('Playlist_ID')
            			->on('Playlist')
            	  	->onUpdate('cascade')
            	  	->onDelete('cascade');
            $table->foreign('Skin_ID')
                	->references('Skin_ID')
                	->on('Skin')
                	->onUpdate('cascade')
                	->onDelete('cascade');
          });
        Schema::create('Screen', function (Blueprint $table) {
			$table->engine = 'InnoDB';
              $table->increments('Screen_ID');
              $table->boolean('Is_Vertical');
              $table->integer('Location_ID')->unsigned();
              $table->foreign('Location_ID')
                  	->references('Location_ID')
              			->on('Location')
              	  	->onUpdate('cascade')
              	  	->onDelete('cascade');
          });
        Schema::create('User', function (Blueprint $table) {
			$table->engine = 'InnoDB';
             $table->increments('User_ID');
             $table->string('Username', 20);
             $table->string('Password', 20);
          });
        Schema::create('Privilage', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('Privilage_ID');
			$table->string('Privilage_Level', 20);
          });
        Schema::create('User_Location', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->integer('User_ID')->unsigned();
			$table->integer('Location_ID')->unsigned();
			$table->primary(array('User_ID','Location_ID'));
			$table->integer('Privilage_ID')->unsigned();
			$table->foreign('Location_ID')
				->references('Location_ID')
					->on('Location')
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->foreign('User_ID')
				->references('User_ID')
				->on('User')
				->onUpdate('cascade')
				->onDelete('cascade');
			$table->foreign('Privilage_ID')
				->references('Privilage_ID')
					->on('Privilage')
				->onUpdate('cascade')
				->onDelete('cascade');
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Transition', 'Duration', 'Template',
                     'Horizontal_Template', 'Vertical_Template',
                     'Advert', 'Page_Data', 'Page', 'Display_Timing',
                     'Playlist', 'Playlist_Advert', 'Skin', 'Location',
                     'Screen', 'User', 'Privilage', 'User_Location');
    }
}
