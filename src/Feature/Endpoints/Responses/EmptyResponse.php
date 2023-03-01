<?php

namespace JMWD\Testing\Feature\Endpoints\Responses;

class EmptyResponse extends AbstractResponse
{
    /**
     * Returns an empty response to use in a test
     *
     * @return array
     */
    public function respond(): array
    {
        return [
            'data' => [],
            'jsonapi' => [
                'version' => '1.1',
            ],
            'links' => [
                'self' => $this->url(),
            ],
            'meta' => [
                'offset' => 0,
                'limit' => 20,
                'total' => 0,
            ],
        ];
    }
}
