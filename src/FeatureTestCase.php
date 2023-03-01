<?php

namespace JMWD\Testing;

use Doctrine\ORM\EntityManager;

abstract class FeatureTestCase extends TestCase
{
    /**
     * FeatureTestCase set-up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @var EntityManager $entityManager */
        $entityManager = app(EntityManager::class);

        $schemaManager = $entityManager->getConnection()->getSchemaManager();
        $tables = $schemaManager->listTables();

        if (count($tables) > 1) {
            // unlink(env('DB_DATABASE'));
        }

        if (count($tables) === 0) {
            $this->artisan('doctrine:schema:create --no-interaction');
        }
    }
}
