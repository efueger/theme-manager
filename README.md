A Simple theme manager that can be used with any php application using PHP 5.5.9 or above. It can also be used with [Laravel 5](http://laravel.com/).

[![Circle CI](https://circleci.com/gh/monkblog/theme-manager.svg?style=svg)](https://circleci.com/gh/monkblog/theme-manager) [![Code Climate](https://codeclimate.com/github/monkblog/theme-manager/badges/gpa.svg)](https://codeclimate.com/github/monkblog/theme-manager) [![Test Coverage](https://codeclimate.com/github/monkblog/theme-manager/badges/coverage.svg)](https://codeclimate.com/github/monkblog/theme-manager/coverage)

# Requirements

ThemeManger 1.0.*
 - Use with Laravel requires version 5 or above.
 - PHP 5.5.9 or greater
 
# Installation

Require this package with Composer

```
composer require monkblog/theme-manager 1.0.x
```

# Using Laravel

Once Composer has installed or updated your packages, you need to register ThemeManager with Laravel. Go into your `config/app.php`, find the `providers` key and add:

```
'ThemeManager\ServiceProvider',
```

You can add the ThemeManager Facade, to have easier access to the ThemeManager globally:

```
'ThemeManager' => 'ThemeManager\Facade\ThemeManager',
```

```php
ThemeManager::all();
ThemeManager::getAllThemeNames();

ThemeManager::themeExists( 'theme-name' );
ThemeManager::getTheme( 'theme-name' );
```

If you have a secondary `themes` folder you add it to the ThemeManager:
```php
ThemeManager::addThemeLocation( __DIR__ . '/path/to/alternative/themes-folder' );
```

# Using with any php application

```php
//Via Helper
$themeManager = theme_manager();

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

//Add another location of themes to the ThemeManager
$themeManager->addThemeLocation( __DIR__ . '/path/to/alternative/themes-folder' );
```