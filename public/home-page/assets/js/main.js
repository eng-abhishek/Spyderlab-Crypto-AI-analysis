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

    
    // login toast
    document.addEventListener('DOMContentLoaded', function() {
      var successToast = new bootstrap.Toast(document.getElementById('successToast'), {
          delay: 5000 // Optional: You can adjust the delay time
      });
      successToast.show();
  });
  
  