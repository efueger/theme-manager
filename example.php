<?php

require_once 'vendor/autoload.php';

$basePath = null;
$requiredFields = [ 'display_name', 'version', 'license', ];

//Bootstrapping theme php files if autoload.php file is present
( new \ThemeManager\Starter )->bootstrapAutoload();
//OR via helper
theme_manager_starter()->bootstrapAutoload();

//Via new
$themeManager = new \ThemeManager\ThemeManager( (new \ThemeManager\Starter)->start() );

//Optionally pass in initial base path
$themeManager = new \ThemeManager\ThemeManager( (new \ThemeManager\Starter)->start( __DIR__ . '/path/to/themes/' ) );

//Optional Required Field(s)
$themeManager = new \ThemeManager\ThemeManager( ( new \ThemeManager\Starter )->start( $basePath, $requiredFields ) );

//Via Theme Manager Starter Helper
$themeManager = new \ThemeManager\ThemeManager( theme_manager_starter()->start() );
//OR
$themeManager = new \ThemeManager\ThemeManager( theme_manager_starter()->start( $basePath, $requiredFields ) );

//Via Helper
$themeManager = theme_manager();

//Optionally pass in initial base path
$themeManager = theme_manager( __DIR__ . '/path/to/themes/' );

//Optional Required Field(s)
$themeManager = theme_manager( $basePath, $requiredFields );

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