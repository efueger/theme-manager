<?php

namespace ThemeManager;


use Illuminate\Support\Collection;

class ThemeManager {

    /**
     * @var Collection
     */
    private $themes;

    /**
     * @var array
     */
    private $themeNames;

    public function __construct( ThemeCollection $themes ) {
        $this->themes = $themes;
        $this->themeNames = $themes->allThemeNames();
    }


}