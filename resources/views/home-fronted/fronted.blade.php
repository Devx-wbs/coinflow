   <body>

   @include('home-fronted.include.header')
   <style>
    .pro-plan-card {
  border: 1px solid #EAEAEA;
  background-color: #fff;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
  width: 385px;
  height: 454px;
  border-radius: 20px;
  padding: 0 29px;
}
.plan-title {
  font-weight: 600;
  font-size: 30px;
  text-align: center;
  color: #4D4D4D;
  padding-top: 54px;
  padding-bottom: 16px;
}
/* Price */
.plan-price {
  padding-bottom: 36px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 6px;
}
.price-amount {
  font-weight: 600;
  font-size: 32px;
  color: #1494FF;
}
.price-duration {
  color: #4D4D4D;
  font-weight: 400;
  font-size: 16px;
}
/* Divider */
.plan-divider {
  border: none;
  border-top: 1px solid #D4D4D4;
  padding-bottom: 36px;
}
/* Plan details */
.plan-details {
  list-style: none;
  padding: 0;
  margin: 0 0 20px 0;
  color: #444;
  font-size: 15px;
}
.plan-details li {
  display: flex;
  justify-content: space-between;
  align-items: center;
  color: #666666;
  font-weight: 400;
  font-size: 14px;
  padding-bottom: 20px;
}
.detail-left {
  display: flex;
  align-items: center;
  gap: 8px;
}
.detail-value {
 color:#666666;
min-width: 72px;
}
/* Check icon */
.check_icon {
  width: 18px;
  height: 18px;
}
/* Subscribe Button */
.subscribe-btn {
  font-weight: 500;
  font-size: 14px;
  text-align: center;
  width: 311px;
  height: 36px;
  border-radius: 4px;
  padding: 8px 16px;
  color: #F5F5F5;
  background-color: #1494FF;
  border: none;
  cursor: pointer;
}
.subscribe-btn:hover {
  background: #0056D9;
  transform: translateY(-2px);
}

