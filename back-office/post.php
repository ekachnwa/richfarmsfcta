<?php
session_start();

#connection to database
include('../config/con.php');

#check if sessions is still active
if (empty($_SESSION['id'])) {
  header("Location: index.php");
  exit(); // Stop further script execution after redirection
} else {
  $msg = $_SESSION['email'];
}

if (isset($_POST['submit'])) {
  #some code here
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- ========== Meta Tags ========== -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- ========== Page Title ========== -->
  <title>Rich Farms | ADMIN POST</title>

  <!-- ========== Favicon Icon ========== -->
  <link
    rel="shortcut icon"
    href="../assets/img/favicon.png"
    type="image/x-icon" />

  <!-- ========== Start Stylesheet ========== -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
  <link href="../assets/css/themify-icons.css" rel="stylesheet" />
  <link href="../assets/css/elegant-icons.css" rel="stylesheet" />
  <link href="../assets/css/flaticon-set.css" rel="stylesheet" />
  <link href="../assets/css/magnific-popup.css" rel="stylesheet" />
  <link href="../assets/css/swiper-bundle.min.css" rel="stylesheet" />
  <link href="../assets/css/animate.css" rel="stylesheet" />
  <link href="../assets/css/validnavs.css" rel="stylesheet" />
  <link href="../assets/css/helper.css" rel="stylesheet" />
  <link href="../assets/css/shop.css" rel="stylesheet" />
  <link href="../assets/css/style.css" rel="stylesheet" />
  <link href="../assets/css/unit-test.css" rel="stylesheet" />
  <link href="../style.css" rel="stylesheet" />
  <!-- ========== End Stylesheet ========== -->
</head>

<body>
  <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->


  <!-- Start Header Top 
    ============================================= -->
  <div class="top-bar-area top-bar-style-one bg-dark text-light">
    <div class="container">
      <div class="row align-center">
        <div class="col-xl-6 col-lg-8 offset-xl-3 pl-30 pl-md-15 pl-xs-15">
          <ul class="item-flex">
            <li>
              <i class="fas fa-map-marker-alt"></i> Dir. of Agric. Building
              Complex, Gwagwalada Area Council Secretariat, FCT.
            </li>
          </ul>
        </div>
        <div class="col-xl-3 col-lg-4 text-end">
          <div class="social">
            <ul>
              <li>

              </li>
              <li>
                <a href="#">
                  <i class="fab fa-facebook-f"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Header Top -->

  <!-- Header 
    ============================================= -->
  <header>
    <!-- Start Navigation -->
    <nav
      class="navbar mobile-sidenav navbar-style-one navbar-sticky navbar-default validnavs white navbar-fixed no-background">
      <div class="container">
        <div class="row align-center">
          <!-- Start Header Navigation -->
          <div class="col-xl-2 col-lg-3 col-md-2 col-sm-1 col-1">
            <div class="navbar-header">
              <button
                type="button"
                class="navbar-toggle"
                data-toggle="collapse"
                data-target="#navbar-menu">
                <i class="fa fa-bars"></i>
              </button>
              <a class="navbar-brand" href="/">
                <img src="../assets/img/fam-logo.png" class="logo" alt="Logo" />
              </a>
            </div>
          </div>
          <!-- End Header Navigation -->

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="col-xl-6 offset-xl-1 col-lg-6 col-md-4 col-sm-4 col-4">
            <div class="collapse navbar-collapse" id="navbar-menu">
              <img src="../assets/img/logo.png" alt="Logo" />
              <button
                type="button"
                class="navbar-toggle"
                data-toggle="collapse"
                data-target="#navbar-menu">
                <i class="fa fa-times"></i>
              </button>

              <ul
                class="nav navbar-nav navbar-center"
                data-in="fadeInDown"
                data-out="fadeOutUp">
                <li>
                  <a href="teams.php">Teams</a>
                </li>
                <li><a href="post.php">Post</a></li>

                <li><a href="logout.php">Logout</a></li>
              </ul>
            </div>
          </div>
          <!-- /.navbar-collapse -->

          <div class="col-xl-3 col-lg-3 col-md-6 col-sm-7 col-7">
            <div class="attr-right">
              <!-- Start Atribute Navigation -->
              <div class="attr-nav">
                <ul>
                  <li class="contact">
                    <div class="call">
                      <div class="icon">
                        <i class="fas fa-comments-alt-dollar"></i>
                      </div>
                      <div class="info">
                        <p>Have any Questions?</p>
                        <h5>
                          <a href="mailto:info@crysta.com">info@richfarmsfcta.org</a>
                        </h5>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <!-- End Atribute Navigation -->
            </div>
          </div>
        </div>
        <!-- Main Nav -->

        <!-- Overlay screen for menu -->
        <div class="overlay-screen"></div>
        <!-- End Overlay screen for menu -->
      </div>
    </nav>
    <!-- End Navigation -->
  </header>
  <!-- End Header -->

  <!-- Start Breadcrumb 
    ============================================= -->
  <div
    class="breadcrumb-area text-center shadow dark bg-fixed text-light"
    style="background-image: url(../assets/img/banner/18.jpg)">
    <div class="container">
      <div class="col-lg-8 offset-lg-2">
        <div class="col-tact-stye-one col-lg-12 mb-md-50">
          <h5 class="sub-title">POST</h5>
          <div class="contact-form-style-one">
            <div class="pull-right">
              <a href="create_post.php" class="link-btn">Create Post</a>
            </div>
            <?php

            $sql = "SELECT postid, title, content, created_at FROM post ORDER BY postid DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              echo "<form action='delete_post.php' method='POST'>";
              echo "<table class='table table-hover'>
                                <thead>
                                    <th></th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Date Created</th>
                                    <th>Actions</th>
                                </thead>";

              // Fetch and display results in table rows
              while ($row = $result->fetch_assoc()) {
                $postid = $row['postid']; // Store postid for easy reference
                echo "<tbody>
                                    <tr>
                                      <td><input type='checkbox' name='postids[]' value='{$postid}'></td>
                                      <td>{$row['title']}</td>
                                      <td>{$row['content']}</td>
                                      <td>{$row['created_at']}</td>
                                      <td>
                                          <a href='update_post.php?postid={$postid}' class='text-secondary'><i class='fa fa-edit'></i></a>
                                          <a type='submit' name='delete' value='{$postid}' class='text-danger'><i class='fa fa-trash'></i></a>
                                      </td>
                                    </tr>
                                </tbody>";
              }

              echo "</table>";
              echo "<button type='submit' name='delete_selected'>Delete Selected</button>";
              echo "</form>";
            } else {
              echo "No posts found.";
            }
            ?>

          </div>




        </div>

      </div>
    </div>
  </div>
  <!-- End Breadcrumb -->


  <!-- Start Footer 
    ============================================= -->
  <footer
    class="bg-dark text-light"
    style="background-image: url(../assets/img/shape/brush-down.png)">
    <div class="container">
      <!-- Start Footer Bottom -->
      <div class="footer-bottom">
        <div class="row">
          <div class="col-lg-6">
            <p>
              &copy; Copyright
              <script>
                document.write(new Date().getFullYear());
              </script>
              . All Rights Reserved.
            </p>
          </div>
          <div class="col-lg-6 text-end">
            <ul>
              <li>
                <a href="about-us">About us</a>
              </li>
              <li>
                <a href="contact-us.html">Support</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- End Footer Bottom -->
    </div>
    <div class="shape-right-bottom">
      <img src="../assets/img/shape/10.png" alt="Image Not Found" />
    </div>
    <div class="shape-left-bottom">
      <img src="../assets/img/shape/11.png" alt="Image Not Found" />
    </div>
  </footer>
  <!-- End Footer -->

  <!-- jQuery Frameworks
    ============================================= -->
  <script src="../assets/js/jquery-3.6.0.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/jquery.appear.js"></script>
  <script src="../assets/js/jquery.easing.min.js"></script>
  <script src="../assets/js/jquery.magnific-popup.min.js"></script>
  <script src="../assets/js/modernizr.custom.13711.js"></script>
  <script src="../assets/js/swiper-bundle.min.js"></script>
  <script src="../assets/js/wow.min.js"></script>
  <script src="../assets/js/progress-bar.min.js"></script>
  <script src="../assets/js/circle-progress.js"></script>
  <script src="../assets/js/isotope.pkgd.min.js"></script>
  <script src="../assets/js/imagesloaded.pkgd.min.js"></script>
  <script src="../assets/js/jquery.nice-select.min.js"></script>
  <script src="../assets/js/count-to.js"></script>
  <script src="../assets/js/jquery.scrolla.min.js"></script>
  <script src="../assets/js/YTPlayer.min.js"></script>
  <script src="../assets/js/TweenMax.min.js"></script>
  <script src="../assets/js/validnavs.js"></script>
  <script src="../assets/js/main.js"></script>
</body>

</html>