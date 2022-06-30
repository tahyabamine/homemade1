

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
