<?php
namespace App\GraphQL\Resolver;

use App\Fixtures\Persons;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;

class PersonResolver implements ResolverInterface
{
    public function search($search)
    {
        return Persons::search($search);
    }

    public function all()
    {
        return Persons::all();
    }

    public function get($id)
    {
        return Persons::get($id);
    }

}