// Dynamically load jQuery
var jqueryScript = document.createElement('script');
jqueryScript.src = 'https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js';
document.head.appendChild(jqueryScript);

// Dynamically load Bootstrap
var bootstrapScript = document.createElement('script');
bootstrapScript.src = 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js';
document.head.appendChild(bootstrapScript);



document.addEventListener("DOMContentLoaded", function () {
  const getStartedBtn = document.getElementById("getStartedBtn");
  const formCard = document.getElementById("formCard");

  if (getStartedBtn && formCard) {
      getStartedBtn.addEventListener("click", function () {
          formCard.style.display = "block";
      });
  }
});

/** */

// Get all the input fields
const inputs = document.querySelectorAll('.form-control');

// Add focus and blur event listeners to handle the label animation
inputs.forEach(input => {
    input.addEventListener('focus', () => {
        const label = input.previousElementSibling;
        label.style.top = '-8px'; // Move label above the border
        label.style.fontSize = '12px'; // Shrink font size on focus
        label.style.color = '#007bff'; // Change label color on focus
    });

    input.addEventListener('blur', () => {
        const label = input.previousElementSibling;
        if (input.value === '') {
            label.style.top = '50%'; // Reset label to the middle
            label.style.fontSize = '16px'; // Reset font size
            label.style.color = '#6c757d'; // Reset label color
        }
    });
});

/**** UPDATE DOWNLOAD COUNTS */
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function (event) {
            let fileID = this.getAttribute('data-id');
            let href = this.getAttribute('href');

            if (!fileID) {
                event.preventDefault();
                alert("Error: No file ID found.");
                return;
            }

            console.log("Download button clicked. File ID: " + fileID);
            console.log("Download link: " + href);
        });
    });
});
