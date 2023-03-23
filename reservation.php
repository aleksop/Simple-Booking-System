<?php
require_once  "header.php";
?>
<br>
<center>
  <h2>Maximum 8 bookings per day</h2>
</center>
<br>

<!-- SERVICE WORKER -->
<script>
  if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("worker.js");
  }
</script>


<!-- JS  -->
<script src="calendar.js">

</script>
<link rel="stylesheet" href="css/calendar.css">
</head>

<body>
  <?php
  // array with months, and current month & year 
  $months = [
    1 => "January", 2 => "Febuary", 3 => "March", 4 => "April",
    5 => "May", 6 => "June", 7 => "July", 8 => "August",
    9 => "September", 10 => "October", 11 => "November", 12 => "December"
  ];
  $monthNow = date("m");
  $yearNow = date("Y"); ?>

  <!-- period selector -->
  <div id="calHead">
    <div id="calPeriod">
      <select id="calMonth"><?php foreach ($months as $m => $mth) {
                              printf(
                                "<option value='%u'%s>%s</option>",
                                $m,
                                $m == $monthNow ? " selected" : "",
                                $mth
                              );
                            } ?></select>
      <input id="calYear" type="number" value="<?= $yearNow ?>">
    </div>
    <input id="calAdd" type="button" value="+">
  </div>

  <!-- calendar wrapper -->
  <div id="calWrap">
    <div id="calDays"></div>
    <div id="calBody"></div>
  </div>

  <!-- event form -->
  <dialog id="calForm">
    <form method="dialog">
      <h2 class="evt100">Appointment</h2>
      <div class="evt50">
        <label>Booking date</label>
        <input id="evtDate" type="date" required>
      </div>
      <div class="evt50">
        <label for="standard-select">Time</label>
        <div class="select">
          <select id="evtTime" required>
            <option value="08:00">08:00</option>
            <option value="09:00">09:00</option>
            <option value="10:00">10:00</option>
            <option value="11:00">11:00</option>
            <option value="13:00">13:00</option>
            <option value="14:00">14:00</option>
            <option value="15:00">15:00</option>
            <option value="16:00">16:00</option>
          </select>
          <span class="focus"></span>
        </div>
      </div>
      <div class="evt100">
        <label>Your name</label>
        <input id="evtName" type="text" required>
      </div>
      <div class="evt100">
        <label>Phone</label>
        <input id="evtPhone" type="text" required>
      </div>
      <div class="evt100">
        <input type="hidden" id="evtID">
        <input type="hidden" id="evtUserId">
        <input type="button" id="evtCX" value="Close">
        <input type="button" id="evtDel" value="Delete">
        <input type="submit" id="evtSave" value="Save">
      </div>
    </form>
  </dialog>

  <br><br>
  <?php
  require_once  "footer.php";
  ?>