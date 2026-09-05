<?php

namespace tagadvance\gilligan\io;

interface Closeable
{
    /**
     * @throws IOException
     */
    public function close();

}
