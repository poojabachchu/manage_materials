@extends('layouts.main')
@section('main-section')
<form action="{{$url}}" method="post">
    @csrf
    <h3>{{$title}}</h3>
    
    @if(session()->has('msg'))
        {!! session()->get('msg') !!}
    @endif

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <label for="category">Category Name</label>
                <select class="form-control" name="category" id="category"  required>
                    <option value="">Select</option>
                    @foreach($categories as $category)
                        <!-- If the old category is present then select by that value and if the db value of category is fetched then select by that value -->
                        <option value="{{$category->id}}" {{ old('category') == $category->id || (isset($material[0]['category_id']) && $material[0]['category_id'] == $category->id) ? 'selected' : '' }}>{{$category->category_name}}</option>
                    @endforeach
                </select>
                <span class="text-danger">
                    @error('category')
                        {{$message}}
                    @enderror
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label for="exampleInputPassword1">Material Name</label>
                <input type="text" class="form-control" id="material_name" value="{{$material[0]['material_name'] ?? old('material_name')}}" placeholder="Material Name" name="material_name" required>
                <input type="hidden" class="form-control" id="material_id" placeholder="Material Id" name="material_id" value="{{$material[0]['material_id'] ?? ''}}" required>
                <span class="text-danger">
                    @error('material_name')
                        {{$message}}
                    @enderror
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label for="exampleInputPassword1">Opening Balance</label>
                <input type="number" class="form-control" id="opening_balance" placeholder="Opening Balance" min="0" max="1000" step="0.01" name="opening_balance" pattern="[0-9]*[.,]?[0-9]*" value="{{$material[0]['opening_balance'] ?? old('opening_balance') }}" required>   
                <span class="text-danger">
                    @error('opening_balance')
                        {{$message}}
                    @enderror
                </span>            
            </div>
        </div>

        <?php
        // If we get the current balance in the url then only show this field 
        if(isset($_GET['current_balance'])){
            $current_balance = $_GET['current_balance'];
        ?>
        <div class="row">
            <div class="col-lg-4">
                <label for="exampleInputPassword1">Current Balance</label>
                <input type="text" class="form-control" id="current_balance" name ="current_balance" placeholder="Current Balance" value="{{$current_balance}}" required readonly>   
                <span class="text-danger">
                    @error('current_balance')
                        {{$message}}
                    @enderror
                </span>            
            </div>
        </div>
        <?php
        }
        ?>
        <div class="row">
            <div class="col-lg-4">
                <button type="submit" class="btn btn-primary submit_btn">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection