<?php

namespace App\Http\Controllers;

use App\Enums\StatusesEnum;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use YaGeo;

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
            })->when(!isset($request->options['time']), function ($query) use ($request) {
                $query->whereRaw("UNIX_TIMESTAMP(tasks.created_at) > UNIX_TIMESTAMP(NOW()) - 604800");
            })
            ->orderBy('created_at', 'desc')->paginate(5);

        return view('tasks',
            ['tasks' => $tasks,
                'carbon' => Carbon::now(),          // скорее всего будет неправильным передавать объект carbon в view
                'categories' => Category::all(),

            ]);
    }

    public function showStore()
    {
        return view('create-task', ['categories' => Category::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreTaskRequest $request)
    {
        $names = [];
        global $long, $lat, $city, $city_id;
        if (isset($request->address)) {
            $data = YaGeo::setQuery($request->address)->load();
            $lat = $data->getResponse()->getLatitude();
            $long = $data->getResponse()->getLongitude();
            $city = $data->getResponse()->getLocality();
            $city_id = City::where(['name' => $city])->first()->id;
        }

        if ($files = $request->file('files')) {
            foreach ($files as $file) {
                $contents = file_get_contents($file);
                $filename = $file->getClientOriginalName();
                $path = "tasks_files/$filename";
                Storage::disk('public')->put($path, $contents);
                $names[] = $filename;
            }
        }

        $task = Task::create([
            'title' => $request->title,
            'client_id' => Auth::user()->id,
            'status_id' => StatusesEnum::STATUS_NEW->value,
            'category_id' => $request->category,
            'description' => $request->description,
            'category' => $request->category,
            'address' => $request->address,
            'lat' => $lat,
            'long' => $long,
            'expiration_date' => $request->deadline,
            'city_id' => $city_id,
            'budget' => $request->budget,
            'deadline' => $request->deadline,
        ]);

        if (!empty($names)) {
            foreach ($names as $name) {
                $task->files()->create([
                    'file_path' => $name,
                ]);
            }
        }

        return redirect(route('task.show', $task->id));
    }

    /**
     * Display the specified resource.
     */
    public
    function show(Task $task)
    {
        return view('task', [
            'task' => $task,
            'carbon' => Carbon::now(),
            'exp_date' => Carbon::parse($task->expiration_date, 'GMT')
        ]);
    }

    public function get_file($file_name)
    {
        return Storage::download("tasks_files/$file_name");
    }
}
