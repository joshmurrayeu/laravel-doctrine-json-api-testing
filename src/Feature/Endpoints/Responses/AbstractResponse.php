<?php

namespace JMWD\Testing\Feature\Endpoints\Responses;

use App\Doctrine\Contracts\Entity;
use JMWD\Testing\Feature\Endpoints\Transport;

abstract class AbstractResponse extends Transport
{
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
}
