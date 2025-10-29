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

    // Get the position and fullname from the form
    $position = trim($_POST['position']);
    $fullname = trim($_POST['fullname']);

    // Validate input data
    if (!empty($position) && !empty($fullname)) {
        // Insert post into the database
        $sql = "INSERT INTO team (position, fullname) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $position, $fullname);

        if ($stmt->execute()) {
            $id = $stmt->insert_id; // Get the ID of the newly inserted post

            // Handle multiple image uploads
            $targetDir = "../uploads/";
            $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (isset($_FILES['images']) && $_FILES['images']['name'] > 0) {
                //for ($i = 0; $i < $_FILES['images']['name']; $i++) {
                $imageName = basename($_FILES['images']['name']);
                $targetFilePath = $targetDir . $imageName;
                $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                // Check if the file is a valid image type
                if (in_array($imageFileType, $allowedFileTypes)) {
                    // Move the file to the target directory
                    if (move_uploaded_file($_FILES['images']['tmp_name'], $targetFilePath)) {
                        // Insert the image path into a separate table
                        $sqlImage = "INSERT INTO post_images (postid, image_path) VALUES (?, ?)";
                        $stmtImage = $conn->prepare($sqlImage);
                        $stmtImage->bind_param('is', $id, $imageName);
                        $stmtImage->execute();
                    } else {
                        $msg = "<div class='text-danger'>Error uploading image: " . $_FILES['images']['name'] . "</div>";
                    }
                } else {
                    $msg = "<div class='text-danger'>Invalid file type: " . $_FILES['images']['name'] . "</div>";
                }
                //}
            }

            // Redirect to post list or success page
            header("Location: teams.php");
            exit();
        } else {
            $msg = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $msg = "<div class='text-danger'> Position and Full Name cannot be empty.</div>";
    }
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
    <style>
        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .image-preview img:hover {
            border-color: #666;
        }
    </style>
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
                    <h5 class="sub-title">ADD NEW TEAM MEMBER</h5>
                    <div class="contact-form-style-one">


                        <!-- Form to Create Post with Multiple Images -->
                        <form action="" method="POST" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="position" class="text-primary pull-left">Position:</label>
                                <input type="text" class="form-control" name="position" id="position" required>
                            </div>
                            <div class="form-group">
                                <label for="fullname" class="text-primary pull-left">Full Name:</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" required>
                            </div>

                            <div class="from-group">
                                <label for="images" class="text-primary pull-left">Post Images:</label>
                                <input type="file" class="form-control" name="images" id="images">
                            </div>
                            <div id="preview" class="image-preview"></div>

                            <button type="submit" name="submit">Add New Member</button>
                        </form>


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

<script>
    document.getElementById('images').addEventListener('change', function(event) {
        let preview = document.getElementById('preview');
        preview.innerHTML = ''; // Clear previous previews

        let files = event.target.files;
        if (files) {
            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let img = document.createElement('img');
                        img.src = e.target.result;
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file); // Convert image to base64 string for preview
                }
            });
        }
    });
</script>