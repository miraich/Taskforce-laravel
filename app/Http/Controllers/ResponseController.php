<?php

namespace App\Http\Controllers;

use App\Enums\StatusesEnum;
use App\Http\Requests\StoreResponseRequest;
use App\Models\Response;
use App\Models\Task;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function to_response(StoreResponseRequest $request, Task $task)
    {
        $response = $request->user()->responses()->create([
            'commentary' => $request->commentary,
            'budget' => $request->budget,
        ]);

        $task->responses()->attach($response);

        return back();
    }
}
