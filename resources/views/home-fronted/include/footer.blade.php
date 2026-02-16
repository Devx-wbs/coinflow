<footer class="footer">
    <div class="container">
      <div class="footer-top">
        <div class="footer-brand">
          <img src="{{ asset('images/footer_logo.png') }}" alt="CoinFlow" class="footer-logo" />
          <p class="footer-description">
            CoinFlow empowers merchants to accept cryptocurrency payments securely and instantly across the globe
          </p>
        </div>
        <div class="footer-links">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#pricing">Pricing</a></li>
            <li><a href="#features">Features</a></li>
            <li><a href="{{ route('contact.form') }}">Contact</a></li>
          </ul>
        </div>
        <div class="footer-links">
          <h4>Resources</h4>
          <ul>
            <li><a href="#faq">FAQ</a></li>
            <li><a href="{{ route('contact.form') }}">Contact Us</a></li>
            <li><a href="{{ route('terms.conditions') }}">Terms of Service</a></li>
          </ul>
        </div>
        <div class="footer-social">
          <h4>Follow Us</h4>
          <div class="social-icons">
            <a href="#"><img src="{{ asset('images/soc_a.png') }}" alt="Social" /></a>
            <a href="#"><img src="{{ asset('images/soc_b.png') }}" alt="Social" /></a>
            <a href="#"><img src="{{ asset('images/soc_c.png') }}" alt="Social" /></a>
            <a href="#"><img src="{{ asset('images/soc_d.png') }}" alt="Social" /></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 CoinFlow. All rights reserved.</p>
      </div>
    </div>
  </footer>