A simple theme manager that can be used with [Laravel 5](http://laravel.com/).

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

#### Note:
This package assumes that you have a `themes` folder (this can be overwritten via `Starter::start(__DIR__.'/path')`, read more below) at the root of your project containing all your theme folders. 
Each theme will need a `theme.yml` or `theme.yaml` with at least a `name` entry defined in the folder.

(e.g. `themes/my-theme/theme.yml`)
```yaml
name: my-theme
```

##### Structure Example
- app/
- public/
- themes/
  - my-theme
    - theme.yml
  - my-other-theme
    - theme.yml
- vendor/

# Bootstrapping Theme Classes
Bootstrapping theme Service Provider(s) or other important classes before the application run:

*For Laravel users: this code snippet is probably best placed at the bottom of `bootstrap/autoload.php` (after `require $compiledPath;`)*

```php
\ThemeManager\Starter::bootstrapAutoload();
```

You can also optionally pass in a path to your themes folder if it's different than the default:
```php
\ThemeManager\Starter::bootstrapAutoload( '/path/to/theme-folder' );
```

# Error Handling
This package requires that a `theme` file have at least a `name` field defined. As of version 1.1 it will handle and separate the invalid themes from the valid ones.

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
$theme = ThemeManager::getTheme( 'theme-name' );
$themeName = $theme->getName();
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

#### Adding more Themes folder to Manager
If you have a secondary `themes` folder you can add all of the themes to the ThemeManager by using:

```php
ThemeManager::addThemeLocation( __DIR__ . '/path/to/alternative/themes-folder' );
```

# Using with any php application

[example.php](https://github.com/monkblog/theme-manager/blob/master/example.php)

#### Create the ThemeManager:

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

#### Using the ThemeManager:

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

#### Add a second theme location:

```php
//Add another location of themes to the ThemeManager
$themeManager->addThemeLocation( __DIR__ . '/path/to/alternative/themes-folder' );
```

### License

This package is open-sourced software licensed under the MIT license.