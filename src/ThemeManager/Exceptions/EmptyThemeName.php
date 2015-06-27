<?php

namespace ThemeManager\Exceptions;

use Exception;
use OutOfBoundsException;
use ThemeManager\Theme;


class EmptyThemeName extends OutOfBoundsException {

    public function __construct( Theme $theme, $code = 0, Exception $previous = null ) {
        $message = "Theme {$theme->getYmlPath()} 'name' entry is empty";
        parent::__construct($message, $code, $previous);
    }

}