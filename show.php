<?php
include('db.php');

$sql = "SELECT * FROM `blogs` WHERE 1";
$run = mysqli_query($conn, $sql);
?>
<?php include("navbar.php"); ?>
<?php


// Pagination logic
$limit = 8; // 4 products per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total blogs
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM `blogs`");
$total_row = mysqli_fetch_assoc($total_result);
$total_blogs = $total_row['total'];

$total_pages = ceil($total_blogs / $limit);

// Fetch paginated blogs
$sql = "SELECT * FROM `blogs` ORDER BY id DESC LIMIT $limit OFFSET $offset";
$run = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Blog Cards</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
 


<h2>OUR PRODUCTS</h2>
  <div class="section mt-5">
    <div class="container-fluid px-4">
      <div class="row">
        <?php while($row = mysqli_fetch_assoc($run)) { ?>
  <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
  <div class="card shadow-sm">
    <img src="uploads/<?php echo $row['img_path']; ?>" class="card-img-top" alt="image">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title">
  <?php
    $words = explode(" ", $row['heading']);
    $short_heading = implode(" ", array_slice($words, 0, 20));
    echo (count($words) > 20) ? $short_heading . "..." : $row['heading'];
  ?>
</h5>

      <p class="text-success fw-bold fs-4">₹<?php echo number_format($row['price']); ?></p>

      <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary mt-auto">Read More</a>
    </div>
  </div>
</div>


        <?php } ?>
      </div>
    </div>
  </div>
  <!-- Pagination -->
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center mt-4">
    <!-- Previous Button -->
    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
      <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
    </li>

    <?php
    $start = max(1, $page - 2);
    $end = min($total_pages, $page + 2);

    for ($i = $start; $i <= $end; $i++) {
      $active = ($i == $page) ? 'active' : '';
      echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>$i</a></li>";
    }
    ?>

    <!-- Next Button -->
    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
      <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
    </li>
  </ul>
</nav>

  <?php include("footer.php"); ?>
</body>
</html>
