<?php
require "../database/database.php";

if(!empty($_POST["marke"])){
  if (!empty($_POST["modell"])) {
    $modell = $_POST["modell"];
  }

  $databaseconnection = createConnection();
  if (($statement = $databaseconnection->prepare("SELECT * FROM Modell WHERE Marke_ID=? ORDER BY Name ASC"))
  && ($statement->bind_param("s", $_POST["marke"]))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    $rowCount = $resultset->num_rows;
  }


    //State option list
    if($rowCount > 0){
        echo '<option value="">Beliebig</option>';
        while($row = $resultset->fetch_assoc()){
            echo '<option '.((isset($modell) && $modell == $row['Modell_ID'])?'selected="selected"':' ').' value="'.$row['Modell_ID'].'">'.$row['Name'].'</option>';
        }
    }else{
        echo '<option value="">Keine Modelle</option>';
    }
}
?>
