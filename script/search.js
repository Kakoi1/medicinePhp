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
    
    function statChange(){
        var quan = parseFloat(document.getElementById('quantity').value)  
       if(quan <= 0){
        document.getElementById('status').value = 'Out of Stock';
       }else{
        document.getElementById('status').value = 'Available';
       }
      
    }
    document.getElementById("status").addEventListener("mousedown", function(e) {
          e.preventDefault(); // Prevent the default action
        });

  