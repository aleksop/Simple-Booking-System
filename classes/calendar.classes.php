<?php
class Calendar
{

  private $DB;
  public $error;
  public function __construct()
  {
    $this->DB = Dbh::getInstance();
  }

  function check($date, $time, $id)
  {

    $start = $date . " 00:00:00";
    $end = $date  . " 23:59:59";

    // checking is it a free time-slot

    $sql = "SELECT * FROM events WHERE evt_date = ? AND evt_time = ? AND evt_id <> ?";
    $data = [$start, $time, $id];
    $this->DB->query($sql, $data);

    $events = [];

    $events = $this->DB->stmt->fetchAll();
    if (count($events) > 0) {
      $this->error = "This time slot is already occupied";
      return false;
    }

    if ($id == "") {
      $sql = "SELECT * FROM events WHERE evt_date BETWEEN ? AND ? ORDER BY evt_date";
      $data = [$start, $end];
      $this->DB->query($sql, $data);
      $events = [];
      if ($this->DB->stmt->rowCount() >= 8) {
        $this->error = "There is no free slots at this day";
        return false;
      } 
    }
    return true;
  }

  // save appointment
  function save($date, $time, $name, $color, $bg, $phone, $id = null, $userId = null)
  {


    if ($id == null) {
      $sql = "INSERT INTO `events` (`evt_date`, `evt_time`, `evt_text`, `evt_color`, `evt_bg`, `evt_phone`, `userId`) VALUES (?,?,?,?,?,?,?)";
      $data = [$date, $time, strip_tags($name), $color, $bg, $phone, $userId];
    } else {
      $sql = "UPDATE `events` SET `evt_date`=?, `evt_time`=?, `evt_text`=?, `evt_color`=?, `evt_bg`=?, `evt_phone`=?, `userId`=?  WHERE `evt_id`=?";
      $data = [$date, $time, strip_tags($name), $color, $bg, $phone,  $userId, $id];
    }
    $this->DB->query($sql, $data);
    return true;
  }

  // delete appointment
  function del($id)
  {
    $this->DB->query("DELETE FROM `events` WHERE `evt_id`=?", [$id]);
    return true;
  }

  // get bookins for the mont
  function get($month, $year)
  {
    // date range calculations
    $month = $month < 10 ? "0$month" : $month;
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $dateYM = "{$year}-{$month}-";
    $start = $dateYM . "01 00:00:00";
    $end = $dateYM . $daysInMonth . " 23:59:59";
    // get data
    // s & e : start date & time
    // c & b : text & background color
    // t : event text, p : phone
    $this->DB->query("SELECT * FROM events WHERE evt_date BETWEEN ? AND ? ORDER BY evt_date", [$start, $end]);
    $events = [];
    while ($r = $this->DB->stmt->fetch()) {
      $events[$r["evt_id"]] = [
        "s" => $r["evt_date"], "e" => $r["evt_time"],
        "c" => $r["evt_color"], "b" => $r["evt_bg"],
        "t" => $r["evt_text"],  "p" => $r["evt_phone"], "userId" => $r["userId"]
      ];
    }

    return count($events) == 0 ? false : $events;
  }
}
