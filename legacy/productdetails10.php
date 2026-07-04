<!DOCTYPE html>
<html>
<head>
  <title>Product Details</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    body {
      font-family: Arial;
      padding: 40px;
      background: #f5f5f5;
    }

    .product-box {
      display: flex;
      gap: 40px;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    img {
      width: 350px;
      border-radius: 10px;
    }

    .btn {
      background: orange;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>

<body>

  <div class="product-box">
    <img src="download (7).jpg">

    <div>
      <h2>Gold Earring</h2>
      <h3><i class="fa-solid fa-star" id="star"></i>
          <i class="fa-solid fa-star" id="star"></i>
          <i class="fa-solid fa-star" id="star"></i>
          <i class="fa-solid fa-star" id="star"></i>☆ (4.4 Ratings)</h3>
      <h2>₹5,000</h2>

      <p>
        Beautiful designer gold earrings. Perfect for weddings,
        parties and daily wear. High quality finish and lightweight.
      </p>

      <button class="btn">Add to Cart</button>
       <button class="btn">By Now</button>

    </div>
  </div>

</body>
</html>