<?php

use ThemeManager\ThemeManagerServiceProvider;

class BasicTest extends PHPUnit_Framework_TestCase
{

    public function testProviderExists() {
        $this->assertTrue( class_exists( 'ThemeManager\ThemeManagerServiceProvider' ) );
    }

}