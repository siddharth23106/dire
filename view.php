<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    echo "<!-- DEBUG: Viewing Product ID = $id -->"; // For debugging

    $sql = "SELECT * FROM blogs WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        // Product not found - send 404 status for SEO
        http_response_code(404);
        
        exit;
    }

    // Fetch gallery images
    $images = [];
    $img_sql = "SELECT * FROM blog_images WHERE blog_id = $id";
    $img_result = mysqli_query($conn, $img_sql);
    if ($img_result && mysqli_num_rows($img_result) > 0) {
        while ($img_row = mysqli_fetch_assoc($img_result)) {
            $images[] = $img_row['image_path'];
        }
    }
} else {
    // ID not provided - send 400 status
    http_response_code(400);
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <title>400 - Bad Request</title>
        <link href='css/bootstrap.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class='container text-center mt-5'>
            <h1 class='display-4 text-warning'>400</h1>
            <p class='lead'>Invalid or missing product ID.</p>
            <a href='index.php' class='btn btn-primary mt-3'>Return to Home</a>
        </div>
    </body>
    </html>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Product</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>
<body>
  <?php include("navbar.php"); ?>

  <div class="container my-5">
    <div class="row g-4">
      <!-- Left Side: Gallery -->
      <div class="col-md-6">
        <img src="uploads/<?php echo $row['img_path']; ?>" id="mainImage" class="main-img mb-3" alt="Main Image">
        <div class="d-flex flex-wrap gap-2">
          <img src="uploads/<?php echo $row['img_path']; ?>" class="thumb-img" onclick="changeImage(this.src)" alt="Main">
          <?php foreach ($images as $img) { ?>
            <img src="uploads/<?php echo $img; ?>" class="thumb-img" onclick="changeImage(this.src)" alt="Gallery">
          <?php } ?>
        </div>
      </div>

      <!-- Right Side: Title and Price -->
      <div class="col-md-6 d-flex flex-column justify-content-center">
        <h2 class="product-heading"><?php echo htmlspecialchars($row['heading']); ?></h2>
        <p class="text-success fs-1 fw-bold mt-2">Price: ₹<?php echo number_format($row['price']); ?></p>
      </div>
    </div>

    <!-- Description -->
    <div class="row mt-4">
      <div class="col-12 description">
        <hr>
        <?php echo $row['content']; ?>
      </div>
    </div>
  </div>

  <!-- Related Products Section -->
  <div class="container my-5">
    <h4 class="mb-4">Related Products</h4>
    <div class="row">
      <?php
        $related_sql = "SELECT * FROM blogs WHERE id != $id ORDER BY RAND() LIMIT 4";
        $related_result = mysqli_query($conn, $related_sql);

        if ($related_result && mysqli_num_rows($related_result) > 0) {
          while ($rel = mysqli_fetch_assoc($related_result)) {
      ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card">
          <img src="uploads/<?php echo $rel['img_path']; ?>" class="card-img-top" style="height:200px; object-fit:contain;" alt="Related Image">
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
            <a href="view.php?id=<?php echo $rel['id']; ?>" class="btn btn-primary btn-sm">View</a>
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

  <script>
    function changeImage(src) {
      document.getElementById("mainImage").src = src;
    }
  </script>
</body>
</html>
