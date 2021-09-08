<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_info_category;
use App\Models\User_info_field;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = User_info_category::all()->sortBy("sortorder");
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

       User_info_category::create($request->only('name')
    +[
        'sortorder' => User_info_category::all()->count()+1
        //'sortorder' => bcrypt($request->input('sortorder'))
    ]);
    return redirect()->route('admin.categories.index')->with('info','La categoria se creo correctamente');;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User_info_category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User_info_category $category)
    {
        return view('admin.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_info_category $category)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('info','La categoria se actualizo correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_info_category $category)
    {
        $ncategoria = User_info_category::all()->count();
        $categorias = User_info_category::all();
        $campos = $category->campos;
        //trasladar los campos de la categoria a otra categoria
        for ($i = 0; $i < $ncategoria; $i++)
        {
        if($categorias[$i]->id != $category->id){
        $torden = User_info_category::find($categorias[$i]->id)->campos->count();
            foreach ($campos as $camp)
            {   $torden = $torden +1;
                $acampos= User_info_field::find($camp->id);
                $acampos->category_id = $categorias[$i]->id;
                $acampos->sortorder = $torden;
                $acampos->save();
            }
            $i = $ncategoria;
        }
        }
        //esto para eliminar las categorias y ordenar
        for ($i = 0; $i < $ncategoria; $i++) 
        {
            if($categorias[$i]->sortorder > $category->sortorder)
                {   
                    $dat = User_info_category::find($categorias[$i]->id);
                    $dat->sortorder   = ($categorias[$i]->sortorder)-1;
                    $dat->save();
                }
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('info','La Categoria se elimino con exito');

    }
    /*funcion mover*/
    public function mover(User_info_category $category,$signo)
    {
        //daclarar atributos
        $numerofilas = User_info_category::all()->count();
        $datos = User_info_category::all();
        //cambio del orden de la categoria
        if($signo == "+"){$category->sortorder   = $category->sortorder+1;}
        else{$category->sortorder   = $category->sortorder-1;}
        $category->save();

        /*ordenamiento de la informacion*/
        for ($i = 0; $i < $numerofilas; $i++) {
        if(($datos[$i]->sortorder == $category->sortorder) && ($datos[$i]->id != $category->id)){
            $dat = User_info_category::find($datos[$i]->id);
            if($signo == "+"){$dat->sortorder   = $category->sortorder-1;}
            else {$dat->sortorder   = $category->sortorder+1;}
            $dat->save();
            break;
        }
        }

        return redirect()->route('admin.categories.index')->with('info','La categoria se movio correctamente');
    } 
}
