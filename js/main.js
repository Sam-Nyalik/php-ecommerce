AOS.init({
  offset: 200,
  duration: 1000,
});

// Script to see password on admin login
function passwordView() {
  const x = document.querySelector("#user_input");

  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function confirmPass(){
  const y = document.querySelector("#passConfirm");
  if(y.type === "password"){
    y.type = "text";
  } else {
    y.type = "password";
  }
}

// Logout alert popup
function logout() {
  confirm("Are you sure you want to sign out?");
}

// Contact-Us Map
function myMap() {
  var map_properties = {
    center: new google.maps.LatLng(-1.29738, 36.7849),
    zoom: 5,
    mapTypeId: google.maps.MapTypeId.HYBRID,
  };

  var map = new google.maps.Map(
    document.getElementById("google_map"),
    map_properties
  );
}

// Button disabled when the password field is empty
document.addEventListener("DOMContentLoaded", function () {
  const submit = document.querySelector("#submit");
  const user_input = document.querySelector("#user_input");

  // By default the submit is disabled
  submit.disabled = true;

  // Listen for input to be typed into the password input field
  user_input.onkeyup = () => {
    if (user_input.value.length > 0) {
      submit.disabled = false;
    } else {
      submit.disabled = true;
    }
  };
});


