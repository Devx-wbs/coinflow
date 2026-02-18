@extends('layouts.frontend')

@section('title', 'Privacy Policy - Coin Flows Pay')

@section('content')

<section class="page-header header_padding bg-light">
    <div class="container">
        <h1 class="fw-bold">Privacy Policy</h1>
        <p class="text-muted">Last Updated: {{ date('F Y') }}</p>
    </div>
</section>

<section class="pb-5">
    <div class="container">

        <p>
            Welcome to <strong>Coin Flows Pay</strong>. Your privacy is important to us. 
            This Privacy Policy explains how we collect, use, disclose, and safeguard your information 
            when you visit our website <strong>https://coinflowspay.com</strong>.
        </p>

        <h4 class="mt-4">1. Information We Collect</h4>
        <p>We may collect the following types of information:</p>
        <ul>
            <li>Personal Information (Name, Email, Phone Number)</li>
            <li>Account and Login Details</li>
            <li>Business and Merchant Information</li>
            <li>Payment and Transaction Data</li>
            <li>IP Address and Device Information</li>
        </ul>

        <h4 class="mt-4">2. How We Use Your Information</h4>
        <p>We use your information to:</p>
        <ul>
            <li>Provide and manage our services</li>
            <li>Process transactions</li>
            <li>Improve user experience</li>
            <li>Send service-related notifications</li>
            <li>Prevent fraud and enhance security</li>
        </ul>

        <h4 class="mt-4">3. Sharing of Information</h4>
        <p>
            We do not sell your personal data. We may share information with:
        </p>
        <ul>
            <li>Trusted payment processing partners</li>
            <li>Legal authorities when required by law</li>
            <li>Service providers assisting in operations</li>
        </ul>

        <h4 class="mt-4">4. Data Security</h4>
        <p>
            We implement appropriate security measures to protect your data from 
            unauthorized access, alteration, disclosure, or destruction.
        </p>

        <h4 class="mt-4">5. Cookies & Tracking</h4>
        <p>
            We may use cookies and tracking technologies to enhance website functionality 
            and analyze traffic.
        </p>

        <h4 class="mt-4">6. Data Retention</h4>
        <p>
            We retain your information as long as necessary to provide services 
            and comply with legal obligations.
        </p>

        <h4 class="mt-4">7. Your Rights</h4>
        <p>You have the right to:</p>
        <ul>
            <li>Access your personal data</li>
            <li>Request correction or deletion</li>
            <li>Withdraw consent</li>
        </ul>

        <h4 class="mt-4">8. Third-Party Links</h4>
        <p>
            Our website may contain links to third-party websites. 
            We are not responsible for their privacy practices.
        </p>

        <h4 class="mt-4">9. Changes to This Policy</h4>
        <p>
            We may update this Privacy Policy periodically. 
            Updates will be posted on this page.
        </p>

        <h4 class="mt-4">10. Contact Us</h4>
        <p>
            If you have any questions regarding this Privacy Policy, 
            please contact us at: <strong>support@coinflowspay.com</strong>
        </p>

    </div>
</section>



@endsection
            <style>
.header_padding {
    padding: 8rem 0 1rem 0;
}
            </style>