@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content')
<style>
    .terms-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 3rem 1.5rem;
        font-family: Arial, sans-serif;
    }

    .terms-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .terms-header h1 {
        font-size: 2.25rem;
        font-weight: 800;
        color: #1f2937;
    }

    .terms-intro {
        font-size: 1.1rem;
        color: #374151;
        line-height: 1.75rem;
        margin-bottom: 2.5rem;
        text-align: justify;
    }

    .terms-section {
        background: #f9fafb;
        border-radius: 1rem;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        padding: 1.5rem;
        margin-bottom: 2rem;
        transition: box-shadow 0.3s ease-in-out;
    }

    .terms-section:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .terms-section h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.75rem;
    }

    .terms-section p {
        font-size: 1rem;
        color: #374151;
        line-height: 1.6rem;
    }

    .last-updated {
        text-align: center;
        color: #6b7280;
        font-size: 0.95rem;
        margin-top: 2rem;
    }

    .back-home {
        display: inline-block;
        margin-top: 2.5rem;
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
        margin-top: 2rem;
    }
</style>

<div class="terms-container">
    <!-- Header -->
    <div class="terms-header">
        <h1>Terms & Conditions</h1>
    </div>

    <!-- Intro -->
    <p class="terms-intro">
        Welcome to our platform. By accessing or using our services, you agree to comply with and be bound by the following terms and conditions.
    </p>

    <!-- Sections -->
    <section class="terms-section">
        <h2>1. Use of Service</h2>
        <p>You agree to use our services only for lawful purposes and in accordance with these Terms.</p>
    </section>

    <section class="terms-section">
        <h2>2. User Accounts</h2>
        <p>You are responsible for maintaining the confidentiality of your account and password.</p>
    </section>

    <section class="terms-section">
        <h2>3. Limitation of Liability</h2>
        <p>We are not liable for any indirect, incidental, or consequential damages resulting from the use of our platform.</p>
    </section>

    <section class="terms-section">
        <h2>4. Changes to Terms</h2>
        <p>We may update these terms at any time. Continued use of our platform means you accept the changes.</p>
    </section>

    <!-- Last Updated -->
    <p class="last-updated">Last updated: {{ date('F j, Y') }}</p>

    <!-- Back to Home -->
    <div class="back-home-container">
        <a href="{{ url('/') }}" class="back-home">← Back to Home</a>
    </div>
</div>
@endsection
