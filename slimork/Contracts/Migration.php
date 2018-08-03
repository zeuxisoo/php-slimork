<?php
namespace Slimork\Contracts;

use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as Capsule;

class Migration extends AbstractMigration {

    protected $schema;

    public function init() {
        $this->schema = Capsule::schema();
    }

}
