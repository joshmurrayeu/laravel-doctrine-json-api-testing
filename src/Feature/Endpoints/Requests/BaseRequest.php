<?php

namespace JMWD\Testing\Feature\Endpoints\Requests;

use App\Doctrine\Contracts\Entity;
use JMWD\Testing\Feature\Endpoints\Transport;

class BaseRequest extends Transport
{
    /**
     * Returns a request body to use in a test
     *
     * @param Entity|null $entity
     *
     * @return array
     */
    public function respond(?Entity $entity = null): array
    {
        return array_filter([
            'data' => $this->shouldDisplayData() ? $this->data($entity) : null,
        ]);
    }
}
