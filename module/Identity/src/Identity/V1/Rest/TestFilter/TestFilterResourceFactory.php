<?php
namespace Identity\V1\Rest\TestFilter;

class TestFilterResourceFactory
{
    public function __invoke($services)
    {
        return new TestFilterResource();
    }
}
