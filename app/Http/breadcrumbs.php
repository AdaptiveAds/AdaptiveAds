<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('dashboard'));
});

// Home > Playlists
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Playlists', route('dashboard/playlist'));
});

// Home > Advert
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Advert', route('dashboard/advert'));
});

// Home > Locations
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Locations', route('dashboard/settings/locations'));
});

// Home > Departments
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Departments', route('dashboard/settings/departments'));
});

// Home > Screens
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Screens', route('dashboard/settings/screens'));
});

// Home > Users
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Users', route('dashboard/settings/users'));
});

// Home > Templates
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Templates', route('dashboard/settings/templates'));
});

// Home > Backgrounds
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Backgrounds', route('dashboard/settings/backgrounds'));
});

// Home > Privileges
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Privileges', route('dashboard/settings/privileges'));
});
