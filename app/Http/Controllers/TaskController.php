<?php

namespace App\Http\Controllers;

use App\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class TaskController extends Controller
{

    /**
     * @var int
     */
    public $paginate;

    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        if (empty(Task::all())) {
            Artisan::call('migrate:fresh --seed');
        }
        $this->paginate = 10;
    }

    /**
     * Таблица с задачами
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tasks = self::getTasks(false, true);
        return view('home', compact('tasks'));
    }

    /**
     * Возвращает список задач
     *
     * @param bool $cache
     * @return Collection
     */
    public function getTasks($cache = true, $paginate = false)
    {
        if ($paginate) {
            return Task::paginate($this->paginate);
        }

        if ($cache) {
            $tasks = Cache::remember('users', 60, function () {
                return $this->jsonResponse(Task::all()->makeHidden(['author', 'status', 'description']));
            });
            return $tasks;
        }
        return self::updatedTasks();
    }

    /**
     * Возвращает обновленные задачи
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatedTasks()
    {
        $tasks = Task::all();
        $i = 1;
        foreach ($tasks as $task) {
            $task->date = Carbon::now()->addHour($i);
            $task->update();
            $i++;
        }
        return $this->jsonResponse($tasks->makeHidden(['author', 'status', 'description']));
    }

    /**
     * @param int $id
     * @return Task
     */
    public function getTask(int $id)
    {
        return $this->jsonResponse(Task::where('id', $id)->first());
    }

    /**
     *  Поиск задачи по title
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $tasks = Task::query()
            ->where('title', 'LIKE', "%{$request->title}%")
            ->paginate(10);
        return view('home', [
            'tasks' => $tasks->appends(Input::except('page')),
        ]);
    }
}
