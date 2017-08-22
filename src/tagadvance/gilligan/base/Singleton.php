<?php

namespace tagadvance\gilligan\base;

trait Singleton {

    static function getInstance() {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }

    private function __construct() {
        
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @return void
     * @see http://www.phptherightway.com/pages/Design-Patterns.html
     */
    private function __clone() {}

}