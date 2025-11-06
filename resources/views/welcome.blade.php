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
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
<link rel="manifest" href="/site.webmanifest">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">


  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<!-- Custom styles for this template -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet" />
<!-- Responsive style -->
<link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />
  <style>
  /* Fix horizontal scroll issues */
body {
    overflow-x: hidden;
    max-width: 100vw;
}

.container-fluid {
    padding-left: 15px;
    padding-right: 15px;
}

/* Ensure carousel images don't cause overflow */
.carousel-inner img {
    max-width: 100%;
    height: auto;
}

/* Constrain all sections */
section {
    max-width: 100vw;
    overflow: hidden;
}

/* Fix floating buttons positioning */
.floating-faq-btn,
.floating-promo-btn {
    right: 20px; /* Ensure they're within viewport */
}

/* Ensure modals don't cause overflow */
.faq-modal,
.promo-modal {
    left: 0;
    right: 0;
}

/* Fix service grid on mobile */
@media (max-width: 768px) {
    .services-grid {
        flex-direction: column;
        align-items: center;
    }
    
    .service-box {
        width: 100%;
        max-width: 300px;
    }
}
/* Fix horizontal scroll - Add this at the end of your style tag */
html, body {
    overflow-x: hidden;
    width: 100%;
    position: relative;
}

* {
    box-sizing: border-box;
}

.container-fluid {
    max-width: 100vw;
}

.row {
    margin-left: 0;
    margin-right: 0;
}

/* Ensure no element exceeds viewport width */
img, .carousel-inner, .service-box, .box {
    max-width: 100%;
}
  .tab-buttons {
    display: flex;
    justify-content: center;
    margin-bottom: 15px;
  }
  .tab-buttons button {
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    background: #f0f0f0;
    margin: 0 5px;
    font-weight: bold;
    border-radius: 5px;
  }
  .tab-buttons button.active {
    background: #ff9800; /* Orange highlight */
    color: #fff;
  }
  .form-tab {
    display: none;
  }
  .form-tab.active {
    display: block;
  }
  .slider_form {
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: #fff;
    max-width: 400px;
    margin: auto;
  }
  .slider_form input {
    width: 100%;
    margin-bottom: 10px;
    padding: 8px;
  }
  .btm_input {
    text-align: center;
  }
  .btm_input button {
    background: #ff9800;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
   .driver-form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px; /* space between inputs */
  }

  /* Floating FAQ Button */
  .floating-faq-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: #ff9800;
    color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    z-index: 1000;
    transition: all 0.3s ease;
  }
  
  .floating-faq-btn:hover {
    transform: scale(1.1);
    background: #ff8533;
  }
  
  .floating-faq-btn i {
    font-size: 24px;
  }
  
  /* Floating Promo Button */
  .floating-promo-btn {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: #4caf50;
    color: white;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    z-index: 1000;
    transition: all 0.3s ease;
  }
  
  .floating-promo-btn:hover {
    transform: scale(1.1);
    background: #67bb6a;
  }
  
  .floating-promo-btn i {
    font-size: 24px;
  }
  
  /* FAQ Modal */
  .faq-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.7);
    z-index: 1001;
    justify-content: center;
    align-items: center;
  }
  
  .faq-content {
    background: white;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    border-radius: 10px;
    padding: 20px;
    overflow-y: auto;
    position: relative;
  }
  
  .close-faq {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
    color: #777;
  }
  
  .faq-item {
    margin-bottom: 15px;
    border-bottom: 1px solid #eee;
    padding-bottom: 15px;
  }
  
  .faq-question {
    font-weight: bold;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .faq-answer {
    margin-top: 10px;
    display: none;
    color: #555;
  }
  
/* Promo Modal container */
.promo-modal {
  display: none; /* hidden by default */
  position: fixed;
  inset: 0; /* full viewport */
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6); /* dark overlay */
  z-index: 9999; /* above header */
  display: flex;
  align-items: flex-start; /* start from top */
  justify-content: center;
  padding: 80px 20px 20px; /* push content down below header */
  overflow-y: auto; /* allow scroll if content is taller */
}

/* Promo content */
.promo-content {
  background: #fff;
  padding: 25px;
  border-radius: 12px;
  text-align: center;
  max-width: 420px;
  width: 100%;
  box-shadow: 0 6px 20px rgba(0,0,0,0.25);
  position: relative;
  z-index: 10000;
  animation: fadeInScale 0.3s ease;
}

