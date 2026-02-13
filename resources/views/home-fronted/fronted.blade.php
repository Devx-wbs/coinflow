@extends('layouts.frontend')

@section('title','Login')

@section('content')



<main class="main-content mt-0">

  <!-- Header end -->

  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->

  <!-- Hero Section Start -->

  <section class="hero">
    <div class="container hero-grid">
      <div class="hero-content-left">
        <div class="hero-badge">Built for Modern Online Stores</div>
        <h1 class="hero-heading-left">
          Simplify Crypto Payments for Your Store
        </h1>
        <p class="hero-paragraph-left">
          Integrate CoinFlow in minutes and start accepting digital currencies
          securely
        </p>
        <div class="hero-buttons-left">
          <a href="#" class="btn-primary">Download Plugin</a>
        </div>

        <div class="social-proof">
          <div class="proof-item">
            <img src="{{ asset('images/hero_customers.png') }}" alt="Happy Customers" class="proof-img-customers" />
            <div class="proof-text">
              <strong>3000+</strong><br>Happy Customers
            </div>
          </div>
          <div class="divider"></div>
          <div class="proof-item">
            <div class="proof-rating-text">
              <strong>4.5/5</strong><br>
              <div class="star-rating">
                <img src="{{ asset('images/hero_stars.png') }}" alt="Stars" class="proof-img-stars" /> Rating
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="hero-image-right">
        <img src="{{ asset('images/hero_right.png') }}" alt="CoinFlow App Interface" />
      </div>
    </div>
  </section>




  <!-- Hero Section End -->

  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->

  <!-- Features Section Start -->


  <section class="features" id="features">
    <div class="container">
      <div class="features-header">
        <div class="features-badge">Powerful Capabilities</div>
        <h2 class="global-heading features-title">
          Powerful Features to Simplify Crypto Payments
        </h2>
        <p class="global-subheading features-subtitle">
          Everything your store needs to accept crypto payments seamlessly
        </p>
      </div>

      <div class="features-grid">
        <!-- Feature 1 -->
        <div class="feature-card">
          <div class="feature-icon">
            <!-- Shield Icon -->
            <img src="{{ asset('images/sec_vec_a.png') }}" alt="Secure Transactions" />
          </div>
          <h3 class="feature-title">Secure Transactions</h3>
          <p class="feature-desc">End-to-end encryption and compliance built-in</p>
        </div>

        <!-- Feature 2 -->
        <div class="feature-card">
          <div class="feature-icon">
            <!-- Handshake/Money Icon -->
            <img src="{{ asset('images/sec_vec_b.png') }}" alt="Instant Settlements" />
          </div>
          <h3 class="feature-title">Instant Settlements</h3>
          <p class="feature-desc">Receive funds quickly without long waits</p>
        </div>

        <!-- Feature 3 -->
        <div class="feature-card">
          <div class="feature-icon">
            <!-- Globe Icon -->
            <img src="{{ asset('images/sec_vec_c.png') }}" alt="Global Currencies" />
          </div>
          <h3 class="feature-title">Global Currencies</h3>
          <p class="feature-desc">Support for BTC, ETH, USDT and more</p>
        </div>

        <!-- Feature 4 -->
        <div class="feature-card">
          <div class="feature-icon">
            <!-- Chart Icon -->
            <img src="{{ asset('images/sec_vec_d.png') }}" alt="Real-Time Analytics" />
          </div>
          <h3 class="feature-title">Real-Time Analytics</h3>
          <p class="feature-desc">Track payments and revenue in real time</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section End -->

  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->

  <!--Plans-Section Start  -->

  <section class="pricing" id="pricing">
    <div class="container">
      <div class="pricing-header">
        <div class="features-badge">Pricing That Scales With You</div>
        <h2 class="global-heading pricing-title">
          Flexible Plans for Every Store
        </h2>
        <p class="global-subheading pricing-subtitle">
          Start free and scale as your business grows. Choose a plan that fits your needs and unlock more features
          with
          CoinFlow.
        </p>
      </div>

      @foreach($plans as $plan)

      <div class="pricing-content">
        <div class="pricing-image-left">
          <img src="{{ asset('images/thr_a.png') }}" alt="CoinFlow Mobile App" />
        </div>
        <div class="pricing-card-right">
          <div class="pricing-card-header">
            <h3 class="plan-name">{{ Str::title(preg_replace('/[^A-Za-z\s]/', '', $plan->name)) }}</h3>
            <div class="plan-price">
              <span class="currency">$</span>{{ number_format($plan->price ) }}<span class="period">/ {{ $plan->duration }}{{ $plan->duration_type }}</span>
            </div>
            <p class="plan-desc">
              {{ $plan->description }}
              lorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsumlorem ipsum
            </p>
          </div>
          <ul class="plan-features">
            <li>
              <span class="check-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="10" cy="10" r="10" fill="#00E096" />
                  <path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </span>
              <span class="feature-label">Max activations :</span>
              <span class="feature-value">{{ $plan->max_activations }}</span>
            </li>
            <li>
              <span class="check-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="10" cy="10" r="10" fill="#00E096" />
                  <path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </span>
              <span class="feature-label">License type :</span>
              <span class="feature-value">{{ $plan->license_type }}</span>
            </li>
            <li>
              <span class="check-icon">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="10" cy="10" r="10" fill="#00E096" />
                  <path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </span>
              <span class="feature-label">Trial days:</span>
              <span class="feature-value">{{ $plan->trial_days }}</span>
            </li>
          </ul>
          <form action="{{ route('buyplan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <button type="submit" class="subscribe-btn">
              Subscribe
            </button>
          </form>

        </div>

        @endforeach

      </div>
    </div>
  </section>











  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->

  <!-- Work Section start -->

  <section class="how-it-works" id="how-it-works">
      <div class="container">
        <div class="how-content">
          <div class="how-image-left">
            <img src="{{ asset('images/for_a.png') }}" alt="How CoinFlow Works" />
          </div>
          <div class="how-text-right">
            <div class="how-badge">Get Started in Minutes</div>
            <h2 class="global-heading how-title">How It Works</h2>
            <p class="global-subheading how-subtitle">
              Everything your store needs to accept crypto payments seamlessly
            </p>

            <div class="steps-list">
              <!-- Step 1 -->
              <div class="step-item">
                <div class="step-icon">
                  <img src="{{ asset('images/for_r_a.png') }}" alt="Install Plugin" />
                </div>
                <div class="step-text">Install the CoinFlow Plugin</div>
              </div>

              <!-- Step 2 -->
              <div class="step-item">
                <div class="step-icon">
                  <img src="{{ asset('images/for_r_b.png') }}" alt="Connect Wallet" />
                </div>
                <div class="step-text">Connect Your Wallet</div>
              </div>

              <!-- Step 3 -->
              <div class="step-item">
                <div class="step-icon">
                  <img src="{{ asset('images/for_r_c.png') }}" alt="Start Accepting" />
                </div>
                <div class="step-text">Start Accepting Payments</div>
              </div>

              <!-- Step 4 -->
              <div class="step-item">
                <div class="step-icon">
                  <img src="{{ asset('images/for_r_d.png') }}" alt="Track Earnings" />
                </div>
                <div class="step-text">Track Your Earnings</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

  

  <!-- Work Section end -->

  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->

  <!-- Why choose Coin flow section Start-->

  <section class="why-choose" id="why-choose">
      <div class="container">
        <div class="why-header">
          <div class="features-badge">Trusted by Growing Businesses</div>
          <h2 class="global-heading why-title">Why Choose CoinFlow?</h2>
          <p class="global-subheading why-subtitle">
            CoinFlow simplifies cryptocurrency payments for online stores by providing a secure, transparent, and
            easy-to-manage payment experience.
          </p>
        </div>

        <div class="why-grid">
          <!-- Card 1 -->
          <div class="why-card">
            <div class="why-icon">
              <!-- Using inferred icon name fif_a.png based on user request -->
              <img src="{{ asset('images/fif_a.png') }}" alt="Low Fees" />
            </div>
            <h3 class="why-card-title">Low Transaction Fees</h3>
            <p class="why-card-desc">
              Keep more of your earnings with CoinFlow's minimal transaction fees.
              Unlike traditional payment gateways, we eliminate unnecessary intermediaries – ensuring you pay less while
              your customers enjoy seamless checkout experiences.
            </p>
          </div>

          <!-- Card 2 -->
          <div class="why-card">
            <div class="why-icon">
              <img src="{{ asset('images/fif_b.png') }}" alt="24/7 Support" />
            </div>
            <h3 class="why-card-title">24/7 Merchant Support</h3>
            <p class="why-card-desc">
              Our dedicated support team is available round the clock to help you troubleshoot, optimize, or upgrade
              your
              crypto payment setup.
              From onboarding to technical assistance, we're always here when you need us.
            </p>
          </div>

          <!-- Card 3 -->
          <div class="why-card">
            <div class="why-icon">
              <img src="{{ asset('images/fif_c.png') }}" alt="Transparent Reporting" />
            </div>
            <h3 class="why-card-title">Transparent Reporting</h3>
            <p class="why-card-desc">
              Get full visibility into every transaction with real-time analytics and clear reporting tools.
              CoinFlow ensures complete transparency – no hidden fees, no complicated statements – just straightforward
              data you can trust.
            </p>
          </div>
        </div>
      </div>
    </section>

  
  <!-- Why choose Coin flow section End-->

  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->

  <!-- merchant section start -->

  <section class="testimonials" id="testimonials">
      <div class="container">
        <div class="testimonials-wrapper">
          <div class="testimonials-inner">
            <div class="testimonials-header">
              <div class="testimonials-badge">Loved by Merchants</div>
              <h2 class="global-heading testimonials-title">
                What Our Merchants Say
              </h2>
              <p class="global-subheading testimonials-subtitle">
                CoinFlow simplifies cryptocurrency payments for online stores.
              </p>
            </div>

            <div class="testimonials-slider-mask">
              <div class="testimonials-track">
                <!-- Testimonial 1 -->
                <div class="testimonial-card">
                  <div class="quote-icon">
                    <img src="{{ asset('images/six_comma.png') }}" alt="Quote" />
                  </div>
                  <div class="stars">
                    <img src="{{ asset('images/six_stars.png') }}" alt="5 Stars" />
                  </div>
                  <p class="testimonial-text">
                    CoinFlow made crypto transactions simple and reliable. The instant settlement feature is incredible
                    –
                    no
                    more long waits for funds.
                  </p>
                  <div class="reviewer-info">
                    <img src="{{ asset('images/six_review.png') }}" alt="Justus Menke" class="reviewer-img" />
                    <div class="reviewer-details">
                      <div class="reviewer-name">Justus Menke</div>
                      <div class="reviewer-role">CEO Eronaman</div>
                    </div>
                  </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="testimonial-card">
                  <div class="quote-icon">
                    <img src="{{ asset('images/six_comma.png') }}" alt="Quote" />
                  </div>
                  <div class="stars">
                    <img src="{{ asset('images/six_stars.png') }}" alt="5 Stars" />
                  </div>
                  <p class="testimonial-text">
                    Our customers love having more payment options. The dashboard insights and real-time analytics help
                    us
                    track everything effortlessly.
                  </p>
                  <div class="reviewer-info">
                    <img src="{{ asset('images/six_review.png') }}" alt="Britain Eriksen" class="reviewer-img" />
                    <div class="reviewer-details">
                      <div class="reviewer-name">Britain Eriksen</div>
                      <div class="reviewer-role">CEO Universal</div>
                    </div>
                  </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="testimonial-card">
                  <div class="quote-icon">
                    <img src="{{ asset('images/six_comma.png') }}" alt="Quote" />
                  </div>
                  <div class="stars">
                    <img src="{{ asset('images/six_stars.png') }}" alt="5 Stars" />
                  </div>
                  <p class="testimonial-text">
                    CoinFlow has redefined how we accept payments online. The integration with our existing systems was
                    smooth and hassle-free.
                  </p>
                  <div class="reviewer-info">
                    <img src="{{ asset('images/six_review.png') }}" alt="Britain Eriksen" class="reviewer-img" />
                    <div class="reviewer-details">
                      <div class="reviewer-name">Britain Eriksen</div>
                      <div class="reviewer-role">CEO Universal</div>
                    </div>
                  </div>
                </div>

                <!-- Testimonial 4 -->
                <div class="testimonial-card">
                  <div class="quote-icon">
                    <img src="{{ asset('images/six_comma.png') }}" alt="Quote" />
                  </div>
                  <div class="stars">
                    <img src="{{ asset('images/six_stars.png') }}" alt="5 Stars" />
                  </div>
                  <p class="testimonial-text">
                    CoinFlow has redefined how we accept payments online. The integration with our existing systems was
                    smooth and hassle-free.
                  </p>
                  <div class="reviewer-info">
                    <img src="{{ asset('images/six_review.png') }}" alt="Britain Eriksen" class="reviewer-img" />
                    <div class="reviewer-details">
                      <div class="reviewer-name">Britain Eriksen</div>
                      <div class="reviewer-role">CEO Universal</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Navigation Arrows -->
            <div class="nav-arrow nav-prev" id="prevBtn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 18L9 12L15 6" stroke="#1494FF" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
            <div class="nav-arrow nav-next" id="nextBtn">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 18L15 12L9 6" stroke="#1494FF" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Section 7: Simple, Transparent Pricing -->
    <section class="simple-pricing" id="simple-pricing">
      <div class="container">
        <div class="simple-pricing-wrapper">
          <div class="simple-pricing-content">
            <div class="simple-pricing-badge">No Hidden Costs</div>
            <h2 class="global-heading simple-pricing-title">
              Simple, Transparent Pricing
            </h2>
            <p class="global-subheading simple-pricing-description">
              No surprises, just straightforward plans designed to scale with your business. Whether you're a small
              store
              getting started with crypto payments or a growing platform handling higher volumes, CoinFlow offers
              transparent pricing that adapts to your needs without hidden fees or complexity
            </p>
            <a href="#pricing" class="btn btn-primary">View Plans</a>
          </div>
          <div class="simple-pricing-image">
            <img src="{{ asset('images/sev_a.png') }}" alt="Simple Pricing" />
          </div>
        </div>
      </div>
    </section>

    <!-- Section 8: Start Accepting Crypto Today -->
    <section class="start-today" id="start-today">
      <div class="container">
        <div class="start-today-wrapper">
          <div class="start-today-inner">
            <div class="start-today-image">
              <img src="{{ asset('images/eig_phone.png') }}" alt="Start Accepting Crypto" />
            </div>
            <div class="start-today-content">
              <div class="start-today-badge">Start Accepting Crypto Today</div>
              <h2 class="global-heading start-today-title">
                Start Accepting Crypto Today
              </h2>
              <p class="global-subheading start-today-description">
                Join thousands of merchants simplifying crypto payments with CoinFlow. Get started in minutes, integrate
                seamlessly with your store, and start accepting crypto securely without complexity.
              </p>
              <a href="#register" class="btn btn-secondary">Start Today</a>
            </div>
          </div>
        </div>
      </div>
    </section>

  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->

  



  <!-- FAQ Section started -->


  <section class="faq-section" id="faq">
      <div class="container">
        <div class="faq-header">
          <div class="faq-badge">Need More Information?</div>
          <h2 class="global-heading faq-title">Frequently Asked Questions</h2>
        </div>

        <div class="faq-container">
          <!-- FAQ Item 1 (Active) -->
          <div class="faq-item active">
            <div class="faq-question">
              <img src="{{ asset('images/nin_sub.png') }}" alt="Collapse" class="faq-icon" />
              <h3>How does CoinFlow work with my eCommerce store?</h3>
            </div>
            <div class="faq-answer">
              <p>CoinFlow integrates seamlessly with platforms like Shopify, WooCommerce, and Magento. Once installed,
                it
                allows you to accept crypto payments directly from customers using supported wallets.</p>
            </div>
          </div>

          <!-- FAQ Item 2 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/nin_plus.png') }}" alt="Expand" class="faq-icon" />
              <h3>What cryptocurrencies does CoinFlow support?</h3>
            </div>
            <div class="faq-answer">
              <p>CoinFlow supports major cryptocurrencies including Bitcoin, Ethereum, Litecoin, and many stablecoins
                like
                USDC and USDT.</p>
            </div>
          </div>

          <!-- FAQ Item 3 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/nin_plus.png') }}" alt="Expand" class="faq-icon" />
              <h3>How long do crypto transactions take to process?</h3>
            </div>
            <div class="faq-answer">
              <p>Transaction speeds depend on the blockchain network but typically range from a few seconds to a few
                minutes.</p>
            </div>
          </div>

          <!-- FAQ Item 4 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/nin_plus.png') }}" alt="Expand" class="faq-icon" />
              <h3>Are there any hidden fees?</h3>
            </div>
            <div class="faq-answer">
              <p>No, CoinFlow prides itself on transparency. We charge a flat nominal fee per transaction with zero
                hidden
                costs.</p>
            </div>
          </div>

          <!-- FAQ Item 5 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/nin_plus.png') }}" alt="Expand" class="faq-icon" />
              <h3>Can I withdraw earnings in fiat currency?</h3>
            </div>
            <div class="faq-answer">
              <p>Yes, you can easily convert and withdraw your crypto earnings into your local fiat currency directly to
                your bank account.</p>
            </div>
          </div>
        </div>
      </div>
    </section>


  

  <!-- ---------------- -->
  <!-- ---------------- -->
  <!-- ---------------- -->
