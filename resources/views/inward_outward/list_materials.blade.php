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
                    <th>Quantity</th>
                    <th>Current Balance</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($materials as $material)
                    <?php
                        $category = App\Models\Category::select('category_name')->where('id','=',$material->category_id)->first();
                        // print_r($category_id);
                        
                    ?>
                    <tr>
                        <td>{{$material->material_id}}</td>
                        <td>{{$category->category_name}}</td>
                        <td>{{$material->material_name}}</td>
                        <td>{{$material->balance}}</td>
                        <td>{{$material->quantity}}</td>
                        <td>{{$material->current_opening_balance}}</td>
                        <td>
                            <a href='/edit_material/{{$material->material_id}}?current_balance={{$material->quantity}}'><i class='fa fa-edit'></i></a>
                            &nbsp;&nbsp;
                            <a href="#" onclick="confirmDelete('{{$material->material_id}}','/delete_material')"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection