<?php
$pageTitle = isset($pageTitle) ? $pageTitle : 'AMIS Project';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Agriculture Marketing Information System connecting farmers, buyers, and market professionals">
    <meta name="keywords" content="agriculture, marketing, information, system, farmers, buyers">
    <meta name="author" content="Your Name">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap.min.css" integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js" integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/scripts.js" defer></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/popper.min.js" defer></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/d3.min.js" defer></script>
    <script src=https://code.jquery.com/jquery-3.7.1.js></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Proxima+Nova:wght@400;700&display=swap" rel="stylesheet">
    
    <link href=https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.css rel=stylesheet>
    <script src=https://cdn.datatables.net/2.1.2/js/dataTables.js></script>

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            AOS.init();
        });
    </script>

    <style>
        body {
            font-family: 'Proxima Nova', sans-serif;
        }

        #scrollToTopBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            border: none;
            outline: none;
            background-color: #007377;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
        }

        #scrollToTopBtn:hover {
            background-color: #555;
        }

        .bg-body-tertiary {
            background-color: #f8f9fa !important;
        }

        .list-unstyled li {
            font-size: 1.2rem;
            display: flex;
            align-items: center;
        }

        .list-unstyled li i {
            margin-right: 10px;
        }

        .featurette-image {
            border-radius: 15px;
        }

        #my-nav {
            background-color: #f3f9f9 !important;
        }

        .text-content .full-text {
            display: none;
        }

        .read-more-btn {
            cursor: pointer;
        }

        .go-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007377;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            text-align: center;
            line-height: 50px;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .centered-form {
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 70vh; */
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-label {
        color: #007377;
    }

    .btn-primary {
        background-color: #007377;
        border-color: #007377;
    }

    .btn-primary:hover {
        background-color: #005f5a;
        border-color: #005f5a;
    }

    form#add-yield-form, form#edit-yield-form {
        margin-bottom: 15px;
    }
    .sidebar .nav-link.active, .nav-link:hover {
    color: #ffffff !important; /* White color for better contrast */
    background-color: #023047; /* Light blue background for active and hover states */
    border-radius: 5px; /* Rounded corners for a modern look */
    transition: background-color 0.3s ease, color 0.3s ease;
}
    </style>
</head>

<body class="d-flex flex-column h-100">
    <div>
        <header>
            <nav id="my-nav" class="navbar navbar-expand-lg navbar-light bg-light" data-aos="fade-down">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#"><img width="36" src="<?php echo BASE_URL; ?>/assets/images/logo.png" alt="Logo">&nbsp;AMIS</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>/public">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">About</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <?php echo isset($logoutButton) ?
                                    '<form action="/amis-project-/pages/routes.php" method="post">
                                        <input type="hidden" name="action" value="logout">
                                        <button type="submit" class="nav-link"><i class="fa fa-sign-out"></i>&nbsp; Logout</button>
                                        </form>'
                                    : '<a class="nav-link" href="../pages/login.php"><i class="fa fa-unlock"></i>&nbsp; Login</a>' ?>
                            </li>

                            <?php echo isset($logoutButton) ? '' : '<li class="nav-item"><a class="nav-link" href="register.php">Sign Up</a></li>' ?>

                        </ul>
                    </div>
                </div>
            </nav>
        </header>