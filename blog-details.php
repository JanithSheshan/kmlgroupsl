<?php
include 'db.php';

// Get the post_id from the URL
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // Query to fetch post details
    $stmt = $conn->prepare("SELECT * FROM posts WHERE post_id = :post_id");
    $stmt->execute(['post_id' => $post_id]);

    $post = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        // Post data found, display the post details
        $title = $post['title'];
        $description = $post['description'];
        $author = $post['author'];
        $created_at = $post['created_at'];
        $image = $post['image'];
        $category = $post['category']; // Ensure 'category' exists in your database table
    } else {
        echo "Post not found!";
        exit;
    }
} else {
    echo "No post specified!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Blog Details - KML Group | A Reliable Distribution Network</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

</head>

<body class="blog-details-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">KML GROUP</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="team.html">Team</a></li>
          <li><a href="blog.html" class="active">Blog</a></li>
          <li class="dropdown"><a href="#"><span>Sectors</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="service-details1.html">Kurunegala Merchants (Pvt) Ltd</a></li>
              <!-- <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li> -->
              <li><a href="service-details2.html">KML Holdings (Pvt) Ltd</a></li>
              <li><a href="service-details3.html">KML Logistics (Pvt) Ltd</a></li>
              <li><a href="service-details4.html">KML Distributors (Pvt) Ltd</a></li>
              <li><a href="service-details5.html">Kanlark Entertainment (Pvt) Ltd</a></li>
            </ul>
          </li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

    <main class="main">
    <div class="page-title dark-background">
      <div class="container position-relative">
        <h1>Blog - Details</h1>
        <p>Stay updated with our latest news and insights.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li class="current">Blog-Details</li>
          </ol>
        </nav>
      </div>
    </div>
        <div class="container">
            <div class="row">
                <div class="col-lg m-auto">

                    <!-- Blog Details Section -->
                    <section id="blog-details" class="blog-details section">
                        <div class="container">
                            <article class="article">

                                <div class="post-img text-center">
                                    <img src="<?php echo htmlspecialchars($image); ?>" alt="" class="img-fluid">
                                </div>

                                <h2 class="title"><?php echo htmlspecialchars($title); ?></h2>

                                <div class="meta-top">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="blog-details.php"><?php echo htmlspecialchars($author); ?></a></li>
                                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-details.php"><time datetime="<?php echo htmlspecialchars($created_at); ?>"><?php echo htmlspecialchars($created_at); ?></time></a></li>
                                        <li class="d-flex align-items-center"><i class="bi bi-chat-dots"></i> <a href="blog-details.php"></a></li>
                                    </ul>
                                </div><br><!-- End meta top -->

                                <div class="description">
                                    <p><?php echo nl2br(htmlspecialchars($description)); ?></p>
                                </div><!-- End post description -->

                                <div class="meta-bottom">
                                    <i class="bi bi-folder"></i>
                                        <li><a href="#"><?php echo isset($category) ? htmlspecialchars($category) : 'Uncategorized'; ?></a></li>
                                    </ul>

                                    <i class="bi bi-tags"></i>
                                    <ul class="tags">
                                        <li><a href="#">Creative</a></li>
                                        <li><a href="#">Tips</a></li>
                                        <li><a href="#">Marketing</a></li>
                                    </ul>
                                </div><!-- End meta bottom -->

                            </article>

                        </div>
                    </section><!-- /Blog Details Section -->
                </div>
            </div>
        </div>
    </main>

    <footer id="footer" class="footer dark-background">

<div class="footer-newsletter">
  <div class="container">
    <div class="row justify-content-center text-center">
      <div class="col-lg-6">
        <h4>Join Our Newsletter</h4>
        <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
        <form action="forms/newsletter.php" method="post" class="php-email-form">
          <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
          <div class="loading">Loading</div>
          <div class="error-message"></div>
          <div class="sent-message">Your subscription request has been sent. Thank you!</div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="container footer-top">
  <div class="row gy-4">
    <div class="col-lg-4 col-md-6 footer-about">
      <a href="index.html" class="d-flex align-items-center">
        <span class="sitename">KML Group</span>
      </a>
      <div class="footer-contact pt-3">
        <p>A108 Adam Street</p>
        <p>New York, NY 535022</p>
        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
        <p><strong>Email:</strong> <span>info@example.com</span></p>
      </div>
    </div>

    <div class="col-lg-2 col-md-3 footer-links">
      <h4>Useful Links</h4>
      <ul>
        <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
        <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
        <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
        <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
      </ul>
    </div>

    <div class="col-lg-2 col-md-3 footer-links">
      <h4>Our Services</h4>
      <ul>
        <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
        <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
        <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
        <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
      </ul>
    </div>

    <div class="col-lg-4 col-md-12">
      <h4>Follow Us</h4>
      <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
      <div class="social-links d-flex">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
    </div>

  </div>
</div>

<div class="container copyright text-center mt-4">
  <p>© <span>Copyright</span> <strong class="px-1 sitename">KML Group</strong> <span>All Rights Reserved</span></p>
  <div class="credits">
    Designed by <a href="https://janithaththanayaka.com/">Janith</a>
  </div>
</div>

</footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>
</html>
