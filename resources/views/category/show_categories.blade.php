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
                    <th>Category Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->category_name}}</td>
                        <td>
                            <a href="/edit_category/{{$category->id}}"><i class="fa fa-edit"></i></a>
                            &nbsp;&nbsp;
                            <a href="#" onclick="confirmDelete('{{$category->id}}','/delete_category')"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection