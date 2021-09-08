<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User_info_category;
use App\Models\User_info_field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('admin.campos.create',compact('tcampo'));

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
            'shortname' => 'required',
        ]);
        User_info_field::create($request->only(
        'shortname',
        'name',
        'dataype',
        'description',
        'descriptionformat',
        'category_id',
        'require',
        'locked',
        'visible',
        'forceunique',
        'signup',
        'defaultdata',
        'name',
        'defaultdataformat',
        'param1',
        'param2',
        'param3',
        'param4',
        'param5',
        )
    +[
        'sortorder' => User_info_field::all()->where('category_id',$request->input('category_id'))->count()+1
    ]);
        return redirect()->route('admin.categories.index')->with('info','Se creo el campo correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User_info_field  $user_info_field
     * @return \Illuminate\Http\Response
     */
    public function show(User_info_field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User_info_field  $user_info_field
     * @return \Illuminate\Http\Response
     */
    public function edit(User_info_field $field)
    {   
        $tcampo = $field->dataype;
        $categories = User_info_category::pluck('name','id');
        return view('admin.campos.edit',compact('field','tcampo','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User_info_field  $user_info_field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_info_field $field)
    {
        $request->validate([
            'name' => 'required',
            'shortname' => 'required',
        ]);
        
        if($field->category_id == $request->input('category_id')){
            $field->update($request->all());
        }
        else{
            //restauración de la categoria anterior
            $aorder = User_info_field::all()->where('category_id',$field->category_id)->count();
            $alorders = User_info_field::all()->where('category_id',$field->category_id);
            foreach ($alorders as $alorder) {
                if ($field->sortorder < $alorder->sortorder ) {
                $campo = User_info_field::find($alorder->id);
                $campo->sortorder   =  $alorder->sortorder-1;
                $campo->save();
                }
            }
            //traslado de la categoria + ordenamiento
            $setorder = User_info_field::all()->where('category_id',$request->input('category_id'))->count()+1;
            $field->update($request->only(
                'shortname',
                'name',
                'dataype',
                'description',
                'descriptionformat',
                'category_id',
                'require',
                'locked',
                'visible',
                'forceunique',
                'signup',
                'defaultdata',
                'name',
                'defaultdataformat',
                'param1',
                'param2',
                'param3',
                'param4',
                'param5',
                )
            +[
                'sortorder' => $setorder
            ]);
        
        }
        if (($request->input('param3') == null) && ($request->input('dataype') == 'datetime')){
            $field->update(['param3' => null]);
        }
        return redirect()->route('admin.categories.index')->with('info','Se Actualizo el campo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User_info_field  $user_info_field
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_info_field $field)
    {
        $fields = User_info_field::all();
        //esto para eliminar las categorias y ordenar
            foreach ($fields as $key => $fielda) {
                if($fielda->sortorder > $field->sortorder)
                {   
                    $dat = User_info_field::find($fielda->id);
                    $dat->sortorder   = ($fielda->sortorder)-1;
                    $dat->save();
                }
            }
            $field->delete();
            return redirect()->route('admin.categories.index')->with('info','El Campo se elimino con exito');

    }

    public function create2($tcampo,$scategoria)
    {   
        $categories = User_info_category::pluck('name','id');
        return view('admin.campos.create',compact('tcampo','categories','scategoria'));

    }

    public function mover(User_info_field $field,$signo)
    {
        //daclarar atributos
        $datos = User_info_field::all()->where('category_id',$field->category_id);
        //cambio del orden del campo
        if($signo == "+"){$field->sortorder   = $field->sortorder+1;}
        else{$field->sortorder   = $field->sortorder-1;}
        $field->save();

        /*ordenamiento de la informacion*/
        foreach ($datos as $dato) {
            if(($dato->sortorder == $field->sortorder) && ($dato->id != $field->id)){
                $dat = User_info_field::find($dato->id);
                if($signo == "+"){$dat->sortorder   = $field->sortorder-1;}
                else {$dat->sortorder   = $field->sortorder+1;}
                $dat->save();
                break;
            }
        }
        return redirect()->route('admin.categories.index')->with('info','El Campo se movio correctamente');
    }
}
