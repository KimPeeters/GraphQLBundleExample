<?php

namespace App\GraphQL\Loader;

use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter;

abstract class BaseLoader
{
    protected $dataloader;

    abstract public function __construct(WebonyxGraphQLSyncPromiseAdapter $promiseAdapter);

    public function load($key) {
        return $this->dataloader->load($key);
    }

    public function loadMay($keys) {
        return $this->dataloader->loadMany($keys);
    }

    public function clear($key) {
        return $this->dataloader->clear($key);
    }

    public function clearAll() {
        return $this->dataloader->clearAll();
    }

    public function prime($key, $value) {
        $this->dataloader->prime($key, $value);
    }

}