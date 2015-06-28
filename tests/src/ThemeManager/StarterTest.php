<?php

namespace ThemeManager;

use PHPUnit_Framework_TestCase;


class StarterTest extends PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        putenv( "APP_ENV=testing" );
    }

    public function testBootstrapAutoload()
    {
        Starter::bootstrapAutoload();

        $this->assertTrue( class_exists( 'ThemeManager\TestAutoload\TestAutoloadServiceProvider' ) );
    }

    public function testStart()
    {
        $themeCollection = Starter::start();

        $this->assertInstanceOf( 'ThemeManager\\ThemeCollection', $themeCollection );
    }

    /**
     * @expectedException \ThemeManager\Exceptions\MissingThemesFolder
     */
    public function testStartFail()
    {
        Starter::start( 'fake/src/testing' );
    }

    /**
     * @expectedException \ThemeManager\Exceptions\MissingThemesFolder
     */
    public function testStartFailNonTestingEnv()
    {
        putenv( "APP_ENV=local" );

        Starter::start();
    }

}