<?php

namespace ThemeManager;

use PHPUnit_Framework_TestCase;


class StarterTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        putenv( "APP_ENV=testing" );
    }

    /**
     * @test
     * @group starter
     */
    public function testBootstrapAutoload()
    {
        Starter::bootstrapAutoload();

        $this->assertTrue( class_exists( 'ThemeManager\TestAutoload\TestAutoloadServiceProvider' ) );
    }

    /**
     * @test
     * @group starter
     */
    public function testStart()
    {
        $themeCollection = Starter::start();

        $this->assertInstanceOf( 'ThemeManager\\ThemeCollection', $themeCollection );
    }

    /**
     * @test
     * @group starter
     */
    public function testStartWithInvalidThemes()
    {
        $path = themes_base_path() . '/../themes-test';

        $themeCollection = Starter::start( $path );

        $this->assertInstanceOf( 'ThemeManager\\ThemeCollection', $themeCollection );

        $this->assertNotEmpty( $themeCollection->getInvalidThemes() );

        $this->assertEmpty( $themeCollection->all() );

        $this->assertTrue( $themeCollection->invalidCount() == 2 );

        $this->assertTrue( $themeCollection->validCount() == 0 );
    }

    /**
     * @test
     * @group starter
     *
     * @expectedException \ThemeManager\Exceptions\NoThemeName
     */
    public function testStartExceptionHandler()
    {
        Starter::start( null, null, true );
    }

    /**
     * @test
     * @group starter
     *
     * @expectedException \ThemeManager\Exceptions\EmptyThemeName
     */
    public function testStartExceptionHandlerEmptyName()
    {
        $path = themes_base_path() . '/../themes-test';

        Starter::start( $path, null, true );
    }

    /**
     * @test
     * @group starter
     *
     * @expectedException \ThemeManager\Exceptions\MissingThemesFolder
     */
    public function testStartFail()
    {
        Starter::start( 'fake/src/testing' );
    }

    /**
     * @test
     * @group starter
     *
     * @expectedException \ThemeManager\Exceptions\MissingThemesFolder
     */
    public function testStartFailNonTestingEnv()
    {
        putenv( "APP_ENV=local" );

        Starter::start();
    }

}