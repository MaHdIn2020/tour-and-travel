
<html lang="en"><head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Travel Website</title>


  <link rel="stylesheet" href="style.css">


  <!-- Bootstrap Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- Bootstrap Link -->




  <!-- Font Awesome Cdn -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <!-- Font Awesome Cdn -->




  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&amp;display=swap" rel="stylesheet">
  <!-- Google Fonts -->
</head>
<body>
 










  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg" id="navbar">
      <div class="container">
        <a class="navbar-brand" href="index.html" id="logo"><span>Fly</span> To Explore</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
          <span><i class="fa-solid fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="mynavbar">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link active" href="index.html">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#book">Book</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#packages">Packages</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#book">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#gallary">Gallary</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About Us</a>
            </li>
           
          </ul>
          <form class="d-flex">
            <input class="form-control me-2" type="text" placeholder="Search">
            <button class="btn btn-primary" type="button">Search</button>
          </form>
        </div>
      </div>
    </nav>
  <!-- Navbar End -->










  <!-- Home Section Start -->
  <div class="home">
      <div class="content">
          <h5>Hey! Explore The World</h5>
          <h1>Visit <span class="changecontent"></span></h1>
          <p>Lets...Fly in the sky.</p>
          <a href="#book">Book Now</a>
      </div>
  </div>
  <!-- Home Section End -->










  <!-- Section Book Start -->
  <section class="book" id="book">
    <div class="container">


      <div class="main-text">
        <h1><span>B</span>ook</h1>
      </div>
     
      <div class="row">


        <div class="col-md-6 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/young-woman-hiker-taking-photo-with-smartphone-mountains-peak-winter.jpg" alt="">
          </div>
        </div>


        <div class="col-md-6 py-3 py-md-0">
          <!-- <form action="booking.php" method="POST">
            <input type="text" class="form-control" placeholder="Name" required=""><br>
            <input type="text" class="form-control" placeholder="Where To(Package Name)" required=""><br>        
            <input type="date" class="form-control" placeholder="From Date" required=""><br>
            <input type="date" class="form-control" placeholder="To Date" required=""><br>
            <textarea class="form-control" rows="5" name="text" placeholder="Messages &amp; Details"></textarea>
            <input type="submit" value="Book Now" class="submit" required="">
          </form> -->
          <form action="booking.php" method="POST">
              <input type="text" class="form-control" name="destination" placeholder="Where To (Package Name)" required><br>
              <input type="date" class="form-control" name="from_date" placeholder="From Date" required><br>
              <input type="date" class="form-control" name="to_date" placeholder="To Date" required><br>
              <textarea class="form-control" rows="5" name="message" placeholder="Messages & Details"></textarea>
              <input type="submit" value="Book Now" class="submit">
          </form>
        </div>


      </div>
    </div>
  </section>
  <!-- Section Book End -->


  <?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all packages for display
$result = $conn->query("SELECT * FROM packages");

$conn->close();
?>

