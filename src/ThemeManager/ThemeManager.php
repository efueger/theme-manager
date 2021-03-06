<?php

namespace ThemeManager;

class ThemeManager
{

    /**
     * @var \ThemeManager\ThemeCollection
     */
    private $themes;


    /**
     * @param ThemeCollection $themes
     */
    public function __construct( ThemeCollection $themes )
    {
        $this->themes = $themes;
    }

    /**
     * @return array
     */
    public function getAllThemeNames()
    {
        return $this->themes()->allThemeNames();
    }

    /**
     * @return array
     */
    public function getInvalidThemes()
    {
        return $this->themes()->getInvalidThemes();
    }

    /**
     * @return array
     */
    public function getInvalidThemesCount()
    {
        return $this->themes()->invalidCount();
    }

    /**
     * @param $name
     *
     * @return boolean|Theme
     */
    public function getTheme( $name )
    {
        return $this->themes()->getTheme( $name );
    }

    /**
     * @param $name
     *
     * @return boolean
     */
    public function themeExists( $name )
    {
        return $this->themes()->themeExists( $name );
    }

    /**
     * @return \ThemeManager\ThemeCollection
     */
    public function themes()
    {
        return $this->themes;
    }

    /**
     * @return \ThemeManager\ThemeCollection
     */
    public function all()
    {
        return $this->themes();
    }

    /**
     * @return \ThemeManager\Theme
     */
    public function first()
    {
        return $this->all()->first();
    }

    /**
     * @return \ThemeManager\Theme
     */
    public function last()
    {
        return $this->all()->last();
    }

    /**
     * @return int
     */
    public function countAll()
    {
        return $this->all()->count();
    }

    /**
     * @param         $path
     * @param array   $requiredFields
     * @param boolean $exceptionOnInvalid
     *
     * @return $this
     */
    public function addThemeLocation( $path, Array $requiredFields = [], $exceptionOnInvalid = false  )
    {
        $addLocation = ( new Starter( true ) )->start( $path, $requiredFields, $exceptionOnInvalid );

        $all = array_merge( $this->getInvalidThemes(), $addLocation->all(), $addLocation->getInvalidThemes() );

        $this->themes = $this->themes()->merge( $all );

        return $this;
    }

}