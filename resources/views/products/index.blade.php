<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Products</h1>
    <form action="{{ route('order.store') }}" method="POST">
        @csrf
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text">${{ $product->price }}</p>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="products[]" value="{{ $product->id }}">
                                <label class="form-check-label">Order this product</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="shipping_address">Shipping Address</label>
            <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Order</button>
    </form>
</div>
</body>
</html>
