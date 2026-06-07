<?php
if (file_exists("signals.json")) {
  echo file_get_contents("signals.json");
} else {
  echo json_encode(null);
}
?>
