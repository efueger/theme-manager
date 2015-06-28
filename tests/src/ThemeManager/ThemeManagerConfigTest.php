<?php

namespace ThemeManager;

use PHPUnit_Framework_TestCase;


class ThemeManagerConfigTest extends PHPUnit_Framework_TestCase
{


    public function testDefaultValueBasePath()
    {
        $config = include_once(__DIR__.'/../../../src/ThemeManager/config/theme-manager.php');
        $this->assertNull( $config[ 'base_path' ] );
    }

}