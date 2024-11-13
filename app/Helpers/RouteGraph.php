<?php

namespace App\Helpers;

use SplStack;

class RouteGraph
{
    private $routes = [
        'program-kelas.index' => ['text' => 'Program Kelas'],
        'program-kelas.create' => ['text' => 'Tambah Program', 'parent' => 'program-kelas.index'],
        'tipe-kelas.index' => ['text' => 'Tipe Kelas'],
        'tipe-kelas.create' => ['text' => 'Tambah Tipe', 'parent' => 'tipe-kelas.index'],
        'level-kelas.index' => ['text' => 'Level Kelas'],
        'level-kelas.create' => ['text' => 'Tambah Level', 'parent' => 'level-kelas.index'],
    ];

    public static function generate(string $routename)
    {
        $route = new RouteGraph();
        return $route->generateGraph($routename);
    }

    private function generateGraph(string $routename)
    {
        $stack = new SplStack();
        $route = $this->routes[$routename];

        while (true) {
            $stack->push(['text' => $route['text'], 'route' => $routename]);
            if (!isset($route['parent'])) {
                break;
            }
            $routename = $route['parent'];
            $route = $this->routes[$routename];
        }

        return $stack;
    }
}