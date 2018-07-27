# Database

This service provider can help developer easily to access the database by `Illuminate/Database`

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Database\DatabaseServiceProvider::class,
            ...
        ]

3. Edit the default database config

        vim config/database.php

## Usage

If you have used `Illuminate/Database`, you can use similar code to achieve what you want.

Base query in collector without define related model

    $user = $this->db->table('user')->find(1);

Using other connection in query

    $this->db->getConnection('connection')->table('user')->find(1);

Or you can define model first then access

    class User extends \Slimork\Contracts\Model {

    }

    $user = User::find(1);
    $user = User::on('connection')->find(1);

Pagination for data

    $user = User::paginate(1);

    echo $paginate->render();
    
Other methods

	// Return object like: { total: 1 }
	$this->db->fetchOneRaw("SELECT COUNT(*) AS total FROM table");

More information you can reference to [this package](https://laravel.com/docs/master/queries)
