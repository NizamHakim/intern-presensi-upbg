<?php

namespace App\Helpers;

use App\Models\User;
use SplStack;

class RouteGraph
{
    public static function generate(string $routename, string $text = null)
    {
        $route = new RouteGraph();
        return $route->generateGraph($routename, $text);
    }

    private function generateGraph(string $routename, string $text = null)
    {
        $routes = [
            'program-kelas.index' => ['text' => 'Program Kelas'],
            'program-kelas.create' => ['text' => 'Tambah Program', 'parent' => 'program-kelas.index'],
            'tipe-kelas.index' => ['text' => 'Tipe Kelas'],
            'tipe-kelas.create' => ['text' => 'Tambah Tipe', 'parent' => 'tipe-kelas.index'],
            'level-kelas.index' => ['text' => 'Level Kelas'],
            'level-kelas.create' => ['text' => 'Tambah Level', 'parent' => 'level-kelas.index'],
            'user.index' => ['text' => 'User'],
            'user.create' => ['text' => 'Tambah User', 'parent' => 'user.index'],
            'user.detail' => ['text' => $text, 'parent' => 'user.index'],
        ];

        $stack = new SplStack();
        $route = $routes[$routename];

        while (true) {
            $stack->push(['text' => $route['text'], 'route' => $routename]);
            if (!isset($route['parent'])) {
                break;
            }
            $routename = $route['parent'];
            $route = $routes[$routename];
        }

        return $stack;
    }
}