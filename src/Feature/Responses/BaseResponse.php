<?php

namespace JMWD\Testing\Feature\Endpoints\Responses;

use App\Doctrine\Contracts\Entity;

class BaseResponse extends AbstractResponse
{
    /**
     * Returns a response to use in a test
     *
     * @param Entity|null $entity
     *
     * @return array
     */
    public function respond(?Entity $entity = null): array
    {
        return array_filter([
            'data' => $this->shouldDisplayData() ? $this->data($entity) : null,
            'jsonapi' => $this->shouldDisplayJsonapi() ? $this->jsonapi() : null,
            'links' => $this->shouldDisplayLinks() ? $this->links($entity) : null,
            'meta' => $this->shouldDisplayMeta() ? $this->meta() : null,
        ]);
    }
}
