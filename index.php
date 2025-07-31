<?php
include("db.php");
session_start();

// Step 1: Create Blog
if (isset($_POST['submit_blog']) && isset($_FILES['blog_img'])) {
    $blog_heading = mysqli_real_escape_string($conn, $_POST['blog_heading']);
    $blog_content = mysqli_real_escape_string($conn, $_POST['blog_content']);
    $blog_price = (int) $_POST['blog_price'];
    $blog_img = $_FILES['blog_img']['name'];
    $blog_imgtemp = $_FILES['blog_img']['tmp_name'];
    $main_img_name = uniqid() . "_" . basename($blog_img);
    $upload = "uploads/" . $main_img_name;

    if (move_uploaded_file($blog_imgtemp, $upload)) {
        $sql = "INSERT INTO `blogs`(`heading`, `content`, `price`, `img_path`) VALUES ('$blog_heading','$blog_content','$blog_price','$main_img_name')";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['last_blog_id'] = mysqli_insert_id($conn);
            echo "<script>alert('Blog Created Successfully. Now add gallery images.');</script>";
        } else {
            echo "<script>alert('Blog insert failed');</script>";
            echo "MySQL Error: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Main image upload failed');</script>";
    }
}

// Step 2: Add Gallery Images
if (isset($_POST['upload_gallery']) && isset($_SESSION['last_blog_id'])) {
    $blog_id = $_SESSION['last_blog_id'];
    if (!empty($_FILES['gallery_imgs']['name'][0])) {
        $gallery_imgs = $_FILES['gallery_imgs'];
        for ($i = 0; $i < count($gallery_imgs['name']); $i++) {
            if (!empty($gallery_imgs['name'][$i])) {
                $gallery_name = uniqid() . "_" . basename($gallery_imgs['name'][$i]);
                $gallery_tmp = $gallery_imgs['tmp_name'][$i];
                $gallery_path = "uploads/" . $gallery_name;

                if (move_uploaded_file($gallery_tmp, $gallery_path)) {
                    $conn->query("INSERT INTO blog_images (blog_id, image_path) VALUES ($blog_id, '$gallery_name')");
                }
            }
        }
        echo "<script>alert('Gallery Images Uploaded');</script>";
    }
}

// Clear session (start new blog)
if (isset($_GET['clear'])) {
    unset($_SESSION['last_blog_id']);
    header("Location: index.php");
    exit;
}

// Fetch all blogs
$blogs = mysqli_query($conn, "SELECT * FROM blogs ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Admin - Blog + Gallery</title>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="css/bootstrap.min.css" rel="stylesheet">

  <script src="https://cdn.tiny.cloud/1/8n8gh7lbf9l2wfvobapectnoup5jls1q5jwc92cahbm5om71/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
<div class="container my-5">
  <h2 class="text-center mb-4">📝 Admin - add  Gallery</h2>

  <!-- Step 1: Blog Creation Form -->
  <?php if (!isset($_SESSION['last_blog_id'])): ?>
    <form action="" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
      <h4>Create New products</h4>
      <div class="mb-3">
        <label class="form-label">product name</label>
        <input type="text" name="blog_heading" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Price (₹)</label>
        <input type="number" name="blog_price" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="blog-content" class="form-label"> Content</label>
        <textarea name="blog_content" id="blog-content"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Main Image</label>
        <input type="file" name="blog_img" class="form-control" accept="image/*" required>
      </div>
      <button type="submit" name="submit_blog" class="btn btn-primary w-100">Create Blog</button>
    </form>
  <?php endif; ?>

  <!-- Step 2: Gallery Upload Form -->
  <?php if (isset($_SESSION['last_blog_id'])): ?>
    <form action="" method="POST" enctype="multipart/form-data" class="border p-4 mt-4 rounded shadow-sm">
      <h4>Add Gallery Images (Blog ID: <?= $_SESSION['last_blog_id'] ?>)</h4>
      <div class="mb-3">
        <input type="file" name="gallery_imgs[]" class="form-control" accept="image/*" multiple required>
      </div>
      <button type="submit" name="upload_gallery" class="btn btn-success w-100">Upload Images</button>
      <a href="?clear=1" class="btn btn-outline-danger w-100 mt-3">add new products</a>
    </form>

    <div class="mt-4">
      <h5>📷 Uploaded Gallery Images:</h5>
      <div class="row">
        <?php
        $blog_id = $_SESSION['last_blog_id'];
        $res = $conn->query("SELECT * FROM blog_images WHERE blog_id = $blog_id");
        while ($img = $res->fetch_assoc()) {
            echo "<div class='col-md-3 mb-3'><img src='uploads/{$img['image_path']}' class='img-fluid border rounded'></div>";
        }
        ?>
      </div>
    </div>
  <?php endif; ?>

  <hr class="my-5">

  <!-- Blog List -->
  <h4 class="text-center">🗂 All products</h4>
  <table class="table table-bordered table-striped mt-3 text-center">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>ID</th>
        <th>Heading</th>
        <th>Price</th>
        <th>Main Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $x = 1; while ($row = mysqli_fetch_assoc($blogs)) { ?>
        <tr>
          <td><?= $x++ ?></td>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['heading']) ?></td>
          <td>₹<?= number_format($row['price']) ?></td>
          <td>
            <img src="uploads/<?= $row['img_path'] ?>" width="70" height="70" style="object-fit: cover;">
          </td>
          <td>
            <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">View</a>
            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<script>
  tinymce.init({
    selector: '#blog-content',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
  });
</script>
</body>
</html>
