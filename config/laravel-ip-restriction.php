<?php

use Illuminate\Http\Response;

return [
    'mode' => \MatejKucera\LaravelIpRestriction\Middleware::ALLOW,

    'ipv4'      => [
        '127.0.0.1'
    ],

    'ipv6'      => [
    ],

    'ipv4subnet'      => [
    ],

    'ipv6subnet'      => [
    ],

    'onDenied' => function() {
        return new Response(
            view('laravel-ip-restriction::restricted')
                ->withMessage('You can access this application only from configured IP Addresses.')
            , 403);
    }
];
