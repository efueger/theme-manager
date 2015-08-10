<?php

namespace ThemeManager\Exceptions;

use Exception;
use OutOfBoundsException;
use ThemeManager\Theme;

class NoThemeName extends OutOfBoundsException
{
    /**
     * @var boolean|Theme
     */
    protected $theme = false;


    /**
     * @param string         $themePath
     * @param bool           $subMessage
     * @param Theme|null     $theme
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct( $themePath, Theme $theme = null, $subMessage = false, $code = 0, Exception $previous = null )
    {
        $message = "Theme {$themePath} " . ( $subMessage ?: "doesn't define 'name'" );

        if( !is_null( $theme ) ) {
            $this->theme = $theme;
        }

        parent::__construct( $message, $code, $previous );
    }

    /**
     * @return boolean|Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

}