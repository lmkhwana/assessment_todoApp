<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Return all todo's
     *
     */
    public function index()
    {
        $todos = Todo::all();
        return ($todos);
    }


    /**
     * Create a todo
     */
    public function store(Request $request)
    {
        $todo = new Todo();

        if ($request->title) {
            $todo->title = $request->title;
            $todo->completed = $request->completed ? $request->completed : 0;
            $todo->save();
        } else {
            echo ('invalid request');
        }

    }

    /**
     * Return a single todo
     *
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        return($todo);
    }


    /**
     * Update a todo
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
         if ($todo) {
             $todo->title = $request->title;
             $todo->completed = $request->completed;
             $todo->save();
         } else {
             echo "not found";
         }
    }

    /**
     * Remove a todo
     *
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);

        if ($todo) {
            $todo->delete();
        } else {
            echo ('not found');
        }
    }
}
