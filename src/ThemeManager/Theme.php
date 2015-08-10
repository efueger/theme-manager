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
     * @var boolean
     */
    private $error = false;

    /**
     * @var string
     */
    private $errorType = 'Unknown';

    /**
     * @var string
     */
    protected $fileName = 'theme';

    /**
     * @var string
     */
    protected $autoloadPath = 'vendor';


    /**
     * @param         $path
     * @param boolean $yaml
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
        $this->yml = $this->basePath( $this->fileName . $this->ymlExtension() );

        return $this;
    }

    /**
     * @return $this
     */
    protected function setAutoloadPath()
    {
        if( file_exists( $this->basePath( rtrim( $this->autoloadPath, '/' ) . '/autoload.php' ) ) ) {
            $this->autoload = $this->basePath( rtrim( $this->autoloadPath, '/' ) . '/autoload.php' );
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
     * @throws \ThemeManager\Exceptions\NoThemeName When themes name isn't defined
     * @throws \ThemeManager\Exceptions\EmptyThemeName When themes name is empty
     *
     * @return $this
     */
    protected function setName()
    {
        $info = $this->getInfo();
        if( !is_array( $info ) ) {
            $this->setError();
            throw new NoThemeName( $this->getYmlPath(), $this );
        }
        if( is_array( $info ) && array_key_exists( 'name', $info ) ) {
            if( empty( $info[ 'name' ] ) ) {
                $this->setError( 'Empty Theme Name' );
                throw new EmptyThemeName( $this->getYmlPath(), $this );
            }
            $this->name = $info[ 'name' ];
        }

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    protected function setError( $type = 'No Name' )
    {
        $this->error = true;
        $this->errorType = $type;

        return $this;
    }

    /**
     * @return null|string
     */
    protected function getAutoloadPath()
    {
        return $this->autoload;
    }

    /**
     * @return boolean
     */
    public function hasError()
    {
        return $this->error;
    }

    /**
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }

    /**
     * @return string
     */
    public function getYmlPath()
    {
        return $this->yml ?: '{undefined}';
    }

    /**
     * @return $this
     */
    public function registerAutoload()
    {
        if( !is_null( $this->getAutoloadPath() ) ) {
            require_once "{$this->getAutoloadPath()}";
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
     * @param $key
     *
     * @return boolean|mixed
     */
    public function getInfoByKey( $key )
    {
        if( array_has( $this->getInfo(), $key ) ) {
            return array_get( $this->getInfo(), $key );
        }

        return false;
    }

    /**
     * @param $key
     *
     * @return boolean|mixed
     */
    public function __get( $key )
    {
        return $this->getInfoByKey( $key );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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