{{-- resources/views/catalogos/vuelosModificar.blade.php --}}
@extends("components.layout")

@section("content")
    @component("components.breadcrumbs", ["breadcrumbs" => $breadcrumbs])
    @endcomponent

    <div class="container">
        <div class="card mt-4 mb-4 p-3">
            <div class="row">
                <div class="form-group my-3">
                    <h1>MODIFICAR VUELO NÚMERO: {{ $vuelo->IDVuelo }}</h1>
                </div>
            </div>
        </div>
    </div>
    
@endsection
