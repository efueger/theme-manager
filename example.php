<?php
//Via new
$themeManager = new \ThemeManager\ThemeManager( \ThemeManager\Starter::start() );

//Optionally pass initial base path in
$themeManager = new \ThemeManager\ThemeManager( \ThemeManager\Starter::start( __DIR__ . '/path/to/themes/' ) );

//Via Helper
$themeManager = theme_manager();

//Optionally pass initial base path in
$themeManager = theme_manager( __DIR__ . '/path/to/themes/' );

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