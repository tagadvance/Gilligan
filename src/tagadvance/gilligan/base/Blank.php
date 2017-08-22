<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\traits\Singleton;

/**
 * Class to represent an empty value where null, false, an empty string, 0, etc are valid return values.
 * I wanted to call it `Void`; however, that is a reserved word. =(
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 *        
 */
final class Blank {
    
    use Singleton;

}