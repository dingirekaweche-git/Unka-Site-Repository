@extends('layouts.app')

@section('title', 'Privacy Policy - Unka Go')

@section('content')
<style>
    .policy-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 4rem 1.5rem;
        font-family: Arial, sans-serif;
    }

    .policy-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .policy-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .policy-header p {
        color: #6b7280;
        font-size: 1rem;
    }

    .policy-intro {
        font-size: 1.1rem;
        line-height: 1.75rem;
        color: #374151;
        margin-bottom: 3rem;
        text-align: justify;
    }

    .policy-section {
        background: #f9fafb;
        border-radius: 1rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        padding: 1.5rem;
        margin-bottom: 2rem;
        transition: box-shadow 0.3s ease-in-out;
    }

    .policy-section:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .policy-section h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }

    .policy-section p, 
    .policy-section li {
        font-size: 1rem;
        color: #374151;
        line-height: 1.6rem;
    }

    .policy-section ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-top: 0.5rem;
    }

    .back-home {
        display: inline-block;
        margin-top: 2rem;
        padding: 0.75rem 1.5rem;
        background: #2563eb;
        color: #fff;
        font-weight: 600;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: background 0.3s ease-in-out;
    }

    .back-home:hover {
        background: #1d4ed8;
    }

    .back-home-container {
        text-align: center;
        margin-top: 3rem;
    }
</style>

<div class="policy-container">
    <!-- Page Header -->
    <div class="policy-header">
        <h1>Privacy Policy</h1>
        <p>Effective Date: <strong>{{ date('F d, Y') }}</strong></p>
    </div>

    <!-- Intro -->
    <p class="policy-intro">
        Unka Go ("we", "our", or "us") values your trust and is committed to protecting your privacy. 
        This Privacy Policy explains how we collect, use, and safeguard your personal information when you use our app and services.
    </p>

    <div>
        <section class="policy-section">
            <h2>1. Information We Collect</h2>
            <ul>
                <li><strong>Personal Information:</strong> Name, phone number, email address, and payment details.</li>
                <li><strong>Location Data:</strong> Real-time location for ride pickups, deliveries, and tracking.</li>
                <li><strong>Usage Data:</strong> App interactions, preferences, and device details.</li>
                <li><strong>Transaction Data:</strong> Ride history, food orders, and delivery records.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>2. How We Use Your Information</h2>
            <ul>
                <li>Provide taxi rides, food delivery, and parcel services.</li>
                <li>Improve and personalize user experience.</li>
                <li>Ensure safety and verify drivers/partners.</li>
                <li>Process payments and send receipts.</li>
                <li>Send important notifications.</li>
                <li>Comply with legal requirements.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>3. Sharing of Information</h2>
            <p>We do not sell your data. We may share with:</p>
            <ul>
                <li>Drivers and Delivery Partners for fulfilling requests.</li>
                <li>Service Providers (payments, SMS/email, customer support).</li>
                <li>Legal Authorities when required by law.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>4. Data Security</h2>
            <p>
                We use encryption and security measures to protect your information from unauthorized access, loss, or misuse.
            </p>
        </section>

        <section class="policy-section">
            <h2>5. Your Choices</h2>
            <ul>
                <li>Update or delete your account information in the app.</li>
                <li>Control location sharing via device settings.</li>
                <li>Opt out of promotional messages.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>6. Children’s Privacy</h2>
            <p>
                Unka Go is not intended for children under 13. We do not knowingly collect data from children.
            </p>
        </section>

        <section class="policy-section">
            <h2>7. Changes to this Policy</h2>
            <p>
                We may update this Privacy Policy. Updates will be reflected with a new “Effective Date.” 
                Continued use of the app means you accept the changes.
            </p>
        </section>

        <section class="policy-section">
            <h2>8. Contact Us</h2>
            <p>If you have any questions or concerns:</p>
            <ul>
                <li><strong>Email:</strong> developer.unka@gmail.com</li>
                <li><strong>Phone:</strong> +260 978 817 141</li>
                <li><strong>Address:</strong> Lusaka, Zambia</li>
            </ul>
        </section>
         <!-- Back to Home -->
    <div class="back-home-container">
        <a href="{{ url('/') }}" class="back-home">← Back to Home</a>
    </div>
    </div>
</div>
@endsection
