Vedette
=======

## About
User Management Skeleton based on several Laravel packages provided by the laravel community.


## Version
0.8.0

* Fork Steve Montambeault's Cpanel package into Vedette (Keep Steve's authorship but change out PSR naming)
* Redo views to allow a more generic approach to using in main app
* Add in some missing functions that Brunogaspar's package includes
* Use anahkiasen/former for forms


## Requirements
* Bootstrap 3.x
* Font-Awesome 4.x
* jquery-2.x

These are not included since I thought most people will already have included them in their main app.


## Packages
* "illuminate/support": "4.0.x"      // Need to make sure laravel exists
* "cartalyst/sentry": "2.0.*"        // Obvious what this is for
* "anahkiasen/former": "dev-master"  // used for forms
* "illuminate3/lingos": "dev-master" // used for lang files. Lingos is an attempt to centralize commonly used words and phrases.


## Installation

1.)
Add to the app.php providers list
`'Illuminate3\Lingos\LingosServiceProvider',`

1.1)
If you haven't already added these to the providers list in app.php, please add them.
`
'Former\FormerServiceProvider',
'Cartalyst\Sentry\SentryServiceProvider',
`

If you haven't already added these to the aliases in app.php, please add them.
`
'Former' => 'Former\Facades\Former',
'Sentry' => 'Cartalyst\Sentry\Facades\Laravel\Sentry',
`

2.)
Vedette comes with a few handy commands that are available in artisan.
`
vedette
  vedette:install        publish assets and configs, run migration, create primary user (admin)
  vedette:user           Create a new user with superuser role
`
Run "vedette:install" to install to start using vedette.

Edit the config file for former:

3.)
Change
`
'automatic_label'   => true,
'framework'         => 'TwitterBootstrap',
`

To
`
'automatic_label'   => false,
'framework'         => 'TwitterBootstrap3',
`

4.)
Make changes to the vedette configs.

## Usage


## Future
* Take more advantage of validation in the anahikiasen/former package
* Verify the validators that are being used
* A better read to explain how to configure the package better

* Refactor this! My code is horrible! LoLo!


## Projects used to create Vedette
[Stevemo's Cpanel](https://github.com/stevemo/cpanel "Stevemo's Cpanel")

[Brunogaspar's Laravel 4 - Starter Kit](https://github.com/brunogaspar/laravel4-starter-kit "Brunogaspar's Laravel 4 - Starter Kit")

[Rydurham's Cpanel](https://github.com/rydurham/L4withSentry "Rydurham's L4withSentry")


# Notes
Vedette is a fork of Steve Montambeault's Cpanel package.

Also, I may have not properly credited each package due to laziness or just forgot to go back and comment those sections.
Sorry ...

