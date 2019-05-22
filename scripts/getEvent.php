<?php
header('Access-Control-Allow-Origin: *');

include_once "../controllers/c_event.php";

$c_event = new C_Event();

echo json_encode($c_event->getEventsForMap());
