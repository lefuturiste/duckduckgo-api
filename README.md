# Duckduckgo api

[![Duckduckgo api](https://duckduckgo.com/assets/logo_homepage.normal.v107.svg)](https://duckduckgo.com)

Host your own duckduckgo api, support bang search and instant awnsers

## Quick install

- Just git clone this repo
- `composer install`

Create a .env file in the root directory and fill it with env vars fields (you can get the list of the fields in .env.example)

## Usage

The simplest usage : `GET /search?query=whatever` , ths url will return the first page of row search result with title, description, icon and url and, with that, the instant awnser api result from duckduckgo's true api.

### bang

## The console

This template include console powered by symfony console:

The console allowed this commands:

### Local dev server

- php console serve -> for run a local dev server with php cli

## Maintenance mode

(not finish)

Maintenance mode allow a independent maintenance mode from your web application.

Maintenance mode is made for rename index.php file in web root directory (public) by _index.php and rename maintenance.php file by index.php file and vice versa.

- php console maintenance open -> for enable maintenance mode
- php console maintenance close -> for disable maintenance mode
