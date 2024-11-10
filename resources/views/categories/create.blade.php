@extends('layouts.app')

@section('content')
<div class="card">
    <h2>Add New Category</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="price_per_unit">Price Per Unit (₹)</label>
            <input type="number" step="0.01" name="price_per_unit" id="price_per_unit" value="{{ old('price_per_unit') }}" required>
        </div>

        <button type="submit" class="btn">Add Category</button>
    </form>
</div>
@endsection