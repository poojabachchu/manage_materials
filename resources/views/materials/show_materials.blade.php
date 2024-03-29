@extends('layouts.main')
@section('main-section')
    @if(session()->has('msg'))
        {!! session()->get('msg') !!}
    @endif  

    <div class="container">
        <table class="table table-bordered datatable">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Material Category</th>
                    <th>Material Name</th>
                    <th>Opening Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                    <tr>
                        <td>{{$material->material_id}}</td>
                        <td>{{$material->category_name}}</td>
                        <td>{{$material->material_name}}</td>
                        <td>{{$material->opening_balance}}</td>
                        <td>
                            <a href='/edit_material/{{$material->material_id}}'><i class='fa fa-edit'></i></a>
                            &nbsp;&nbsp;
                            <a href="#" onclick="confirmDelete('{{$material->material_id}}','/delete_material')"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection