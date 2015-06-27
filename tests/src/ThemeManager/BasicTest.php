<?php

namespace ThemeManager;

use PHPUnit_Framework_TestCase;

class BasicTest extends PHPUnit_Framework_TestCase
{

    public function testProviderExists() {
        $this->assertTrue( class_exists( 'ThemeManager\ThemeManagerServiceProvider' ) );
    }

}