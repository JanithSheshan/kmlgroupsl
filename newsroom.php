<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>News Room - KML Group | A Legacy of 60 Years</title>
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

<body class="blog-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="KML Group Logo">
        <h1 class="sitename">KML GROUP</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="services.html">Services</a></li>
          <li><a href="gallery.html">Gallery</a></li>
          <li><a href="team.html">Team</a></li>
          <li><a href="newsroom.php" class="active">News Room</a></li>
          <li class="dropdown"><a href="#"><span>Sectors</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="kurunegala-merchants.html">Kurunegala Merchants (Pvt) Ltd</a></li>
              <!-- <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li> -->
              <li><a href="kml-holdings.html">KML Holdings (Pvt) Ltd</a></li>
              <li><a href="kml-logistics.html">KML Logistics (Pvt) Ltd</a></li>
              <li><a href="kml-distributors.html">KML Distributors (Pvt) Ltd</a></li>
              <li><a href="kanlark-ntertainment.html">Kanlark Entertainment (Pvt) Ltd</a></li>
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
        <h1>News Room</h1>
        <p>Stay updated with our latest news and insights.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">News Room</li>
            <li><a href="login.php">Login</a></li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="green-background"></div>

    <section id="blog-posts" class="blog-posts section">
      <div class="container">
        <div class="row gy-4">
          <?php

          // Fetch blog posts
          $sql = "SELECT * FROM posts ORDER BY created_at DESC";
          $result = $conn->query($sql);
          while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
              echo '<div class="col-lg-4">';
              echo '  <article>';
              echo '    <div class="post-img">';
              echo '      <img src="' . $row['image'] . '" alt="" class="img-fluid">';
              echo '    </div>';
              echo '    <p class="post-category">' . $row['category'] . '</p>';
              echo '    <h2 class="title">';
              echo '      <a href="newsroom-details.php?post_id=' . htmlspecialchars($row['post_id'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8') . '</a>';
              echo '    </h2>';
              echo '    <a href="newsroom-details.php?post_id=' . htmlspecialchars($row['post_id'], ENT_QUOTES, 'UTF-8') . '" class="readmore">';
              echo '    <div class="d-flex align-items-center">';
              echo '      <img src="' . $row['author_image'] . '" alt="" class="img-fluid post-author-img flex-shrink-0">';
              echo '      <div class="post-meta">';
              echo '        <p class="post-author">' . $row['author'] . '</p>';
              echo '        <p class="post-date"><time datetime="' . $row['created_at'] . '">' . date("M d, Y", strtotime($row['created_at'])) . '</time></p>';
              echo '      </div>';
              echo '    </div>';
              echo '    </a>';
              echo '  </article>';
              echo '</div>';
          }
          $conn = null;
          ?>
        </div>
      </div>
    </section>
  </main>

  <footer id="footer" class="footer dark-background">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Stay updated with the latest news and insights from KML Group. Subscribe now!</p>
            <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email" placeholder="Enter your email"><input
                  type="submit" value="Subscribe"></div>
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
            <!-- <img src="assets/img/logo.png" alt="KML Group Logo" class="footer-logo"> -->
            <span class="sitename">KML Group</span>
          </a>
          <div class="footer-contact pt-3">
            <p>118/3 Sumangala Mawatha, Kurunegala, Sri Lanka</p>
            <p><strong>Phone:</strong> <span>+94 37 222 2353</span></p>
            <p><strong>Email:</strong> <span>kmlkurunegala@gmail.com</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="index.html">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="about.html">About Us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="services.html">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="contact.html">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Our Sectors</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="kurunegala-merchants.html">Logistics</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="kml-holdings.html">Investments</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="kml-logistics.html">Distribution</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="kml-distributors.html">Entertainment</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Connect with Us</h4>
          <p>Follow us on social media for the latest updates and industry insights.</p>
          <div class="social-links d-flex">
            <a href="#"><i class="bi bi-twitter"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">KML Group</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://janithaththanayaka.com/">Janith Aththanayaka</a>
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
