<?php

namespace App\Controller;

use App\GraphQL\Schema;
use GraphQL\Executor\Promise\Adapter\SyncPromiseAdapter;
use GraphQL\GraphQL;
use Overblog\DataLoader\DataLoader;
use Overblog\PromiseAdapter\Adapter\WebonyxGraphQLSyncPromiseAdapter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GraphQLController
{
    public function graphQL(Request $request)
    {
        $graphQLSyncPromiseAdapter = new SyncPromiseAdapter();
        $promiseAdapter = new WebonyxGraphQLSyncPromiseAdapter($graphQLSyncPromiseAdapter);

        $titleLoader = new DataLoader(function ($keys) use ($promiseAdapter ) {
            $result = array_fill_keys($keys, null);
            $rows = Titles::findByPersons($keys);
            foreach ($rows as $k => $r) {
                $result[$r['person']][] = $r;
            }
            return $promiseAdapter->createAll(array_values($result));
        }, $promiseAdapter);

        GraphQL::setPromiseAdapter($graphQLSyncPromiseAdapter);

        $context = [
            'titleLoader' => $titleLoader,
        ];

        $schema = Schema::get();

        $input = json_decode($request->getContent(), true);

        $query = $input['query'] ?? null;
        $operation = $input['operations'] ?? null;
        $variables = $input['variables'] ?? null;

        $response = GraphQL::executeQuery(
            $schema,
            $query,
            null,
            $context,
            $variables,
            $operation
        )->toArray();

        return new JsonResponse($response);
    }

    public function graphiQL() {
        $content = <<<EOH
<!DOCTYPE html>
<html>
<head>
        <style>
      html, body {
        width: 100%;
        height: 100%;
        margin: 0;
        overflow: hidden;
      }
    </style>
  <link href="https://unpkg.com/graphiql@0.11/graphiql.css" rel="stylesheet">
      <script src="https://unpkg.com/whatwg-fetch@2.0/fetch.js"></script>
    <script src="https://unpkg.com/react@15.6/dist/react.min.js"></script>
    <script src="https://unpkg.com/react-dom@15.6/dist/react-dom.min.js"></script>
    <script src="https://unpkg.com/graphiql@0.11/graphiql.min.js"></script>
    <title>GraphiQL</title>
  </head>
<body>
  Loading...      <script>
      var endpoint = "\/"

        function graphQLFetcher(params) {
                    var headers

                    headers = {
            "Accept": "application/json",
            "Content-Type": "application/json",
          }
          
          return fetch(endpoint, {
              method: "post",
              headers: headers,
              body: JSON.stringify(params),
              credentials: 'include',
            }).then((res) => {
                            return res.text()
            }).then((body) => {
            try {
              return JSON.parse(body)
            } catch (err) {
              return body
            }
          })
                  }

      ReactDOM.render(
        React.createElement(GraphiQL, {
                    fetcher: graphQLFetcher
                  }),
        document.body
      )
    </script>
  </body>
</html>

EOH;
        return new Response($content);
    }
}