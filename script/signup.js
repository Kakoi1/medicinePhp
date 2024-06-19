

function openForm() {
  document.getElementById("divOne").style.display = "flex";
}

function closeForm() {
  document.getElementById("divOne").style.display = "none";
}
 closing.addEventListener('click', closeForm);
  jister.addEventListener('click', openForm);
 

function showHistory(){
  document.getElementById("overlayHisto").style.display = 'flex';
  
}
function closeHistory(){
  document.getElementById("overlayHisto").style.display = 'none';
  
}


function openTransac(){
  document.getElementById('medTransac').style.display = 'flex';
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
function closeTransac(){
  document.getElementById('medTransac').style.display = 'none';
  document.getElementById('medId').value = '';
  document.getElementById('medName').value = '';
  // document.getElementById('price').value = '';
  document.getElementById('quantity').value = '';
  document.getElementById('status').value = '';
  document.getElementById('expD').value = '';
  document.getElementById('quanBuy').value = '';
  document.getElementById('tPrice').value = '';
  // document.getElementById('cash').value = '';
  document.getElementById('change').value = '';
}

function openTab(evt, tabName) {
  document.getElementById('tableOver').style.display = 'flex';
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " active";
}
function closeTab(){
  document.getElementById('tableOver').style.display = 'none';
}
