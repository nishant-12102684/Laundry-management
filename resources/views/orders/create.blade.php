@extends('layouts.app')

@section('content')
<div class="card">
    <h2>New Order</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <h3>Customer Details</h3>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" id="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
        </div>

        <h3>Order Details</h3>
        <div id="order-items">
            <div class="order-item">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id[]" class="form-control category-select" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-price="{{ $category->price_per_unit }}">
                                {{ $category->name }} - ₹{{ number_format($category->price_per_unit, 2) }}/unit
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity[]" class="quantity-input" min="1" required>
                </div>

                <button type="button" class="btn btn-danger remove-item">Remove</button>
            </div>
        </div>

        <button type="button" id="add-item" class="btn btn-primary">Add Another Category</button>

        <div class="form-group">
            <label>Total Amount</label>
            <div id="total_amount">₹0.00</div>
        </div>

        <button type="submit" class="btn">Create Order</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addItemButton = document.getElementById('add-item');
        const orderItems = document.getElementById('order-items');
        const totalAmount = document.getElementById('total_amount');

        addItemButton.addEventListener('click', addOrderItem);
        orderItems.addEventListener('change', calculateTotal);
        orderItems.addEventListener('input', calculateTotal);

        function addOrderItem() {
            const orderItem = document.querySelector('.order-item').cloneNode(true);
            orderItem.querySelector('.quantity-input').value = '';
            orderItem.querySelector('.remove-item').addEventListener('click', removeOrderItem);
            orderItems.appendChild(orderItem);
            calculateTotal();
        }

        function removeOrderItem(event) {
            event.target.closest('.order-item').remove();
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.order-item').forEach(function(item) {
                const category = item.querySelector('.category-select');
                const quantity = item.querySelector('.quantity-input').value;
                const price = category.options[category.selectedIndex].dataset.price;
                if (price && quantity) {
                    total += price * quantity;
                }
            });
            totalAmount.textContent = '₹' + total.toFixed(2);
        }

        // Initialize with one remove button event
        document.querySelector('.remove-item').addEventListener('click', removeOrderItem);
    });
</script>
@endsection
