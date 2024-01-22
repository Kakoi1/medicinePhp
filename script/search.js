function performSearch() {
    // Get the search term from the input field
    var searchTerm = document.getElementById('inputSearch').value;

    // Fetch API to send a GET request
    fetch('search.php?inputSearch=' + encodeURIComponent(searchTerm))
        .then(response => response.text())
        .then(data => {
            // Update the content of the searchResults div with the response
            document.getElementById('tableData').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
   
        