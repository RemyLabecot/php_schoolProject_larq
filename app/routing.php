<?php
/**
 * This file hold all routes definitions.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 * @link     https://github.com/WildCodeSchool/simple-mvc
 */

$routes = [
    'Homepage' => [
        ['home', '/', 'GET'],
    ],
    'ShowTravel' => [
        ['show', '/showTravel/{id:\d+}', 'GET'],
    ],
    'Item' => [ // Controller
        ['index', '/items', 'GET'], // action, url, method
        ['add', '/item/add', ['GET', 'POST']],
        ['edit', '/item/edit/{id:\d+}', ['GET', 'POST']],
        ['show', '/item/{id:\d+}', 'GET'],
        ['delete', '/item/delete/{id:\d+}', 'GET'],
    ],

    'ContactForm' => [
        ['contactForm', '/contact', ['GET', 'POST']],
    ],

    'Log' => [
        ['login', '/login', ['GET', 'POST']],
        ['logout', '/logout', 'GET'],
    ],];
if (isset($_SESSION['login'])) {

    $routes_secure = [
        'Travel' => [
            ['index', '/admin', 'GET'],
            ['index', '/admin/travels', 'GET'],
            ['edit', '/admin/travel/edit/{id:\d+}', ['GET', 'POST']],
            ['add', '/admin/travel/add', ['GET', 'POST']],
            ['show', '/admin/travel/{id:\d+}', 'GET'],
            ['delete', '/admin/travel/delete/{id:\d+}', 'GET'],
        ],
        'Country' => [ // Controller
            ['index', '/admin/countries', 'GET'],
            ['add', '/admin/country/add', ['GET', 'POST']],
            ['edit', '/admin/country/edit/{id:\d+}', ['GET', 'POST']],
            ['show', '/admin/country/{id:\d+}', 'GET'],
            ['delete', '/admin/country/delete/{id:\d+}', 'GET'],
        ],
        'Agency' => [ // Controller
            ['index', '/admin/agencies', 'GET'],
            ['add', '/admin/agency/add', ['GET', 'POST']],
            ['edit', '/admin/agency/edit/{id:\d+}', ['GET', 'POST']],
            ['show', '/admin/agency/{id:\d+}', 'GET'],
            ['delete', '/admin/agency/delete/{id:\d+}', 'GET'],
        ],

        'Theme' => [ // Controller
            ['index', '/admin/themes', 'GET'],
            ['add', '/admin/theme/add', ['GET', 'POST']],
            ['edit', '/admin/theme/edit/{id:\d+}', ['GET', 'POST']],
            ['show', '/admin/theme/{id:\d+}', 'GET'],
            ['delete', '/admin/theme/delete/{id:\d+}', 'GET'],
        ],
        'Deal' => [
            ['index', '/admin/deals', 'GET'],
            ['add', '/admin/deal/add', ['GET', 'POST']],
            ['edit', '/admin/deal/edit/{id:\d+}', ['GET', 'POST']],
            ['show', '/admin/deal/{id:\d+}', 'GET'],
            ['delete', '/admin/deal/delete/{id:\d+}', 'GET'],
            ['associate', '/admin/deal/associate', ['GET', 'POST']],
        ],
    ];
    $routes = array_merge($routes, $routes_secure);
}

