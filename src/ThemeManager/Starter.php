<?php

namespace ThemeManager;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use ThemeManager\Exceptions\MissingThemesFolder;
use ThemeManager\Exceptions\NoThemeName;

class Starter
{

    /**
     * @var boolean
     */
    private static $autoload = false;

    /**
     * @var boolean
     */
    private static $exceptionOnInvalid = false;

    /**
     * @var Finder
     */
    private static $finder;

    /**
     * @var array
     */
    private static $themes = [ ];

    /**
     * @var string
     */
    private static $themesFolder;


    /**
     * @param  null    $basePath
     * @param  Finder  $finder
     * @param  boolean $exceptionOnInvalid
     */
    public static function bootstrapAutoload( $basePath = null, Finder $finder = null, $exceptionOnInvalid = false )
    {
        self::$autoload = true;
        $collection = self::start( $basePath, $finder, $exceptionOnInvalid );

        $collection->each( function ( $theme ) {
            if( $theme instanceof Theme ) {
                $theme->registerAutoload();
            }
        } );
    }

    /**
     *
     * @param string|null $basePath
     * @param Finder      $finder
     * @param boolean     $exceptionOnInvalid
     *
     * @return ThemeCollection
     *
     */
    public static function start( $basePath = null, Finder $finder = null, $exceptionOnInvalid = false )
    {
        self::$themes = [];
        self::setThemeFolder( $basePath );
        self::setFinder( $finder );
        self::$exceptionOnInvalid = $exceptionOnInvalid;

        //Look for theme.yml and theme.yaml
        self::find( 'theme.yml' );
        self::find( 'theme.yaml' );

        return new ThemeCollection( self::$themes );
    }

    /**
     * @param null|\Symfony\Component\Finder\Finder $finder
     */
    private static function setFinder( $finder = null )
    {
        self::$finder = $finder ?: new Finder;
    }

    /**
     * @param null|string $basePath
     *
     * @throws \ThemeManager\Exceptions\MissingThemesFolder - When themes folder does not exist
     */
    private static function setThemeFolder( $basePath = null )
    {
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
                if( !empty( $path ) && file_exists( $file ) ) {
                    self::addTheme( $themes, $path, $file );
                }
            }

            self::$themes = array_merge( self::$themes, $themes );
        }
    }

    /**
     * @param $themes
     * @param $path
     * @param $file
     *
     * @throws \ThemeManager\Exceptions\EmptyThemeName - When themes name is empty
     * @throws \ThemeManager\Exceptions\NoThemeName When - themes name isn't defined
     *
     * @return boolean|Theme
     */
    private static function addTheme( &$themes, &$path, &$file )
    {
        try {
            return $themes[ $path ] = new Theme( $path, ( stristr( $file, '.yaml' ) ) );
        }
        catch( NoThemeName $error ) {
            if( self::$exceptionOnInvalid === false && $error->getTheme() ) {
                return $themes[ $path ] = $error->getTheme();
            }

            throw $error;
        }
    }

}