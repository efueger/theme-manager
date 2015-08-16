<?php

namespace ThemeManager;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use ThemeManager\Exceptions\MissingThemesFolder;
use ThemeManager\Exceptions\NoThemeData;
use ThemeManager\Exceptions\NoThemeName;

class Starter
{

    /**
     * @var boolean
     */
    private $autoload = false;

    /**
     * @var boolean
     */
    private $exceptionOnInvalid = false;

    /**
     * @var Finder
     */
    private $finder;

    /**
     * @var array
     */
    private $themes = [ ];

    /**
     * @var string
     */
    private $themesFolder;


    /**
     * @param null    $basePath
     * @param Finder  $finder
     * @param array    $requiredFields
     * @param boolean $exceptionOnInvalid
     */
    public function bootstrapAutoload( $basePath = null, Finder $finder = null, Array $requiredFields = [], $exceptionOnInvalid = false )
    {
        $this->autoload = true;
        $collection = $this->start( $basePath, $finder, $requiredFields, $exceptionOnInvalid );

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
     * @param array       $requiredFields
     * @param boolean     $exceptionOnInvalid
     *
     * @return ThemeCollection
     */
    public function start( $basePath = null, Finder $finder = null, Array $requiredFields = [], $exceptionOnInvalid = false )
    {
        $this->setThemeFolder( $basePath );
        $this->finder = $finder ?: new Finder;
        $this->exceptionOnInvalid = $exceptionOnInvalid;

        //Look for theme.yml and theme.yaml
        $this->find( 'theme.yml', $requiredFields );
        $this->find( 'theme.yaml', $requiredFields );

        return new ThemeCollection( $this->themes );
    }

    /**
     * @param null|string $basePath
     *
     * @throws \ThemeManager\Exceptions\MissingThemesFolder - When themes folder does not exist
     */
    private function setThemeFolder( $basePath = null )
    {
        $this->themesFolder = $basePath ?: themes_base_path();

        if( !is_dir( $this->themesFolder ) ) {
            throw new MissingThemesFolder( $this->themesFolder );
        }
    }

    /**
     * @param        $file
     * @param array  $requiredFields
     *
     * @return array
     */
    private function find( $file, Array $requiredFields = [] )
    {
        $files = $this->finder->in( $this->themesFolder )->files()->name( $file )->depth( '<= 2' )->followLinks();
        if( !empty( $files ) ) {
            $themes = [ ];
            /* @var $file SplFileInfo */
            foreach( $files as $file ) {
                $path = rtrim( $file->getPath(), DIRECTORY_SEPARATOR );
                if( !empty( $path ) && file_exists( $file ) ) {
                    $this->addTheme( $themes, $path, $file, $requiredFields );
                }
            }

            $this->themes = array_merge( $this->themes, $themes );
        }
    }

    /**
     * @param       $themes
     * @param       $path
     * @param       $file
     * @param array $requiredFields
     *
     * @throws \ThemeManager\Exceptions\EmptyThemeName - When themes name is empty
     * @throws \ThemeManager\Exceptions\NoThemeName - When themes name isn't defined
     * @throws \ThemeManager\Exceptions\NoThemeData - When theme.yml is empty
     *
     * @return Theme - When themes name is empty
     */
    private function addTheme( &$themes, &$path, &$file, Array $requiredFields = [] )
    {
        try {
            $isYaml = ( stristr( $file, '.yaml' ) );
            return $themes[ $path ] = new Theme( $path, $requiredFields, $isYaml );
        }
        catch( NoThemeData $error ) {
            if( $this->exceptionOnInvalid === false && $error->getTheme() ) {
                return $themes[ $path ] = $error->getTheme();
            }

            throw $error;
        }
    }

}