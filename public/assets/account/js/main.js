window.onload = function() {
  document.getElementById("content").style.opacity = 1; 
  document.getElementById("header").style.opacity = 1;
  document.getElementById("footer").style.opacity = 1;  /* Make it visible */
};
document.addEventListener("DOMContentLoaded", function() {
  var sidebar = document.getElementById("sidebar");
  var header = document.getElementById("header");
  var content = document.getElementById("content");
  var footer = document.getElementById("footer");
  var toggleBtn = document.getElementById("toggleSidebar");
  var mobileCloseBtn = document.getElementById("mobile-nav-close-btn");

  // Remove the "collapsed" class when the page loads
  sidebar.classList.remove("collapsed");
  header.classList.remove("collapsed");
  content.classList.remove("collapsed");
  footer.classList.remove("collapsed");

  // Add event listener to the toggle button to collapse/expand sidebar
  toggleBtn.addEventListener("click", function() {
      sidebar.classList.toggle("collapsed");
      header.classList.toggle("collapsed");
      content.classList.toggle("collapsed");
      footer.classList.toggle("collapsed");
  });

  // Add event listener to the mobile close button
  mobileCloseBtn.addEventListener("click", function() {
      sidebar.classList.add("collapsed");
      header.classList.add("collapsed");
      content.classList.add("collapsed");
      footer.classList.add("collapsed");
  });
});

    document.querySelectorAll('.nav-link.dropdown-icon').forEach(function(dropdown) {
      dropdown.addEventListener('click', function () {
        var icon = this.querySelector('.rotate-icon');
        var submenu = document.querySelector(this.dataset.bsTarget);
        
        // Toggle the rotated class on the icon
        icon.classList.toggle('rotated');
        
        // Add event listeners to ensure the icon rotation is synchronized with submenu state
        submenu.addEventListener('shown.bs.collapse', function () {
          icon.classList.add('rotated');
        });
        submenu.addEventListener('hidden.bs.collapse', function () {
          icon.classList.remove('rotated');
        });
      });
    });

  
      document.getElementById('mobile-nav-close-btn').addEventListener('click', function () {
      var sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('collapsed');
    });

    document.querySelectorAll('.nav-link').forEach(function(link) {
      link.addEventListener('click', function () {
        document.querySelectorAll('.nav-link').forEach(function(nav) {
          nav.classList.remove('active');
        });
        this.classList.add('active');
      });
    });

    // tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    document.addEventListener('DOMContentLoaded', function() {
      var addMonitoringModal = new bootstrap.Modal(document.getElementById('addMonitoringModal'));
      var editMonitoringModal = new bootstrap.Modal(document.getElementById('editMonitoringModal'));
      var recipientEmailModal = new bootstrap.Modal(document.getElementById('recipientEmailModal'));
      var currentMonitoringModal = null;
    
      // Event listener for buttons that open the recipientEmailModal from addMonitoringModal
      document.querySelectorAll('.open-email-from-add').forEach(function(button) {
        button.addEventListener('click', function() {
          addMonitoringModal.hide();
          recipientEmailModal.show();
          currentMonitoringModal = addMonitoringModal;
        });
      });
    
      // Event listener for buttons that open the recipientEmailModal from editMonitoringModal
      document.querySelectorAll('.open-email-from-edit').forEach(function(button) {
        button.addEventListener('click', function() {
          editMonitoringModal.hide();
          recipientEmailModal.show();
          currentMonitoringModal = editMonitoringModal;
        });
      });
    
      // When the recipientEmailModal is hidden, show the last monitoring modal
      document.getElementById('recipientEmailModal').addEventListener('hidden.bs.modal', function() {
        if (currentMonitoringModal) {
          currentMonitoringModal.show();
          currentMonitoringModal = null;
        }
      });
    });
    

    // toast click btn add
    document.addEventListener("DOMContentLoaded", function() {
      const addButton = document.getElementById('liveToastBtn');
      const toastEl = document.getElementById('liveToast');

      addButton.addEventListener('click', function() {
        const toast = new bootstrap.Toast(toastEl);
        toast.show();
      });
    });

// auto show toast

    document.addEventListener('DOMContentLoaded', function() {

      var successToast = new bootstrap.Toast(document.getElementById('successToast'), {

        delay: 10000000 // Optional: You can adjust the delay time

      });

      successToast.show();

    });


    // osint phone and email section
    function toggleEmailInfo() {
      const emailInfo = document.querySelector('.email-information');
      const phoneNumberInfo = document.querySelector('.phone-number-information');
  
      // Toggle visibility
      emailInfo.style.display = 'block';
      phoneNumberInfo.style.display = 'none';
  }
  
  function togglePhoneNumberInfo() {
      const emailInfo = document.querySelector('.email-information');
      const phoneNumberInfo = document.querySelector('.phone-number-information');
  
      // Toggle visibility
      emailInfo.style.display = 'none';
      phoneNumberInfo.style.display = 'block';
  }
  






 
 
 
  





 