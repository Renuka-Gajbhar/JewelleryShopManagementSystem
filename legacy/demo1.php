<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add & Delete Cards</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      background: #111;
      color: white;
      padding: 20px;
    }

    .form {
      margin-bottom: 20px;
    }

    input {
      padding: 8px;
      margin-right: 5px;
    }

    button {
      padding: 8px 12px;
      cursor: pointer;
    }

    .cards {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .card {
      background: #1f1f1f;
      width: 200px;
      padding: 15px;
      border-radius: 10px;
      position: relative;
    }

    .card img {
      width: 100%;
      border-radius: 8px;
    }

    .delete-btn {
      background: red;
      color: white;
      border: none;
      padding: 5px 8px;
      position: absolute;
      top: 10px;
      right: 10px;
    }
  </style>
</head>
<body>

  <h2>Cards Example</h2>

  <!-- ✅ Add Card Form -->
  <div class="form">
    <input type="text" id="title" placeholder="Title" />
    <input type="text" id="description" placeholder="Description" />
    <button onclick="addCard()">Add Card</button>
  </div>

  <!-- ✅ Cards Container -->
  <div class="cards" id="cards"></div>

  <script>
    // ✅ Step 1: Cards data stored in array
    let cardsData = [
      {
        title: "Movies",
        description: "Watch latest movies",
        image: "https://via.placeholder.com/200"
      },
      {
        title: "Events",
        description: "Live concerts & shows",
        image: "https://via.placeholder.com/200"
      }
    ];

    // ✅ Step 2: Function to show cards
    function renderCards() {
      const cardsContainer = document.getElementById("cards");
      cardsContainer.innerHTML = "";

      cardsData.forEach((card, index) => {
        cardsContainer.innerHTML += `
          <div class="card">
            <button class="delete-btn" onclick="deleteCard(${index})">X</button>
            <img src="${card.image}">
            <h3>${card.title}</h3>
            <p>${card.description}</p>
          </div>
        `;
      });
    }

    // ✅ Step 3: Add new card
    function addCard() {
      const title = document.getElementById("title").value;
      const description = document.getElementById("description").value;

      if (title === "" || description === "") {
        alert("Please fill all fields");
        return;
      }

      cardsData.push({
        title,
        description,
        image: "download(4).jpg"
      });

      renderCards();

      // clear input fields
      document.getElementById("title").value = "";
      document.getElementById("description").value = "";
    }

    // ✅ Step 4: Delete card
    function deleteCard(index) {
      cardsData.splice(index, 1);
      renderCards();
    }

    // Initial render
    renderCards();
  </script>

</body>
</html>