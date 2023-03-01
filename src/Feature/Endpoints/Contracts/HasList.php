<?php

namespace JMWD\Testing\Feature\Endpoints\Contracts;

use App\Doctrine\Contracts\Entity;

interface HasList
{
    /**
     * @return array
     */
    public function empty(): array;

    /**
     * @param Entity $entity
     *
     * @return array
     */
    public function list(Entity $entity): array;
}
