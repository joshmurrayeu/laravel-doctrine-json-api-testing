<?php

namespace JMWD\Testing\Feature\Endpoints\Responses\Concerns;

use App\Doctrine\Contracts\Entity;
use App\Doctrine\Entities\Category;
use JMWD\Testing\Feature\Endpoints\Responses\Category\ReadResponse;

trait IsListResponse
{
    /**
     * @return bool
     */
    public function shouldDisplayLinks(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function shouldDisplayMeta(): bool
    {
        return true;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return 1;
    }
}
