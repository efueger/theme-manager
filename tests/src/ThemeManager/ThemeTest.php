<?php

namespace ThemeManager;

use PHPUnit_Framework_TestCase;


class ThemeTest extends PHPUnit_Framework_TestCase
{

    public function testConstruct()
    {
        $themePath = themes_base_path() . '/demo';
        $theme = new Theme( $themePath );

        $this->assertArrayHasKey( 'name', $theme->getInfo() );
        $this->assertEquals( 'demo-theme-yml', $theme->getName() );
        $this->assertEquals( '.yml', $theme->ymlExtension() );
        $this->assertEquals( $themePath, $theme->basePath() );
        $this->assertEquals( $themePath . '/theme.yml', $theme->basePath( 'theme.yml' ) );
    }

    public function testConstructYamlTrue()
    {
        $theme = new Theme( themes_base_path() . '/demo-yaml', true );

        $this->assertArrayHasKey( 'name', $theme->getInfo() );
    }

    public function testThemeAutoload()
    {
        $theme = new Theme( themes_base_path() . '/test-autoload' );

        $this->assertEquals( themes_base_path() . '/test-autoload/vendor/autoload.php', $theme->getAutoloadPath() );

        $theme->setup();

        $this->assertTrue( class_exists( 'ThemeManager\TestAutoload\TestAutoloadServiceProvider' ) );
    }

    /**
     * @expectedException \ThemeManager\Exceptions\NoThemeName
     */
    public function testConstructFail()
    {
        new Theme( themes_base_path() . '/demo', true );
    }

    /**
     * @expectedException \ThemeManager\Exceptions\NoThemeName
     */
    public function testThemeUndefinedName()
    {
        new Theme( themes_base_path() . '/../themes-test/no-name' );
    }

    /**
     * @expectedException \ThemeManager\Exceptions\EmptyThemeName
     */
    public function testThemeEmptyName()
    {
        new Theme( themes_base_path() . '/../themes-test/empty-name' );
    }

}