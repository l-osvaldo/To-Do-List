<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ToDoListCompleteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toDoList = ToDoList::where([['user_id',Auth::user()->id],['status',2]])->get();
        return Inertia::render('Complete/Index',['toDoList' => $toDoList]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            ToDoList::find($id)->delete();

            return redirect()->back()
                ->with('message', 'Tarea Completada Eliminada Exitosamente.');

        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function deleteAll()
    {
        try {
            ToDoList::where('status',2)->delete();

            return redirect()->back()
                ->with('message', 'Tareas Completadas Eliminadas Exitosamente.');

        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
