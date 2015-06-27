<?php

namespace ThemeManager\Exceptions;

use Exception;
use OutOfBoundsException;

class NoThemeName extends OutOfBoundsException {

    public function __construct( $themePath, $subMessage = false, $code = 0, Exception $previous = null ) {
        $message = "Theme {$themePath} " . ( $subMessage ? : "doesn't define 'name'" );
        parent::__construct($message, $code, $previous);
    }

}