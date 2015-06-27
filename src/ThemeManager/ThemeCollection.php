<?php

namespace ThemeManager;

use Illuminate\Support\Collection;

class ThemeCollection extends Collection
{

    /**
     * @var array
     */
    private $themeNames = [ ];

    /**
     * Create a new theme collection.
     *
     * @param  mixed $items
     */
    public function __construct( $items = [ ] )
    {
        $this->items = is_array( $items ) ? $items : $this->getArrayableItems( $items );
        /* @var $theme Theme */
        foreach( $this->items as $theme ) {
            if( $theme instanceof Theme ) {
                $this->themeNames[ ] = $theme->getName();
            }
        }
    }

    /**
     * @param $name
     *
     * @return null|Theme
     */
    public function getTheme( $name )
    {
        /* @var $theme Theme */
        foreach( $this->items as $theme ) {
            if( $theme->getName() == $name ) {
                return $theme;
            }
        }

        return null;
    }

    /**
     * @return array
     */
    public function allThemeNames()
    {
        return $this->themeNames;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function themeExists( $name )
    {
        return ( in_array( $name, $this->themeNames ) && !is_null( $this->getTheme( $name ) ) );
    }
}