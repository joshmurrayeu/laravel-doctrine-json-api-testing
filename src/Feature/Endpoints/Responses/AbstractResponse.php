<?php

namespace JMWD\Testing\Feature\Endpoints\Responses;

use App\Doctrine\Contracts\Entity;

abstract class AbstractResponse
{
    /**
     * AbstractResponse constructor.
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
     * @return bool
     */
    public function shouldDisplayJsonapi(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function jsonapi(): array
    {
        return [
            'version' => '1.1',
        ];
    }

    /**
     * @return bool
     */
    public function shouldDisplayLinks(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function links(Entity $entity): array
    {
        return [
            'self' => $this->url($entity->getId()),
        ];
    }

    /**
     * @return bool
     */
    public function shouldDisplayMeta(): bool
    {
        return true;
    }

    /**
     * @return int[]
     */
    public function meta(): array
    {
        return [
            'offset' => $this->offset(),
            'limit' => $this->limit(),
            'total' => $this->total(),
        ];
    }

    /**
     * @return int
     */
    public function offset(): int
    {
        return 0;
    }

    /**
     * @return int
     */
    public function limit(): int
    {
        return 20;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return 0;
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
     * @param int|null $id
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
                'id' => (string)$id,
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
