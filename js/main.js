AOS.init({
  offset: 200,
  duration: 1000,
});

// Script to see password on admin login
function passwordView() {
  const x = document.getElementById("pwd");

  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
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
  const password_input = document.querySelector("#pwd");

  // By default the submit is disabled
  submit.disabled = true;

  // Listen for input to be typed into the password input field
  password_input.onkeyup = () => {
    if (password_input.value.length >= 8) {
      submit.disabled = false;
    } else {
      submit.disabled = true;
    }
  };
});
