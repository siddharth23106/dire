<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
       <link href="css/style.css" rel="stylesheet">
      <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<footer class="bg-light text-dark pt-5 pb-4">
  <div class="container">
    <div class="row gy-4">

      <!-- Logo + About -->
      <div class="col-md-4">
        <h4 class="text-uppercase mb-3">YourShopName</h4>
        <p class="text-dark">We provide trusted healthcare and personalized medical services with modern infrastructure and experienced doctors.</p>

        <!-- Social Icons -->
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-light fs-5"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-light fs-5"><i class="bi bi-instagram"></i></a>
          <a href="#" class="text-light fs-5"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="text-light fs-5"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

      <!-- Quick Navigation -->
      <div class="col-md-2">
        <h5 class="mb-3">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-dark text-decoration-none">Home</a></li>
          <li><a href="about.php" class="text-dark text-decoration-none">About</a></li>
          <li><a href="services.php" class="text-dark text-decoration-none">Services</a></li>
          <li><a href="contact.php" class="text-dark text-decoration-none">Contact</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="col-md-3">
        <h5 class="mb-3">Contact</h5>
        <ul class="list-unstyled text-muted">
          <li><strong>Phone 1:</strong> <a href="tel:+911234567890" class="text-muted text-decoration-none">+91 12345 67890</a></li>
          <li><strong>Phone 2:</strong> <a href="tel:+919876543210" class="text-muted text-decoration-none">+91 98765 43210</a></li>
          <li><strong>Email:</strong> <a href="mailto:info@yourshop.com" class="text-muted text-decoration-none">info@yourshop.com</a></li>
        </ul>
      </div>

      <!-- Address -->
      <div class="col-md-3">
        <h5 class="mb-3">Shop Address</h5>
        <p class="text-muted">
          123 Market Road,<br>
          Your City, State - 123456<br>
          India
        </p>
      </div>

    </div>

    <hr class="border-light mt-4">

    <div class="text-center text-muted">
      <small>&copy; <?php echo date('Y'); ?> YourShopName. All rights reserved.</small>
    </div>
  </div>
</footer>



</body>
</html>