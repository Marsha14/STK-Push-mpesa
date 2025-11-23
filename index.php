<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Trouser - Payment</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; text-align: center; padding: 50px; }
        .product { background: #fff; padding: 30px; border-radius: 12px; display: inline-block; box-shadow: 0 5px 15px rgba(0,0,0,0.2);}
        h1 { color: #333; }
        button { padding: 15px 30px; background: #ffcc00; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; }
        button:hover { background: #e6b800; }
        input { padding: 10px; width: 200px; margin-bottom: 10px; border-radius: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>

    <div class="product">
        <h1>Trouser</h1>
        <p>Price: KES 800</p>
        <form action="daraja.php" method="POST">
            <input type="text" name="phone" placeholder="Enter your phone number" required>
            <input type="hidden" name="amount" value="800">
            <button type="submit">Pay Now</button>
        </form>
    </div>

</body>
</html>
