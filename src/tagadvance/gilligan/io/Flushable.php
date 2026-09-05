<?php

namespace tagadvance\gilligan\io;

/**
 * A sink that buffers, and so has to be told when to hand its bytes on.
 */
interface Flushable
{
    /**
     * @throws IOException when the buffered bytes could not be written out
     */
    public function flush();

}
