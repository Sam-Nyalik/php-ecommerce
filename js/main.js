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
