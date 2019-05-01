<?php
require "../database/database.php";

if(!empty($_POST["markeID"])){

  if (($statement = $databaseconnection->prepare("SELECT * FROM Modell WHERE Marke_ID=? ORDER BY Name ASC"))
  && ($statement->bind_param("s", $_POST["markeID"]))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    $rowCount = $resultset->num_rows;
  }
    //State option list
    if($rowCount > 0){
        echo '<option value="">Modell</option>';
        while($row = $resultset->fetch_assoc()){
            echo '<option value="'.$row['Modell_ID'].'">'.$row['Name'].'</option>';
        }
    }else{
        echo '<option value="">State not available</option>';
    }
}
?>
