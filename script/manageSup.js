function populateSup(id, company, address, cont, email) {
    document.getElementById('supId').value = id;
    document.getElementById('company').value = company;
    document.getElementById('namer').value = company;
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

function openSupForm(){
    document.getElementById('overlaySup').style.display = 'flex';
    document.getElementById('add').style.display = 'none';
    document.getElementById('clear').style.display = 'none';
}
function openSupadd(){
    document.getElementById('overlaySup').style.display = 'flex';
    document.getElementById('update').style.display = 'none';
    document.getElementById('delete').style.display = 'none';
}
function closeSupForm(){
    document.getElementById('overlaySup').style.display = 'none';
    document.getElementById('add').style.display = 'block';
    document.getElementById('update').style.display = 'block';
    document.getElementById('delete').style.display = 'block';
    document.getElementById('clear').style.display = 'block';
    document.getElementById('supId').value = '';
    document.getElementById('company').value = '';
    document.getElementById('address').value = '';
    document.getElementById('cont').value = '';
    document.getElementById('email').value = '';
    document.getElementById('categoryForm').reset();
}
function populateCat(id, name, desc) {
    document.getElementById('catId').value = id;
    document.getElementById('namer').value = name;
    document.getElementById('desc').value = desc;
    document.getElementById('archive').style.display = 'block';

}
function openCat(){
    document.getElementById('overlaySup').style.display = 'flex';
    document.getElementById('update').style.display = 'none';
    document.getElementById('archive').style.display = 'none';
    document.getElementById('catId').value = '';
    document.getElementById('namer').value = '';
    document.getElementById('desc').value = '';
}
