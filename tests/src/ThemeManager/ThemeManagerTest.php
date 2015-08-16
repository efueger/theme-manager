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
        $this->themeManager = new ThemeManager( (new Starter)->start() );
    }

    /**
     * @test
     * @group manager
     */
    public function testGetAllThemeNamesIsArray()
    {
        $this->assertTrue( is_array( $this->themeManager->getAllThemeNames() ) );
    }

    /**
     * @test
     * @group manager
     */
    public function testGetAllThemeNamesCountThree()
    {
        $this->assertTrue( $this->themeManager->all()->count() === 3 );
    }

    /**
     * @test
     * @group manager
     */
    public function testGetInvalidThemes()
    {
        $this->assertTrue( $this->themeManager->getInvalidThemesCount() == 1 );
    }

    /**
     * @test
     * @group manager
     */
    public function testGetAllThemes()
    {
        $this->assertInstanceOf( 'ThemeManager\\ThemeCollection', $this->themeManager->all() );
    }

    /**
     * @test
     * @group manager
     */
    public function testThemeExists()
    {
        $this->assertTrue( $this->themeManager->themeExists( 'demo-theme-yml' ) );
    }

    /**
     * @test
     * @group manager
     */
    public function testGetTheme()
    {
        $this->assertInstanceOf( 'ThemeManager\\Theme', $this->themeManager->getTheme( 'demo-theme-yml' ) );
    }

    /**
     * @test
     * @group manager
     */
    public function testAddThemeLocation()
    {
        $path = themes_base_path() . '/../themes-alternative';
        $this->assertInstanceOf( 'ThemeManager\\ThemeManager', $this->themeManager->addThemeLocation( $path ) );
        //Make sure it exists
        $this->assertTrue( $this->themeManager->themeExists( 'example-theme' ) );
        $this->assertInstanceOf( 'ThemeManager\\Theme', $this->themeManager->getTheme( 'example-theme' ) );
        //There should now be four themes
        $this->assertTrue(  $this->themeManager->all()->count() === 4 );
    }

    /**
     * @test
     * @group manager
     */
    public function testAddThemeLocationWithBadData()
    {
        $path = themes_base_path() . '/../themes-test';

        $this->themeManager = new ThemeManager( (new Starter)->start( $path ) );

        $this->assertNotEmpty( $this->themeManager->getInvalidThemes() );

        $this->assertTrue(  $this->themeManager->getInvalidThemesCount() === 2 );
    }

}