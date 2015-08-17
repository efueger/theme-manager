A simple theme manager that can be used with [Laravel 5](http://laravel.com/).

[![Circle CI](https://circleci.com/gh/monkblog/theme-manager.svg?style=svg)](https://circleci.com/gh/monkblog/theme-manager)
[![Code Climate](https://codeclimate.com/github/monkblog/theme-manager/badges/gpa.svg)](https://codeclimate.com/github/monkblog/theme-manager)
[![Test Coverage](https://codeclimate.com/github/monkblog/theme-manager/badges/coverage.svg)](https://codeclimate.com/github/monkblog/theme-manager/coverage)
[![Total Downloads](https://poser.pugx.org/monkblog/theme-manager/d/total.svg)](https://packagist.org/packages/monkblog/theme-manager)
[![Latest Stable Version](https://poser.pugx.org/monkblog/theme-manager/v/stable.svg)](https://packagist.org/packages/monkblog/theme-manager)
[![Latest Unstable Version](https://poser.pugx.org/monkblog/theme-manager/v/unstable.svg)](https://packagist.org/packages/monkblog/theme-manager)
[![License](https://poser.pugx.org/monkblog/theme-manager/license.svg)](https://packagist.org/packages/monkblog/theme-manager)

# Requirements
 - Use with Laravel requires version 5 or above.
 - PHP 5.5.9 or greater
 
# Installation

Require this package with Composer

```
composer require monkblog/theme-manager 1.1.*
```

#### Note:
This package assumes that you have a `themes` folder at the root of your project containing all your theme folders. 

*The 'base path' can be overwritten via `config/theme-manager.php` or the `start( __DIR__ . '/folder/' )` method on the `\ThemeManager\Starter` class* 

e.g.
```yaml
# themes/my-theme/theme.yml
name: my-theme
```

# Requiring Theme Meta Data Field(s)
This package requires that a `theme.yml`/`theme.yaml` file have at least a `name` field defined.

As of version 1.1 you can define a list of required fields that need to be defined in each `theme.yml` file. 
This package will handle and separate the invalid themes from the valid ones.

Go to `config/theme-manager.php` and change the `required_fields` to the array of required field to be enforced.
(see **Publish Config** below if config is not in your config folder).

# Error Handling
As of version 1.1 there's a `boolean $exceptionOnInvalid` which by default is `false`. To have the package throw exceptions
for invalid themes change `exception_on_invalid` in `config/theme-manager.php` to be `true` or pass `true` as the `$exceptionOnInvalid` 
argument on the `start` method of `\ThemeManager\Starter` class.

# Folder Structure Example
- app/
- public/
- themes/
  - my-theme/
    - theme.yml
  - my-theme-with-autoload/
    - composer.json
    - helpers.php
    - src/
      - MyThemeNamespace/
        - MyClass.php
        - MyThemeServiceProvider.php
    - theme.yml
    - vendor/
  - my-other-theme/
    - theme.yml
- vendor/

# Examples

[example.php](https://github.com/monkblog/theme-manager/blob/master/example.php)

# Bootstrapping Theme Classes
Bootstrapping theme Service Provider(s) or other important classes before the application runs:

*For Laravel users: this code snippet is probably best placed at the bottom of `bootstrap/autoload.php` (after `require $compiledPath;`)*

```php
( new \ThemeManager\Starter )->bootstrapAutoload();
```

You can also optionally pass in a path to your themes folder if it's different than the default:
```php
( new \ThemeManager\Starter )->bootstrapAutoload( '/path/to/theme-folder' );
```

#### Injecting into Starter Class
If you're not using the Laravel Service Provider, you can pass an array to the  `\ThemeManager\Starter` `start()` method:

```php
$basePath = null;
$requiredFields = [ 'display_name', 'version', 'license', ];

$starter = ( new \ThemeManager\Starter )->start( $basePath, $requiredFields );

$themeManager = new \ThemeManager\ThemeManager( $starter );
```

You may also use the helper function as a shortcut:

```php
$themeManager = theme_manager( null, [ 'display_name', 'version', 'license', ] );
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

#### Publish Config
Run:

```
php artisan vendor:publish --tag=theme
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
(See **Publish Config** section above if `theme-manager.php` isn't present)

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

### License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).