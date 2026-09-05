<?php

namespace tagadvance\gilligan\io;

/**
 * A resource whose release can fail and therefore has to be reported.
 */
interface Closeable
{
    /**
     * @throws IOException when the underlying resource could not be released
     */
    public function close();

}
