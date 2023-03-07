<?php

namespace JMWD\Testing\Feature\Endpoints\Collections;

abstract class BaseCollection
{
    const DEFAULT_JSON_API_HEADER = 'application/vnd.api+json';

    /**
     * BaseCollection constructor.
     *
     * @param string $resourceType
     * @param string $version
     */
    public function __construct(
        protected string $resourceType,
        protected string $version = 'v1',
    ) {
        //
    }

    /**
     * @param mixed ...$params
     *
     * @return string
     */
    public function url(mixed ...$params): string
    {
        $url = "{$this->getVersion()}/{$this->getResourceType()}";

        if (!empty($params)) {
            $url .= '/' . implode('/', $params);
        }

        return url($url);
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return $this->resourceType;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }
}
