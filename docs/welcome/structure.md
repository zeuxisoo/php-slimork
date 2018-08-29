# Structure

The default structure of the Slimork

## Project Tree

The project tree maybe like:

    ProjectName
    ├── app
    │   └── Controllers
    ├── config
    ├── database
    ├── docker
    ├── docs
    ├── public
    ├── resources
    │   └── views
    │       └── errors
    ├── slimork
    │   ├── Contracts
    │   ├── Exceptions
    │   │   └── Handlers
    │   ├── Foundation
    │   ├── Middlewares
    │   │   └── Route
    │   └── Providers
    │       ├── Log
    │       │   └── Handlers
    │       └── View
    └── storage
        ├── cache
        │   └── views
        └── logs

-  `app`     : The project directory such as controller, models and other project related code
-  `config`  : The project config directory such as service provider, database and view config
-  `database`: The project database directory such as migration and seed files
-  `docker`  : The docker container config files
-  `docs`    : The documentation of the Slimork
-  `public`  : The public directory for everyone access such as assets and download files
-  `resource`: The resources directory for the project such as assets and view sources
-  `slimork` : The project library ***(Note: Please don't modify this directory/files)***
-  `storage` : The storage directory for user or program to store the generated file such as upload file, system logs.
