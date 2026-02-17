
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
                if (otherIcon) otherIcon.src = '/images/nin_plus.png';
              }
            });

            // Toggle current item
            item.classList.toggle('active');

            // Update icon
            if (item.classList.contains('active')) {
              icon.src = '/images/nin_sub.png';
            } else {
              icon.src = '/images/nin_plus.png'; 
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
