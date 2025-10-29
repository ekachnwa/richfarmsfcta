<?php
session_start();

#connection to database
include('../config/con.php');
?>
<?php
if (isset($_POST['update'])) {
    // Get the post ID and the updated data
    $id = $_POST['id'];
    $position = trim($_POST['position']);
    $fullname = trim($_POST['fullname']);

    // Validate input data
    if (!empty($position) && !empty($fullname)) {

        // Handle image upload
        $imageName = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = "../uploads/";
            $imageName = basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $imageName;
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            // Allow only certain file formats
            $allowedFileTypes = ['jpg', 'png', 'jpeg', 'gif'];

            if (in_array($imageFileType, $allowedFileTypes)) {
                // Upload the file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    // Image uploaded successfully
                } else {
                    echo "Error uploading image.";
                    exit();
                }
            } else {
                echo "Only JPG, JPEG, PNG & GIF files are allowed.";
                exit();
            }
        }

        // If no new image is uploaded, keep the old image
        if (empty($imageName)) {
            // Fetch the old image from the database
            $sql = "SELECT image_path FROM post_images WHERE postid = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $post = $result->fetch_assoc();
                $imageName = $post['image_path']; // Keep old image
            }
            $stmt->close();
        }

        // Update in the database
        $sql = "UPDATE team SET position = ?, fullname = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssi', $position, $fullname, $id);

        // if ($stmt->execute()) {
        //     $msg = "<div class='text-success'> updated successfully.</div>";

        //     // Delete old image when a new one is uploaded
        //     if (!empty($imageName) && !empty($post['image_path']) && file_exists('../uploads/' . $post['image_path'])) {
        //         unlink('../uploads/' . $post['image_path']); // Delete the old image
        //     }

        //     //header("Location: post.php"); // Redirect to the post list after updating
        //     //exit();
        //     // Close the statement
        //     $stmt->close();
        // } else {
        //     $msg = "Error updating post: " . $conn->error;
        // }
    } else {
        $msg = "position and fullname cannot be empty.";
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
                            <i class="fas fa-map-marker-alt"></i> 2 Pittsburgh str, Wuse 2,
                            FCT Abuja
                        </li>
                        <li>
                            <a href="tel:+2348149646850"><i class="fas fa-phone-alt"></i> +2348149646850</a>
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
                    <h5 class="sub-title">UPDATE POST</h5>

                    <?php
                    // Check if post ID is provided
                    if (isset($_GET['id'])) {
                        $teamid = $_GET['id'];

                        // Fetch post data from the database
                        $sql = "SELECT position, fullname FROM team WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('i', $teamid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // If post is found, fetch the data
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                        } else {
                            echo "Team not found.";
                            exit();
                        }
                    } else {
                        echo "Invalid Team ID.";
                        exit();
                    }

                    // Close the statement
                    $stmt->close();
                    ?>
                    <div class="contact-form-style-one">
                        <?php
                        if (isset($msg)) {
                            echo $msg;
                        }
                        ?>
                        <!-- Update Form -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $teamid; ?>">
                            <div class="form-group">
                                <div class="text-primary pull-left">Position:</div>
                                <input type="text" name="position" id="position" class="form-control" value="<?php echo htmlspecialchars($row['position']); ?>" required>
                            </div>
                            <div class="form-group">
                                <div class="text-primary pull-left">Full Name:</div>
                                <input type="text" name="fullname" id="fullname" class="form-control" value="<?php echo htmlspecialchars($row['fullname']); ?>" required>
                            </div>

                            <div class="form-group">
                                <!-- Display the current image if it exists -->
                                <?php if (!empty($row['image'])): ?>
                                    <div>
                                        <img src="../uploads/<?php echo $row['image']; ?>" alt="Post Image" width="100">
                                        <div class="text-secondary">Current Image: <?php echo htmlspecialchars($row['image']); ?></div>
                                    </div>
                                <?php endif; ?>

                                <div for="image" class="text-primary p-1 pull-left">Upload New Image (optional):</div>
                                <input type="file" name="image" id="image">
                                <br>
                            </div>

                            <button type="submit" name="update">Update</button>
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