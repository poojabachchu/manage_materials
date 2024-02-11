@extends('layouts.main')
@section('main-section')
<form action="{{$url}}" method="post">
    @csrf
    <h3>{{$title}}</h3>
    
    <!-- if any msg like success or failure are there then print the message  -->
    @if(session()->has('msg'))
        {!! session()->get('msg') !!}
    @endif
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <label for="category">Category Name</label>
                <input type="text" class="form-control" name="category" value="{{$category['category_name'] ?? old('category')}}" id="category"  placeholder="Enter category name" required>
                <input type="hidden" class="form-control" name="category_id" value="{{$category['id']?? ''}}" id="category_id"  required>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <button type="submit" class="btn btn-primary submit_btn">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection
