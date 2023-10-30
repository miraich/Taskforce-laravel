<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::whereColumn('created_at', '<', 'expiration_date')
            ->when(isset($request->options['category']), function ($query) use ($request) {
                $query->whereIn('category_id', $request->options['category']);
            })
            ->when(isset($request->options['additional']), function ($query) use ($request) {
                foreach ($request->options['additional'] as $item) {
                    switch ($item) {
                        case 'without-performer':
                            $query->whereNull('executor_id');
                            break;
                        case 'distant':
                            $query->whereNull('city_id');
                    }
                }
            })->when(isset($request->options['time']), function ($query) use ($request) {
                switch ($request->options['time']) {
                    case '3600':
                        $time = 3600;
                        break;
                    case '86400':
                        $time = 86400;
                        break;
                    case '604800':
                        $time = 604800;
                }
                $query->whereRaw("UNIX_TIMESTAMP(tasks.created_at) > UNIX_TIMESTAMP(NOW()) - $time");
            })
            ->orderBy('created_at', 'desc')->paginate(5);

        return view('tasks',
            ['tasks' => $tasks,
                'carbon' => Carbon::now(),          // скорее всего будет неправильным передавать объект carbon в view
                'categories' => Category::all()
            ]);
    }


    public function showStore()
    {
        return view('create-task', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public
    function store(StoreTaskRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public
    function show(Task $task)
    {

        return view('task', [
            'responses' => $task->responses,
            'task' => $task,
            'carbon' => Carbon::now(),
            'exp_date' => Carbon::parse($task->expiration_date, 'GMT')
        ]);
    }
}
