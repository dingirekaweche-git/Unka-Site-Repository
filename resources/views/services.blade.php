<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Unka Go</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

  
  <style>
    /* Service Tabs Styling */
    .service-tabs {
      display: flex;
      justify-content: center;
      margin-bottom: 40px;
      flex-wrap: wrap;
      gap: 10px;
    }
    
    .service-tab {
      padding: 12px 25px;
      border: none;
      background: #f0f0f0;
      border-radius: 30px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
      margin: 5px;
    }
    
    .service-tab.active {
      background: #ff9800;
      color: white;
    }
    
    .service-tab:hover:not(.active) {
      background: #e0e0e0;
    }
    
    /* Service Content Styling */
    .service-content {
      display: none;
    }
    
    .service-content.active {
      display: block;
    }
    
    .service-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .service-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    
    .service-card:hover {
      transform: translateY(-5px);
    }
    
    .service-image {
      height: 200px;
      overflow: hidden;
    }
    
    .service-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .service-details {
      padding: 20px;
    }
    
    .service-title {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: #333;
    }
    
    .service-price {
      color: #ff9800;
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: 15px;
    }
    
    .service-features {
      margin-bottom: 20px;
    }
    
    .service-feature {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }
    
    .service-feature i {
      color: #ff9800;
      margin-right: 10px;
    }
    
    .service-cta {
      display: block;
      width: 100%;
      padding: 12px;
      background: #ff9800;
      color: white;
      border: none;
      border-radius: 5px;
      font-weight: 600;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      transition: background 0.3s ease;
    }
    
    .service-cta:hover {
      background: #e68900;
    }
    
    /* Service Comparison Table */
    .comparison-section {
      padding: 60px 0;
      background: #f9f9f9;
    }
    
    .comparison-table {
      width: 100%;
      border-collapse: collapse;
      max-width: 1000px;
      margin: 0 auto;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .comparison-table th, 
    .comparison-table td {
      padding: 15px;
      text-align: center;
      border: 1px solid #eee;
    }
    
    .comparison-table th {
      background: #ff9800;
      color: white;
      font-weight: 600;
    }
    
    .comparison-table tr:nth-child(even) {
      background: #f8f8f8;
    }
    
    .feature-name {
      text-align: left;
      font-weight: 600;
      background: #f0f0f0;
    }
    
    /* How It Works Section */
    .how-it-works {
      padding: 60px 0;
      background: white;
    }
    
    .steps-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .step-card {
      flex: 1;
      min-width: 250px;
      max-width: 300px;
      text-align: center;
      padding: 30px 20px;
      background: #f9f9f9;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .step-number {
      width: 50px;
      height: 50px;
      background: #ff9800;
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0 auto 20px;
    }
    
    .step-title {
      font-size: 1.25rem;
      margin-bottom: 15px;
      color: #333;
    }
    .custom_nav-container {
  display: flex;
  align-items: center; /* vertically center logo and nav items */
  height: 70px;        /* fixed navbar height */
  padding: 0 20px;
}

/* Logo */
.logo-link {
  display: inline-block;
}

.logo-img {
  max-height: 150px; /* fits inside navbar */
  width: auto;
  display: block;
}
  </style>
</head>

<body class="sub_page">

  <div class="hero_area">
    <!-- header section strats -->
   <header class="header_section" id="mainHeader">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg custom_nav-container">
      <!-- Logo -->
      <a href="/" class="logo-link">
        <img src="images/logo.png" alt="Unka Go Logo" class="logo-img">
      </a>

      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Nav links -->
      <div class="collapse navbar-collapse mobile-menu" id="navbarSupportedContent">
        <button type="button" class="close-btn" data-toggle="collapse" data-target="#navbarSupportedContent">&times;</button>
        <ul class="navbar-nav ml-auto align-items-center">
           <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
     <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('driver') }}">Drivers</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('partner') }}">Partners</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
        </ul>
      </div>
    </nav>
  </div>
