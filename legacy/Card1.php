<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        .main {
            border: 1px solid black;
            width: 500px;
            height: 400px;
            position: absolute;
            left: 450px ;
            top: 100px;
        }
        {

        }
    </style>
</head>

<body>
    <div class="main">

        <h2 style="text-align: center;">Your Cart</h2>

        <div class="cart-item">
            <img src="download (1).jpg" alt="">
            <div class="details">
                <h4>Gold Earring</h4>
                <p>₹ 25,000</p>
                <div class="qty">
                    <button>-</button>
                    <input type="text" value="1">
                    <button>+</button>
                </div>
            </div>
            <button class="remove">Remove</button>
        </div>

        <div class="total-box">
            <h3>Total: ₹ 24,700</h3>
            <button class="checkout">Checkout</button>
        </div>

    </div>

</body>

</html>