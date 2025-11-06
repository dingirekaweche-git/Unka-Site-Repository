<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Unka Go - Float Purchase</title>
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

      body {
      font-family: 'Poppins', sans-serif;
      background: #f5f5f5;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      margin: 0;
    }

    .header_section {
      background: #ff9800;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .custom_nav-container {
      display: flex;
      align-items: center;
      height: 90px;
      padding: 0 20px;
    }

    .logo-link img {
      max-height: 150px;
      width: auto;
    }

    .form-wrapper {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding: 60px 20px;
    }

    .purchase-form-container {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
      width: 100%;
      max-width: 500px;
    }

    h5 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 700;
      color: #ff6600;
    }

    .btn-purchase {
      background: linear-gradient(135deg, #ff9800, #ff6600);
      color: #fff;
      font-weight: 600;
      width: 100%;
      padding: 12px;
      border-radius: 8px;
      margin-top: 15px;
    }

    .btn-purchase:hover {
      background: linear-gradient(135deg, #ff6600, #ff9800);
    }

    .purchase-summary {
      background: #f8f9fa;
      border-radius: 10px;
      padding: 15px;
      margin-top: 20px;
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 8px;
    }

    .summary-total {
      font-weight: 700;
      border-top: 1px solid #ddd;
      padding-top: 10px;
      margin-top: 10px;
    }

    .payment-options img {
      height: 50px;
      cursor: pointer;
      transition: transform 0.3s;
    }

    .payment-options img:hover {
      transform: scale(1.1);
    }

  </style>
</head>
<body>

<!-- Header -->
 
<div class="hero_are">
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

  <!-- Purchase Form -->
  <div class="form-wrapper">
    <div class="purchase-form-container">
      <h5>Float Purchase</h5>

      <div id="messageContainer"></div>

      <form id="floatPurchaseForm" method="POST" action="{{ route('topup.driver') }}">
        @csrf
        <div class="form-group">
          <label for="registeredNumber">Registered Number</label>
          <input type="text" class="form-control" name="registeredNumber" id="registeredNumber"
            placeholder="Enter registered number" required>
        </div>

        <div class="form-group">
          <label for="paymentNumber">Payment Number</label>
          <div class="input-group">
            <div class="input-group-prepend"><span class="input-group-text">+260</span></div>
            <input type="tel" class="form-control" name="paymentNumber" id="paymentNumber"
              placeholder="Enter payment number" required>
          </div>
        </div>

        <div class="form-group">
          <label for="amount">Amount (ZMW)</label>
          <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter amount" min="1"
            step="0.01" required>
        </div>

        <div class="purchase-summary">
          <h6>Purchase Summary</h6>
          <div class="summary-item"><span>Registered:</span><span id="summaryRegistered">-</span></div>
          <div class="summary-item"><span>Payment:</span><span id="summaryPayment">-</span></div>
          <div class="summary-item"><span>Amount:</span><span id="summaryAmount">-</span></div>
          <div class="summary-item summary-total"><span>Total:</span><span id="summaryTotal">ZMW 0.00</span></div>
        </div>

        <div class="payment-options">
          <img src="/images/airtel.png" alt="Airtel">
          <img src="/images/mtn.png" alt="MTN">
          <img src="/images/zamtel.png" alt="Zamtel">
          <img src="/images/zedmobile.png" alt="ZedWallet">
        </div>

        <button type="submit" class="btn btn-purchase"><i class="fas fa-shopping-cart mr-2"></i> Complete Purchase
        </button>
      </form>
    </div>
  </div>

  </div>

 

<!-- Replace this line -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- With the full jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
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

    $(document).ready(function () {
      function updateSummary() {
        const reg = $('#registeredNumber').val() || '-';
        const pay = $('#paymentNumber').val() ? '+260' + $('#paymentNumber').val() : '-';
        const amt = $('#amount').val() ? 'ZMW ' + parseFloat($('#amount').val()).toFixed(2) : '-';
        const total = $('#amount').val() ? 'ZMW ' + parseFloat($('#amount').val()).toFixed(2) : 'ZMW 0.00';
        $('#summaryRegistered').text(reg);
        $('#summaryPayment').text(pay);
        $('#summaryAmount').text(amt);
        $('#summaryTotal').text(total);
      }

      $('#registeredNumber, #paymentNumber, #amount').on('input', updateSummary);

      $('#floatPurchaseForm').on('submit', function (e) {
        e.preventDefault();
        const form = $(this);
        const url = form.attr('action');
        const data = form.serialize();
        const btn = form.find('button[type="submit"]');
        const originalText = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Processing...');
        $('#messageContainer').html('');

        $.post(url, data)
          .done(function (response) {
            if (response.success) {
              $('#messageContainer').html('<div class="alert alert-success">✅ ' + (response.message || 'Top-up successful!') + '</div>');
              form[0].reset();
              updateSummary();
            } else {
              $('#messageContainer').html('<div class="alert alert-danger">❌ ' + (response.error || 'Top-up failed.') + '</div>');
            }
          })
          .fail(function (xhr) {
            let msg = 'Top-up failed. Please try again.';
            if (xhr.responseJSON && xhr.responseJSON.error) msg = xhr.responseJSON.error;
            $('#messageContainer').html('<div class="alert alert-danger">❌ ' + msg + '</div>');
          })
          .always(function () {
            btn.prop('disabled', false).html(originalText);
          });
      });
    });
  </script>



</body>
</html>
