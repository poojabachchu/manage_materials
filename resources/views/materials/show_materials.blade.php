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
                    <?php
                        if(isset($_GET['basic_details'])){
                            echo "<th>Current Balance</th>";
                        }
                    ?>
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
                        <td>{{$material->opening_balance}}</td>
                         <?php
                      
                        if(isset($_GET['basic_details'])){
                            $current_balance = 0;
                            if ($material->quantity >= 0) {
                                // If quantity is positive or zero, perform addition
                                $current_balance = $material->opening_balance + $material->quantity;

                            } else {
                                // If quantity is negative, perform subtraction
                                $current_balance = $material->opening_balance. $material->quantity;
                            }
                            echo "<th>$current_balance</th>";
                        }
                        ?>
                        <td>
                            <?php
                                if($basic_details == 'on'){
                                    echo "<a href='/edit_material/$material->material_id?current_balance=$material->quantity'><i class='fa fa-edit'></i></a>";
                                }else{
                                    echo "<a href='/edit_material/$material->material_id'><i class='fa fa-edit'></i></a>";
                                }
                            ?>
                           
                            &nbsp;&nbsp;
                            <a href="#" onclick="confirmDelete('{{$material->material_id}}','/delete_material')"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection