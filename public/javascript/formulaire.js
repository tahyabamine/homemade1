var currentTab = 0;
document.addEventListener("DOMContentLoaded", function (event) {
  showTab(currentTab);
});

function showTab(n) {
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == 2) {
    document.getElementById("nextBtn").style.display = "none";
  } else {
    document.getElementById("nextBtn").style.display = "inline";

    document.getElementById("nextBtn").innerHTML =
      '<i class="fa fa-angle-double-right"></i>';
  }
  fixStepIndicator(n);
}

function nextPrev(n) {
  var x = document.getElementsByClassName("tab");
  if (n == 1 && !validateForm()) return false;

  x[currentTab].style.display = "none";
  currentTab = currentTab + n;
  if (currentTab >= x.length) {
    document.getElementById("nextprevious").style.display = "none";
    document.getElementById("all-steps").style.display = "none";
    document.getElementById("register").style.display = "none";
  }
  showTab(currentTab);
}

function validateForm() {
  var x,
    y,
    i,
    valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  //   for (i = 0; i < y.length; i++) {
  //     if (y[i].value == "") {
  //       //   y[i].className += " invalid";
  //       valid = false;
  //     }
  //   }
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid;
}
function fixStepIndicator(n) {
  var i,
    x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}

e = true;
function change() {
  if (e) {
    document.getElementById("pass").setAttribute("type", "text");
    document.getElementById("eye").setAttribute("class", "bi-eye-fill");
    e = false;
  } else {
    document.getElementById("pass").setAttribute("type", "password");
    document.getElementById("eye").setAttribute("class", "bi-eye-slash");
    e = true;
  }
}
var id = 0;
function ajouter() {
  id++;
  var container = document.getElementById("cont");
  var elem = document.getElementById("specialite");
  var input = elem.cloneNode(true);
  input.setAttribute("id", id);
  input.setAttribute("value", id);
  input.setAttribute("name", "registration_form[specialite] " + id);
  container.appendChild(input);
  container.innerHTML += "<br>";
}
