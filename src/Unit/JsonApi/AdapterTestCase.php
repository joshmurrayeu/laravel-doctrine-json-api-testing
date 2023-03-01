<?php

namespace JMWD\Testing\Unit\JsonApi;

use JMWD\JsonApi\Database\Adapter;

abstract class AdapterTestCase extends JsonApiTestCase
{
    /**
     * @return void
     */
    public function testAdapterForReturnsEntityClass(): void
    {
        $this->assertEquals($this->getEntityClass(), $this->buildAdapter()->adapterFor());
    }

    /**
     * @return string
     */
    protected function getAdapterName(): string
    {
        return key($this->resolveJsonApiUtilities());
    }

    /**
     * @return Adapter
     */
    protected function buildAdapter(): Adapter
    {
        return app($this->getAdapterName());
    }
}
