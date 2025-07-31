<?php
include("db.php");

// Get current product/blog ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
   <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  
</head>
<body>

<!-- Top Info Bar -->
<div class="bg-dark text-light py-2">
  <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center small">
    <div>
      📞 +91-9876543210 | 📞 +91-9123456789 | ✉️ email@example.com
    </div>
    <div>
      🏪 123, Shop Address, City, State - Pincode
    </div>
  </div>
</div>

<?php include("navbar.php"); ?>

<!-- Hero Section -->
<section class="hero-banner position-relative d-flex align-items-center text-white">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-7 col-md-10 col-12">
        <div class="content">
          <p class="text-uppercase fw-semibold mb-2">Diagnosis</p>
          <h1 class="display-5 fw-bold mb-3">Personal care for your<br> healthy living</h1>
          <p class="mb-4">Small river named Duden flows by their place and supplies it with the necessary regelialia.<br>It is a paradisematic country.</p>
         
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Related Products Section -->
<div class="container my-5">
  <h2>OUR PRODUCTS</h2>
  <div class="row">
    <?php
      $related_sql = "SELECT * FROM blogs WHERE id != $id ORDER BY RAND() LIMIT 8";
      $related_result = mysqli_query($conn, $related_sql);

      if ($related_result && mysqli_num_rows($related_result) > 0) {
        while ($rel = mysqli_fetch_assoc($related_result)) {
    ?>
   <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
  <div class="card">
    <img src="uploads/<?php echo $rel['img_path']; ?>" class="card-img-top" alt="image">
    <div class="card-body">
  <h5 class="card-title" title="<?php echo htmlspecialchars($rel['heading']); ?>">
    <?php
      $headingWords = explode(' ', strip_tags($rel['heading']));
      $shortHeading = implode(' ', array_slice($headingWords, 0, 20));
      echo htmlspecialchars($shortHeading);
      if (count($headingWords) > 20) echo '...';
    ?>
  </h5>

  <p class="text-success fw-bold fs-4 mb-2">₹<?php echo number_format($rel['price']); ?></p>

  <a href="view.php?id=<?php echo $rel['id']; ?>" class="btn btn-primary btn-sm">Read More</a>
</div>

  </div>
</div>

    <?php
        }
      } else {
        echo "<p>No related products found.</p>";
      }
    ?>
  </div>
</div>

  <?php include("footer.php"); ?>

</body>
</html>
