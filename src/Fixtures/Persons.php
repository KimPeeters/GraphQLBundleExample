<?php

namespace App\Fixtures;

class Persons
{
    static function all() {
        return [
            1 => ['id' => 1, 'name' => 'Jon'],
            8 => ['id' => 8, 'name' => 'Daenerys'],
            2 => ['id' => 2, 'name' => 'Arya'],
        ];
    }

    static function search($search) {
        return array_filter(self::all(), function($u) use ($search) {
            return stripos($u['name'], $search) !== false;
        });
    }

    static function get($id) {
        return self::all()[$id] ?? null;
    }
}