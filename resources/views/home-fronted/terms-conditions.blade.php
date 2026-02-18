@extends('layouts.frontend')

@section('title', 'Terms & Conditions - Coin Flows Pay')

@section('content')

<section class="page-header header_padding bg-light">
    <div class="container">
        <h1 class="fw-bold">Terms & Conditions</h1>
        <p class="text-muted">Last Updated: {{ date('F Y') }}</p>
    </div>
</section>

<section class="pb-5">
    <div class="container">

        <p>
            Welcome to <strong>Coin Flows Pay</strong>. By accessing or using our website 
            https://coinflowspay.com, you agree to comply with and be bound by these Terms & Conditions.
        </p>

        <h4 class="mt-4">1. Use of Services</h4>
        <p>
            You agree to use our platform only for lawful purposes and in compliance with all 
            applicable regulations.
        </p>

        <h4 class="mt-4">2. Account Responsibility</h4>
        <ul>
            <li>You are responsible for maintaining account confidentiality.</li>
            <li>You agree to provide accurate information.</li>
            <li>You are responsible for all activities under your account.</li>
        </ul>

        <h4 class="mt-4">3. Payments & Transactions</h4>
        <p>
            Coin Flows Pay facilitates digital payment processing. 
            We are not responsible for transaction failures caused by third-party providers.
        </p>

        <h4 class="mt-4">4. Prohibited Activities</h4>
        <ul>
            <li>Fraudulent transactions</li>
            <li>Money laundering</li>
            <li>Unauthorized access attempts</li>
            <li>Violation of local financial laws</li>
        </ul>

        <h4 class="mt-4">5. Intellectual Property</h4>
        <p>
            All content, trademarks, and materials on this website 
            are the property of Coin Flows Pay and may not be used without permission.
        </p>

        <h4 class="mt-4">6. Limitation of Liability</h4>
        <p>
            We shall not be liable for any indirect, incidental, or consequential damages 
            arising from the use of our services.
        </p>

        <h4 class="mt-4">7. Termination</h4>
        <p>
            We reserve the right to suspend or terminate accounts 
            that violate these terms.
        </p>

        <h4 class="mt-4">8. Governing Law</h4>
        <p>
            These Terms shall be governed by the laws of India.
        </p>

        <h4 class="mt-4">9. Changes to Terms</h4>
        <p>
            We may update these Terms & Conditions at any time. 
            Continued use of the website indicates acceptance of changes.
        </p>

        <h4 class="mt-4">10. Contact Information</h4>
        <p>
            For any queries regarding these Terms, contact us at:
            <strong>support@coinflowspay.com</strong>
        </p>

    </div>
</section>

@endsection



            <style>
.header_padding {
    padding: 8rem 0 1rem 0;
}
            </style>
