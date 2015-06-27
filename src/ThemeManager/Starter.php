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
     * @var string
     */
    private static $themesFolder;

    /**
     *
     * @param  string $basePath
     * @param  Finder $finder
     *
     * @throws \ThemeManager\Exceptions\MissingThemesFolder When themes folder does not exist
     *
     * @return \ThemeManager\ThemeCollection
     */
    public static function start( $basePath = null, Finder $finder = null )
    {
        self::$themesFolder = $basePath ?: themes_base_path();

        if( !is_dir( self::$themesFolder ) ) {
            throw new MissingThemesFolder( self::$themesFolder );
        }

        self::$finder = $finder ?: new Finder;

        //Look for theme.yml and theme.yaml
        self::$themes = array_merge( self::$themes, self::find( 'theme.yml' ), self::find( 'theme.yaml' ) );

        return new ThemeCollection( self::$themes );
    }

    /**
     * @param        $file
     * @param string $depth
     *
     * @return array
     */
    private static function find( $file, $depth = '<= 2' )
    {
        $themes = [ ];
        $files = self::$finder->in( self::$themesFolder )->files()->name( $file )->depth( $depth )->followLinks();
        if( !empty( $files ) ) {
            /* @var $file SplFileInfo */
            foreach( $files as $file ) {
                $path = rtrim( $file->getPath(), DIRECTORY_SEPARATOR );
                $themes[ $path ] = new Theme( $path, ( stristr( $file, '.yaml' ) ) );
            }
        }

        return $themes;
    }

}