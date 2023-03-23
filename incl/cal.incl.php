<?php
if (isset($_POST["req"])) {

  require_once  '../classes/dbh.classes.php';
  require_once  '../classes/calendar.classes.php';

  $calendar = new Calendar();

  switch ($_POST["req"]) {
      // get dates and events for selected period 
    case "get":
      echo json_encode($calendar->get($_POST["month"], $_POST["year"]));
      break;
      
      // check event
    case "check":
      echo $calendar->check($_POST["date"], $_POST["time"], $_POST["idd"]) ? "OK" : $calendar->error;
      break;

      // save event
    case "save":
      echo $calendar->save(
        $_POST["date"],
        $_POST["time"],
        $_POST["name"],
        $_POST["color"],
        $_POST["bg"],
        $_POST["phone"],
        isset($_POST["id"]) ? $_POST["id"] : null,
        isset($_POST["userId"]) ? $_POST["userId"] : null
      ) ? "OK" : $calendar->error;
      break;

      // delete event
    case "del":
      echo $calendar->del($_POST["id"])  ? "OK" : $calendar->error;
      break;
  }
}
