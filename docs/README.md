# Slimork

Slimork is a set of packages to help you build your web project

## Introduction

This is a simple documentation of `Slimork`

The document will explain how to use the service provider, helpers, and other related functions

## Installation

Create program from the Slimork

    composer create-project --prefer-dist --no-dev zeuxisoo/php-slimork:3.x-dev slimork

Edit the slim application settings

    vim ./config/slim.php

## Development

Install the vendors

1. If the `composer` command already installed, run the following command

        composer install

2. If the `composer` command is not installed by default, run the following command

        make composer
        make vendor

Run the development server, the default url is `http://localhost:8080`

    make server
