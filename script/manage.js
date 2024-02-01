function populateForm(id, name, price, quantity, stat, dates, suply) {
    document.getElementById('medId').value = id;
    document.getElementById('medName').value = name;
    document.getElementById('price').value = price;
    document.getElementById('quantity').value = quantity;
    document.getElementById('status').value = stat;
    document.getElementById('expD').value = dates;
    document.getElementById('supply').value = suply;
    document.getElementById('deleteField').value = id;
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