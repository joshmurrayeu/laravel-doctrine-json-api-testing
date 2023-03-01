<?php


use App\Doctrine\Contracts\Entity;
use Doctrine\ORM\EntityManager;
use Illuminate\Support\Collection;
use JMWD\Testing\Feature\Endpoints\Collections\BaseCollection;
use JMWD\Testing\Feature\Endpoints\Contracts\HasList;
use JMWD\Testing\Feature\Endpoints\Contracts\HasRead;
use JMWD\Testing\FeatureTestCase;

abstract class EndpointTestCase extends FeatureTestCase
{
    /**
     * @var string $resourceType
     */
    protected string $resourceType;

    /**
     * @var BaseCollection $collection
     */
    protected BaseCollection $collection;

    /**
     * @param int $count
     *
     * @return Entity|Collection
     */
    abstract public function buildEntities(int $count = 1): Entity|Collection;

    /**
     * @return void
     */
    public function testListWithNoEntities(): void
    {
        /** @var BaseCollection|HasList $collection */
        $collection = $this->getCollection();

        $this->get($collection->url())
            ->assertOk()
            ->assertExactJson($collection->empty());
    }

    /**
     * @return void
     */
    public function testListWithEntityInDatabase(): void
    {
        $entity = $this->buildEntities();

        /** @var BaseCollection|HasList $collection */
        $collection = $this->getCollection();

        $this->get($collection->url())
            ->assertOk()
            ->assertExactJson($collection->list($entity));
    }

    /**
     * @return void
     */
    public function testReadWithEntityInDatabase(): void
    {
        /** @var Collection $entities */
        $entities = $this->buildEntities(2);

        /** @var Entity $entity */
        $entity = $entities->first();

        /** @var BaseCollection|HasRead $collection */
        $collection = $this->getCollection();

        $this->get($collection->url($entity->getId()))
            ->assertOk()
            ->assertExactJson($collection->read($entity));
    }

    /**
     * @return string
     */
    public function getResourceType(): string
    {
        return $this->resourceType;
    }

    /**
     * @return BaseCollection
     */
    public function getCollection(): BaseCollection
    {
        return $this->collection;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}
