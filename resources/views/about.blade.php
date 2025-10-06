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
    /* CEO Message Styling */
    .ceo-section {
      padding: 60px 0;
      background-color: #f9f9f9;
    }
    
    .ceo-container {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
    }
    
    .ceo-image {
      flex: 1;
      min-width: 300px;
      padding: 20px;
      text-align: center;
    }
    
    .ceo-image img {
      width: 100%;
      max-width: 350px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .ceo-content {
      flex: 2;
      min-width: 300px;
      padding: 20px;
    }
    
    .ceo-signature {
      font-style: italic;
      margin-top: 20px;
      text-align: right;
    }
    
    .ceo-name {
      font-weight: bold;
      color: #ff9800;
    }
    
    .ceo-title {
      color: #777;
    }
    
    /* Team Gallery Styling */
    .team-section {
      padding: 60px 0;
      background-color: #fff;
    }
    
    .section-heading {
      text-align: center;
      margin-bottom: 50px;
    }
    
    .section-heading h2 {
      font-size: 2.5rem;
      font-weight: 700;
      color: #333;
    }
    
    .section-heading h2 span {
      color: #ff9800;
    }
    
    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 30px;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
    }
    
   .team-member {
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  overflow: hidden;
  width: 280px;
  text-align: center;
  transition: transform 0.3s;
}

.team-member:hover {
  transform: translateY(-5px);
}

.member-image {
  width: 100%;
  aspect-ratio: 4/5; /* maintain consistent card ratio */
  overflow: hidden;
  border-bottom: 1px solid #eee;
  background: #eee;
  display: flex;
  justify-content: center;
  align-items: center;
}

.member-image img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* crop smartly */
  object-position: center; /* keep subject centered */
  transition: transform 0.3s;
}

.member-image img:hover {
  transform: scale(1.05); /* subtle zoom on hover */
}

.member-info {
  padding: 20px;
}

.member-name {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 5px;
}

.member-position {
  font-size: 1rem;
  color: #ff9800;
  margin-bottom: 10px;
}

.member-desc {
  font-size: 0.95rem;
  color: #555;
  line-height: 1.4;
}
    
    /* Mission and Vision Section */
    .mission-vision {
      padding: 60px 0;
      background-color: #f9f9f9;
    }
    
    .mv-container {
      display: flex;
      flex-wrap: wrap;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 15px;
      gap: 40px;
    }
    
    .mv-card {
      flex: 1;
      min-width: 300px;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      text-align: center;
    }
    
    .mv-icon {
      font-size: 3rem;
      color: #ff9800;
      margin-bottom: 20px;
    }
    
    .mv-card h3 {
      font-size: 1.5rem;
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

  <!-- CEO Message Section -->
  <section class="ceo-section">
  <div class="ceo-container">
    <div class="ceo-image">
      <img src="images/ceo.jpeg" alt="CEO of Unka Go">
    </div>
    <div class="ceo-content">
      <h2 style="color: #ff9800; margin-bottom: 20px;">Message from Our CEO</h2>
      <p>
        Welcome to Unka Go! We're transforming transportation and delivery in Zambia by connecting people with reliable, affordable, and convenient services. Our intuitive app makes rides, food delivery, and package sending effortless.
      </p>
      <p>
        We are committed to our community—creating opportunities for drivers, supporting local businesses, and providing services that simplify everyday life. Our core values of reliability, safety, affordability, and innovation guide everything we do.
      </p>
      <div class="ceo-signature">
        <div class="ceo-name">James Phiri</div>
        <div class="ceo-title">Founder & CEO, Unka Go</div>
      </div>
    </div>
  </div>
</section>

  <!-- Mission and Vision Section -->
  <section class="mission-vision">
    <div class="mv-container">
      <div class="mv-card">
        <div class="mv-icon">
          <i class="fas fa-bullseye"></i>
        </div>
        <h3>Our Mission</h3>
        <p>To transform urban mobility and delivery services in Zambia through technology, making transportation and logistics more accessible, affordable, and efficient for everyone.</p>
      </div>
      
      <div class="mv-card">
        <div class="mv-icon">
          <i class="fas fa-eye"></i>
        </div>
        <h3>Our Vision</h3>
        <p>To become Zambia's leading super-app that simplifies daily life by connecting people, businesses, and services through an integrated, user-friendly platform.</p>
      </div>
      
      <div class="mv-card">
        <div class="mv-icon">
          <i class="fas fa-handshake"></i>
        </div>
        <h3>Our Values</h3>
        <p>Innovation, Reliability, Community, Safety, and Customer-centricity guide everything we do at Unka Go.</p>
      </div>
    </div>
  </section>

  <!-- Team Gallery Section -->
  <section class="team-section">
    <div class="section-heading">
      <h2>Meet Our <span>Leadership Team</span></h2>
      <p>The passionate professionals driving Unka Go's success</p>
    </div>
    
    <div class="team-grid">
      <!-- Team Member 1 -->
      <div class="team-member">
        <div class="member-image">
          <img src="images/ceo.jpeg" alt="James Phiri">
        </div>
        <div class="member-info">
          <h3 class="member-name">James Phiri</h3>
          <div class="member-position">Chief Executive Officer</div>
          <p class="member-desc">Visionary leader with 10+ years in tech and transportation industries.</p>
        </div>
      </div>
      
      <!-- Team Member 2 -->
      <div class="team-member">
        <div class="member-image">
          <img src="images/ceo.jpeg" alt="Sarah Mwale">
        </div>
        <div class="member-info">
          <h3 class="member-name">Sarah Mwale</h3>
          <div class="member-position">Chief Technology Officer</div>
          <p class="member-desc">Tech expert leading our platform development and innovation efforts.</p>
        </div>
      </div>
      
      <!-- Team Member 3 -->
      <div class="team-member">
        <div class="member-image">
          <img src="images/ceo.jpeg" alt="David Banda">
        </div>
        <div class="member-info">
          <h3 class="member-name">David Banda</h3>
          <div class="member-position">Chief Operations Officer</div>
          <p class="member-desc">Ensures seamless operations and driver partner management across Zambia.</p>
        </div>
      </div>
      
      <!-- Team Member 4 -->
      <div class="team-member">
        <div class="member-image">
          <img src="images/ceo.jpeg" alt="Chileshe Kapumba">
        </div>
        <div class="member-info">
          <h3 class="member-name">Chileshe Kapumba</h3>
          <div class="member-position">Head of Marketing</div>
          <p class="member-desc">Drives brand awareness and customer acquisition strategies.</p>
        </div>
      </div>
      
      <!-- Team Member 5 -->
      <div class="team-member">
        <div class="member-image">
          <img src="images/ceo.jpeg" alt="Michael Tembo">
        </div>
        <div class="member-info">
          <h3 class="member-name">Michael Tembo</h3>
          <div class="member-position">Finance Director</div>
          <p class="member-desc">Manages financial strategy and ensures sustainable business growth.</p>
        </div>
      </div>
      
      <!-- Team Member 6 -->
      <div class="team-member">
        <div class="member-image">
          <img src="images/ceo.jpeg" alt="Ruth Ngoma">
        </div>
        <div class="member-info">
          <h3 class="member-name">Ruth Ngoma</h3>
          <div class="member-position">Customer Experience Manager</div>
          <p class="member-desc">Dedicated to ensuring exceptional service for all Unka Go users.</p>
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
  <!-- end owl carousel script -->

</body>

</html>