</header>
    <!-- end header section -->
  </div>

  <!-- Service Tabs Section -->
  <section class="service_section layout_padding" style="padding: 60px 0; background-color: #f9f9f9;">
    <div class="container" style="max-width: 1200px; margin: auto;">
      <h2 style="font-size: 2.5rem; line-height: 1.3; font-weight: 700; color: #ff9800; text-align: center; margin-bottom: 20px;">Our Services</h2>
      <p style="font-size: 1.1rem; margin-bottom: 50px; text-align: center;">
        Ride. Food. Deliver. Easy. Unka brings all your daily needs into one app.
      </p>
      
      <!-- Service Type Tabs -->
      <div class="service-tabs">
        <button class="service-tab active" data-service="ride">Ride Services</button>
        <button class="service-tab" data-service="delivery">Delivery Services</button>
      
      </div>
      
      <!-- Ride Services -->
      <div class="service-content active" id="ride-services">
        <h3 style="text-align: center; margin-bottom: 30px; color: #333;">Choose Your Ride</h3>
        <div class="service-grid">
          <!-- Classic Ride -->
          <div class="service-card">
            <div class="service-image">
              <img src="images/classic.jpeg" alt="Classic Ride">
            </div>
            <div class="service-details">
              <h4 class="service-title">Classic Ride</h4>
              <div class="service-price">Starting from ZMW 25</div>
              <div class="service-features">
                <div class="service-feature">
                  <i class="fas fa-user-friends"></i>
                  <span>Up to 4 passengers</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-suitcase"></i>
                  <span>2 medium bags</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-car"></i>
                  <span>Standard sedan</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-bolt"></i>
                  <span>Affordable pricing</span>
                </div>
              </div>
              <a href="#" class="service-cta">Book Now</a>
            </div>
          </div>
          
          <!-- Business Class -->
          <div class="service-card">
            <div class="service-image">
              <img src="images/business.jpeg" alt="Business Class">
            </div>
            <div class="service-details">
              <h4 class="service-title">Business Class</h4>
              <div class="service-price">Starting from ZMW 45</div>
              <div class="service-features">
                <div class="service-feature">
                  <i class="fas fa-user-friends"></i>
                  <span>Up to 4 passengers</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-suitcase"></i>
                  <span>3 large bags</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-car"></i>
                  <span>Premium vehicles</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-star"></i>
                  <span>Professional drivers</span>
                </div>
              </div>
              <a href="#" class="service-cta">Book Now</a>
            </div>
          </div>
          
          <!-- Bike Service -->
          <div class="service-card">
            <div class="service-image">
              <img src="images/bikes.png" alt="Bike Service">
            </div>
            <div class="service-details">
              <h4 class="service-title">Bike Service</h4>
              <div class="service-price">Starting from ZMW 15</div>
              <div class="service-features">
                <div class="service-feature">
                  <i class="fas fa-user"></i>
                  <span>1 passenger</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-helmet-safety"></i>
                  <span>Helmet provided</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-bolt"></i>
                  <span>Fastest option</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-tachometer-alt"></i>
                  <span>Beat the traffic</span>
                </div>
              </div>
              <a href="#" class="service-cta">Book Now</a>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Delivery Services -->
      <div class="service-content" id="delivery-services">
        <h3 style="text-align: center; margin-bottom: 30px; color: #333;">Delivery Options</h3>
        <div class="service-grid">
          <!-- Food Delivery -->
          <div class="service-card">
            <div class="service-image">
              <img src="images/bikes.png" alt="Food Delivery">
            </div>
            <div class="service-details">
              <h4 class="service-title">Food Delivery</h4>
              <div class="service-price">Delivery from ZMW 10</div>
              <div class="service-features">
                <div class="service-feature">
                  <i class="fas fa-utensils"></i>
                  <span>Restaurant meals</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-clock"></i>
                  <span>30-45 min delivery</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>Real-time tracking</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-temperature-high"></i>
                  <span>Thermal bags</span>
                </div>
              </div>
              <a href="#" class="service-cta">Order Food</a>
            </div>
          </div>
          
          <!-- Grocery Delivery -->
          <div class="service-card">
            <div class="service-image">
              <img src="images/bikes.png" alt="Grocery Delivery">
            </div>
            <div class="service-details">
              <h4 class="service-title">Grocery Delivery</h4>
              <div class="service-price">Delivery from ZMW 15</div>
              <div class="service-features">
                <div class="service-feature">
                  <i class="fas fa-shopping-basket"></i>
                  <span>Supermarket items</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-clock"></i>
                  <span>1-2 hour delivery</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-snowflake"></i>
                  <span>Cold storage</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-list"></i>
                  <span>Shopping assistance</span>
                </div>
              </div>
              <a href="#" class="service-cta">Order Groceries</a>
            </div>
          </div>
          
          <!-- Parcel Delivery -->
          <div class="service-card">
            <div class="service-image">
              <img src="images/bikes.png" alt="Parcel Delivery">
            </div>
            <div class="service-details">
              <h4 class="service-title">Parcel Delivery</h4>
              <div class="service-price">Starting from ZMW 20</div>
              <div class="service-features">
                <div class="service-feature">
                  <i class="fas fa-box"></i>
                  <span>Up to 10kg</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-bolt"></i>
                  <span>Same-day delivery</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>Real-time tracking</span>
                </div>
                <div class="service-feature">
                  <i class="fas fa-receipt"></i>
                  <span>Proof of delivery</span>
                </div>
              </div>
              <a href="#" class="service-cta">Send Package</a>
            </div>
          </div>
        </div>
      </div>
     
  </section>

  <!-- Service Comparison Section -->
  <section class="comparison-section">
    <div class="container">
      <h2 style="text-align: center; margin-bottom: 40px; color: #333;">Service Comparison</h2>
      <div class="table-responsive">
        <table class="comparison-table">
          <thead>
            <tr>
              <th>Feature</th>
              <th>Classic Ride</th>
              <th>Business Class</th>
              <th>Bike Service</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="feature-name">Max Passengers</td>
              <td>4</td>
              <td>4</td>
              <td>1</td>
            </tr>
            <tr>
              <td class="feature-name">Luggage Capacity</td>
              <td>2 medium bags</td>
              <td>3 large bags</td>
              <td>1 small bag</td>
            </tr>
            <tr>
              <td class="feature-name">Vehicle Type</td>
              <td>Standard sedan</td>
              <td>Premium vehicle</td>
              <td>Motorcycle</td>
            </tr>
            <tr>
              <td class="feature-name">Base Fare</td>
              <td>ZMW 25</td>
              <td>ZMW 45</td>
              <td>ZMW 15</td>
            </tr>
            <tr>
              <td class="feature-name">Waiting Time</td>
              <td>5-10 min</td>
              <td>3-7 min</td>
              <td>2-5 min</td>
            </tr>
            <tr>
              <td class="feature-name">Air Conditioning</td>
              <td><i class="fas fa-check" style="color: green;"></i></td>
              <td><i class="fas fa-check" style="color: green;"></i></td>
              <td><i class="fas fa-times" style="color: red;"></i></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works">
    <div class="container">
      <h2 style="text-align: center; margin-bottom: 50px; color: #333;">How It Works</h2>
      <div class="steps-container">
        <div class="step-card">
          <div class="step-number">1</div>
          <h3 class="step-title">Book</h3>
          <p>Open the app, enter your destination, and choose your service type</p>
        </div>
        <div class="step-card">
          <div class="step-number">2</div>
          <h3 class="step-title">Track</h3>
          <p>Watch your driver approach in real-time on the map</p>
        </div>
        <div class="step-card">
          <div class="step-number">3</div>
          <h3 class="step-title">Ride</h3>
          <p>Enjoy a safe and comfortable journey to your destination</p>
        </div>
        <div class="step-card">
          <div class="step-number">4</div>
          <h3 class="step-title">Pay</h3>
          <p>Choose from multiple payment options for a seamless experience</p>
        </div>
      </div>
    </div>
  </section>

  <!-- info section -->
  <section class="container-fluid footer_section" style="background: #222; color: #fff; padding: 60px 0 20px;">
    <div class="container">
      <div class="row">
        <!-- About -->
        <div class="col-md-4 mb-4">
          <h5 style="color: #ff9800; font-weight: 700;">About Us</h5>
          <p style="color: #bbb; line-height: 1.6; margin-top: 15px;">
            We provide fast, secure, and affordable delivery services. Our mission is to make your everyday logistics simple and hassle-free.
          </p>
        </div>

        <!-- Quick Links -->
        <div class="col-md-4 mb-4 footer_links">
          <h5 style="color: #ff9800; font-weight: 700;">Quick Links</h5>
          <ul style="list-style: none; padding: 0; margin-top: 15px;">
            <li><a href="#" style="color: #bbb; text-decoration: none;">Home</a></li>
            <li><a href="#" style="color: #bbb; text-decoration: none;">About</a></li>
            <li><a href="#" style="color: #bbb; text-decoration: none;">Services</a></li>
            <li><a href="#" style="color: #bbb; text-decoration: none;">Contact</a></li>
            <li><a href="#" style="color: #bbb; text-decoration: none;">Download App</a></li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="col-md-4 mb-4">
          <h5 style="color: #ff9800; font-weight: 700;">Get in Touch</h5>
          <!-- Social icons -->
          <div class="info_social" style="display: flex; gap: 15px; margin-top: 20px;">
            <div>
              <a href="#"><img src="images/fb.png" alt="Facebook" style="width: 32px; height: 32px;"></a>
            </div>
            <div>
              <a href="#"><img src="images/twitter.png" alt="Twitter" style="width: 32px; height: 32px;"></a>
            </div>
            <div>
              <a href="#"><img src="images/linkedin.png" alt="LinkedIn" style="width: 32px; height: 32px;"></a>
            </div>
            <div>
              <a href="#"><img src="images/instagram.png" alt="Instagram" style="width: 32px; height: 32px;"></a>
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom line -->
      <div class="text-center" style="margin-top: 40px; border-top: 1px solid #444; padding-top: 20px;">
        <p style="color: #aaa; margin: 0;">
          &copy; 2025 All Rights Reserved | <span style="color: #ff9800;">Unka</span>
        </p>
      </div>
    </div>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>

  <!-- Service Tabs Script -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tabs = document.querySelectorAll('.service-tab');
      const contents = document.querySelectorAll('.service-content');
      
      tabs.forEach(tab => {
        tab.addEventListener('click', function() {
          // Remove active class from all tabs and contents
          tabs.forEach(t => t.classList.remove('active'));
          contents.forEach(c => c.classList.remove('active'));
          
          // Add active class to clicked tab
          this.classList.add('active');
          
          // Show corresponding content
          const serviceType = this.getAttribute('data-service');
          document.getElementById(`${serviceType}-services`).classList.add('active');
        });
      });
    });
   document.addEventListener("DOMContentLoaded", function() {
    const currentPath = window.location.pathname;

    document.querySelectorAll(".navbar-nav .nav-link").forEach(link => {
        // Get the path from the link (ignoring domain)
        const linkPath = new URL(link.href).pathname;

        if (linkPath === currentPath) {
            link.classList.add("active"); // highlight the link
        } else {
            link.classList.remove("active");
        }
    });
});

    // Show/hide header on scroll
let prevScrollPos = window.pageYOffset;
let header = document.getElementById("mainHeader");

window.onscroll = function() {
  let currentScrollPos = window.pageYOffset;
  if (prevScrollPos > currentScrollPos) {
    header.style.top = "0";   // scrolling up → show header
  } else {
    header.style.top = "-80px"; // scrolling down → hide header
  }
  prevScrollPos = currentScrollPos;
}
  </script>

</body>

</html>