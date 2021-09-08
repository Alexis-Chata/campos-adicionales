<?php

namespace App\Http\Controllers\Admin;

use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_info_category;
use App\Models\User_info_field;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function importExcel(Request $request)
    {
        $file = $request->file('file');
        if (isset($file)) {
            try {
                Excel::import(new UsersImport, $file);

                $message = "Importacion de Alumnos Completada";
                $success = "true";

            } catch (Exception $th) {
                $message = "Error en importacion \n";
                //$message += $th->getMessage();
                if(isset($th->errorInfo[2])){
                    $message .= str_replace(["Undefined index", "Duplicate entry", "for key", "alumnos.alumnos_", "_unique"], ["Falta la columna", "Entrada duplicada", "para la clave", "", ""], $th->errorInfo[2]);
                }else{
                    $message .= str_replace(["Undefined index"], ["Falta la columna"], $th->getMessage());
                }
                $success = "false";
            }
        } else {
            $message = "Por favor ingrese un archivo csv, con la informacion requerida";
        }
        return view('import')->with(compact('message', 'success'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = User_info_category::all();
        //return $categories;
        return view('admin.users.create',compact('categories'));
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
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
        //return $request->vcampos;


        $user = User::create($request->only('name','email')
    +[
        'password' => bcrypt($request->input('password'))
    ]);

    for ($i=0; $i <sizeof($request->idcampos) ; $i++) {
        $user->campos()->attach($request->idcampos[$i],['data'=> $request->vcampos[$i],'dataformat'=> 0]);
    }

    return redirect()->route('admin.users.edit',$user)->with('info','El usuario se creo con exito');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $categories = User_info_category::all();
        return view('admin.users.edit',compact('user','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
         $lcampos = User_info_field::all();
         $ncampos = User_info_field::all()->count();
        $request->validate([
            'name' => 'required',
            'email' => "required|unique:users,email,$user->id",
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $user->update($request->only('name','email')
    +[
        'password' => bcrypt($request->input('password'))
    ]);
    /*Agregar ids que falta a la tabla intermedia*/
    if($ncampos != 0 ){
    foreach ($lcampos  as $lcamp) {
        if($user->campos != '[]'){
            foreach ($user->campos as $camp) {
                if($lcamp->id == $camp->pivot->field_id){$existe = true;}
                else {$existe = false;     }
            }
        }
        else{$existe = false;}
        if ($existe == false) {$user->campos()->attach($lcamp->id);}
        }
        /*actulizar datos*/
        for ($i=0; $i <$ncampos ; $i++)
            {
            $user->campos()->updateExistingPivot($request->idcampos[$i],
            ['data'=> $request->vcampos[$i],
            'dataformat'=> 0]);
            }
        }
    /**/
    return redirect()->route('admin.users.edit',$user)->with('info','El usuario se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('info','El usuario se elimino con exito');
    }
}
