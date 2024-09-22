// main slider
$(document).ready(function(){
    $(".main-banner").owlCarousel({
        items: 1,
        loop: true,
        margin: 10,
        nav:false,
        dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true
    });
});

// blog details slider
$(document).ready(function() {
  // Initialize the second Owl Carousel
  $("#second-owl-carousel").owlCarousel({
      items: 1, // Number of items to display
      loop: true,
      nav:true,
      autoplay: true,
      dots:false,
      autoplayTimeout: 3000,
      navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
  });
});

document.addEventListener('DOMContentLoaded', function () {
    // Get all the tab links
    const tabLinks = document.querySelectorAll('.product-list a');
    // Get all the service boxes
    const serviceBoxes = document.querySelectorAll('.service-box');

    // Function to handle tab switching
    function switchTab(event) {
        event.preventDefault();

        // Get the target tab
        const targetTab = event.target.getAttribute('data-tab');

        // Remove active class from all tabs
        tabLinks.forEach(link => link.classList.remove('active'));
        // Add active class to the clicked tab
        event.target.classList.add('active');

        // Hide all service boxes
        serviceBoxes.forEach(box => box.style.display = 'none');
        // Show service boxes corresponding to the selected tab
        document.querySelectorAll(`.service-box[id="${targetTab}"]`).forEach(box => box.style.display = 'block');
    }

    // Add event listeners to all tab links
    tabLinks.forEach(link => link.addEventListener('click', switchTab));

    // Initially trigger a click on the active tab to show its content
    document.querySelector('.product-list a.active').click();
});

document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function () {
        if (window.scrollY > 0) {
            navbar.classList.add('navbar-shadow');
        } else {
            navbar.classList.remove('navbar-shadow');
        }
    });
});

// counter
$(document).ready(function() {

    var counters = $(".count-number");
    var countersQuantity = counters.length;
    var counter = [];
  
    for (i = 0; i < countersQuantity; i++) {
      counter[i] = parseInt(counters[i].innerHTML);
    }
  
    var count = function(start, value, id) {
      var localStart = start;
      setInterval(function() {
        if (localStart < value) {
          localStart++;
          counters[id].innerHTML = localStart;
        }
      }, 40);
    }
  
    for (j = 0; j < countersQuantity; j++) {
      count(0, counter[j], j);
    }
  });
  
    // login toast
    document.addEventListener('DOMContentLoaded', function() {
      var successToast = new bootstrap.Toast(document.getElementById('successToast'), {
        delay: 5000 // Optional: You can adjust the delay time
      });
      successToast.show();
    

    });

// blog-details-FAQ
document.addEventListener('DOMContentLoaded', function() {
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
      const question = item.querySelector('.faq-question');
      const answer = item.querySelector('.faq-answer');
      const icon = item.querySelector('.icon');

      question.addEventListener('click', () => {
          // Close all other answers
          faqItems.forEach(otherItem => {
              if (otherItem !== item) {
                  otherItem.querySelector('.faq-answer').style.display = 'none';
                  otherItem.querySelector('.icon').textContent = '+';
              }
          });

          // Toggle the clicked answer
          const isOpen = answer.style.display === 'block';
          answer.style.display = isOpen ? 'none' : 'block';
          icon.textContent = isOpen ? '+' : '−';
      });
  });
});


// fa-sidebar
function toggleCardBody() {
  var cardBody = document.getElementById('cardBody');
  cardBody.classList.toggle('close'); // Toggle the open class on card-body

  var toggleButtonIcon = document.querySelector('#toggleButton .rotate-icon');
  toggleButtonIcon.classList.toggle('rotate');

  // Toggle card body visibility
  cardBody.style.display = cardBody.classList.contains('close') ? 'none' : 'block';
}


// drop  down submenu
document.querySelectorAll('.toc > ul > li > a').forEach(item => {
  item.addEventListener('click', event => {
    let nextEl = item.nextElementSibling;
    if (nextEl) {
      nextEl.classList.toggle('show');
      item.parentElement.classList.toggle('show');
    }
  });
});

document.querySelectorAll('.toc > ul > li > ul > li > a').forEach(item => {
  item.addEventListener('click', event => {
    let nextEl = item.nextElementSibling;
    if (nextEl) {
      nextEl.classList.toggle('show');
      item.parentElement.classList.toggle('show');
    }
  });
});



  //js login/signup card
  const signInBtn = document.getElementById('signInBtn');
    const signUpBtn = document.getElementById('signUpBtn');
    const signInForm = document.getElementById('signInForm');
    const signUpForm = document.getElementById('signUpForm');

    signInBtn.addEventListener('click', () => {
        signInForm.classList.add('active');
        signUpForm.classList.remove('active');
        signInBtn.classList.add('active');
        signUpBtn.classList.remove('active');
    });

    signUpBtn.addEventListener('click', () => {
        signUpForm.classList.add('active');
        signInForm.classList.remove('active');
        signUpBtn.classList.add('active');
        signInBtn.classList.remove('active');
    }); 

    // range
    



    // login page email password
     // Initialize the previous value to 0
     let previousValue = 0;
    document.addEventListener('DOMContentLoaded', function () {
      const showPasswordButton = document.getElementById('showPasswordButton');
      const signInForm = document.getElementById('signInForm');
      const emailError = document.getElementById('emailError');

      showPasswordButton.addEventListener('input', function () {
          var rangeValue = parseInt(this.value);
          emailError.textContent = "Current range value: " + rangeValue;

          // Toggle signInForm visibility based on rangeValue
          if (rangeValue === 100 || rangeValue > 80) {
              signInForm.classList.add('show');
          } else {
              signInForm.classList.remove('show');
          }

          previousValue = rangeValue;
      });

      // Initialize the range value display to 0
      emailError.textContent = "Current range value: " + showPasswordButton.value;
  });

  
  
  //signup page email password
     // Initialize the previous value to 0
     let previousValue1 = 0;
    document.addEventListener('DOMContentLoaded', function () {
      const showPasswordButtonsignup = document.getElementById('showPasswordButtonsignup');
      const signUpForm = document.getElementById('signUpForm');
      const emailErrorSignup = document.getElementById('emailErrorSignup');

      showPasswordButtonsignup.addEventListener('input', function () {
          var rangeValue = parseInt(this.value);
          emailErrorSignup.textContent = "Current range value: " + rangeValue;

          // Toggle signInForm visibility based on rangeValue
          if (rangeValue === 100 || rangeValue > 80) {
              signUpForm.classList.add('show');
          } else {
              signUpForm.classList.remove('show');
          }

          previousValue1 = rangeValue;
      });

      // Initialize the range value display to 0
      emailErrorSignup.textContent = "Current range value: " + showPasswordButtonsignup.value;
  });
    
  
  
  

  