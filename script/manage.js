function populateForm(id, name, price, quantity, stat, dates, suply) {
    document.getElementById('medId').value = id;
    document.getElementById('medName').value = name;
    document.getElementById('price').value = price;
    document.getElementById('quantity').value = quantity;
    document.getElementById('status').value = stat;
    document.getElementById('expD').value = dates;
    document.getElementById('supply').value = suply;
}

function clearForm(){
    document.getElementById('medId').value = '';
    document.getElementById('medName').value = '';
    document.getElementById('price').value = '';
    document.getElementById('quantity').value = '';
    document.getElementById('status').value = '';
    document.getElementById('expD').value = '';
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