.download-btn {
    background: #0ea5e9;
    color: #fff;
    border: none;
    transition: background 0.2s;
    padding: 1.5rem;
    border-radius: 6px;

  }



   </style>
 
    <!-- Header end -->

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!-- Hero Section Start -->
    <section class="hero-section">
      <div class="container text-center">
        <h1>
          Simplify Crypto Payments
          <span> for Your Store </span>
        </h1>
        <p>
          Integrate CoinFlow in minutes and start accepting digital
          <span>currencies securely</span>
        </p>
      

     <!-- @foreach ($plans as $plan)
          <form action="{{ route('buyplan.store') }}" method="POST">
              @csrf
              <input type="hidden" name="plan_id" value="{{ $plan->id }}">
              <button type="submit" class="btn">
                  Download Plugin 
              </button>
          </form>
      @endforeach -->

       @if($license && isset($latestPlugin))
         <a href="{{ route('update-tracker.download', $latestPlugin->id) }}?license_key={{ $license->license_key }}"
           class="download-btn">
           Download Latest Plugin
         </a>
         @else
         <a href="#plans-section" class="download-btn">
           Purchase Plan
         </a>
         @endif

      


        <div class="hero-image">
          <picture>
            <source
              media="(max-width: 999px)"
              srcset="{{ asset('images/mobile_hero.png') }}"
            />
            <img src="{{ asset('images/image2.png') }}" alt="hero-image" />
          </picture>
        </div>
      </div>
    </section>
    <!-- Hero Section End -->

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!-- Features Section Start -->
    <section class="features-section">
      <div class="container text-center">
        <h2>Powerful Features to Simplify Crypto Payments</h2>
        <p class="subtitle">
          Everything your store needs to accept crypto payments seamlessly
        </p>
        <div class="features-grid">
          <div class="feature-item">
            <div class="icon" aria-hidden="true">
              <img src="{{ asset('images/Layer_1.png') }}" alt="Secure Transactions" />
            </div>
            <h3>Secure Transactions</h3>
            <p>End-to-end encryption and compliance built-in</p>
          </div>
          <div class="feature-item">
            <div class="icon" aria-hidden="true">
              <img src="{{ asset('images/Layer_2.png') }}" alt="Instant Settlements" />
            </div>
            <h3>Instant Settlements</h3>
            <p>Receive funds quickly without long waits</p>
          </div>
          <div class="feature-item">
            <div class="icon" aria-hidden="true">
              <img src="{{ asset('images/Layer_3.png') }}" alt="Global Currencies" />
            </div>
            <h3>Global Currencies</h3>
            <p>Support for BTC, ETH, USDT and more</p>
          </div>
          <div class="feature-item">
            <div class="icon" aria-hidden="true">
              <img src="{{ asset('images/Layer_4.png') }}" alt="Real-Time Analytics" />
            </div>
            <h3>Real-Time Analytics</h3>
            <p>Track payments and revenue in real time</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Features Section End -->

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!--Plans-Section Start  -->
    <section class="plans-section" id="plans-section">
      <div class="container">
        <div class="plans-header text-center">
          <h2>Flexible Plans for Every Store</h2>
          <p class="subtitle">
            Start free and scale as your business grows. Choose a plan that fits
            your needs and unlock more features with CoinFlow.
          </p>
        </div>
        <div class="image-section">
          @foreach($plans as $plan)
          <div class="plan-media">
            <img src="{{ asset('images/plan_img1.png') }}" alt="Plan preview 1" />
          </div>
          <div class="pro-plan-card">
       <h3 class="plan-title">{{ Str::title(preg_replace('/[^A-Za-z\s]/', '', $plan->name)) }}</h3>

        <div class="plan-price">
          <span class="price-amount">${{ number_format($plan->price ) }}</span>
          <span class="price-duration">/ {{ $plan->duration }}{{ $plan->duration_type }} </span>
        </div>
        <hr class="plan-divider" />
        <ul class="plan-details">
          <li>
            <div class="detail-left">
              <img src="{{ asset('images/check.png') }}" alt="" class="check_icon">Max activations: 
            </div>
            <span class="detail-value">{{ $plan->max_activations }}</span>
          </li>
          <li>
            <div class="detail-left">
              <img src="{{ asset('images/check.png') }}" alt="" class="check_icon"> License type: 
            </div>
            <span class="detail-value">{{ $plan->license_type }} </span>
          </li>
          <li>
            <div class="detail-left">
              <img src="{{ asset('images/check.png') }}" alt="" class="check_icon">Trial days: 
            <span class="detail-value">{{ $plan->trial_days }}</span>
          </li>
        </ul>
         <form action="{{ route('buyplan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button type="submit" class="subscribe-btn">
                                Subscribe
                            </button>
                        </form>

         
        @endforeach
      </div>
        </div>
      </div>
    </section>

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!-- Work Section start -->

    <section class="works-section">
      <div class="container">
        <div class="how-content">
          <!-- Left Side Image -->
          <div class="how-image">
            <img src="{{ asset('images/Export_left_img.png') }}" alt="Checkout with Crypto" />
          </div>
          <!-- Right Side Text -->
          <div class="how-text">
            <h2>How It Works</h2>
            <p>
              Everything your store needs to accept crypto payments seamlessly.
            </p>
            <div class="steps">
              <div class="step">
                <img src="{{ asset('images/work_icon1.png') }}" alt="Plugin Icon" />
                <span>Install the CoinFlow Plugin</span>
              </div>
              <div class="step">
                <img src="{{ asset('images/work_icon2.png') }}" alt="Wallet Icon" />
                <span>Connect Your Wallet</span>
              </div>
              <div class="step">
                <img src="{{ asset('images/work_icon3.png') }}" alt="Payments Icon" />
                <span>Start Accepting Payments</span>
              </div>
              <div class="step">
                <img src="{{ asset('images/work_icon4.png') }}" alt="Earnings Icon" />
                <span>Track Your Earnings</span>
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

    <section class="why-choose">
      <div class="container">
        <div class="why-header text-center">
          <h2>Why Choose CoinFlow?</h2>
          <p>
            CoinFlow simplifies cryptocurrency payments for online stores by
            providing a secure, transparent, and easy-to-manage payment
            experience.
          </p>
        </div>
        <div class="why-grid">
          <div class="why-card">
            <div class="why-icon">
              <img src="{{ asset('images/coinflow_sec_img1.png') }}" alt="Low Fees Icon" />
            </div>
            <h3>Low Transaction Fees</h3>
            <p>
              Keep more of your earnings with CoinFlow’s minimal transaction
              fees.
              <br />Unlike traditional payment gateways, we eliminate
              unnecessary intermediaries — ensuring you pay less while your
              customers enjoy seamless checkout experiences.
            </p>
          </div>
          <div class="why-card">
            <div class="why-icon">
              <img src="{{ asset('images/coinflow_sec_img2.png') }}" alt="Support Icon" />
            </div>
            <h3>24/7 Merchant Support</h3>
            <p>
              Our dedicated support team is available round the clock to help
              you troubleshoot, optimize, or upgrade your crypto payment setup.
              <br />
              From onboarding to technical assistance, we’re always here when
              you need us.
            </p>
          </div>
          <div class="why-card">
            <div class="why-icon">
              <img src="{{ asset('images/coinflow_sec_img3.png') }}" alt="Reporting Icon" />
            </div>
            <h3>Transparent Reporting</h3>
            <p>
              Get full visibility into every transaction with real-time
              analytics and clear reporting tools. <br />
              CoinFlow ensures complete transparency — no hidden fees, no
              complicated statements — just straightforward data you can trust.
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
    <section class="testimonials-section">
      <div class="testimonials-header">
        <h2>What Our Merchants Say</h2>
      </div>
      <div class="testimonials-slider">
        <article class="testimonial-card">
          <img
            class="quote-img"
            src="{{ asset('images/comma_merchant.svg') }}"
            alt=""
            aria-hidden="true"
          />
          <img class="rating-stars" src="{{ asset('images/five_star.svg') }}" alt="5 stars" />
          <p class="testimonial-text">
            Integrating CoinFlow into our store was effortless. We started
            accepting crypto payments from customers worldwide in minutes.
          </p>
          <div class="author">
            <img
              class="avatar"
              src="{{ asset('images/profile_logo_merchant.svg') }}"
              alt="Sethy Hipskyy"
            />
            <div class="meta">
              <strong>Sethy Hipskyy</strong>
              <span>CEO Universal</span>
            </div>
          </div>
        </article>
        <article class="testimonial-card">
          <img
            class="quote-img"
            src="{{ asset('images/comma_merchant.svg') }}"
            alt=""
            aria-hidden="true"
          />
          <img class="rating-stars" src="{{ asset('images/five_star.svg') }}" alt="5 stars" />
          <p class="testimonial-text">
            The instant settlement feature is incredible — no more long waits
            for funds. Transactions are simple and reliable.
          </p>
          <div class="author">
            <img
              class="avatar"
              src="{{ asset('images/profile_logo_merchant.svg') }}"
              alt="Justus Menke"
            />
            <div class="meta">
              <strong>Justus Menke</strong>
              <span>CEO Eronann</span>
            </div>
          </div>
        </article>
        <article class="testimonial-card">
          <img
            class="quote-img"
            src="{{ asset('images/comma_merchant.svg') }}"
            alt=""
            aria-hidden="true"
          />
          <img class="rating-stars" src="{{ asset('images/five_star.svg') }}" alt="5 stars" />
          <p class="testimonial-text">
            Our customers love having more payment options. The dashboard
            insights and real-time analytics help us grow.
          </p>
          <div class="author">
            <img
              class="avatar"
              src="{{ asset('images/profile_logo_merchant.svg') }}"
              alt="Britain Eriksen"
            />
            <div class="meta">
              <strong>Britain Eriksen</strong>
              <span>CEO Universal</span>
            </div>
          </div>
        </article>
        <article class="testimonial-card">
          <img
            class="quote-img"
            src="{{ asset('images/comma_merchant.svg') }}"
            alt=""
            aria-hidden="true"
          />
          <img class="rating-stars" src="{{ asset('images/five_star.svg') }}" alt="5 stars" />
          <p class="testimonial-text">
            CoinFlow redefined how we accept payments online. Integration with
            our existing systems was smooth.
          </p>
          <div class="author">
            <img
              class="avatar"
              src="{{ asset('images/profile_logo_merchant.svg') }}"
              alt="Britain Eriksen"
            />
            <div class="meta">
              <strong>Britain Eriksen</strong>
              <span>CEO Universal</span>
            </div>
          </div>
        </article>
        <article class="testimonial-card">
          <img
            class="quote-img"
            src="{{ asset('images/comma_merchant.svg') }}"
            alt=""
            aria-hidden="true"
          />
          <img class="rating-stars" src="{{ asset('images/five_star.svg') }}" alt="5 stars" />
          <p class="testimonial-text">
            CoinFlow redefined how we accept payments online. Integration with
            our existing systems was smooth.
          </p>
          <div class="author">
            <img
              class="avatar"
              src="{{ asset('images/profile_logo_merchant.svg') }}"
              alt="Britain Eriksen"
            />
            <div class="meta">
              <strong>Britain Eriksen</strong>
              <span>CEO Universal</span>
            </div>
          </div>
        </article>
        <article class="testimonial-card">
          <img
            class="quote-img"
            src="{{ asset('images/comma_merchant.svg') }}"
            alt=""
            aria-hidden="true"
          />
          <img class="rating-stars" src="{{ asset('images/five_star.svg') }}" alt="5 stars" />
          <p class="testimonial-text">
            CoinFlow redefined how we accept payments online. Integration with
            our existing systems was smooth.
          </p>
          <div class="author">
            <img
              class="avatar"
              src="{{ asset('images/profile_logo_merchant.svg') }}"
              alt="Britain Eriksen"
            />
            <div class="meta">
              <strong>Britain Eriksen</strong>
              <span>CEO Universal</span>
            </div>
          </div>
        </article>
      </div>
    </section>
    <!-- merchant section end -->

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!-- Pricing Intro Section Started -->
    <section class="pricing-intro">
      <div class="container">
        <div class="pricing-content">
          <!-- Left Text Section -->
          <div class="pricing-text">
            <h2>Simple, Transparent Pricing</h2>
            <p>
              No surprises — just straightforward plans designed to scale with
              your business.
            </p>
            <button class="view-btn">View Plans</button>
          </div>
          <!-- Right Image Section -->
          <div class="pricing-media">
            <img src="{{ asset('images/pricing_sec_img.svg') }}" alt="Pricing Preview" />
          </div>
        </div>
      </div>
    </section>
    <!-- Pricing Intro Section End-->

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!-- Blog Section Started -->
    <section class="blog-section">
      <div class="container">
        <div class="blog-header text-center">
          <h2>Latest from the Blog</h2>
          <p>
            Insights, guides, and crypto-commerce trends — stay ahead with
            expert tips from CoinFlow.
          </p>
        </div>
        <div class="blog-grid">
          <!-- Blog Card 1 -->
          <div class="blog-card">
            <img
              src="{{ asset('images/blog_img1.png') }}"
              alt="Blog Image 1"
              class="blog-img"
            />
            <div class="blog-content">
              <div class="blog-meta">
                <img src="{{ asset('images/blog_icon1.png') }}" alt="icon" class="blog-icon" />
                <span>May 03, 2025</span>
              </div>
              <h3>5 Ways to Increase Sales by Accepting Crypto Payments</h3>
              <p>
                Discover how top online stores are boosting conversions and
                attracting new customers.
              </p>
              <a href="#" class="read-more">Read More →</a>
            </div>
          </div>
          <!-- Blog Card 2 -->
          <div class="blog-card">
            <img
              src="{{ asset('images/blog_img2.png') }}"
              alt="Blog Image 2"
              class="blog-img"
            />
            <div class="blog-content">
              <div class="blog-meta">
                <img src="{{ asset('images/blog_icon1.png') }}" alt="icon" class="blog-icon" />
                <span>May 03, 2025</span>
              </div>
              <h3>Getting Started with CoinFlow: A Step-by-Step Setup Guide</h3>
              <p>
                Learn how to install the plugin, connect your wallet, and start
                accepting payments.
              </p>
              <a href="#" class="read-more">Read More →</a>
            </div>
          </div>
          <!-- Blog Card 3 -->
          <div class="blog-card">
            <img
              src="{{ asset('images/blog_img3.png') }}"
              alt="Blog Image 3"
              class="blog-img"
            />
            <div class="blog-content">
              <div class="blog-meta">
                <img src="{{ asset('images/blog_icon1.png') }}" alt="icon" class="blog-icon" />
                <span>May 03, 2025</span>
              </div>
              <h3>The Future of Crypto Commerce: What Merchants Should Know</h3>
              <p>
                From stablecoins to Layer 2 solutions — explore the technologies
                shaping tomorrow.
              </p>
              <a href="#" class="read-more">Read More →</a>
            </div>
          </div>
          <!-- Blog Card 4 -->
          <div class="blog-card">
            <img
              src="{{ asset('images/blog_img4.png') }}"
              alt="Blog Image 4"
              class="blog-img"
            />
            <div class="blog-content">
              <div class="blog-meta">
                <img src="{{ asset('images/blog_icon1.png') }}" alt="icon" class="blog-icon" />
                <span>May 03, 2025</span>
              </div>
              <h3>5 Ways to Increase Sales by Accepting Crypto Payments</h3>
              <p>
                Discover how top online stores are boosting conversions and
                attracting new customers.
              </p>
              <a href="#" class="read-more">Read More →</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Blog Section End-->

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!-- Download Section Start -->
    <section class="download-section">
      <div class="container">
        <div class="download-card">
          <h2>Start Accepting Crypto Today</h2>
          <p>Join 100+ merchants simplifying crypto payments with CoinFlow</p>
          <div class="download-actions">
            <a href="#" class="btn primary">Download Plugin</a>
            <a href="#" class="btn ghost">Contact Sales</a>
          </div>
        </div>
      </div>
    </section>
    <!-- Download Section End -->

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->

    <!-- FAQ Section started -->
    <section class="faq-section">
      <div class="container">
        <h2 class="faq-title">Frequently Asked Questions</h2>
        <div class="faq-container">
          <!-- FAQ Item 1 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/faqplus_icon.png') }}" alt="icon" class="faq-icon" />
              <h3>How does CoinFlow work with my eCommerce store?</h3>
            </div>
            <div class="faq-answer">
              <p>
                CoinFlow integrates seamlessly with platforms like Shopify,
                WooCommerce, and Magento. Once installed, it allows you to
                accept crypto payments directly from customers using supported
                wallets.
              </p>
            </div>
          </div>
          <!-- FAQ Item 2 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/faqplus_icon.png') }}" alt="icon" class="faq-icon" />
              <h3>What cryptocurrencies does CoinFlow support?</h3>
            </div>
            <div class="faq-answer">
              <p>
                CoinFlow supports a wide range of cryptocurrencies including
                BTC, ETH, USDT, and many more to make payments convenient for
                customers.
              </p>
            </div>
          </div>
          <!-- FAQ Item 3 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/faqplus_icon.png') }}" alt="icon" class="faq-icon" />
              <h3>How long do crypto transactions take to process?</h3>
            </div>
            <div class="faq-answer">
              <p>
                Transaction time varies depending on network congestion but
                usually takes between a few seconds to a few minutes.
              </p>
            </div>
          </div>
          <!-- FAQ Item 4 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/faqplus_icon.png') }}" alt="icon" class="faq-icon" />
              <h3>Are there any hidden fees?</h3>
            </div>
            <div class="faq-answer">
              <p>
                No hidden charges — CoinFlow maintains complete transparency
                with all transaction fees clearly displayed upfront.
              </p>
            </div>
          </div>
          <!-- FAQ Item 5 -->
          <div class="faq-item">
            <div class="faq-question">
              <img src="{{ asset('images/faqplus_icon.png') }}" alt="icon" class="faq-icon" />
              <h3>Can I withdraw earnings in fiat currency?</h3>
            </div>
            <div class="faq-answer">
              <p>
                Yes, you can convert and withdraw your crypto earnings into fiat
                currency directly through supported exchanges or wallets.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ---------------- -->
    <!-- ---------------- -->
    <!-- ---------------- -->


     @include('home-fronted.include.footer')
    </div>


 