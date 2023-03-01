<?php

namespace JMWD\Testing\Feature\Endpoints\Contracts;

interface ListEmptyEndpoint
{
    /**
     * @param ...$args
     *
     * @return array
     */
    public function list(...$args): array;
}
