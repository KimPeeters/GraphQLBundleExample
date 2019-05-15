<?php

namespace App\GraphQL\Loader;

use App\Fixtures\Titles;
use Overblog\DataLoader\DataLoader;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter;

class TitleLoader extends BaseLoader
{
    public function __construct(WebonyxGraphQLSyncPromiseAdapter $promiseAdapter)
    {
        $this->dataloader = new DataLoader(
            function($keys) use ($promiseAdapter) {
                $result = array_fill_keys($keys, null);
                $rows = Titles::findByPersons($keys);
                foreach ($rows as $k => $r) {
                    $result[$r['person']][] = $r;
                }
                return $promiseAdapter->createAll(array_values($result));
            },
            $promiseAdapter
        );
    }
}