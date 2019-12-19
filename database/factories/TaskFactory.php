<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Task::class, function (Faker $faker) {
    static $i = 1;
    return [
        'title'       => 'Задача ' . $j = $i++,
        'date'        => Carbon::now()->addHour($j),
        'author'      => $j,
        'status'      => 'Cтатус ' . $j,
        'description' => 'Описание ' . $j,
    ];
});