</main>
@endsection

<script>
    // Header Scroll Logic
    window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      const scrollThreshold = window.innerHeight * 0.1;

      if (window.scrollY > scrollThreshold) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Mobile Menu Logic
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const mobileLinks = document.querySelectorAll('.mobile-link');

    if (mobileToggle && mobileMenu) {
      mobileToggle.addEventListener('click', () => {
        mobileToggle.classList.toggle('active');
        mobileMenu.classList.toggle('active');
        document.body.classList.toggle('no-scroll'); // Prevent background scrolling
      });

      // Close menu when a link is clicked
      mobileLinks.forEach(link => {
        link.addEventListener('click', () => {
          mobileToggle.classList.remove('active');
          mobileMenu.classList.remove('active');
          document.body.classList.remove('no-scroll');
        });
      });
    }

    // FAQ Accordion Logic
    document.addEventListener('DOMContentLoaded', function () {
      const faqQuestions = document.querySelectorAll('.faq-question');
      if (faqQuestions.length > 0) {
        faqQuestions.forEach(question => {
          question.addEventListener('click', () => {
            const item = question.parentElement;
            const icon = question.querySelector('.faq-icon');

            // Close all other items
            document.querySelectorAll('.faq-item').forEach(otherItem => {
              if (otherItem !== item) {
                otherItem.classList.remove('active');
                const otherIcon = otherItem.querySelector('.faq-icon');
                if (otherIcon) otherIcon.src = '{{ asset('images/nin_plus.png') }}';
              }
            });

            // Toggle current item
            item.classList.toggle('active');

            // Update icon
            if (item.classList.contains('active')) {
              icon.src = '{{ asset('images/nin_sub.png') }}';
            } else {
              icon.src = '{{ asset('images/nin_plus.png') }}';
            }
          });
        });
      }
    });

    // Testimonials Slider Logic
    document.addEventListener('DOMContentLoaded', function () {
      const track = document.querySelector('.testimonials-track');
      const cards = document.querySelectorAll('.testimonial-card');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');

      if (!track || cards.length === 0 || !prevBtn || !nextBtn) return;

      let currentIndex = 0;
      const gap = 32; // 2rem gap

      function getMoveAmount() {
        const cardWidth = cards[0].offsetWidth;
        return cardWidth + gap;
      }

      function updateSlider() {
        const move = getMoveAmount() * currentIndex;
        track.style.transform = `translateX(-${move}px)`;
      }

      nextBtn.addEventListener('click', () => {
        const isMobile = window.innerWidth <= 992;
        const visibleItems = isMobile ? 1 : 3;
        const maxIndex = Math.max(0, cards.length - visibleItems);

        if (currentIndex < maxIndex) {
          currentIndex++;
        } else {
          currentIndex = 0; // Loop back to start
        }
        updateSlider();
      });

      prevBtn.addEventListener('click', () => {
        const isMobile = window.innerWidth <= 992;
        const visibleItems = isMobile ? 1 : 3;
        const maxIndex = Math.max(0, cards.length - visibleItems);

        if (currentIndex > 0) {
          currentIndex--;
        } else {
          currentIndex = maxIndex; // Loop to end
        }
        updateSlider();
      });

      // Handle resize
      window.addEventListener('resize', () => {
        currentIndex = 0;
        track.style.transform = `translateX(0)`;
      });
    });
  </script>