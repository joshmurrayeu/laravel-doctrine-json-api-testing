<?php

namespace JMWD\Testing\Feature\Endpoints\Contracts;

use App\Doctrine\Contracts\Entity;

interface HasRead
{
    /**
     * Returns a `read` response to compare within a test
     *
     * @param Entity $entity
     *
     * @return array
     */
    public function read(Entity $entity): array;
}
