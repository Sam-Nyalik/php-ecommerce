AOS.init({
  offset: 200,
  duration: 1000,
});

// Script to see password on admin login
function passwordView() {
  var x = document.getElementById("pwd");

  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

// Logout alert popup
function logout(){
  confirm("Are you sure you want to sign out?");
}
