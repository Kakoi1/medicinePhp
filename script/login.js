import { initializeApp } from "https://www.gstatic.com/firebasejs/10.6.0/firebase-app.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/10.6.0/firebase-analytics.js";
import { getAuth,signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.6.0/firebase-auth.js";
import { getDatabase,set,ref,update} from "https://www.gstatic.com/firebasejs/10.6.0/firebase-database.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
 apiKey: "AIzaSyCCpPqshTgB5-E2KhYaCGk3C1bUF2NTcc8",
 authDomain: "mis-authentication-d8022.firebaseapp.com",
 projectId: "mis-authentication-d8022",
 storageBucket: "mis-authentication-d8022.appspot.com",
 messagingSenderId: "665580590031",
 appId: "1:665580590031:web:5d6cf9c69790e42874b8ba",
 measurementId: "G-Q1BH5NTVG1"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
//    const analytics = getAnalytics(app);
const auth = getAuth();
const database = getDatabase(app);

logIn.addEventListener('click', (e) => { 

 var enterUsername = document.getElementById('uname').value;
 var enterPassword = document.getElementById('pass').value;

    var lgdate = new Date();
signInWithEmailAndPassword(auth, enterUsername, enterPassword)
.then((userCredential) => {
  // Signed in 
  const user = userCredential.user;
  // ...
  update(ref(database, 'users/' + user.uid), {
    Last_Login: lgdate,
   
  })
  .then(() => {
    // Data saved successfully!
    alert('Login Sucessfully!');
  })
  .catch((error) => {
    // The write failed...
    alert(error);
  });
})
.catch((error) => {
  const errorCode = error.code;
  const errorMessage = error.message;
  alert(errorMessage)
});
});