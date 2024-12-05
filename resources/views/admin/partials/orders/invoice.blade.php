<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <center>
        <h1>Order Details</h1>
        <h3>Customer Name : {{ $data->name }}</h3>
        <h3>Address : {{ $data->address }}</h3>
        <h3>Phone : {{ $data->phone }}</h3>
        <h2>Product Title : {{ $data->product->title}}</h2>
        <h3>Price : {{ $data->product->price }}</h3>
        <!-- <img height="250" width="300" src="{{ asset('/upload/product/.$data->product->image') }} "> -->
    </center>
    
</body>
</html>