

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

 