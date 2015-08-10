<?php

namespace ThemeManager;

use PHPUnit_Framework_TestCase;

class ThemeManagerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \ThemeManager\ThemeManager
     */
    protected $themeManager;

    public function setUp()
    {
        $this->themeManager = new ThemeManager( Starter::start() );
    }

    public function testGetAllThemeNames()
    {
        $this->assertTrue( is_array( $this->themeManager->getAllThemeNames() ) );

        $this->assertTrue( $this->themeManager->all()->count() === 2 );

        $this->assertTrue( $this->themeManager->getInvalidThemesCount() == 1 );
    }

    public function testGetAllThemes()
    {
        $this->assertInstanceOf( 'ThemeManager\ThemeCollection', $this->themeManager->all() );
    }

    public function testThemeExists()
    {
        $this->assertTrue( $this->themeManager->themeExists( 'demo-theme-yml' ) );
    }

    public function testGetTheme()
    {
        $this->assertInstanceOf( 'ThemeManager\Theme', $this->themeManager->getTheme( 'demo-theme-yml' ) );
    }

    public function testAddThemeLocation()
    {
        $path = themes_base_path() . '/../themes-alternative';
        $this->assertInstanceOf( 'ThemeManager\ThemeManager', $this->themeManager->addThemeLocation( $path ) );
        //Make sure it exists
        $this->assertTrue( $this->themeManager->themeExists( 'example-theme' ) );
        $this->assertInstanceOf( 'ThemeManager\Theme', $this->themeManager->getTheme( 'example-theme' ) );
        //There should now be four themes
        $this->assertTrue(  $this->themeManager->all()->count() === 3 );
    }

}