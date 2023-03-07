<?php

namespace JMWD\Testing\Feature\Endpoints\Responses;

use JMWD\Testing\Feature\Endpoints\Responses\Concerns\ErrorResponse;

abstract class BaseErrorResponse extends AbstractResponse implements ErrorResponse
{
    /**
     * Returns an error response to use in a test
     *
     * @return array
     */
    public function respond(): array
    {
        return ['errors' => $this->errors()];
    }

    /**
     * @return array[]
     */
    public function errors(): array
    {
        return [
            [
                'detail' => $this->getErrorDetail(),
                'status' => $this->getErrorStatus(),
                'title' => $this->getErrorTitle(),
            ]
        ];
    }

    /**
     * @return string
     */
    abstract public function getErrorTitle(): string;

    /**
     * @return string
     */
    public function getErrorStatus(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getErrorDetail(): string
    {
        return '';
    }
}
