<!DOCTYPE html>
<html>
<head>
    <title>Fee Automation System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <style>
        /* Custom CSS styles */
        body {
            background-color: aquamarine;

        }
        .course-card {
            margin-bottom: 20px;
        }
        /* Style for the carousel */
        .carousel-item {
            height: 400px; 
            position: relative;
        }
        .carousel-caption {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            padding: 20px;
        }
    </style>
</head>
<body>

<?php
include('navbar.php');
?>
<div id="carouselExample" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExample" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExample" data-slide-to="1"></li>
        <li data-target="#carouselExample" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="./images/Pic1.Png" class="d-block w-100" alt="Slide 1">
            <div class="carousel-caption">
                <h3>Welcome to Fee Automation System</h3>
                <p>Streamline fee management with our automated platform.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="./images/Pic2.jpg" class="d-block w-100" alt="Slide 2">
            <div class="carousel-caption">
                <h3>Simplify Fee Tracking</h3>
                <p>Effortlessly manage and track fee submissions.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="./images/Pic3.jpg" class="d-block w-100" alt="Slide 3">
            <div class="carousel-caption">
                <h3>Enhance Financial Efficiency</h3>
                <p>Optimize financial processes with Fee Automation System.</p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>


    <section class="container mt-5">
  <h2 class="text-center">Contact Us</h2>
  <p class="text-center">If you have any questions or queries, please feel free to contact us by filling out the form below.</p>

  <form action="contact_process.php" method="POST">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="subject">Subject:</label>
          <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </form>
</section>



<footer class="mt-5 py-3 bg-light">
    <div class="container text-center">
        <p>&copy; 2023 Fee Automation System. All rights reserved.</p>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
