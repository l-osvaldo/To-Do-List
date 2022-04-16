<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\ToDoList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ToDoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->path() === "pending") {
            $toDoList = ToDoList::where([['user_id',Auth::user()->id],['status',1]])->get();
            return Inertia::render('ToDoList/Index',['data' => $toDoList, 'type' => true]);
        }else {
            $toDoList = ToDoList::where([['user_id',Auth::user()->id],['status',2]])->get();
            return Inertia::render('ToDoList/Index',['data' => $toDoList, 'type' => false]);
        }

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
        try {
            Validator::make($request->all(), [
                'titulo'        => ['required'],
                'descripcion'   => ['required'],
            ])->validate();

            $newToDoList = new ToDoList();
            $newToDoList->user_id       = Auth::user()->id;
            $newToDoList->titulo        = $request->titulo;
            $newToDoList->descripcion   = $request->descripcion;
            $newToDoList->save();

            return redirect()->back()
                ->with('message', 'Tarea Creada Exitosamente.');

        } catch (\Throwable $th) {
            dd($th);
        }
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
        try {
            Validator::make($request->all(), [
                'titulo'        => ['required'],
                'descripcion'   => ['required'],
            ])->validate();

            $updateToDoList = ToDoList::find($id);
            $updateToDoList->titulo        = $request->titulo;
            $updateToDoList->descripcion   = $request->descripcion;
            $updateToDoList->save();

            return redirect()->back()
                ->with('message', 'Tarea Actualizada Exitosamente.');

        } catch (\Throwable $th) {
            dd($th);
        }
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
                ->with('message', 'Tarea Pendiente Eliminada Exitosamente.');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function complete(Request $request)
    {
        try {
            $id = $request->id;
            $statusCompleteToDoList = ToDoList::find($id);
            $statusCompleteToDoList->status = 2;
            $statusCompleteToDoList->save();
    
            return redirect()->back()
                    ->with('message', 'Tarea Completada Exitosamente.');
            
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
