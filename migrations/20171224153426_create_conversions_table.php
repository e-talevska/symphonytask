<?php

use \QuickBetOnline\Migration\Migration;

class CreateConversionsTable extends Migration
{
    public function up()  {
        $this->schema->create('odds', function(Illuminate\Database\Schema\Blueprint $table){
            // Auto-increment id
            $table->increments('id');
            //the conversion values
            $table->string('moneyline', 10);
            $table->string('decimal', 10);
            $table->string('fractional', 10);
            // Required for Eloquent's created_at and updated_at columns
            $table->timestamps();
        });
    }
    public function down()  {
        $this->schema->dropIfExists('odds');
    }
}
