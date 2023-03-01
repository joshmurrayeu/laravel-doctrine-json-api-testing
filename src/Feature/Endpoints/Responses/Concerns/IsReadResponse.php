<?php

namespace JMWD\Testing\Feature\Endpoints\Responses\Concerns;

trait IsReadResponse
{
    /**
     * @return bool
     */
    public function shouldDisplayLinks(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function shouldDisplayMeta(): bool
    {
        return false;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return 2;
    }
}
