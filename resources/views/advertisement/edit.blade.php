@extends('adminlte::page')

@section('title', 'Panel de Control')

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ __('advertisement.edit') }}</h1>
@stop

@section('content')
    @if ($errors->any())
        <div id="alert" class="alert alert-danger">
            <span id="close" class="hover-text-black-50" style="position: absolute; right: 30px; cursor: pointer;">X</span>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
        
    <div class="mb-4 d-flex justify-content-end">
        <a class="btn btn-primary" href="{{ route('advertisements.index') }}">Volver a Index</a>
    </div>

    <div class="col-9 mx-auto py-3">

        <form action="{{ route('advertisement.update', ['id' => $advertisement->id]) }}" method="POST" enctype="multipart/form-data" >
            @csrf
            @method('PUT')
            <!-- 2 column grid layout with text inputs for the first and last names -->
            <div class="mw-100 mb-4">
                <img class="w-100" src="{{ asset("storage/$advertisement->image") }}" alt="{{ 'Banner Biblioteca Empresa Familiar' }}">
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="form-outline">
                    <input name="name" type="text" id="form6Example1" class="form-control" 
                    value="{{ old('name') ?? $advertisement->name }}"
                    />
                    <label class="form-label" for="form6Example1">{{ __('advertisement.create.name') }}</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <input name="owner" type="text" id="form6Example2" class="form-control" 
                        value="{{ old('owner') ?? $advertisement->owner }}"/>
                        <label class="form-label" for="form6Example2">{{ __('advertisement.create.owner') }}</label>
                    </div>
                </div>
            </div>
        
            <!-- Image input -->
            <div class="form-outline mb-4">
                <label class="form-label d-block" for="customFile">{{ __('advertisement.create.image') }}</label>
                <button id="file" type="button" class="btn btn-primary">Carga una nueva imagen para cambiar el actual.</button><span id="nameOfFile"></span>
                <input name="image" type="file" class="d-none" id="customFile" />
            </div>
        
            <!-- URL input -->
            <div class="form-outline mb-4">
                <input name="url" type="text" id="form6Example4" class="form-control" 
                value="{{ old('url') ?? $advertisement->url }}"/>
                <label class="form-label" for="form6Example4">{{ __('advertisement.create.url') }}</label>
            </div>
            
            <div class="row mb-4 d-flex justify-content-around w-100">
                <!-- Launching input -->
                <div class="mb-4">
                    <input name="launching" type="date" id="form6Example5" class="form-control" 
                    value="{{ old('launching') ?? $advertisement->launching }}"/>
                    <label class="form-label" for="form6Example5">{{ __('advertisement.create.lauching') }}</label>
                </div>
            
                <!-- Expiration input -->
                <div class="mb-4">
                    <input name="expiration" type="date" id="form6Example6" class="form-control" 
                    value="{{ old('expiration') ?? $advertisement->expiration }}"/>
                    <label class="form-label" for="form6Example6">{{ __('advertisement.create.expiration') }}</label>
                </div>
            </div>
        
            <!-- Information input -->
            <div class="form-outline mb-4">
                <textarea name="information" class="form-control" id="form6Example7" rows="4">{{ old('owner') ?? $advertisement->owner }}</textarea>
                <label class="form-label" for="form6Example7">Additional information</label>
            </div>
        
            <!-- Checkbox -->
            <div class="form-check d-flex justify-content-center mb-4">
                <input
                    class="form-check-input me-2 position-relative"
                    type="checkbox"
                    value="true"
                    name="status"
                    id="form6Example8"
                    {{-- {{ !$errors->any() ? 'checked' : ( old('status') == 'true' ? 'checked' : '' )}} --}}
                />
                <label class="form-check-label" for="form6Example8"> Publicar ahora? </label>
            </div>
        
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">Place order</button>
        </form>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('css/layout-app.css') }}"> --}}
@stop

@section('js')
    <script>
        // Swal.fire(
        //     'Good job!',
        //     'You clicked the button!',
        //     'success'
        // )
        
        $('#close').click(function (e) { 
            // this.parentElement
            $('#alert').slideUp();
            // this.parentElement.remove();
        });

        let f = $('#file');

        f.click(function () {
            $('#customFile').click();
        });
        $('#customFile').change(function (e) { 
            document.getElementById('nameOfFile').innerText = this.value.replace("C:\\fakepath\\", "");
            console.log('cambió');
            if (this.value.replace("C:\\fakepath\\", "") != "") {
                f.addClass('btn-success');
                document.getElementById('file').innerText = 'Cargado!';
            }else{
                f.removeClass('btn-success');
                document.getElementById('file').innerText = 'Carga una nueva imagen para cambiar el actual.';
            }
        });

    </script>

@stop