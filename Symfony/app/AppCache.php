<?php

require_once __DIR__.'/AppKernel.php';

use Symfony\Bundle\FrameworkBundle\HttpCache\HttpCache;

class AppCache extends HttpCache
{
    protected function getOptions() {
        return array(
            'debug'                  => true,
            'allow_reload'           => true,
        );
    }
}
