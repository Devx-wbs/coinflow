(function () {
  var body = document.body;
  var toggle = document.querySelector(".menu-toggle");
  var drawer = document.getElementById("mobile-drawer");
  var backdrop = document.querySelector(".drawer-backdrop");

  function openDrawer() {
    drawer.classList.add("open");
    backdrop.removeAttribute("hidden");
    backdrop.classList.add("active");
    toggle.setAttribute("aria-expanded", "true");
    drawer.setAttribute("aria-hidden", "false");
    body.classList.add("no-scroll");
    toggle.classList.add("active");
  }

  function closeDrawer() {
    drawer.classList.remove("open");
    backdrop.classList.remove("active");
    backdrop.setAttribute("hidden", "hidden");
    toggle.setAttribute("aria-expanded", "false");
    drawer.setAttribute("aria-hidden", "true");
    body.classList.remove("no-scroll");
    toggle.classList.remove("active");
  }

  if (toggle)
    toggle.addEventListener("click", function () {
      if (drawer.classList.contains("open")) {
        closeDrawer();
      } else {
        openDrawer();
      }
    });
  if (backdrop) backdrop.addEventListener("click", closeDrawer);
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") closeDrawer();
  });

  // Drag-to-scroll for testimonials slider
  var slider = document.querySelector(".testimonials-slider");
  if (slider) {
    var isDown = false;
    var startX = 0;
    var scrollLeft = 0;

    var start = function (e) {
      isDown = true;
      slider.classList.add("dragging");
      slider.style.scrollSnapType = "none";
      startX = (e.pageX || e.touches[0].pageX) - slider.offsetLeft;
      scrollLeft = slider.scrollLeft;
    };
    var move = function (e) {
      if (!isDown) return;
      e.preventDefault();
      var x =
        (e.pageX || (e.touches && e.touches[0].pageX)) - slider.offsetLeft;
      var walk = x - startX;
      slider.scrollLeft = scrollLeft - walk;
    };
    var end = function () {
      isDown = false;
      slider.classList.remove("dragging");
      slider.style.scrollSnapType = "";
    };

    slider.addEventListener("mousedown", start);
    slider.addEventListener("mousemove", move);
    slider.addEventListener("mouseleave", end);
    slider.addEventListener("mouseup", end);
    slider.addEventListener("touchstart", start, { passive: true });
    slider.addEventListener("touchmove", move, { passive: false });
    slider.addEventListener("touchend", end);
  }
})();

const faqItems = document.querySelectorAll(".faq-item");
faqItems.forEach((item) => {
  const question = item.querySelector(".faq-question");
  const icon = item.querySelector(".faq-icon");
  question.addEventListener("click", () => {
    // Close all others first
    faqItems.forEach((i) => {
      if (i !== item) {
        i.classList.remove("active");
        i.querySelector(".faq-answer").style.maxHeight = null;
        i.querySelector(".faq-icon").src = "public/faqplus_icon.png";
      }
    });
    // Toggle this one
    item.classList.toggle("active");
    const answer = item.querySelector(".faq-answer");
    if (item.classList.contains("active")) {
      answer.style.maxHeight = answer.scrollHeight + "px";
      icon.src = "public/faqminus_icon.png"; // Switch to minus
    } else {
      answer.style.maxHeight = null;
      icon.src = "public/faqplus_icon.png"; // Back to plus
    }
  });
});
