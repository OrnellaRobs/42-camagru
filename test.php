<?php
var_dump($_POST);
?>
<button id="startbutton" onclick="loadDoc()">Prendre une photo</button>
<!-- <p id="demo"></p> -->
<script>
function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("startbutton").innerHTML = this.responseText;
    }
  };
  xhttp.open("POST", "test.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("fname=Mavrick&lname=Ford");
}
</script>
</body>
</html>