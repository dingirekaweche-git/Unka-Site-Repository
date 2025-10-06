<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Driver Page</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <!-- Owl Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">

  <!-- Custom Styles -->
  <link href="css/style.css" rel="stylesheet"/>
  <link href="css/responsive.css" rel="stylesheet"/>
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">


  <style>
    /* General Styles */
    body { font-family: 'Poppins', sans-serif; }
    .carousel-item img { height: 90vh; object-fit: cover; }
    .carousel-caption { background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; }
    
    /* Core Values & Sections */
    .core_values i, .why_drive i, .driver_steps i { margin-bottom: 10px; }
    .btn-warning { font-weight: 600; }
    
    /* Footer */
    .footer_section { background: #222; color: #fff; padding: 40px 0 20px; }
    .footer_section h5 { margin-bottom: 15px; color: #ff9800; }
    .footer_links a { display: block; color: #bbb; margin-bottom: 8px; text-decoration: none; }
    .footer_links a:hover { color: #ff9800; }
    .info_social { display: flex; gap: 15px; margin-top: 15px; }
    .info_social a img { width: 28px; height: 28px; }

    /* App Section */
    .app_section .btn-box img { height: 55px; }
    
    /* Driver FAQs */
/* Driver slider responsive height */
#driver_slider,
#driver_slider .carousel,
#driver_slider .carousel-inner,
#driver_slider .carousel-item {
  height: 80vh;         /* default for desktops */
  min-height: 400px;    /* ensures visibility on smaller screens */
}

/* Images cover the container fully */
#driver_slider .carousel-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;     /* fills space without stretching */
}

/* Mobile adjustments */
@media (max-width: 768px) {
  #driver_slider,
  #driver_slider .carousel,
  #driver_slider .carousel-inner,
  #driver_slider .carousel-item {
    height: 50vh;        /* smaller height for mobiles */
    min-height: 300px;   /* ensures image is still visible */
  }
  
  #driver_slider .carousel-caption h2 {
    font-size: 1.5rem;
  }
  
  #driver_slider .carousel-caption p {
    font-size: 1rem;
  }
  
  #driver_slider .carousel-caption .btn {
    padding: 8px 20px;
    font-size: 0.9rem;
  }
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
    /* General Styles */
    body { font-family: 'Poppins', sans-serif; }
    .carousel-item img { height: 90vh; object-fit: cover; }
    .carousel-caption { background: rgba(0,0,0,0.5); padding: 20px; border-radius: 10px; }
    
    /* Core Values & Sections */
    .core_values i, .why_drive i, .driver_steps i { margin-bottom: 10px; }
    .btn-warning { font-weight: 600; }
    
    /* Footer */
    .footer_section { background: #222; color: #fff; padding: 40px 0 20px; }
    .footer_section h5 { margin-bottom: 15px; color: #ff9800; }
    .footer_links a { display: block; color: #bbb; margin-bottom: 8px; text-decoration: none; }
    .footer_links a:hover { color: #ff9800; }
    .info_social { display: flex; gap: 15px; margin-top: 15px; }
    .info_social a img { width: 28px; height: 28px; }

    /* App Section */
    .app_section .btn-box img { height: 55px; }
    
    /* Driver FAQs */
    #driver_slider,
    #driver_slider .carousel,
    #driver_slider .carousel-inner,
    #driver_slider .carousel-item {
      height: 80vh;         /* default for desktops */
      min-height: 400px;    /* ensures visibility on smaller screens */
    }

    /* Images cover the container fully */
    #driver_slider .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;     /* fills space without stretching */
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
      #driver_slider,
      #driver_slider .carousel,
      #driver_slider .carousel-inner,
      #driver_slider .carousel-item {
        height: 50vh;        /* smaller height for mobiles */
        min-height: 300px;   /* ensures image is still visible */
      }
      
      #driver_slider .carousel-caption h2 {
        font-size: 1.5rem;
      }
      
      #driver_slider .carousel-caption p {
        font-size: 1rem;
      }
      
      #driver_slider .carousel-caption .btn {
        padding: 8px 20px;
        font-size: 0.9rem;
      }
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

    /* Floating Purchase Button */
    .floating-purchase-btn {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 70px;
      height: 70px;
      background: linear-gradient(135deg, #ff9800, #ff6600);
      color: white;
      border-radius: 50%;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      font-size: 14px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
      cursor: pointer;
      z-index: 1000;
      transition: all 0.3s ease;
      text-align: center;
      line-height: 1.2;
      padding: 5px;
    }

    .floating-purchase-btn:hover {
      transform: scale(1.1);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    .floating-purchase-btn i {
      font-size: 24px;
      margin-bottom: 3px;
    }

    .floating-purchase-btn span {
      font-size: 11px;
      font-weight: 600;
    }

    /* Float Purchase Modal */
    .float-purchase-modal .modal-content {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .float-purchase-modal .modal-header {
      background: linear-gradient(135deg, #ff9800, #ff6600);
      color: white;
      border-bottom: none;
      padding: 20px 25px;
    }

    .float-purchase-modal .modal-title {
      font-weight: 700;
      font-size: 1.5rem;
    }

    .float-purchase-modal .modal-body {
      padding: 25px;
    }

    .float-purchase-modal .form-group {
      margin-bottom: 20px;
    }

    .float-purchase-modal .form-label {
      font-weight: 600;
      color: #333;
      margin-bottom: 8px;
    }

    .float-purchase-modal .form-control {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 12px 15px;
      font-size: 1rem;
      transition: all 0.3s;
    }

    .float-purchase-modal .form-control:focus {
      border-color: #ff9800;
      box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
    }

    .float-purchase-modal .input-group-text {
      background-color: #f8f9fa;
      border: 1px solid #ddd;
      border-right: none;
      border-radius: 8px 0 0 8px;
    }

    .float-purchase-modal .input-group .form-control {
      border-left: none;
      border-radius: 0 8px 8px 0;
    }

    .float-purchase-modal .btn-purchase {
      background: linear-gradient(135deg, #ff9800, #ff6600);
      border: none;
      border-radius: 8px;
      color: white;
      font-weight: 600;
      padding: 12px 20px;
      width: 100%;
      font-size: 1.1rem;
      transition: all 0.3s;
      margin-top: 10px;
    }

    .float-purchase-modal .btn-purchase:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 102, 0, 0.4);
    }

    .purchase-summary {
      background-color: #f8f9fa;
      border-radius: 10px;
      padding: 15px;
      margin-top: 20px;
    }

    .purchase-summary h6 {
      color: #ff9800;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
      font-size: 0.9rem;
    }

    .summary-total {
      border-top: 1px solid #ddd;
      padding-top: 10px;
      margin-top: 10px;
      font-weight: 700;
      color: #333;
    }

    /* Mobile adjustments for floating button */
    @media (max-width: 768px) {
      .floating-purchase-btn {
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        font-size: 12px;
      }

      .floating-purchase-btn i {
        font-size: 20px;
      }

      .floating-purchase-btn span {
        font-size: 10px;
      }
    }

  </style>
</head>
<body>

<!-- Header -->
 
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
<!-- Slider Section -->
  
<!-- Driver Slider -->
<section id="driver_slider" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="images/driver1.jpg" class="d-block w-100" alt="Driver Banner">
      <div class="carousel-caption d-block caption-center">
        <h2>Become a Driver with Us</h2>
        <p>Join our growing network and start earning today!</p>
        <button class="btn btn-warning" data-toggle="modal" data-target="#driverRegisterModal">Register Now</button>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="images/driver2.jpg" class="d-block w-100" alt="Earn Money">
      <div class="carousel-caption d-block caption-center">
        <h2>Earn on Your Own Schedule</h2>
        <p>Drive when it works best for you and boost your income.</p>
        <button class="btn btn-warning" data-toggle="modal" data-target="#driverRegisterModal">Join Today</button>
      </div>
    </div>

        <div class="carousel-item">
      <img src="images/driver3.jpeg" class="d-block w-100" alt="Earn Money">
      <div class="carousel-caption d-block caption-center">
        <h2>Earn on Your Own Schedule</h2>
        <p>Drive when it works best for you and boost your income.</p>
        <button class="btn btn-warning" data-toggle="modal" data-target="#driverRegisterModal">Join Today</button>
      </div>
    </div>

  </div>

  <!-- Controls -->
  <a class="carousel-control-prev" href="#driver_slider" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  </a>
  <a class="carousel-control-next" href="#driver_slider" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
</section>

</div>

<!-- Core Values -->
<section class="core_values py-5 bg-white text-center">
  <div class="container">
    <h2 class="font-weight-bold mb-5">Our Core Values</h2>
    <div class="row">
      <div class="col-md-3">
        <i class="fas fa-handshake fa-2x text-warning"></i>
        <h6 class="mt-3">Trust</h6>
        <p>We build long-lasting relationships with drivers and riders.</p>
      </div>
      <div class="col-md-3">
        <i class="fas fa-shield-alt fa-2x text-warning"></i>
        <h6 class="mt-3">Safety</h6>
        <p>We prioritize safe journeys for both drivers and passengers.</p>
      </div>
      <div class="col-md-3">
        <i class="fas fa-thumbs-up fa-2x text-warning"></i>
        <h6 class="mt-3">Quality</h6>
        <p>High service standards ensure a smooth and reliable experience.</p>
      </div>
      <div class="col-md-3">
        <i class="fas fa-users fa-2x text-warning"></i>
        <h6 class="mt-3">Community</h6>
        <p>We empower local communities with opportunities and growth.</p>
      </div>
    </div>
  </div>
</section>

<!-- Why Drive With Us -->
<section class="why_drive py-5 bg-light text-center">
  <div class="container">
    <h2 class="font-weight-bold mb-5">Why Drive With Us?</h2>
    <div class="row">
      <div class="col-md-4">
        <i class="fas fa-wallet fa-2x text-warning"></i>
        <h5 class="mt-3">Great Earnings</h5>
        <p>Get paid weekly and earn bonuses for consistent performance.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-clock fa-2x text-warning"></i>
        <h5 class="mt-3">Flexible Hours</h5>
        <p>Work whenever you want – part-time or full-time, it’s your choice.</p>
      </div>
      <div class="col-md-4">
        <i class="fas fa-car fa-2x text-warning"></i>
        <h5 class="mt-3">Drive Your Vehicle</h5>
        <p>Use your own car, bike, or scooter and start delivering with ease.</p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works -->
<section class="driver_steps py-5 text-center">
  <div class="container">
    <h2 class="font-weight-bold mb-5">How It Works</h2>
    <div class="row">
      <div class="col-md-3">
        <i class="fas fa-user-plus fa-2x text-success"></i>
        <h6 class="mt-3">Step 1</h6>
        <p>Sign up online and upload your documents.</p>
      </div>
      <div class="col-md-3">
        <i class="fas fa-check-circle fa-2x text-success"></i>
        <h6 class="mt-3">Step 2</h6>
        <p>Get approved after verification.</p>
      </div>
      <div class="col-md-3">
        <i class="fas fa-mobile-alt fa-2x text-success"></i>
        <h6 class="mt-3">Step 3</h6>
        <p>Download our app and log in to your account.</p>
      </div>
      <div class="col-md-3">
        <i class="fas fa-map-marker-alt fa-2x text-success"></i>
        <h6 class="mt-3">Step 4</h6>
        <p>Start accepting trips and deliveries nearby.</p>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="driver_cta py-5 text-center text-white" style="background:#ff9800;">
  <div class="container">
    <h2 class="font-weight-bold">Ready to Start Driving?</h2>
    <p class="mb-4">Sign up today and join hundreds of drivers already earning with Unka.</p>
    <button class="btn btn-light btn-lg" data-toggle="modal" data-target="#driverRegisterModal">Register Now</button>
  </div>
</section>

<!-- Driver Registration Modal -->
<div class="modal fade" id="driverRegisterModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <h5 class="modal-title">Driver Registration</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="/register-driver" method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Full Name</label>
              <input type="text" class="form-control" name="driver_name" required>
            </div>
            <div class="form-group col-md-6">
              <label>Email Address</label>
              <input type="email" class="form-control" name="driver_email" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Phone Number</label>
              <input type="text" class="form-control" name="driver_phone" required>
            </div>
            <div class="form-group col-md-6">
              <label>NRC/ID Number</label>
              <input type="text" class="form-control" name="driver_nrc" required>
            </div>
          </div>
          <div class="form-group">
            <label>Vehicle Type</label>
            <select class="form-control" name="vehicle_type" required>
              <option value="">Select Vehicle</option>
              <option>Car</option>
              <option>Bike</option>
              <option>Van</option>
            </select>
          </div>
          <div class="form-group">
            <label>Upload Driver's License</label>
            <input type="file" class="form-control-file" name="driver_license" required>
          </div>
          <button type="submit" class="btn btn-warning btn-block">Submit Registration</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Driver App Section -->
<section class="app_section layout_padding2" style="background: #f9f9f9; padding: 60px 0;"> <div class="container"> <div class="row align-items-center"> <!-- Left Side: Driver App Info --> <div class="col-md-6"> <div class="detail-box"> <h2 style="font-size: 2.2rem; margin-bottom: 20px; font-weight: 700; color: #333;"> Download the <span style="color: #ff6600;">Unka Driver App</span> </h2> <div class="text-box" style="margin-bottom: 20px;"> <h5 style="font-size: 1.3rem; color: #ff6600; margin-bottom: 10px;"> 🚚 How to Download </h5> <p style="color: #555; line-height: 1.6;"> Get our driver app from your preferred store. Just click the Play Store or App Store icon, download, install, and you’re ready to start delivering. </p> </div> <div class="text-box" style="margin-bottom: 30px;"> <h5 style="font-size: 1.3rem; color: #ff6600; margin-bottom: 10px;"> ⚙️ How It Works </h5> <p style="color: #555; line-height: 1.6;"> Open the app, register as a driver, and start accepting delivery requests. Track trips, earnings, and manage your account—all from your phone. </p> </div> <div class="btn-box" style="display: flex; gap: 15px;"> <a href="#" target="_blank"> <img src="images/playstore.png" alt="Download on Play Store" style="height: 55px;"> </a> <a href="#" target="_blank"> <img src="images/appstore.png" alt="Download on App Store" style="height: 55px;"> </a> </div> </div> </div> <div class="col-md-6"> <div class="img-box"> <img src="images/mobile.png" alt=""> </div> </div> </div> </div> </section>

<!-- Driver FAQs -->
<!-- Driver FAQs -->
<section class="driver_faqs py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="font-weight-bold">Frequently Asked Questions</h2>
      <p class="text-muted">Find answers to the most common questions about becoming a driver with Unka.</p>
    </div>

    <div class="accordion" id="driverFaqAccordion">
      <!-- FAQ 1 -->
      <div class="card">
        <div class="card-header bg-warning faq-header" data-target="faq1">
          <h5 class="mb-0 text-white">How do I register as a driver?</h5>
        </div>
        <div id="faq1" class="faq-body" style="display: block;">
          <div class="card-body">Click "Register Now", fill in your details, upload documents, and submit your application. Our team will review it and approve you.</div>
        </div>
      </div>
      <!-- FAQ 2 -->
      <div class="card">
        <div class="card-header bg-warning faq-header" data-target="faq2">
          <h5 class="mb-0 text-white">What types of vehicles can I use?</h5>
        </div>
        <div id="faq2" class="faq-body" style="display: none;">
          <div class="card-body">You can use a car, bike, or van. Ensure your vehicle meets safety standards.</div>
        </div>
      </div>
      <!-- FAQ 3 -->
      <div class="card">
        <div class="card-header bg-warning faq-header" data-target="faq3">
          <h5 class="mb-0 text-white">How do I get paid?</h5>
        </div>
        <div id="faq3" class="faq-body" style="display: none;">
          <div class="card-body">Drivers are paid weekly via mobile money or bank transfer. Bonuses available for consistent trips.</div>
        </div>
      </div>
      <!-- FAQ 4 -->
      <div class="card">
        <div class="card-header bg-warning faq-header" data-target="faq4">
          <h5 class="mb-0 text-white">Can I work part-time?</h5>
        </div>
        <div id="faq4" class="faq-body" style="display: none;">
          <div class="card-body">Yes, you can work part-time or full-time at your convenience.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<section class="footer_section">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5>About Us</h5>
        <p class="text-muted">We connect drivers with riders for safe, reliable, and affordable transport solutions.</p>
      </div>
      <div class="col-md-4">
        <h5>Quick Links</h5>
        <div class="footer_links">
          <a href="#">Home</a>
          <a href="#">Driver Registration</a>
          <a href="#">FAQs</a>
          <a href="#">Support</a>
        </div>
      </div>
      <div class="col-md-4">
        <h5>Follow Us</h5>
        <div class="info_social">
          <a href="#"><img src="images/fb.png" alt="Facebook"></a>
          <a href="#"><img src="images/twitter.png" alt="Twitter"></a>
          <a href="#"><img src="images/linkedin.png" alt="LinkedIn"></a>
          <a href="#"><img src="images/instagram.png" alt="Instagram"></a>
        </div>
      </div>
    </div>
    <hr class="bg-dark">
    <p class="text-center text-muted">&copy; 2025 All Rights Reserved | Powered by <a href="https://unka.co.zm" class="text-warning">Unka</a></p>
  </div>
</section>
<!-- Floating Purchase Button -->
<div class="floating-purchase-btn" data-toggle="modal" data-target="#floatPurchaseModal">
  <i class="fas fa-money-bill-wave"></i>
  <span>Float Purchase</span>
</div>

<!-- Float Purchase Modal -->
<div class="modal fade float-purchase-modal" id="floatPurchaseModal" tabindex="-1" role="dialog" aria-labelledby="floatPurchaseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="floatPurchaseModalLabel">Float Purchase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="floatPurchaseForm">
          <div class="form-group">
            <label for="registeredNumber" class="form-label">Registered Number</label>
            <input type="text" class="form-control" id="registeredNumber" placeholder="Enter your registered number" required>
          </div>
          
          <div class="form-group">
            <label for="paymentNumber" class="form-label">Payment Number</label>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">+260</span>
              </div>
              <input type="tel" class="form-control" id="paymentNumber" placeholder="Enter payment number" required>
            </div>
          </div>
          
          <div class="form-group">
            <label for="amount" class="form-label">Amount (ZMW)</label>
            <input type="number" class="form-control" id="amount" placeholder="Enter amount" min="1" step="0.01" required>
          </div>
          
          <div class="purchase-summary">
            <h6>Purchase Summary</h6>
            <div class="summary-item">
              <span>Registered Number:</span>
              <span id="summaryRegistered">-</span>
            </div>
            <div class="summary-item">
              <span>Payment Number:</span>
              <span id="summaryPayment">-</span>
            </div>
            <div class="summary-item">
              <span>Amount:</span>
              <span id="summaryAmount">-</span>
            </div>
            <div class="summary-item summary-total">
              <span>Total:</span>
              <span id="summaryTotal">ZMW 0.00</span>
            </div>
          </div>
          
          <button type="submit" class="btn btn-purchase">
            <i class="fas fa-shopping-cart mr-2"></i> Complete Purchase
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Replace this line -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- With the full jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.querySelectorAll('.faq-header').forEach(header => {
    header.addEventListener('click', () => {
      const targetId = header.getAttribute('data-target');
      const target = document.getElementById(targetId);

      // Toggle the clicked FAQ
      const isVisible = target.style.display === 'block';
      target.style.display = isVisible ? 'none' : 'block';

      // Optional: close other FAQs
      document.querySelectorAll('.faq-body').forEach(body => {
        if(body.id !== targetId) body.style.display = 'none';
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

  document.querySelectorAll('.faq-header').forEach(header => {
    header.addEventListener('click', () => {
      const targetId = header.getAttribute('data-target');
      const target = document.getElementById(targetId);

      // Toggle the clicked FAQ
      const isVisible = target.style.display === 'block';
      target.style.display = isVisible ? 'none' : 'block';

      // Optional: close other FAQs
      document.querySelectorAll('.faq-body').forEach(body => {
        if(body.id !== targetId) body.style.display = 'none';
      });
    });
  });
  

  // Float Purchase Form Functionality
  $(document).ready(function() {
    // Update purchase summary in real-time
    $('#registeredNumber, #paymentNumber, #amount').on('input', function() {
      updatePurchaseSummary();
    });
    
    // Handle form submission
    $('#floatPurchaseForm').on('submit', function(e) {
      e.preventDefault();
      
      // Get form values
      const registeredNumber = $('#registeredNumber').val();
      const paymentNumber = '+260' + $('#paymentNumber').val();
      const amount = $('#amount').val();
      
      // Validate form
      if (!registeredNumber || !paymentNumber || !amount) {
        alert('Please fill in all fields');
        return;
      }
      
      // In a real application, you would send this data to your server
      // For this demo, we'll just show a success message
      alert(`Purchase successful!\n\nRegistered Number: ${registeredNumber}\nPayment Number: ${paymentNumber}\nAmount: ZMW ${amount}`);
      
      // Reset form and close modal
      $('#floatPurchaseForm')[0].reset();
      $('#floatPurchaseModal').modal('hide');
      updatePurchaseSummary();
    });
    
    function updatePurchaseSummary() {
      const registeredNumber = $('#registeredNumber').val() || '-';
      const paymentNumber = $('#paymentNumber').val() ? '+260' + $('#paymentNumber').val() : '-';
      const amount = $('#amount').val() ? 'ZMW ' + $('#amount').val() : '-';
      const total = $('#amount').val() ? 'ZMW ' + $('#amount').val() : 'ZMW 0.00';
      
      $('#summaryRegistered').text(registeredNumber);
      $('#summaryPayment').text(paymentNumber);
      $('#summaryAmount').text(amount);
      $('#summaryTotal').text(total);
    }
  });
</script>

</body>
</html>
