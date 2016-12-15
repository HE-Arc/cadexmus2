# CadExMus2

Web app using Laravel that aim to create music collaboratively.

[![Join the chat at https://gitter.im/HE-Arc/cadexmus2](https://badges.gitter.im/HE-Arc/cadexmus2.svg)](https://gitter.im/HE-Arc/cadexmus2?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## Abstract

CadExMus2 provides a music sequencer, each collaborator of a project can simultaneously add lines to the sequencer and edit notes.
Lines contains notes, each note have a position and a length (duration). A line is bound to a sound.
A project is an arrangement of sequencers (or clips).

The Wiki is in french

## Install

* `git clone https://github.com/HE-Arc/cadexmus2.git`
* `cd cadexmus/`
* `composer install`
* create a new database
* open `.env.example`, edit `APP_URL`, `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD`, then **save as** `.env`
* `php artisan key:generate`
* `php artisan migrate:refresh --seed`
* `npm install`
* `npm install --global gulp`
* `gulp`
