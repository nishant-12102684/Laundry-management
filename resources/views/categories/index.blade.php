@extends('layouts.app')

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h2>Categories</h2>
        <a href="{{ route('categories.create') }}" class="btn">Add New Category</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price Per Unit</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>₹{{ number_format($category->price_per_unit, 2) }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn" style="background: #28a745;">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection