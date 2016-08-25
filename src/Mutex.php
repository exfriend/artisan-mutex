<?php

namespace Exfriend\ArtisanMutex;

/**
 * Class Mutex
 * @author yourname
 */
class Mutex
{

    protected $command;

    public function __construct( $command )
    {
        $this->command = $command;

    }

    public function exists()
    {
        return file_exists( $this->filename() );
    }

    public function lock()
    {
        return $this->write( '' );
    }

    public function unlock()
    {
        return unlink( $this->filename() );
    }

    public function read()
    {
        return file_get_contents( $this->filename() );
    }

    public function write( $text )
    {
        return file_put_contents( $this->filename(), $text );
    }

    public function filename()
    {
        return storage_path( 'framework' . DIRECTORY_SEPARATOR . 'artisan-' . sha1( $this->command->getName() ) );
    }

}
