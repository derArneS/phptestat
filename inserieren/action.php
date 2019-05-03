<?php print_r($_FILES); ?>
<br>
<?php print_r($_POST); ?>
<br>

<?php

if ($_POST['file']) {
  echo "hallo";
} else {
  echo "nicht hallo";
}

?>
