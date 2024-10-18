"use strict";

var resultsHolder = document.getElementById('membership-page-content');
var searchForm = document.getElementById('DirectorySearchForm_Form');
function initDirectorySearchForm() {
  if (resultsHolder === null || searchForm === null) {
    console.error('Cannot find required elements.  Quitting');
    return;
  }
  searchForm.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form's default submission behavior

    var formData = new FormData(searchForm); // Get the form data

    hideResultsContent().then(function () {
      // Fetch POST request to the URL specified in the form's action attribute
      fetch(searchForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest' // Signal that this is an AJAX request
        }
      }).then(function (response) {
        return response.text();
      }) // Assuming the response is an HTML fragment
      .then(function (html) {
        // Populate new results
        processResults(html);
        // Fade the results back in after updating
        showResultsContent();
      })["catch"](function (error) {
        console.error('Error occurred during form submission:', error);
      });
    });
  });
}

// Function to hide results content with a fade-out effect
function hideResultsContent() {
  return new Promise(function (resolve) {
    resultsHolder.classList.add('hidden'); // Start the fade-out
    setTimeout(function () {
      resolve(); // Resolve after the fade-out is complete (200ms)
    }, 200);
  });
}

// Function to show results content with a fade-in effect
function showResultsContent() {
  resultsHolder.classList.remove('hidden'); // Fade the content back in
}

// Function to process and insert the HTML fragment into the results holder
function processResults(html) {
  // Clear the previous results
  resultsHolder.innerHTML = '';

  // Insert the new HTML fragment into the resultsHolder
  resultsHolder.innerHTML = html;
}

// Initialize the form submission behavior
initDirectorySearchForm();
//# sourceMappingURL=maps/directory_main.js.map
