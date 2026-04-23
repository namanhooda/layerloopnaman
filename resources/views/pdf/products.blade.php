<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #000;
}

.header {
    text-align: center;
    margin-bottom: 15px;
}

.logo {
    font-size: 22px;
    font-weight: bold;
}

.tagline {
    font-size: 10px;
    letter-spacing: 2px;
}

.title {
    text-align: center;
    font-size: 18px;
    font-weight: bold;
    margin: 10px 0 20px;
}

/* CARD GRID */
.card {
    width: 27%;
    display: inline-block;
    margin: 1%;
    border: 1px solid #ddd;
    border-radius: 6px;
    text-align: center;
    vertical-align: top;
    padding: 10px;
    box-sizing: border-box;
}

/* IMAGE */
.card img {
    width: 100%;
    height: 120px;
    object-fit: contain;
    margin-bottom: 10px;
}

/* PRODUCT NAME */
.card-title {
    font-size: 13px;
    font-weight: bold;
    margin-bottom: 5px;
}

/* OPTIONAL PRICE */
.price {
    font-size: 12px;
    color: #2c7a2c;
    font-weight: bold;
}

</style>
</head>

<body>

<div class="header">
    <div class="logo">LAYERLOOP</div>
    <div class="tagline">WE PRINT FOR YOU</div>
</div>

<div class="title">OUR PRODUCTS</div>

<!-- PRODUCTS -->
@foreach($products as $product)

    <div class="card">

        <img src="{{ public_path('storage/' . $product->featured_image) }}">

        <div class="card-title">
            {{ $product->name }}
        </div>

        @if(isset($product->price))
        <div class="price">
            ₹ {{ $product->price }}
        </div>
        @endif

    </div>

@endforeach

</body>
</html>