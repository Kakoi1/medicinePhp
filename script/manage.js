function populateForm(id, name, price, quantity, stat, dates) {

    document.getElementById('medTransac').style.display = 'flex';
    // document.getElementById('medId').value = '';
    // document.getElementById('medName').value = '';
    // document.getElementById('price').value = '';
    // document.getElementById('quantity').value = '';
    // document.getElementById('status').value = '';
    // document.getElementById('expD').value = '';
    // document.getElementById('quanBuy').value = '';
    // document.getElementById('tPrice').value = '';
    // document.getElementById('cash').value = '';
    // document.getElementById('change').value = '';


    document.getElementById('medId').value = id;
    document.getElementById('medName').value = name;
    document.getElementById('price').value = price;
    document.getElementById('quantity').value = quantity;
    document.getElementById('status').value = stat;
    document.getElementById('expD').value = dates;
    // document.getElementById('deleteField').value = id;
    
}

function populateForm1(id, name, price, quantity, dates, supp, category,type) {

    document.getElementById('medId').value = id;
    document.getElementById('medName').value = name;
    document.getElementById('medic').value = name;
    document.getElementById('price').value = price;
    document.getElementById('quantity').value = quantity;
    document.getElementById('overlayUp').style.display = 'flex';
    document.getElementById('expD').value = dates;
    document.getElementById('supply').value = supp;
    document.getElementById('selectedInput').value = category;
    document.getElementById('medType').value = type;
    
    console.log(id, name, price, quantity, dates, supp)
}

function clearForm(){
    document.getElementById('medId').value = '';
    document.getElementById('medName').value = '';
    document.getElementById('price').value = '';
    document.getElementById('quantity').value = '';
    document.getElementById('status').value = '';
    document.getElementById('expD').value = '';
    document.getElementById('quanBuy').value = '';
    document.getElementById('tPrice').value = '';
    document.getElementById('cash').value = '';
    document.getElementById('change').value = '';
}
clear.addEventListener('click', clearForm);



function openReport(){
    document.getElementById('overHer').style.display = 'flex';
}
function closeReport(){
    document.getElementById('overHer').style.display = 'none';
}
function closemedUp(){
    document.getElementById('overlayUp').style.display = 'none';
    document.getElementById("popup").style.display = "none";
}
genPorts.addEventListener('click', openReport);

function idtoDelete(id){
    document.getElementById('inputSearch').value = id;
    
}
function openMedupdate(){
    document.getElementById('overlayMed').style.display = 'flex';
    document.getElementById('add').style.display = 'none';
    document.getElementById('clear').style.display = 'none';
    // document.getElementById('alertOver').style.display = 'flex';
}
function openMedadd(){
    document.getElementById('overlayMed').style.display = 'flex';
    document.getElementById('update').style.display = 'none';
    document.getElementById('delete').style.display = 'none';
    document.getElementById('clear').style.display = 'block';

}
function closeMedupdate(){
    document.getElementById('overlayMed').style.display = 'none';
    document.getElementById('add').style.display = 'block';
    document.getElementById('update').style.display = 'block';
    document.getElementById('delete').style.display = 'block';
    document.getElementById('clear').style.display = 'block';
    document.getElementById('medId').value = '';
    document.getElementById('medName').value = '';
    document.getElementById('price').value = '';
    document.getElementById('quantity').value = '';
    document.getElementById('status').value = '';
    document.getElementById('expD').value = '';
}

function showTab(tabNumber) {
   
    document.querySelectorAll('.tab-content').forEach(function(content) {
        content.classList.remove('active');
    });

   
    document.querySelector('.tab' + tabNumber + '-content').classList.add('active');
}
function sidebarShow(){
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('contents');

    if (sidebar.style.marginLeft === '-250px') {
      sidebar.style.marginLeft = '0';
      content.style.marginLeft = '250px';
      
    } else {
      sidebar.style.marginLeft = '-250px';
      content.style.marginLeft = '0';
      
    }
}

function fetchArchive(num,action) {
    fetch('fetchArchive.php?archive=' + num+'&action='+action)
    .then(response => response.text())
    .then(data => {
    // alert(response);
    document.getElementById("tableData").innerHTML = data;
    })
    .catch(error => {
    console.error('Error fetching note content:', error);
    });
    }
    function filterHistory(action) {
        var filterValue = document.querySelector('input[name="filter"]:checked').value;
    
        $.ajax({
            type: 'POST',
            url: 'filterHistory.php',
            data: { filter: filterValue, action: action },
            success: function(response) {
                $('#historyTableBody').html(response);
            },
            error: function(xhr, status, error) {
                alert("Error: " + error);
            }
        });
    }
