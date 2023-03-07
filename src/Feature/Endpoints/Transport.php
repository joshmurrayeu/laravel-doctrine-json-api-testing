<?php

namespace JMWD\Testing\Feature\Endpoints;

use App\Doctrine\Contracts\Entity;

abstract class Transport
{
    /**
     * Transport constructor.
     *
     * @param string $resourceType
     * @param string $version
     */
    public function __construct(
        protected string $resourceType,
        protected string $version = 'v1'
    ) {
        //
    }

    /**
     * @return bool
     */
    public function shouldDisplayData(): bool
    {
        return true;
    }

    /**
     * @param Entity $entity
     *
     * @return string[]|array[]
     */
    public function data(Entity $entity): array
    {
        return [];
    }

    /**
     * @param Entity|null $entity
     *
     * @return array
     */
    public function dataLinks(?Entity $entity = null): array
    {
        return [
            'self' => $this->url($entity?->getId() ?: null),
        ];
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
     * @param string|null $resourceType
     * @param int|null    $id
     *
     * @return array[]
     */
    public function relationship(?string $resourceType = null, ?int $id = null): array
    {
        if (empty($resourceType) && empty($id)) {
            return [
                'data' => [],
            ];
        }

        return [
            'data' => [
                'type' => $resourceType,
                'id' => (string) $id,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function emptyRelationship(): array
    {
        return $this->relationship();
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
