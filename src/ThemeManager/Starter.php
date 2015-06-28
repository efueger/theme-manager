<?php

namespace ThemeManager;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use ThemeManager\Exceptions\MissingThemesFolder;

class Starter
{

    /**
     * @var array
     */
    private static $themes = [ ];

    /**
     * @var Finder
     */
    private static $finder;

    /**
     * @var bool
     */
    private static $autoload = false;

    /**
     * @var string
     */
    private static $themesFolder;

    /**
     * @param null   $basePath
     * @param Finder $finder
     */
    public static function bootstrapAutoload( $basePath = null, Finder $finder = null ) {
        self::$autoload = true;
        $collection = self::start( $basePath, $finder );

        $collection->each( function( $theme ) {
            /* @var $theme Theme */
            if( $theme instanceof Theme ) {
                $theme->registerAutoload();
            }
        });
    }

    /**
     *
     * @param  string $basePath
     * @param  Finder $finder
     *
     * @return ThemeCollection When themes folder does not exist
     *
     */
    public static function start( $basePath = null, Finder $finder = null )
    {
        self::setThemeFolder( $basePath );
        self::setFinder( $finder );

        //Look for theme.yml and theme.yaml
        self::find( 'theme.yml' );
        self::find( 'theme.yaml' );

        return new ThemeCollection( self::$themes );
    }

    /**
     * @param null $finder
     */
    private static function setFinder( $finder = null ) {
        self::$finder = $finder ?: new Finder;
    }

    /**
     * @param null $basePath
     */
    private static function setThemeFolder( $basePath = null ) {
        self::$themesFolder = $basePath ?: themes_base_path();

        if( !is_dir( self::$themesFolder ) ) {
            throw new MissingThemesFolder( self::$themesFolder );
        }
    }

    /**
     * @param        $file
     * @param string $depth
     *
     * @return array
     */
    private static function find( $file, $depth = '<= 2' )
    {
        $files = self::$finder->in( self::$themesFolder )->files()->name( $file )->depth( $depth )->followLinks();
        if( !empty( $files ) ) {
            $themes = [ ];
            /* @var $file SplFileInfo */
            foreach( $files as $file ) {
                $path = rtrim( $file->getPath(), DIRECTORY_SEPARATOR );
                $themes[ $path ] = new Theme( $path, ( stristr( $file, '.yaml' ) ) );
            }
            self::$themes = array_merge( self::$themes, $themes );
        }
    }

}