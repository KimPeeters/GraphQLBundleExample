<?php

namespace App\Fixtures;

class Titles
{
    static function all() {
        return [
            1 => ['id' => 1, 'name' => '998th Lord Commander of the Night\'s Watch', 'person' => 1],
            2 => ['id' => 2, 'name' => 'Queen of the Andals, the Rhoynar and the First Men', 'person' => 8],
            3 => ['id' => 3, 'name' => 'Protector of the Realm', 'person' => 8],
            4 => ['id' => 4, 'name' => 'Queen of Meereen', 'person' => 8],
            5 => ['id' => 5, 'name' => 'Khaleesi of the Great Grass Sea', 'person' => 8],
            6 => ['id' => 6, 'name' => 'Mother of Dragons', 'person' => 8],
            7 => ['id' => 7, 'name' => 'The Unburnt', 'person' => 8],
            8 => ['id' => 8, 'name' => 'Breaker of Chains', 'person' => 8],
            9 => ['id' => 9, 'name' => 'Lady of Dragonstone', 'person' => 8],
        ];
    }

    static function findByPersons($persons) {
        return array_filter(self::all(), function($t) use ($persons) {
            return in_array($t['person'], $persons);
        });
    }

    static function get($id) {
        return self::all()[$id] ?? null;
    }
}