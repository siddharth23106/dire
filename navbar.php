<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>JS Toggle Navbar</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
   <link href="css/style.css" rel="stylesheet">
</head>
<body>

  <nav>
    <div class="navbar-container">

      <!-- Top Row -->
      <div class="top-row">
        <div class="logo">ShopLogo</div>
        <div class="menu-toggle" id="menu-toggle">
          <i class="fas fa-bars"></i>
        </div>
      </div>

     
      

      <!-- Navigation Menu -->
      <div class="nav-menu" id="nav-menu">
        <a href="front.php">Home</a>
         <a href="show.php">shop</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
        
      </div>

    </div>
  </nav>

  <!-- JavaScript for toggle -->
  <script>
    const toggleBtn = document.getElementById('menu-toggle');
    const navMenu = document.getElementById('nav-menu');

    toggleBtn.addEventListener('click', () => {
      navMenu.classList.toggle('show');
    });
  </script>

</body>
</html>
