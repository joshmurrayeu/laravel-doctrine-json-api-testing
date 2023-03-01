<?php

namespace JMWD\Testing\Feature\Endpoints\Collections;

abstract class BaseCollection
{
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
     * @param int|null $id
     *
     * @return string
     */
    public function url(?int $id = null): string
    {
        $url = "{$this->getVersion()}/{$this->getResourceType()}";

        if (!empty($id)) {
            $url .= "/{$id}";
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
