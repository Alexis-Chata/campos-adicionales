@extends('adminlte::page')

@section('title', 'Importar Alumno')

@section('content_header')
    <div class="container">
        <h1 class="mt-3">Importar Alumno</h1>
    </div>
@stop

@section('content')
<main role="main" class="flex-shrink-0">
    <div class="container">
        <p><a class="m-0" target="_blank"
            href="https://docs.google.com/spreadsheets/d/1mGPNLLT2_DpFAlmJgkNzKVNQ_t3VrCKDz9EXgsDNRQ4/edit?usp=sharing">Plantilla
            de Importación</a></p>
        <form action="{{ route('alumnos.import.excel') }}" method="POST" enctype="multipart/form-data" class="col-12 col-md-12">
            @csrf
            @if ($success == 'true')
                <div class="form-group">
                    <p class="alert alert-success col-md-7">{{ $message }}</p>
                </div>
            @elseif ($success=="false")
                <div class="form-group">
                    <p class="alert alert-danger col-md-7">{{ $message }}</p>
                </div>
            @endif
            <div class="form-group pb-3">
                <input type="file" name="file" required class="form-control-file  col-md-7 p-0">
            </div>
            <div class="">
                <button type="submit" class="btn btn-primary">Importar</button>
            </div>
        </form>
    </div>
    <div class="p-3 pt-5">
        <img src="{{asset('/img/formato_importar.png')}}" alt="formato de importacion" class="shadow-lg w-100" data-toggle="modal" data-target="#imagenModal" />
    </div>
    <div class="modal fade"
        id="imagenModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 95%;" role="document">
            <div class="modal-content">
                    <button type="button"
                            class="align-self-end close pr-2 pl-2 pt-1"
                            data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>

                <!--Modal body with image-->
                <div class="modal-body p-0">
                    <img src="{{asset('/img/formato_importar.png')}}" alt="formato de importacion" class="w-100"/>
                </div>

            </div>
        </div>
    </div>
</main>
@endsection
