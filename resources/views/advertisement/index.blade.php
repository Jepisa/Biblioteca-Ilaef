@extends('adminlte::page')

@section('title', 'Panel de Control')

@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1>{{ __('advertisement.index') }} {{ "({$advertisements->total()})" }}</h1>
@stop

@section('content')
    <div class="mb-4 d-flex justify-content-end">
        <a class="btn btn-primary" href="{{ route('advertisement.create') }}">Crear Advertisement</a>
    </div>
    {{ $advertisements->links() }}
    <div class="table-responsive">
        <table class="table table-dark table-hover"> {{--table-responsive  --}}
            <thead>
            <tr>
                <th style="" scope="col">#</th>
                <th style="min-width: 140px" scope="col">Advertisement</th>
                <th style="min-width: 140px" scope="col">Inicio</th>
                <th style="min-width: 140px" scope="col">Vencimento</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach ( $advertisements as $advertisement )
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td class="text-center" style="width: 500px;">
                            <div class="mw-100">
                                <img class="w-100" src="{{ asset("storage/$advertisement->image") }}" alt="{{ 'Banner Biblioteca Empresa Familiar' }}">
                            </div>
                            {{ $advertisement->owner ?? 'OWNER'}}

                        </td>
                        <td>{{ $advertisement->launching }}</td>
                        <td>{{ $advertisement->expiration }}</td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium" style="display: flex; align-content: inherit; flex-direction: column; align-items: center;">
                            <a href="{{ route('advertisement.edit', ['id' => $advertisement->id]) }}"
                                class="text-indigo-600 hover:text-indigo-900"
                                style="min-width: 20px; text-align:center; margin: 5px 0;"><i
                                    class="fas fa-edit text-lg"></i></a>
                            <form class="" style="min-width: 20px; text-align:center; margin: 5px 0;"
                                method="POST" action="{{ route('advertisement.destroy', ['id' => $advertisement->id]) }}">
                                @csrf
                                @method('DELETE')
                                <a type="submit" href="{{ route('advertisement.destroy', ['id' => $advertisement->id]) }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-danger">
                                    <i class="fas fa-trash-alt text-lg"></i>
                                </a>

                            </form>
                        </td>
                    </tr>
                @endforeach
            
            </tbody>
        </table>
    </div>
    {{ $advertisements->links() }}
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Text:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet">
@stop

@section('js')
    {{-- <script>
        Swal.fire(
            'Good job!',
            'You clicked the button!',
            'success'
        )
    </script> --}}
@stop