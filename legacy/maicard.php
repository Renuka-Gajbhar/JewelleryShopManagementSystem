<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style type="text/css">
    .cart-container {
      width: 80%;
      margin: auto;
      padding: 20px;
      font-family: Arial;
    }

    .cart-container h2 {
      margin-bottom: 20px;
    }

    .cart-item {
      display: flex;
      align-items: center;
      background: #fff;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    .cart-item img {
      width: 110px;
      height: 110px;
      border-radius: 8px;
      object-fit: cover;
      margin-right: 15px;
    }

    .details h4 {
      margin: 0;
    }

    .details p {
      margin: 5px 0;
      color: #444;
    }

    .qty {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-top: 8px;
    }

    .qty button {
      width: 26px;
      height: 26px;
      border: none;
      background: #e0e0e0;
      cursor: pointer;
      border-radius: 4px;
    }

    .qty input {
      width: 30px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .remove {
      margin-left: auto;
      background: transparent;
      border: none;
      color: red;
      cursor: pointer;
      font-size: 14px;
    }

    .total-box {
      text-align: right;
      margin-top: 15px;
    }

    .checkout {
      background: #d2a73c;
      border: none;
      padding: 10px 18px;
      color: #fff;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>


</head>

<body>
  <div class="cart-container">

    <h2>Your Cart</h2>

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
     <button class="remove" onclick="removeItem(this)">Remove</button>

    </div>

    <div class="total-box">
      <h3>Total: ₹ 24,700</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>

  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="download.jpg" alt="">
      <div class="details">
        <h4>Diamond Ring</h4>
        <p>₹ 35,000</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
      <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 34,700</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="download (3).jpg" alt="">
      <div class="details">
        <h4>Silver Necklace</h4>
        <p>₹ 5,500</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
      <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 5,000</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="download (4).jpg" alt="">
      <div class="details">
        <h4>Silver bangle</h4>
        <p>₹ 5,000</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
      <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 5,200</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="download (5).jpg" alt="">
      <div class="details">
        <h4>Silver Bracelet</h4>
        <p>₹ 7,500</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
      <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 7,000</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="download (0).jpg" alt="">
      <div class="details">
        <h4>Gold Necklace</h4>
        <p>₹ 70,500</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
      <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 70,000</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="images (2).jpg" alt="">
      <div class="details">
        <h4>Pearl Necklace</h4>
        <p>₹ 50,500</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
     <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 50,300</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="download (6).jpg" alt="">
      <div class="details">
        <h4>Diamond Necklace</h4>
        <p>₹ 70,500</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
     <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 70,300</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="images (1).jpg" alt="">
      <div class="details">
        <h4>Gold Necklace</h4>
        <p>₹ 40,500</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
    <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 40,300</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
  <div class="cart-container">

    <h2>Your Cart</h2>

    <div class="cart-item">
      <img src="download (7).jpg" alt="">
      <div class="details">
        <h4>Gold Bracelet</h4>
        <p>₹ 20,500</p>
        <div class="qty">
          <button>-</button>
          <input type="text" value="1">
          <button>+</button>
        </div>
      </div>
    <button class="remove" onclick="removeItem(this)">Remove</button>
    </div>

    <div class="total-box">
      <h3>Total: ₹ 20,3SS00</h3>
      <button class="checkout">Checkout</button>
    </div>

  </div>
<script>
  function removeItem(btn) {
    btn.closest('.cart-container').remove();
  }
</script>

</body>


</html>