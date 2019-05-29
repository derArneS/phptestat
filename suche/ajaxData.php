<?php
require "../database/database.php";

if(!empty($_POST["marke"])){
  //Wenn das Modell gesetzt sind, wird das Modell in $modell gespeichert, damit das gesetzte Modell als selectiert ausgewählt werden kann
  if (!empty($_POST["modell"])) {
    $modell = $_POST["modell"];
  }

  //Datenbankverbindung wird aufgebaut
  $databaseconnection = createConnection();
  //Alle Modelle von der übergebenen Marke werden aus der Datenbank gelesen
  if (($statement = $databaseconnection->prepare("SELECT * FROM Modelle WHERE Marken_ID=? ORDER BY Name ASC"))
  && ($statement->bind_param("s", $_POST["marke"]))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    $rowCount = $resultset->num_rows;
  }


    //Wenn eine oder mehrere Modelle gefunden wurden
    if($rowCount > 0){
        //Beliebiges Modell, so kann man alle Modelle einer Marken finden
        echo '<option value="">Beliebig</option>';
        //Es wird durch das Resultset iteriert und jedes Modell wird ein Eintrag im Dropdown
        while($row = $resultset->fetch_assoc()){
            //Wenn das Modell der aktuellen Zeile dem übergebenen Modell entspricht, wird es als selected ausgegeben. Damit ist dieses Modell im Dropdown beim laden schon ausgewählt
            echo '<option '.((isset($modell) && $modell == $row['ID'])?'selected="selected"':' ').' value="'.$row['ID'].'">'.$row['Name'].'</option>';
        }
    //Wenn keine Modelle gefunden werden, wird ein Platzhalter angezeigt, der wie Beliebig funktioniert
    }else{
        echo '<option value="">Keine Modelle</option>';
    }
}
?>
