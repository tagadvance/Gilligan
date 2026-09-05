<?php

namespace tagadvance\gilligan\io;

interface Flushable
{
    /**
     * @throw IOException
     */
    public function flush();

}
