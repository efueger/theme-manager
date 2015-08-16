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
     * @param       $path
     * @param array $requiredFields
     * @param bool  $exceptionOnInvalid
     *
     * @return $this
     */
    public function addThemeLocation( $path, Array $requiredFields = [], $exceptionOnInvalid = false  )
    {
        $this->themes = $this->themes()->merge( (new Starter)->start( $path, null, $requiredFields, $exceptionOnInvalid )->all() );

        return $this;
    }

}