/* Close button */
.close-promo {
  position: absolute;
  top: 12px;
  right: 15px;
  font-size: 26px;
  font-weight: bold;
  color: #555;
  cursor: pointer;
  transition: color 0.2s;
}
.close-promo:hover {
  color: #ff9800;
}

/* Promo code */
.promo-code {
  background: #ffefd9;
  padding: 12px 20px;
  border-radius: 6px;
  font-weight: bold;
  color: #ff9800;
  margin: 18px 0;
  display: inline-block;
  font-size: 1.2rem;
  letter-spacing: 1px;
}

/* CTA */
.promo-cta {
  background: #ff9800;
  color: #fff;
  padding: 12px 25px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 18px;
  font-weight: bold;
  font-size: 1rem;
  transition: background 0.3s;
}
.promo-cta:hover {
  background: #e68900;
}

/* Responsive */
@media (max-width: 768px) {
  .promo-content {
    max-width: 95%;
    padding: 20px;
  }
  .promo-code {
    font-size: 1rem;
    padding: 10px 15px;
  }
  .promo-cta {
    width: 100%;
    font-size: 1rem;
  }
}

/* Animation */
@keyframes fadeInScale {
  from { opacity: 0; transform: scale(0.9); }
  to { opacity: 1; transform: scale(1); }
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
.carousel-caption {
  background: rgba(0, 0, 0, 0.5); /* semi-transparent background */
  padding: 20px;
  border-radius: 10px;
}

.carousel-caption h2 {
  font-size: 2.5rem;
  font-weight: bold;
  color: #fff;
}

.carousel-caption p {
  font-size: 1.2rem;
  color: #f8f9fa;
}
  .small-img {
    width: 250px;
    height: auto;
  }

</style>
</head>

<body>

  <!-- Floating FAQ Button -->
  <div class="floating-faq-btn">
    <i class="fas fa-question"></i>
  </div>
  
  <!-- Floating Promo Button -->
  <div class="floating-promo-btn">
    <i class="fas fa-gift"></i>
  </div>
  
  <!-- FAQ Modal -->
  <div class="faq-modal">
    <div class="faq-content">
      <span class="close-faq">&times;</span>
      <h2>Frequently Asked Questions</h2>
      
      <div class="faq-item">
        <div class="faq-question">
          How do I book a ride with Unka Go?
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
          Download the Unka Go app from the Play Store or App Store, create an account, enter your destination, and confirm your ride. You'll be matched with a nearby driver.
        </div>
      </div>
      
      <div class="faq-item">
        <div class="faq-question">
          What payment methods do you accept?
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
          We accept cash, mobile money (Zambia-specific options), and credit/debit cards. In-app payments are secure and convenient.
        </div>
      </div>
      
      <div class="faq-item">
        <div class="faq-question">
          How long does food delivery take?
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
          Delivery times vary based on restaurant preparation and distance, but most orders arrive within 30-45 minutes. You can track your order in real-time through the app.
        </div>
      </div>
      
      <div class="faq-item">
        <div class="faq-question">
          Can I schedule a ride in advance?
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
          Yes! Our app allows you to schedule rides up to 24 hours in advance. Perfect for airport trips, meetings, or any important appointments.
        </div>
      </div>
      
      <div class="faq-item">
        <div class="faq-question">
          How do I become an Unka Go driver?
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
          You can apply directly through our website or visit our office. Requirements include a valid driver's license, vehicle insurance, and meeting our vehicle standards.
        </div>
      </div>
      
      <div class="faq-item">
        <div class="faq-question">
          Is there a discount for first-time users?
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
          Yes! Use promo code WELCOME20 for 20% off your first ride or delivery. The promo code can be applied in the payment section before confirming your order.
        </div>
      </div>
      
      <div class="faq-item">
        <div class="faq-question">
          How does Unka Go ensure safety?
          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="faq-answer">
          All our drivers are verified with background checks. We also offer features like share ride details, emergency assistance, and 24/7 customer support for any concerns.
        </div>
      </div>
    </div>
  </div>
  
  <!-- Promo Modal -->
  <div class="promo-modal">
    <div class="promo-content">
      <span class="close-promo">&times;</span>
      <h2>Special Promotion!</h2>
      <p>Enjoy <strong>20% OFF</strong> your first ride or food delivery with Unka Go!</p>
      <div class="promo-code">UNKA20</div>
      <p>Use this code when booking through our app</p>
      <img src="images/appdownload.jpeg" alt="Special Offer" class="promo-image">
      <p>Offer valid for new users only. Expires in 30 days.</p>
      <button class="promo-cta">Download App Now</button>
    </div>
  </div>

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
        <li class="nav-item"><a class="nav-link" href="{{ route('purchase') }}">Float Purchase</a></li>
         <li class="nav-item"><a class="nav-link" href="{{ route('wallet-top-up') }}">Wallet Top Up</a></li>
<li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>

        </ul>
      </div>
    </nav>
  </div>
</header>



    <!-- end header section -->
    <!-- slider section -->
   <section class="slider_section">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-7">
        <div class="box">
         

          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
              <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">

              <!-- Slide 1 -->
              <div class="carousel-item active">
                <div class="img-box">
                  <img src="images/unka_go.png" alt="">
                </div>
                <div class="carousel-caption d-none d-md-block">
                  <h3>Fast & Reliable</h3>
                  <p>Experience quick and safe transport with Unka Go.</p>
                </div>
              </div>

              <!-- Slide 2 -->
              <div class="carousel-item">
                <div class="img-box">
                  <img src="images/Unka 2.png" alt="">
                </div>
                <div class="carousel-caption d-none d-md-block">
                  <h3>Affordable Rides</h3>
                  <p>Get to your destination at the best price.</p>
                </div>
              </div>

              <!-- Slide 3 -->
              <div class="carousel-item">
                <div class="img-box">
                  <img src="images/unka 3.png" alt="">
                </div>
                <div class="carousel-caption d-none d-md-block">
                  <h3>Anywhere, Anytime</h3>
                  <p>We’re available whenever you need us.</p>
                </div>
              </div>


             
            </div>
          </div>

         
        </div>
      </div>

          <div class="col-lg-4 col-md-5 ">
<div class="tab-buttons">
  <button class="tab-btn active" onclick="showForm('driver')">Driver</button>
  <button class="tab-btn" onclick="showForm('partner')">Partner</button>
</div>

<!-- Driver Registration -->
<div id="driver" class="form-tab active">
  <div class="slider_form">
    <h4>Driver Registration</h4>
    <form action="" method="post">
      <input type="text" name="driver_name" placeholder="Full Name" required>
      <input type="email" name="driver_email" placeholder="Email Address" required>
      <input type="text" name="driver_phone" placeholder="Phone Number" required>
      <input type="text" name="driver_nrc" placeholder="NRC/ID Number" required>
      <input type="text" name="driver_location" placeholder="City / Province" required>
      <input type="text" name="vehicle_type" placeholder="Vehicle Type (Car, Bike, Van)" required>
      <input type="text" name="vehicle_plate" placeholder="Vehicle Plate Number" required>
      <div class="btm_input">
        <button type="submit">Register as Driver</button>
      </div>
    </form>
  </div>
</div>

<!-- Partner Registration -->
<div id="partner" class="form-tab">
  <div class="slider_form">
    <h4>Partner Registration</h4>
    <form action="" method="post">
      <input type="text" name="partner_name" placeholder="Business/Partner Name" required>
      <input type="email" name="partner_email" placeholder="Email Address" required>
      <input type="text" name="partner_phone" placeholder="Phone Number" required>
      <input type="text" name="partner_location" placeholder="City / Province" required>
      <input type="text" name="business_type" placeholder="Business Type (Fleet Owner, Agency)" required>
      <div class="btm_input">
        <button type="submit">Register as Partner</button>
      </div>
    </form>
  </div>
</div>


          </div>
        </div>
      </div>

    </section>
    <!-- end slider section -->
  </div>

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-md-5 offset-lg-2 offset-md-1">
     <div class="detail-box">
    <h2 style="font-size: 2.5rem; line-height: 1.3; font-weight: 700; color: #ff9800;">
        About <br>
        Unka Go
    </h2>
    <p>
        Ride. Food. Deliver. Easy. Unka is Zambia's all-in-one app for taxi rides, food delivery, and parcel pickups. Whether you're heading across town, ordering your favorite meal, or sending a package — Unka makes it fast, affordable, and reliable. Enjoy safe, local taxi rides, quick food and grocery deliveries, and convenient parcel services, all in one app.
    </p>
    <p>
        Why choose Unka? We're proudly Zambian, supporting local drivers, businesses, and communities. Our services are safe, reliable, and affordable, offering fair fares, student discounts, and promotions. With Unka, you can earn rewards, get loyalty points, and enjoy referral bonuses while handling your daily commutes, meal deliveries, and parcel pickups with ease.
    </p>
    <a href="">
        Read More
    </a>
</div>

        </div>
        <div class="col-md-6">
          <div class="img-box">
            <img src="images/about_img.png" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->

  <!-- service section -->
<section class="service_section layout_padding" style="padding: 60px 0; background-color: #f9f9f9;">
    <div class="container" style="max-width: 1200px; margin: auto; text-align: center;">
        <h2 style="font-size: 2.5rem; line-height: 1.3; font-weight: 700; color: #ff9800;">Our Services</h2>
        <p style="font-size: 1.1rem; margin-bottom: 50px;">
            Ride. Food. Deliver. Easy. Unka brings all your daily needs into one app.
        </p>
        
        <div class="services-grid" style="display: flex; justify-content: space-around; flex-wrap: wrap; gap: 40px;">
            
            <!-- Taxi Rides -->
            <div class="service-box" style="background: #fff; padding: 30px; border-radius: 15px; width: 300px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-taxi" style="font-size: 3rem; color: #ff9800; margin-bottom: 20px;"></i>
                <h3 style="font-size: 1.5rem; margin-bottom: 15px;">Fast & Affordable Taxi Rides</h3>
                <p>
                    Skip the hassle of negotiating fares. Book a safe, local taxi in seconds with trained drivers and transparent pricing.
                </p>
            </div>
            
            <!-- Food & Grocery Delivery -->
            <div class="service-box" style="background: #fff; padding: 30px; border-radius: 15px; width: 300px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-utensils" style="font-size: 3rem; color: #4caf50; margin-bottom: 20px;"></i>
                <h3 style="font-size: 1.5rem; margin-bottom: 15px;">Food & Grocery Delivery</h3>
                <p>
                    Order from your favorite restaurants, cafes, or grocery stores and have it delivered straight to your door with real-time tracking.
                </p>
            </div>
            
            <!-- Parcel Pickup & Delivery -->
            <div class="service-box" style="background: #fff; padding: 30px; border-radius: 15px; width: 300px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-box" style="font-size: 3rem; color: #2196f3; margin-bottom: 20px;"></i>
                <h3 style="font-size: 1.5rem; margin-bottom: 15px;">Parcel Pickup & Delivery</h3>
                <p>
                    Send or receive packages easily with trusted drivers who handle your parcels with care — same-day or scheduled delivery.
                </p>
            </div>
            
        </div>
    </div>
</section>
  <!-- end service section -->



  <!-- client section -->

<section class="client_section layout_padding-bottom" style="padding: 60px 0; background-color: #f9f9f9;">
  <div class="container">
    <div class="heading_container text-center" style="margin-bottom: 50px;">
       <h2 style="font-size: 2.5rem; line-height: 1.3; font-weight: 700;">
        What Our<span style="color: #ff9800;"> Clients Say</span>
      </h2>
    </div>
    
    <div class="client_container">
      <div class="carousel-wrap">
        <div class="owl-carousel">
          
          <!-- Client 1 -->
          <div class="item">
            <div class="box" style="background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;">
              <div class="img-box" style="margin-bottom: 20px;">
                <img src="images/ceo.jpeg" alt="Aliqua" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #ff9800;">
              </div>
              <div class="detail-box">
                <h3 style="font-size: 1.25rem; margin-bottom: 15px;">Cobet</h3>
                <p style="font-size: 1rem; color: #555;">
                  "Unka has completely transformed the way I get around town and get my packages delivered. Fast, reliable, and easy to use!"
                </p>
                <img src="images/quote.png" alt="" style="margin-top: 15px; width: 30px;">
              </div>
            </div>
          </div>
          
          <!-- Client 2 -->
          <div class="item">
            <div class="box" style="background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;">
              <div class="img-box" style="margin-bottom: 20px;">
                <img src="images/mary.png" alt="Liqua" style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #4caf50;">
              </div>
              <div class="detail-box">
                <h3 style="font-size: 1.25rem; margin-bottom: 15px;">Mary</h3>
                <p style="font-size: 1rem; color: #555;">
                  "I love using Unka for food delivery and parcel pickups. Everything arrives on time, and the app is super easy to navigate."
                </p>
                <img src="images/quote.png" alt="" style="margin-top: 15px; width: 30px;">
              </div>
            </div>
          </div>
          
          <!-- Add more clients as needed -->
          
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- end client section -->

  <!-- contact section -->
<section class="contact_section layout_padding-bottom" style="padding: 60px 0;">
  <div class="container" style="max-width: 1200px; margin: auto; display: flex; flex-wrap: wrap; gap: 40px;">
    
    <!-- Get in Touch -->
    <div class="contact-info" style="flex: 1; min-width: 350px;">
      <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 10px; position: relative;">
        GET IN TOUCH
        <span style="position: absolute; bottom: -5px; left: 0; width: 50px; height: 3px; background-color: orange;"></span>
      </h2>
      <p style="margin-bottom: 30px;">
        If you have any questions or need assistance, feel free to reach out to us. We're here to help!
      </p>
      
      <div class="contact-boxes" style="display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Address -->
        <div style="display: flex; align-items: center; gap: 15px; border: 1px solid #ddd; padding: 15px; border-radius: 10px; background: #fff;">
          <i class="fas fa-map-marker-alt" style="color: orange; font-size: 1.5rem;"></i>
          <div>
            <strong>Address</strong><br>
            Counting House Square, Thabo Mbeki Road, Lusaka, Lusaka Province, Zambia
          </div>
        </div>
        
        <!-- Phone -->
        <div style="display: flex; align-items: center; gap: 15px; border: 1px solid #ddd; padding: 15px; border-radius: 10px; background: #fff;">
          <i class="fas fa-phone-alt" style="color: orange; font-size: 1.5rem;"></i>
          <div>
            <strong>Phone Number</strong><br>
           +260980410697
          </div>
        </div>
        
        <!-- Email -->
        <div style="display: flex; align-items: center; gap: 15px; border: 1px solid #ddd; padding: 15px; border-radius: 10px; background: #fff;">
          <i class="fas fa-envelope" style="color: orange; font-size: 1.5rem;"></i>
          <div>
            <strong>Email</strong><br>
            info@unka.co.zm
          </div>
        </div>
        
      </div>
    </div>
    
    <!-- Useful Links -->
    <div class="useful-links" style="flex: 1; min-width: 250px;">
      <h2 style="font-size: 2rem; font-weight: bold; margin-bottom: 10px; position: relative;">
        USEFUL LINKS
        <span style="position: absolute; bottom: -5px; left: 0; width: 50px; height: 3px; background-color: orange;"></span>
      </h2>
      <p style="margin-bottom: 30px;">Check out these helpful resources</p>
      
      <div class="links-list" style="display: flex; flex-direction: column; gap: 15px;">
        <a href="{{ url('/') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #000;">
          <i class="fas fa-arrow-right" style="color: orange;"></i> Dashboard
        </a>
        <a href="{{ route('about') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #000;">
          <i class="fas fa-arrow-right" style="color: orange;"></i> About
        </a>
        <a href="{{ route('services') }}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #000;">
          <i class="fas fa-arrow-right" style="color: orange;"></i> Services
        </a>
        <a href="{{route('terms')}}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #000;">
          <i class="fas fa-arrow-right" style="color: orange;"></i> Terms of Service
        </a>
        <a href="{{route('policies')}}" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: #000;">
          <i class="fas fa-arrow-right" style="color: orange;"></i> Privacy Policy
        </a>
      </div>
    </div>
    
  </div>
</section>

  <!-- end contact section -->

  <!-- app section -->

  <section class="app_section layout_padding2">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
  <div class="detail-box">
    <h2 style="font-size: 2rem; margin-bottom: 20px; font-weight: 700;">
      Download Our App
    </h2>

    <div class="text-box" style="margin-bottom: 20px;">
      <h5 style="font-size: 1.25rem; color: #fff; margin-bottom: 10px;">
        How to Download
      </h5>
      <p style="color: #555; line-height: 1.6;">
        Get our app quickly from your preferred store. Simply click on the Play Store or App Store icon below, download, and install to start enjoying seamless deliveries and services.
      </p>
    </div>

    <div class="text-box" style="margin-bottom: 30px;">
      <h5 style="font-size: 1.25rem; color: #fff; margin-bottom: 10px;">
        How It Works
      </h5>
      <p style="color: #555; line-height: 1.6;">
        Once installed, open the app, register or log in, and start using our service. Place orders, track deliveries, and manage your account easily—all from your phone.
      </p>
    </div>

    <div class="btn-box" style="display: flex; gap: 15px;">
      <a href="https://play.google.com/store/apps/details?id=unkago.taxi.zambia.passenger" target="_blank">
        <img src="images/playstore.png" alt="Download on Play Store" style="height: 50px;">
      </a>
      <a href="https://play.google.com/store/apps/details?id=unkago.taxi.zambia.passenger" target="_blank">
        <img src="images/appstore.png" alt="Download on App Store" style="height: 50px;">
      </a>
    </div>
  </div>
</div>

        <div class="col-md-6">
          <div class="img-box">
            <img src="images/passag-portrait.png" alt="" class="small-img">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end app section -->

  <!-- why section -->

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

<section class="why_section layout_padding" style="padding: 60px 0; background-color: #f9f9f9;">
  <div class="container">
    <div class="heading_container text-center" style="margin-bottom: 50px;">
      <h2 style="font-size: 2.5rem; line-height: 1.3; font-weight: 700;">
        Why <span style="color: #ff9800;">Choose Us</span>
      </h2>
    </div>

    <div class="why_features" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; text-align: center; align-items: start;">
      
      <div class="feature" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <i class="fas fa-truck" style="font-size: 40px; color: #ff9800;"></i>
        <h5 style="font-size: 1.25rem; margin: 0;">Best Drivers</h5>
        <p style="color: #555; font-size: 0.95rem;">Professional drivers ensuring timely deliveries with care and efficiency.</p>
      </div>

      <div class="feature" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <i class="fas fa-shield-alt" style="font-size: 40px; color: #4caf50;"></i>
        <h5 style="font-size: 1.25rem; margin: 0;">Safe & Secure</h5>
        <p style="color: #555; font-size: 0.95rem;">Your parcels are protected every step of the way with our trusted system.</p>
      </div>

      <div class="feature" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <i class="fas fa-headset" style="font-size: 40px; color: #2196f3;"></i>
        <h5 style="font-size: 1.25rem; margin: 0;">24x7 Support</h5>
        <p style="color: #555; font-size: 0.95rem;">Our customer support team is always available for assistance.</p>
      </div>

      <div class="feature" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <i class="fas fa-bolt" style="font-size: 40px; color: #ff5722;"></i>
        <h5 style="font-size: 1.25rem; margin: 0;">Fast Delivery</h5>
        <p style="color: #555; font-size: 0.95rem;">Quick and reliable delivery to ensure your packages arrive on time.</p>
      </div>

      <div class="feature" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <i class="fas fa-mobile-alt" style="font-size: 40px; color: #9c27b0;"></i>
        <h5 style="font-size: 1.25rem; margin: 0;">Easy to Use</h5>
        <p style="color: #555; font-size: 0.95rem;">User-friendly app for placing orders, tracking, and managing accounts.</p>
      </div>

      <div class="feature" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <i class="fas fa-wallet" style="font-size: 40px; color: #ffc107;"></i>
        <h5 style="font-size: 1.25rem; margin: 0;">Affordable</h5>
        <p style="color: #555; font-size: 0.95rem;">Cost-effective delivery solutions without compromising quality.</p>
      </div>

      <div class="feature" style="display: flex; flex-direction: column; align-items: center; gap: 15px;">
        <i class="fas fa-gift" style="font-size: 40px; color: #ff4081;"></i>
        <h5 style="font-size: 1.25rem; margin: 0;">Best Offers</h5>
        <p style="color: #555; font-size: 0.95rem;">Exclusive deals and discounts for the best value on deliveries.</p>
      </div>

    </div>
  </div>
</section>



  <!-- end why section -->

 <!-- Footer -->
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
          <li><a href="" style="color: #bbb; text-decoration: none;">Dashboard</a></li>
          <li><a href="{{ route('about') }}" style="color: #bbb; text-decoration: none;">About</a></li>
          <li><a href="{{ route('services') }}" style="color: #bbb; text-decoration: none;">Services</a></li>
          <li><a href="#" style="color: #bbb; text-decoration: none;">Download App</a></li>
        </ul>
      </div>

      <!-- Contact -->
      <div class="col-md-4 mb-4">
        <h5 style="color: #ff9800; font-weight: 700;">Get in Touch</h5>
        <!-- Social icons -->
        <div class="info_social" style="display: flex; gap: 15px; margin-top: 20px;">
          <div>
            <a href="https://www.facebook.com/unkagotaxi"><img src="images/fb.png" alt="Facebook" style="width: 32px; height: 32px;"></a>
          </div>
          <div>
            <a href="#"><img src="images/twitter.png" alt="Twitter" style="width: 32px; height: 32px;"></a>
          </div>
          <div>
            <a href="#"><img src="images/linkedin.png" alt="LinkedIn" style="width: 32px; height: 32px;"></a>
          </div>
          <div>
            <a href="https://www.instagram.com/unka.go/"><img src="images/instagram.png" alt="Instagram" style="width: 32px; height: 32px;"></a>
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
  <!-- end info section -->

  <!-- footer section -->
<!-- Include Font Awesome CDN in your <head> -->
<!-- Font Awesome (CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

<!-- Local JS files -->
<script type="text/javascript" src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.js') }}"></script>

<!-- Owl Carousel (CDN) -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>



  <!-- owl carousel script -->
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 20,
      navText: [],
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        768: {
          items: 2
        },
        1000: {
          items: 2
        }
      }
    });
   
  function showForm(formId) {
    document.querySelectorAll(".form-tab").forEach(tab => {
      tab.classList.remove("active");
    });
    document.querySelectorAll(".tab-btn").forEach(btn => {
      btn.classList.remove("active");
    });
    document.getElementById(formId).classList.add("active");
    event.target.classList.add("active");
  }

  // Floating FAQ and Promo functionality
  document.addEventListener('DOMContentLoaded', function() {
    // FAQ functionality
    const faqBtn = document.querySelector('.floating-faq-btn');
    const faqModal = document.querySelector('.faq-modal');
    const closeFaq = document.querySelector('.close-faq');
    
    faqBtn.addEventListener('click', function() {
      faqModal.style.display = 'flex';
    });
    
    closeFaq.addEventListener('click', function() {
      faqModal.style.display = 'none';
    });
    
    window.addEventListener('click', function(event) {
      if (event.target == faqModal) {
        faqModal.style.display = 'none';
      }
    });
    
    // FAQ accordion functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
      question.addEventListener('click', function() {
        const answer = this.nextElementSibling;
        const isOpen = answer.style.display === 'block';
        
        // Close all answers
        document.querySelectorAll('.faq-answer').forEach(ans => {
          ans.style.display = 'none';
        });
        
        document.querySelectorAll('.faq-question i').forEach(icon => {
          icon.className = 'fas fa-chevron-down';
        });
        
        // Open this answer if it was closed
        if (!isOpen) {
          answer.style.display = 'block';
          this.querySelector('i').className = 'fas fa-chevron-up';
        }
      });
    });
    
    // Promo functionality
    const promoBtn = document.querySelector('.floating-promo-btn');
    const promoModal = document.querySelector('.promo-modal');
    const closePromo = document.querySelector('.close-promo');
    
    promoBtn.addEventListener('click', function() {
      promoModal.style.display = 'flex';
    });
    
    closePromo.addEventListener('click', function() {
      promoModal.style.display = 'none';
    });
    
    window.addEventListener('click', function(event) {
      if (event.target == promoModal) {
        promoModal.style.display = 'none';
      }
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
// Debug function to find what's causing horizontal scroll
function findHorizontalScrollCulprit() {
    const elements = document.querySelectorAll('*');
    let culprit = null;
    
    elements.forEach(el => {
        if (el.offsetWidth > document.documentElement.clientWidth) {
            console.log('Wide element found:', el);
            console.log('Element width:', el.offsetWidth, 'Viewport width:', document.documentElement.clientWidth);
            culprit = el;
        }
    });
    
    return culprit;
}

// Run on load and resize
window.addEventListener('load', findHorizontalScrollCulprit);
window.addEventListener('resize', findHorizontalScrollCulprit);
  </script>
  <!-- end owl carousel script -->

</body>

</html>