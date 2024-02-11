@extends('layouts.main')
@section('main-section')

<form action="{{$url}}" method="post">
    @csrf
    <h3>{{$title}}</h3>
    
    @if(session()->has('msg'))
        {!! session()->get('msg') !!}
    @endif

    <?php
        $disabled = '';
        if(!empty($inward_outward)){
            $disabled = 'disabled';
        }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <label for="category">Material Category</label>
                <input type="hidden" name="inward_id" value={{$inward_outward[0]->inward_id ?? ''}}>
                <select class="form-control" name="category" id="category" onchange='getMaterials()' required {{$disabled}}>
                    <option value="">Select</option>
                    @if(!empty($inward_outward)){
                        <option value="$inward_outward[0]->category_id" selected>{{$inward_outward[0]->category_name}}</option>
                    }
                    @endif
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" data-id="{{$category->id}}" {{ old('category') == $category->id ? 'selected' : '' }}>{{$category->category_name}}</option>
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
                <select class="form-control" id="material_name"  name="material_id" value="{{$inward_outward[0]->material_id ?? old('material_id')}}" required {{$disabled}}>
                <option value="">Select</option>
                @if(!empty($inward_outward)){
                    <option value="$inward_outward[0]->material_id" selected>{{$inward_outward[0]->material_name}}</option>
                }
                @endif
                </select>
                <span class="text-danger">
                    @error('material_id')
                        {{$message}}
                    @enderror
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label for="exampleInputPassword1">Date</label>
                <input type="date" class="form-control" id="date" name="date" value="{{$inward_outward[0]->date ?? old('date')}}" required>   
                <span class="text-danger">
                    @error('date')
                        {{$message}}
                    @enderror
                </span>            
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <label for="exampleInputPassword1">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" max="1000" value="{{$inward_outward[0]->quantity ?? old('quantity')}}" step="0.01" name="opening_balance" pattern="[0-9]*[.,]?[0-9]*" required>   
                <span class="text-danger">
                    @error('quantity')
                        {{$message}}
                    @enderror
                </span>            
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <button type="submit" class="btn btn-primary submit_btn">Submit</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function () {
        getMaterials("{{old('material_id')}}");
    });
</script>
@endsection
