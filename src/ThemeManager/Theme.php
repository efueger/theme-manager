<?php

namespace ThemeManager;

use Symfony\Component\Yaml\Yaml;
use ThemeManager\Exceptions\EmptyThemeName;
use ThemeManager\Exceptions\NoThemeName;

class Theme
{

    /**
     * @var array
     */
    private $info;

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var string
     */
    private $ymlFileExtension;

    /**
     * @var string
     */
    private $yml;

    /**
     * @var string
     */
    private $name;

    /**
     * @var null|string
     */
    private $autoload = null;


    /**
     * @param      $path
     * @param bool $yaml
     */
    public function __construct( $path, $yaml = false )
    {
        $this->basePath = $path;
        $this->ymlFileExtension = $yaml ? '.yaml' : '.yml';
        $this->setThemeYmlPath()
            ->setAutoloadPath()
            ->setInfo()
            ->setName();
    }

    /**
     * @return $this
     */
    protected function setThemeYmlPath()
    {
        $this->yml = $this->basePath( 'theme' . $this->ymlExtension() );

        return $this;
    }

    /**
     * @return $this
     */
    protected function setAutoloadPath()
    {
        if( file_exists( $this->basePath( 'vendor/autoload.php' ) ) ) {
            $this->autoload = $this->basePath( 'vendor/autoload.php' );
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function setInfo()
    {
        $this->info = Yaml::parse( $this->yml );

        return $this;
    }

    /**
     * @throws \ThemeManager\Exceptions\NoThemeName When themes name isn't defined or empty
     * @throws \ThemeManager\Exceptions\EmptyThemeName When themes name isn't defined or empty
     *
     * @return $this
     */
    protected function setName()
    {
        $info = $this->getInfo();
        if( is_array( $info ) && array_key_exists( 'name', $info ) ) {
            if( empty( $info[ 'name' ] ) ) {
                throw new EmptyThemeName( $this->getYmlPath() );
            }
            $this->name = $info[ 'name' ];
        }
        else {
            throw new NoThemeName( $this->getYmlPath() );
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getYmlPath()
    {
        return $this->yml ?: '{undefined}';
    }

    /**
     * @return null|string
     */
    public function getAutoloadPath()
    {
        return $this->autoload;
    }

    /**
     * @return $this
     */
    public function registerAutoload()
    {
        if( !is_null( $this->getAutoloadPath() ) ) {
            include_once "{$this->getAutoloadPath()}";
        }

        return $this;
    }

    /**
     * @return string
     */
    public function ymlExtension()
    {
        return $this->ymlFileExtension;
    }

    /**
     * @return array
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return $this
     */
    public function setup()
    {
        $this->registerAutoload();

        return $this;
    }

    /**
     * @param null $path
     *
     * @return string
     */
    public function basePath( $path = null )
    {
        return $this->basePath . ( $path ? DIRECTORY_SEPARATOR . $path : $path );
    }

}