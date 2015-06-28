A Simple theme manager that can be used with any php application using PHP 5.5.9 or above. It can also be used with [Laravel 5](http://laravel.com/).

[![Circle CI](https://circleci.com/gh/monkblog/theme-manager.svg?style=svg)](https://circleci.com/gh/monkblog/theme-manager)
[![Code Climate](https://codeclimate.com/github/monkblog/theme-manager/badges/gpa.svg)](https://codeclimate.com/github/monkblog/theme-manager)
[![Test Coverage](https://codeclimate.com/github/monkblog/theme-manager/badges/coverage.svg)](https://codeclimate.com/github/monkblog/theme-manager/coverage)
[![Total Downloads](https://poser.pugx.org/monkblog/theme-manager/d/total.svg)](https://packagist.org/packages/monkblog/theme-manager)
[![Latest Stable Version](https://poser.pugx.org/monkblog/theme-manager/v/stable.svg)](https://packagist.org/packages/monkblog/theme-manager)
[![Latest Unstable Version](https://poser.pugx.org/monkblog/theme-manager/v/unstable.svg)](https://packagist.org/packages/monkblog/theme-manager)
[![License](https://poser.pugx.org/monkblog/theme-manager/license.svg)](https://packagist.org/packages/monkblog/theme-manager)

# Requirements

ThemeManger 1.0.*
 - Use with Laravel requires version 5 or above.
 - PHP 5.5.9 or greater
 
# Installation

Require this package with Composer

```
composer require monkblog/theme-manager 1.0.x
```

# Using with Laravel

Once Composer has installed or updated your packages, you need to register ThemeManager with Laravel. Go into your `config/app.php`, find the `providers` key and add:

```
'ThemeManager\ServiceProvider',
```

You can add the ThemeManager Facade, to have easier access to the ThemeManager globally:

```
'ThemeManager' => 'ThemeManager\Facade\ThemeManager',
```

#### Usages:

```php
ThemeManager::all();
ThemeManager::getAllThemeNames();

ThemeManager::themeExists( 'theme-name' );
ThemeManager::getTheme( 'theme-name' );
```

#### Override the base themes path:

Publish config:

```
php artisan vendor:publish --tag=theme
```
Go to `config/theme-manager.php` and change the `base_path` to the folder you want to use.
```php
<?php

return [
    'base_path' => __DIR__ . '/../path/to/themes-folder',
];
```

If you have a secondary `themes` folder you can add all of the themes to the ThemeManager by using:
```php
ThemeManager::addThemeLocation( __DIR__ . '/path/to/alternative/themes-folder' );
```

# Using with any php application

[example.php](https://github.com/monkblog/theme-manager/blob/master/example.php)

Create the ThemeManager:

```php
//Via new
$themeManager = new \ThemeManager\ThemeManager( \ThemeManager\Starter::start() );

//Optionally pass in initial base path
$themeManager = new \ThemeManager\ThemeManager( \ThemeManager\Starter::start( __DIR__ . '/path/to/themes/' ) );

//Via Helper
$themeManager = theme_manager();

//Optionally pass in initial base path
$themeManager = theme_manager( __DIR__ . '/path/to/themes/' );
```

Using the ThemeManager:

```php
//ThemeCollection
$allThemes = $themeManager->all();

//Returns bool
$myThemeExists = $themeManager->themeExists( 'theme-name' ) ? 'yes' : 'nope';

//Theme Obj or null
$myTheme = $themeManager->getTheme( 'theme-name' );

//Array
$myThemeInfo = $myTheme->getInfo();

//Array of strings
$themeNames = $themeManager->getAllThemeNames();

//First Theme Obj
$firstTheme = $allThemes->first();

//Last Theme Obj
$lastTheme = $allThemes->last();
```

Add a second theme location:

```php
//Add another location of themes to the ThemeManager
$themeManager->addThemeLocation( __DIR__ . '/path/to/alternative/themes-folder' );
```