<?php


if( ! function_exists( 'themes_base_path' ) ) {
    /**
     * @return string|bool
     */
    function themes_base_path() {
        if( is_dir( realpath( __DIR__ . '/../../vendor' ) ) ) {
            return realpath( __DIR__ . '/../../themes' );
        }
        if( is_dir( realpath( __DIR__ . '/../../themes' ) ) ) {
            return realpath( __DIR__ . '/../../themes' );
        }
        if( getenv( 'APP_ENV' ) === 'testing' ) {
            return realpath( __DIR__ . '/tests/themes' );
        }
        return false;
    }
}