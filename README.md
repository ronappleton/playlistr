# Playlistr

Playlistr is a personalised playlist management system, incorporating categories and multiple playlists, along with IP whitelisting and blacklisting to keep your playlists private.

[![Build Status](https://travis-ci.org/ronappleton/playlistr.svg?branch=master)](https://travis-ci.org/ronappleton/playlistr)

## Installation

To install simple run `composer install ronappleton\playlistr`

Then `composer install`

Copy the `.env.example` file to `.env` using `cp .env.example .env`

Run `php artisan key:generate`

Open `.env` and configure with your database details

Run `php artisan migrate`

Now run `npm install`

Once all the above is done, it's time to create your admin user

Run `php artisan admin:create` and enter the required details

The system is now ready for use, navigate to the webpage and proceed to login.
