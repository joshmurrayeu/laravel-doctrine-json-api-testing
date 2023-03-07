<?php

namespace JMWD\Testing\Feature\Endpoints\Responses\Concerns;

interface ErrorResponse
{
    /**
     * Returns the error as JSON
     *
     * @return string[]|array[]
     */
    public function errors(): array;
}
