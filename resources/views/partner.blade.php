<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Our Partners</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

    /* Hero Section */
    .partner-hero {
      background: url('images/driver1.jpg') no-repeat center center/cover;
      color: white;
      padding: 200px 20px;
      text-align: center;
      position: relative;
    }
    .partner-hero::after {
      content: "";
      position: absolute;
      top:0; left:0; right:0; bottom:0;
      background: rgba(0,0,0,0.6);
    }
    .partner-hero .content {
      position: relative;
      z-index: 2;
    }
    .partner-hero h1 {
      font-size: 3rem;
      font-weight: 700;
    }

    /* Benefits Section */
    .benefits {
      padding: 80px 0;
    }
    .benefit-box {
      text-align: center;
      padding: 30px;
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }
    .benefit-box:hover {
      transform: translateY(-10px);
    }
    .benefit-box i {
      font-size: 40px;
      color: #ff9800;
      margin-bottom: 15px;
    }

    /* Partner Logos */
    .partner-logos {
      background: #f8f9fa;
      padding: 60px 0;
      text-align: center;
    }
    .partner-logos img {
      max-width: 150px;
      margin: 20px;
     
    }
    .partner-logos img:hover {
      filter: grayscale(0%);
    }

    /* CTA */
    .partner-cta {
      padding: 80px 20px;
      text-align: center;
      background: #ff9800;
      color: white;
    }
    .partner-cta h2 {
      font-weight: 700;
      margin-bottom: 20px;
    }
    .partner-cta .btn {
      background: #fff;
      color: #ff9800;
      font-weight: 600;
      border-radius: 30px;
      padding: 12px 30px;
    }

    /* Partner Registration */
    .partner-form {
      padding: 80px 20px;
      background: #fdf2e9;
    }
    .partner-form h2 {
      font-weight: 700;
      text-align: center;
      margin-bottom: 40px;
    }

    /* FAQ */
    .faq {
      padding: 80px 20px;
    }
    .faq h2 {
      font-weight: 700;
      text-align: center;
      margin-bottom: 40px;
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

  <!-- Hero -->
  <section class="partner-hero">
    <div class="content">
      <h1>Partner with Us</h1>
      <p class="lead">Grow together with Unka – Let’s create success stories together.</p>
      <a href="#partnerForm" class="btn btn-warning btn-lg mt-3">Become a Partner</a>
    </div>
  </section>
  </div>

  <!-- Benefits -->
  <section class="benefits container">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Why Partner With Us?</h2>
      <p class="text-muted">Here’s what makes our partnership program stand out.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="benefit-box">
          <i class="bi bi-people"></i>
          <h5>Wide Network</h5>
          <p>Access thousands of customers and drivers through our platform.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="benefit-box">
          <i class="bi bi-bar-chart-line"></i>
          <h5>Business Growth</h5>
          <p>Boost your brand visibility and expand into new markets.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="benefit-box">
          <i class="bi bi-headset"></i>
          <h5>Dedicated Support</h5>
          <p>Our team works with you to ensure a smooth and rewarding experience.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Logos -->
  <section class="partner-logos">
    <div class="container">
      <h2 class="fw-bold mb-4">Trusted by Leading Brands</h2>
      <div class="d-flex flex-wrap justify-content-center">
        <img src="images/zedmobile.png" alt="Partner 1">
        <img src="images/rtsa.png" alt="Partner 2">
        <img src="images/shoprite.jpeg" alt="Partner 3">
        <img src="images/phama.png" alt="Partner 4">
         <img src="images/hungry.jpeg" alt="Partner 4">
      </div>
    </div>
  </section>

  <!-- Partner Registration Form -->
  <section class="partner-form" id="partnerForm">
    <div class="container">
      <h2>Partner Registration</h2>
      <form>
        <div class="row g-3">
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Full Name" required>
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" placeholder="Email Address" required>
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Company Name" required>
          </div>
          <div class="col-md-6">
            <input type="tel" class="form-control" placeholder="Phone Number" required>
          </div>
          <div class="col-12">
            <textarea class="form-control" placeholder="Tell us about your business" rows="4" required></textarea>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-warning btn-lg">Submit Registration</button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- FAQ Section -->
  <section class="faq container">
    <h2>Frequently Asked Questions</h2>
    <div class="accordion" id="faqAccordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
            How do I become a partner?
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Fill out the registration form above, and our team will contact you within 2-3 business days.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
            What are the benefits of partnering?
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            Gain access to a wide network, increased brand visibility, and dedicated support for your business growth.
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="faqThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
            Is there a cost to join?
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            No, joining our partner network is completely free.
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="partner-cta" id="cta">
    <div class="container">
      <h2>Let’s Build the Future Together</h2>
      <p>Join our partner network today and explore endless opportunities.</p>
      <a href="#partnerForm" class="btn">Become a Partner</a>
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
</script>

</body>
</html>
