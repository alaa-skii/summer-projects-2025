<?php
$data = file_get_contents("php://input");
file_put_contents("signals.json", $data); // تخزين آخر إشارات المستخدم
?>
