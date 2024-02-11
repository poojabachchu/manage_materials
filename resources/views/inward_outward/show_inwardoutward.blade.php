@extends('layouts.main')
@section('main-section')
    @if(session()->has('msg'))
        {!! session()->get('msg') !!}
    @endif  
    <div class="container">
        <table class="table table-bordered datatable">
            <thead>
                <th>Id</th>
                <th>Material Category</th>
                <th>Material Name</th>
                <th>Date</th>
                <th>Quantity</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($inwardoutwards as $inward_outward)
                    <tr>
                        <td>{{$inward_outward->inward_id}}</td>
                        <td>{{$inward_outward->category_name}}</td>
                        <td>{{$inward_outward->material_name}}</td>
                        <td>{{$inward_outward->date}}</td>
                        <td>{{$inward_outward->quantity}}</td>
                        <td>
                            <a href="/edit_inwardoutward/{{$inward_outward->inward_id}}"><i class="fa fa-edit"></i></a>
                            &nbsp;&nbsp;
                            <a href="#" onclick="confirmDelete('{{$inward_outward->inward_id}}','/delete_inwardoutward')"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection