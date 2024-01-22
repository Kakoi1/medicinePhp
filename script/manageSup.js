function populateForm1(id, company, address, cont, email) {
    document.getElementById('supId').value = id;
    document.getElementById('company').value = company;
    document.getElementById('address').value = address;
    document.getElementById('cont').value = cont;
    document.getElementById('email').value = email;

}
function clearForms(){
    document.getElementById('supId').value = '';
    document.getElementById('company').value = '';
    document.getElementById('address').value = '';
    document.getElementById('cont').value = '';
    document.getElementById('email').value = '';
}
clear.addEventListener('click', clearForms);