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
        $this->themeManager = new ThemeManager( ( new Starter )->start() );
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
        $this->assertEquals( 3,  $this->themeManager->countAll() );
    }

    /**
     * @test
     * @group manager
     */
    public function testGetInvalidThemes()
    {
        $this->assertEquals( 1,  $this->themeManager->getInvalidThemesCount() );
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
    public function testGetLocationTypePrimary()
    {
        $this->assertEquals( 'Primary', $this->themeManager->first()->getLocationType() );
        $this->assertEquals( 'Primary', $this->themeManager->last()->getLocationType() );
    }

    /**
     * @test
     * @group manager
     */
    public function testAddThemeLocation()
    {
        //Path that has one theme
        $path = themes_base_path() . '/../themes-alternative';
        //returns $this
        $this->assertInstanceOf( 'ThemeManager\\ThemeManager', $this->themeManager->addThemeLocation( $path ) );
        //Make sure it exists
        $this->assertTrue( $this->themeManager->themeExists( 'example-theme' ) );
        $this->assertInstanceOf( 'ThemeManager\\Theme', $this->themeManager->getTheme( 'example-theme' ) );
        //example-theme is a Secondary Theme
        $this->assertEquals( 'Secondary', $this->themeManager->getTheme( 'example-theme' )->getLocationType() );
        //There should now be four themes
        $this->assertEquals( 4,  $this->themeManager->countAll() );
    }

    /**
     * @test
     * @group manager
     */
    public function testAddThemeLocationWithBadData()
    {
        $this->assertEquals( 1,  $this->themeManager->getInvalidThemesCount() );

        $addPath = themes_base_path() . '/../themes-test';

        $this->themeManager->addThemeLocation( $addPath );

        $this->assertNotEmpty( $this->themeManager->getInvalidThemes() );

        $this->assertEquals( 3,  $this->themeManager->getInvalidThemesCount() );
    }

}