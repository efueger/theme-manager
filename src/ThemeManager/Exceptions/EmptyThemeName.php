<?php

namespace ThemeManager\Exceptions;

class EmptyThemeName extends NoThemeName
{

    public function __construct( $themePath, $code = 0, \Exception $previous = null )
    {
        parent::__construct( $themePath, "'name' entry is empty", $code, $previous );
    }

}