<?php

use App\Doctrine\AbstractRepository;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Mockery;
use Mockery\MockInterface;
use JMWD\Testing\TestCase;

abstract class AbstractRepositoryTest extends TestCase
{
    /**
     * @var string $repositoryClass
     */
    protected string $repositoryClass;

    /**
     * @var string $entityClass
     */
    protected string $entityClass;

    /**
     * @var AbstractRepository $repository
     */
    protected AbstractRepository $repository;

    /**
     * @var EntityManager|MockInterface $entityManagerMock
     */
    protected EntityManager|MockInterface $entityManagerMock;

    /**
     * AbstractRepositoryTest set-up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->entityManagerMock = Mockery::mock(EntityManager::class);
        $this->repository = $this->buildRepository();
    }

    /**
     * @return void
     */
    public function testClassMetadataRelatesToEntity(): void
    {
        $className = $this->getRepository()->getClassName();

        $this->assertEquals($this->getEntityClass(), $className);
    }

    /**
     * @return AbstractRepository
     */
    public function buildRepository(): AbstractRepository
    {
        $repository = $this->getRepositoryClass();

        return new $repository($this->entityManagerMock, new ClassMetadata($this->getEntityClass()));
    }

    /**
     * @param EntityManager|MockInterface $entityManager
     *
     * @return void
     */
    public function runEntityManagerQueryExpectations(EntityManager|MockInterface $entityManager): void
    {
        $configurationMock = Mockery::mock(Configuration::class);

        $configurationMock->shouldReceive('getDefaultQueryHints')
            ->once()
            ->withNoArgs()
            ->andReturns([]);

        $configurationMock->shouldReceive('isSecondLevelCacheEnabled')
            ->once()
            ->withNoArgs()
            ->andReturns(false);

        $entityManager->shouldReceive('getConfiguration')
            ->twice()
            ->withNoArgs()
            ->andReturns($configurationMock);
    }

    /**
     * @return string
     */
    public function getRepositoryClass(): string
    {
        return $this->repositoryClass;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * @return AbstractRepository
     */
    public function getRepository(): AbstractRepository
    {
        return $this->repository;
    }

    /**
     * @return EntityManager|MockInterface
     */
    public function getEntityManagerMock(): EntityManager|MockInterface
    {
        return $this->entityManagerMock;
    }
}