<!-- Section Packages Start -->
<section class="packages" id="packages">
    <div class="container">
        <div class="main-txt">
            <h1><span>P</span>ackages</h1>
        </div>

        <div class="row" style="margin-top: 30px;">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 py-3 py-md-0">
                <div class="card">
                    <!-- Use the correct field name for the image URL -->
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['pack_name']; ?>" class="card-img-top">
                    <div class="card-body">
                        <h3><?php echo $row['pack_name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <h6>Price: <strong>$<?php echo number_format($row['price'], 2); ?></strong></h6>
                        <a href="#book" class="btn btn-primary">Book Now</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
</section>

<!-- Section Packages End -->
















  <!-- Section Services Start -->
  <section class="services" id="services">
    <div class="container">


      <div class="main-txt">
        <h1><span>S</span>ervices</h1>
      </div>


      <div class="row" style="margin-top: 30px;">


        <div class="col-md-4 py-3 py-md-0">


          <div class="card">
            <i class="fas fa-hotel"></i>
            <div class="card-body">
              <h3>Affordable Hotel</h3>
              <p>We provide affordable hotels in a cheap price.</p>
            </div>
          </div>


        </div>
        <div class="col-md-4 py-3 py-md-0">


          <div class="card">
            <i class="fas fa-utensils"></i>
            <div class="card-body">
              <h3>Food &amp; Drinks</h3>
              <p>Maintain quality foods with hygiene.</p>
            </div>
          </div>


        </div>
        <div class="col-md-4 py-3 py-md-0">


          <div class="card">
            <i class="fas fa-bullhorn"></i>
            <div class="card-body">
              <h3>Safty Guide</h3>
              <p>Our professional guiding stuffs will guide.</p>
            </div>
          </div>


        </div>






      </div>




      <div class="row" style="margin-top: 30px;">


        <div class="col-md-4 py-3 py-md-0">


          <div class="card">
            <i class="fas fa-globe-asia"></i>
            <div class="card-body">
              <h3>Around The World</h3>
              <p>We have brances around the world.</p>
            </div>
          </div>


        </div>
        <div class="col-md-4 py-3 py-md-0">


          <div class="card">
            <i class="fas fa-plane"></i>
            <div class="card-body">
              <h3>Fastest Travel</h3>
              <p>We assure fastest travel by providing renowned flights.</p>
            </div>
          </div>


        </div>
        <div class="col-md-4 py-3 py-md-0">


          <div class="card">
            <i class="fas fa-hiking"></i>
            <div class="card-body">
              <h3>Adventures</h3>
              <p>We are also open for adventure tours.</p>
            </div>
          </div>


        </div>






      </div>


    </div>
  </section>
  <!-- Section Services End -->








  <!-- Section Gallary Start -->
  <section class="gallary" id="gallary">
    <div class="container">


      <div class="main-txt">
        <h1><span>G</span>allary</h1>
      </div>


      <div class="row" style="margin-top: 30px;">
        <div class="col-md-4 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/street-scape-positano-italy.jpg" alt="" height="230px">
          </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/tourist-from-mountain-top-sun-rays-man-wear-big-backpack-against-sun-light (1).jpg" alt="" height="230px">
          </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/tourist-from-mountain-top-sun-rays-man-wear-big-backpack-against-sun-light.jpg" alt="" height="230px">
          </div>
        </div>
      </div>




      <div class="row" style="margin-top: 30px;">
        <div class="col-md-4 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/wooden-bridge-koh-nangyuan-island-surat-thani-thailand.jpg" alt="" height="230px">
          </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/young-beautiful-woman-beige-t-shirt-summer-hat-holding-toy-airplane-looking-up.jpg" alt="" height="230px">
          </div>
        </div>
        <div class="col-md-4 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/male-traveler-montenegro-outdoors.jpg" alt="" height="230px">
          </div>
        </div>
      </div>


    </div>
  </section>
  <!-- Section Gallary End -->














  <!-- About Start -->
  <section class="about" id="about">
    <div class="container">


      <div class="main-txt">
        <h1>About <span>Us</span></h1>
      </div>


      <div class="row" style="margin-top: 50px;">


        <div class="col-md-6 py-3 py-md-0">
          <div class="card">
            <img src="Travel_tour/full-shot-woman-taking-selfie.jpg" alt="">
          </div>
        </div>


        <div class="col-md-6 py-3 py-md-0">
          <h2>How Travel Agency Work</h2>
          <p>We're here to offer you an unforgettable travel experience that will stay with you for a lifetime! Our expert team is dedicated to creating tailor-made itineraries for every budget and taste. We offer an array of travel packages, including accommodation, tours, flights, and more.</p>
          <button id="about-btn">Read More...</button>
        </div>


      </div>


    </div>
  </section>
  <!-- About End -->
















  <!-- Footer Start -->
  <footer id="footer">
    <h1><span>Fly</span> To Explore</h1>
    <p>We are promised to serve you the best.</p>
    <div class="social-links">
      <i class="fa-brands fa-twitter"></i>
      <i class="fa-brands fa-facebook"></i>
      <i class="fa-brands fa-instagram"></i>
      <i class="fa-brands fa-youtube"></i>
      <i class="fa-brands fa-pinterest-p"></i>
    </div>
    <div class="credit">
      <p>Designed By <a href="#">Nitro Coders</a></p>
    </div>
  </footer>
  <!-- Footer End -->




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>




</body></html>
