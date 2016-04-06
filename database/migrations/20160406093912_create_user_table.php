<?php
use App\Contracts\Migration;

class CreateUserTable extends Migration {

    public function up() {
        $this->schema->create('user', function(Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->string('username', 30);
            $table->string('email', 120);
            $table->string('password', 64);
            $table->timestamps();
        });
    }

    public function down() {
        $this->schema->drop('user');
    }

}
