# Migration

This command can help you migration the migration file transform to your database

## Usage

Fist, you must run this command to migration the default migration file and default user table

    php ./vendor/bin/phinx migrate

Next, Create the migration file, like

    php ./vendor/bin/phinx create CreateSomesTable

Edit the generated file, like

    vim database/migrations/YYYYMMDDHHMMSS_create_somes_table.php

And the content like

    <?php
    use Slimork\Contracts\Migration;

    use Slimork\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;

    class CreateSomesTable extends Migration {

        public function up() {
            Schema::create('somes', function(Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('email')->unique();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
            });
        }

        public function down() {
            Schema::dropIfExists('somes');
        }

    }

Then, you can run the migration command again, to migrate the schema into database

    php ./vendor/bin/phinx migrate

## Other

If you don't like to using the `Schema` facade, you can replace it with migration attribute

    $this->schema

    // like
    $this->schema->create('table', function(Blueprint $table) {
        ...
        ...
        ...
    });

    $this->schema->dropIfExists('table');
