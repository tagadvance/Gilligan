<?php

namespace tagadvance\gilligan\traits;

trait Singleton {
    
    static function getInstance(): self {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }
    
    private function __construct() {}
    
    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     * @see http://www.phptherightway.com/pages/Design-Patterns.html
     */
    private function __clone() {}
    
}