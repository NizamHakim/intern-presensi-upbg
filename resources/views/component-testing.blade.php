<x-layouts.user-layout>
    <x-slot:title>Testing</x-slot>
<div class="flex flex-row gap-2 w-full flex-wrap">
    <input type="text" class="input-style flex-1 min-w-0">
    <input type="text" class="input-style flex-1 min-w-0">
    <input type="text" class="input-style flex-1 min-w-0">
</div>
    {{-- <div class="grid grid-cols-3 gap-x-2 w-full">
        <input type="text" class="input-style">
        <input type="text" class="input-style">
        <input type="text" class="input-style">
    </div> --}}
</x-layouts.user-layout>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 100vw;
            min-height: 100vh;
        }
        .flex-parent {
            display: flex;
            gap: 1rem;
            min-width: 0;
        }
        .flex-child {
            min-width: 0;
        }
        p{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>
    <div class="flex-parent">
        <div class="flex-child">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit soluta deserunt voluptas praesentium unde? Officiis reiciendis maxime facere commodi, nobis eaque facilis consectetur, quos aliquam mollitia inventore ipsam exercitationem cum in maiores sed velit nam est, quam assumenda aut distinctio obcaecati. Enim cum quidem velit iusto minus odio, adipisci laboriosam?</p>
        </div>
    </div>
</body>
</html> --}}