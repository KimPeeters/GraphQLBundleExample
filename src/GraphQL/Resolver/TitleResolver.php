<?php
namespace App\GraphQL\Resolver;

use App\Fixtures\Persons;
use App\GraphQL\Loader\TitleLoader;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Psr\Container\ContainerInterface;

class TitleResolver implements ResolverInterface
{
    private $container;

    public function __construct(TitleLoader $loader)
    {
        $this->container = $loader;
    }

    public function findByPerson($id)
    {
        return $this->container->load($id);
    }
}