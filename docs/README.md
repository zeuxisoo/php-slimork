# Slimork

Slimork is a set of packages to help you build your web project

## Introduction

This is a simple documentation of `Slimork`

The document will explain how to use the service provider, helpers, and other related functions

## Installation

Create program from the Slimork

    composer create-project --prefer-dist --no-dev zeuxisoo/php-slimork:3.x-dev slimork

Create the dotenv file from the example file

> Optional, if the `dotenv` file is not exists, the application will using the default settings

    cp .env.example .env

## Settings

The basic slim application settings in `./config/slim.php`. Other settings in the config directory, Please reference to the each service provider section

## Development

Install the vendors

1. If the `composer` command already installed, run the following command

        composer install

2. If the `composer` command is not installed by default, run the following command

        make composer
        make vendor

3. Run the development server, the default url is `http://localhost:8080`

        make server

## Production

1. Install the vendor and composer like point 1 and 2 in development parts

        make composer
        make vendor

2. Create the dotenv for your production (`.env.production`) or using the default dotenv file (`.env`)

        cp .env .env.production

3. Run the server and set the APP_ENV variable like

        APP_ENV=production make server
