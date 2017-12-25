<?php

use \QuickBetOnline\Migration\Migration;

class CreateConversionLogTable extends Migration
{
    public function up()  {
        $this->schema->create('conversion_logs', function(Illuminate\Database\Schema\Blueprint $table){
            // Auto-increment id
            $table->increments('id');
            //the conversion values
            $table->string('user_ip', 20);
            $table->json('data');
            // Required for Eloquent's created_at and updated_at columns
            $table->timestamps();
        });
    }
    public function down()  {
        $this->schema->dropIfExists('conversion_logs');
    }
}
