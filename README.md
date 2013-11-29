Vedette
=======

> vedette |viˈdet|(also vidette )
> noun
> historical, a mounted sentry positioned beyond an army's outposts to observe the movements of the enemy.


Using Sentry2 as the core of this package, I couldn't help from coming up with a name related to "sentry".


## About
User Management Skeleton based on several Laravel packages provided by the laravel community.


## Version
0.9.0

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
Add to composer.json in the require statement:

```
"require": {
    "illuminate3/vedette": "dev-master",
    ...
},
```

2.)
Add to the app.php providers list

```
'Illuminate3\Lingos\LingosServiceProvider',
```


2.1)
If you haven't already added these to the providers list in app.php, please add them.

```
'Former\FormerServiceProvider',
'Cartalyst\Sentry\SentryServiceProvider',
```


3.)
Vedette comes with a few handy commands that are available in artisan.

```
vedette
  vedette:install        publish assets and configs, run migration, create primary user (admin)
  vedette:user           Create a new user with superuser role
```

Run "vedette:install" to install to start using vedette.

Edit the config file for former:

4.)
Change

```
'automatic_label'   => true,
'framework'         => 'TwitterBootstrap',
```

To

```
'automatic_label'   => false,
'framework'         => 'TwitterBootstrap3',
```

5.)
You can use the included layout or you can point to your own.
To point to you own change:

```
'layout' => 'vedette::layouts',
```

To the location that points to your own layout. for example:

```
'layout' => 'frontend/layouts/default',
```

6.)
If you change to a different layout there are several points that you should be aware of.
I strongly suggest looking at the included default layout as a template or at least a reference
to make sure you have all the necessary sections.

6.1)
Menu area

This is the main code that creates the menu.

```
<ul class="nav navbar-nav navbar-right">
	@if (Sentry::check())
	<li class="dropdown{{ (Request::is('auth*') ? ' active' : '') }}">
		<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="{{ route('vedette.home') }}" data-hover="dropdown">
			<i class="fa fa-user"></i>
			{{ Sentry::getUser()->first_name }}
			<b class="caret"></b>
		</a>
		<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
			@if(Sentry::getUser()->hasAccess('admin'))
				<li><a href="{{ route('vedette.users') }}"><i class="fa fa-wrench"></i>{{ trans('lingos::general.users') }}</a></li>
				<li><a href="{{ route('vedette.groups') }}"><i class="fa fa-wrench"></i>{{ trans('lingos::sentry.groups') }}</a></li>
				<li><a href="{{ route('vedette.permissions') }}"><i class="fa fa-wrench"></i>{{ trans('lingos::sentry.permissions') }}</a></li>
				<li><a href="{{ route('vedette.admin') }}"><i class="fa fa-gear"></i>{{ trans('lingos::general.administration') }}</a></li>
			@endif
			<li class="divider"></li>
			<li><a href="{{ route('vedette.logout') }}"><i class="fa fa-power-off"></i>{{ trans('lingos::auth.log_out') }}</a></li>
		</ul>
	</li>
	@else
		<li {{ (Request::is('auth/login') ? 'class="active"' : '') }}><a href="{{ route('vedette.login') }}">{{ trans('lingos::auth.sign_in') }}</a></li>
		<li {{ (Request::is('auth/register') ? 'class="active"' : '') }}><a href="{{ route('vedette.register') }}">{{ trans('lingos::auth.sign_up') }}</a></li>
	@endif
</ul>
```

6.2)
section includes

> @section('css')
>
> @section('js')
>
> @section('page_title')
>
> @section('title')
>
> @section('content')

"title" is used for H 1 like headers.
"page_title" is used for the title of the page, as in what you'd see in the browser title area.

7.)
I tried to keep the html to a minimum without too much fancy CSS styling. However, 1 CSS part should be noted.

```
.fa,
.fa > a,
.fa > li {
  margin-right: 5px;
}
```

I didn't like add a space in the html so I just forced a margin-right with CSS.

8.)
Javascript

> restfulizer.js
>
> twitter-bootstrap-hover-dropdown.js

restufilizer.js is used to create a browser pop-up for when deleting data. I'm still sold on this but I
wanted a way to interfere with users accidently deleting a user.

twitter-bootstrap-hover-dropdown.js is straight up Bling. It adds a hover function for drop down buttons. Fall back
is to the normal Bootstrap functionality. You probably wouldn't even notice it working or not ;)


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

[MrJuliuss's Syntara](https://github.com/MrJuliuss/syntara "MrJuliuss's Syntara")


## Notes
Vedette is a fork of Steve Montambeault's Cpanel package.

Also, I may have not properly credited each package due to laziness or just forgot to go back and comment those sections.
Sorry ...

