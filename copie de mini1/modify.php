
<?php
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "project1";
      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
          die("Connection error: " . $conn->connect_error);
      }
  
  $nameTable = $_POST["nameTable"];
  $nameColumn = $_POST["nameColumn"];
  $value = $_POST["value"];
  $id = $_POST["id"];
  $idT= "id".ucfirst($nameTable) ;

  
  $sql = "UPDATE $nameTable SET $nameColumn = '$value WGERE $idT=$id'";
    if ($conn->query($sql) === TRUE) {
      echo "Database modified successfully.";
  } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
  }
  
  $conn->close();
  ?>