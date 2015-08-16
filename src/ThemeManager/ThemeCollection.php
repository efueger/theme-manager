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
     * @var array
     */
    protected $invalidThemes = [];

    /**
     * Create a new theme collection.
     *
     * @param mixed $items
     */
    public function __construct( $items = [ ] )
    {
        $this->separateInvalidItems( $items );
        parent::__construct( $items );

        /* @var $theme Theme */
        foreach( $this->items as $theme ) {
            if( $theme instanceof Theme ) {
                $this->themeNames[] = $theme->getName();
            }
        }
    }

    /**
     * @param $items
     *
     * @return $this
     */
    public function separateInvalidItems( &$items )
    {
        foreach( $items as $key => $theme ) {
            if( $theme instanceof Theme && $theme->hasError() ) {
                $this->invalidThemes[] = $theme;
                unset( $items[ $key ] );
            }
        }
        array_values( array_filter( $items ) );

        return $this;
    }

    /**
     * @return int
     */
    public function invalidCount()
    {
        return count( $this->invalidThemes );
    }

    /**
     * @return array
     */
    public function getInvalidThemes()
    {
        return $this->invalidThemes;
    }

    /**
     * @return int
     */
    public function validCount()
    {
        return $this->count();
    }

    /**
     * @return array
     */
    public function getValidThemes()
    {
        return $this->all();
    }

    /**
     * @param $name
     *
     * @return boolean|Theme
     */
    public function getTheme( $name )
    {
        /* @var $theme Theme */
        foreach( $this->items as $theme ) {
            if( $theme instanceof Theme && $theme->getName() == $name ) {
                return $theme;
            }
        }

        return false;
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
     * @return boolean
     */
    public function themeExists( $name )
    {
        return ( in_array( $name, $this->themeNames ) && !is_null( $this->getTheme( $name ) ) );
    }
}