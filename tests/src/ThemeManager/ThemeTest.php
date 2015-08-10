<?php

namespace ThemeManager;

use PHPUnit_Framework_TestCase;


class ThemeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group theme
     */
    public function testConstruct()
    {
        $themePath = themes_base_path() . '/demo';
        $theme = new Theme( $themePath );

        $this->assertArrayHasKey( 'name', $theme->getInfo() );

        $this->assertEquals( 'demo-theme-yml', $theme->getName() );
        $this->assertEquals( '.yml', $theme->ymlExtension() );

        $this->assertEquals( $themePath, $theme->basePath() );
        $this->assertEquals( $themePath . '/theme.yml', $theme->basePath( 'theme.yml' ) );

        $this->assertEquals( 'demo-theme-yml', $theme->getInfoByKey( 'name' ) );

        $this->assertFalse( $theme->getInfoByKey( 'info' ) );
    }

    /**
     * @test
     * @group theme
     */
    public function testMagicGetter()
    {
        $themePath = themes_base_path() . '/demo';
        $theme = new Theme( $themePath );

        $this->assertEquals( 'Demo Theme Yml', $theme->display_name );
        $this->assertFalse( $theme->false );
    }

    /**
     * @test
     * @group theme
     */
    public function testConstructYamlTrue()
    {
        $theme = new Theme( themes_base_path() . '/demo-yaml', true );

        $this->assertArrayHasKey( 'name', $theme->getInfo() );
    }
    /**
     * @test
     * @group theme
     */
    public function testThemeAutoload()
    {
        $theme = new Theme( themes_base_path() . '/test-autoload' );

        $theme->registerAutoload();

        $this->assertTrue( class_exists( 'ThemeManager\TestAutoload\TestAutoloadServiceProvider' ) );
    }

    /**
     * @test
     * @group theme
     *
     * @expectedException \ThemeManager\Exceptions\NoThemeName
     */
    public function testConstructFail()
    {
        new Theme( themes_base_path() . '/demo', true );
    }

    /**
     * @test
     * @group theme
     *
     * @expectedException \ThemeManager\Exceptions\NoThemeName
     */
    public function testThemeUndefinedName()
    {
        new Theme( themes_base_path() . '/../themes-test/no-name' );
    }

    /**
     * @test
     * @group theme
     *
     * @expectedException \ThemeManager\Exceptions\EmptyThemeName
     */
    public function testThemeEmptyName()
    {
        new Theme( themes_base_path() . '/../themes-test/empty-name' );
    }

}