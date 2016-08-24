<?php

namespace Exfriend\ArtisanMutex;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait PreventRealOverlapping
{

    protected function configureUsingFluentDefinition()
    {
        $def = parent::configureUsingFluentDefinition();

        $this->addOption( 'force', 'f', null, 'Ignore mutex locks' );

        return $def;
    }


    protected function execute( InputInterface $input, OutputInterface $output )
    {

        $this->mutex = new Mutex( $this );

        if ( $this->mutex->exists() && !$this->option( 'force' ) )
        {
            $this->error( 'Process is locked' );
            return false;
        }

        $this->mutex->lock();
        $exec = parent::execute( $input, $output );
        $this->mutex->unlock();

        return $exec;

    }


}
