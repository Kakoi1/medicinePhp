function performSearch() {
    // Get the search term from the input field
    var searchTerm = document.getElementById('inputSearch').value;

    // Get selected categories
    var selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(checkbox => checkbox.value);

    var selectedType = document.querySelector('input[name="type"]:checked')?.value || '';

    // Create the query string
    var query = `inputSearch=${encodeURIComponent(searchTerm)}`;
    selectedCategories.forEach(category => {
        query += `&categories[]=${encodeURIComponent(category)}`;
    });

    if (selectedType && selectedType !== 'all') {
        query += `&type=${encodeURIComponent(selectedType)}`;
    }

    console.log(query);

    // Fetch API to send a GET request
    fetch('search.php?' + query)
        .then(response => response.text())
        .then(data => {
            // Update the content of the tableData div with the response
            document.getElementById('tableData').innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Add event listener to checkboxes to trigger performSearch on change
// document.querySelectorAll('.category-checkbox').forEach(checkbox => {
//     checkbox.addEventListener('change', performSearch);
// });


// Add event listener to checkboxes to trigger performSearch on change
// document.querySelectorAll('.category-checkbox').forEach(checkbox => {
//     checkbox.addEventListener('change', performSearch);
// });

    
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

        function transacSearch() {
            // Get the search term from the input field
             var searchTerm = document.getElementById('inputSearch').value;

    // Get selected categories
    var selectedCategories = Array.from(document.querySelectorAll('.category-checkbox:checked')).map(checkbox => checkbox.value);

    var selectedType = document.querySelector('input[name="type"]:checked')?.value || '';

    // Create the query string
    var query = `inputSearch=${encodeURIComponent(searchTerm)}`;
    selectedCategories.forEach(category => {
        query += `&categories[]=${encodeURIComponent(category)}`;
    });
    
    if (selectedType && selectedType !== 'all') {
        query += `&type=${encodeURIComponent(selectedType)}`;
    }

    console.log(query);
            // Fetch API to send a GET request
            fetch('transacSearch.php?' + query)
                .then(response => response.text())
                .then(data => {
                    // Update the content of the tableData div with the response
                    document.getElementById('tableData').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            