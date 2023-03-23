
var cal = {
  // properties
  mon: true, // monday first
  events: null, // events data for current month/year
  sMth: 0, sYear: 0, // selected month & year
  hMth: null, hYear: null, // html month & year
  hCD: null, hCB: null, // html calendar days & body
  // html form & fields
  hFormWrap: null, hForm: null, hfID: null,
  hfDate: null, hfTime: null, hfName: null,
  hfColor: null, hfBG: null, hfDel: null, hPhone: null,
  userId: null, address: null, phone: null, hfUserEvt: null, admin: null,

  // ajax fetch
  ajax: (data, onload) => {
    // form data
    let form = new FormData();
    for (let [k, v] of Object.entries(data)) { form.append(k, v); }


    fetch("incl/cal.incl.php", { method: "POST", body: form })
      .then(res => res.text())
      .then(txt => onload(txt))
      .catch(err => console.error(err));
  },

  // init calendar
  init: () => {

    // if user is logged in
    fetch("incl/session-storage.php",).then(function (response) {
      return response.json();
    }).then(function (userData) {
      cal.userId = userData['idUser'];
      cal.address = userData['address'];
      cal.phone = userData['phone'];
      cal.admin = userData['admin'];
      cal.name = userData['name'];
      cal.load();
    }).catch(function (err) {
      cal.load(); //anyway in has to be called, because we need to draw days&events
    });

    // get HTML events
    cal.hMth = document.getElementById("calMonth");
    cal.hYear = document.getElementById("calYear");
    cal.hCD = document.getElementById("calDays");
    cal.hCB = document.getElementById("calBody");
    cal.hFormWrap = document.getElementById("calForm");
    cal.hForm = cal.hFormWrap.querySelector("form");
    cal.hfID = document.getElementById("evtID");
    cal.hfDate = document.getElementById("evtDate");
    cal.hfTime = document.getElementById("evtTime");
    cal.hfName = document.getElementById("evtName");
    cal.hfColor = document.getElementById("evtColor");
    cal.hfBG = document.getElementById("evtBG");
    cal.hPhone = document.getElementById("evtPhone");
    cal.hfDel = document.getElementById("evtDel");
    cal.hfUserEvt = document.getElementById("evtUserId");

    // attach controls

    cal.hMth.onchange = cal.load;
    cal.hYear.onchange = cal.load;
    document.getElementById("calAdd").onclick = () => cal.show();
    cal.hForm.onsubmit = () => cal.save();
    document.getElementById("evtCX").onclick = () => cal.hFormWrap.open = false;
    cal.hfDel.onclick = cal.del;

    // draw day names
    let days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    if (cal.mon) { days.push("Sun"); } else { days.unshift("Sun"); }
    for (let d of days) {
      let cell = document.createElement("div");
      cell.className = "calCell";
      cell.innerHTML = d;
      cal.hCD.appendChild(cell);
    }

  },

  // load events
  load: () => {
    cal.sMth = parseInt(cal.hMth.value);
    cal.sYear = parseInt(cal.hYear.value);
    cal.ajax({
      req: "get", month: cal.sMth, year: cal.sYear
    }, events => {
      cal.events = JSON.parse(events);
      cal.draw();
    });
  },

  // draw calendar
  draw: () => {

    // calculate day month year
    // note - jan is 0 & dec is 11 in js
    // note - sun is 0 & sat is 6 in js
    let daysInMth = new Date(cal.sYear, cal.sMth, 0).getDate(), // number of days in selected month
      startDay = new Date(cal.sYear, cal.sMth - 1, 1).getDay(), // first day of the month
      endDay = new Date(cal.sYear, cal.sMth - 1, daysInMth).getDay(), // last day of the month
      now = new Date(), // current date
      nowMth = now.getMonth() + 1, // current month
      nowYear = parseInt(now.getFullYear()), // current year
      nowDay = cal.sMth == nowMth && cal.sYear == nowYear ? now.getDate() : null;

    // draw calendar rows & cells 
    // init + helper functions
    let rowA, rowB, rowC, rowMap = {}, rowNum = 1,
      cell, cellNum = 1,
      rower = () => {
        rowA = document.createElement("div");
        rowB = document.createElement("div");
        rowC = document.createElement("div");
        rowA.className = "calRow";
        rowA.id = "calRow" + rowNum;
        rowB.className = "calRowHead";
        rowC.className = "calRowBack";
        cal.hCB.appendChild(rowA);
        rowA.appendChild(rowB);
        rowA.appendChild(rowC);
        rowA.insertAdjacentHTML('beforeend','<br><br>');    
      },
      celler = day => {
        cell = document.createElement("div");
        cell.className = "calCell";
        if (day) { cell.innerHTML = day; }
        rowB.appendChild(cell);
        cell = document.createElement("div");
        cell.className = "calCell";
        if (day === undefined) { cell.classList.add("calBlank"); }
        if (day !== undefined && day == nowDay) { cell.classList.add("calToday"); }
        //  cell.id = "calRowNum" + rowNum + "ColNum" + day;     
        cell.id = "calRowColNum" + day;
        indent = document.createElement("br");
        rowC.appendChild(cell);
        cell.appendChild(indent);
      };
    cal.hCB.innerHTML = ""; rower();

    // blank cells before start of month 
    if (cal.mon && startDay != 1) {
      let blanks = startDay == 0 ? 7 : startDay;
      for (let i = 1; i < blanks; i++) { celler(); cellNum++; }
    }
    if (!cal.mon && startDay != 0) {
      for (let i = 0; i < startDay; i++) { celler(); cellNum++; }
    }

    // days of the month 
    for (let i = 1; i <= daysInMth; i++) {
      rowMap[i] = { r: rowNum, c: cellNum };
      celler(i);
      if (cellNum % 7 == 0) { rowNum++; rower(); }
      cellNum++;
    }

    // blank cells after end of month
    if (cal.mon && endDay != 0) {
      let blanks = endDay == 6 ? 1 : 7 - endDay;
      for (let i = 0; i < blanks; i++) { celler(); cellNum++; }
    }
    if (!cal.mon && endDay != 6) {
      let blanks = endDay == 0 ? 6 : 6 - endDay;
      for (let i = 0; i < blanks; i++) { celler(); cellNum++; }
    }
    // draw events 

    if (cal.events !== false) {
      var sortableEvents = Object.entries(cal.events);
      sortableEvents.sort(function (a, b) {

        var nameA = a[1].e, nameB = b[1].e;
        if (nameA < nameB)
          return -1
        if (nameA > nameB)
          return 1
        return 0
      })
      for (let [id, evt] of sortableEvents) {
        // EVENT START & END DAY
        let sd = new Date(evt.s), ed = new Date(evt.e);
        if (sd.getFullYear() != cal.sYear) { sd = 1; }
        else { sd = sd.getMonth() + 1 < cal.sMth ? 1 : sd.getDate(); }
        if (ed.getFullYear() != cal.sYear) { ed = daysInMth; }
        else { ed = ed.getMonth() + 1 > cal.sMth ? daysInMth : ed.getDate(); }
        // "map" onto HTML calendat 
        cell = {}; rowNum = 0;
        for (let i = sd; i <= sd; i++) {
          if (rowNum != rowMap[i]["r"]) {
            cell[rowMap[i]["r"]] = { s: rowMap[i]["c"], e: 0 };
            rowNum = rowMap[i]["r"];
          }
          if (cell[rowNum]) { cell[rowNum]["e"] = rowMap[i]["c"]; }
        }

        // draw HTML event row 
        for (let [r, c] of Object.entries(cell)) {
          let o = c.s - 1 - ((r - 1) * 7), // event cell offset
            w = c.e - c.s + 1; // event cell width
          let dt = new Date(evt.s);
          rowA = document.getElementById("calRowColNum" + dt.getDate());
          rowB = document.createElement("div");
          rowC = document.getElementById("calRow" + r);
          indent = document.createElement("br");
          indent.id = "week" + r;
          indent.class = "week" + r;
          rowB.className = "calRowEvt";
          if (cal.userId == null) {
            rowB.innerHTML = cal.events[id]["e"].substring(0, 5) + " reserved";
          }
          else if ((cal.userId == cal.events[id]["userId"]) || (cal.admin == true)) {
            rowB.innerHTML = cal.events[id]["e"].substring(0, 5) + " " + cal.events[id]["t"];
          }
          else {
            rowB.innerHTML = cal.events[id]["e"].substring(0, 5) + " reserved";
          }
          rowB.style.color = cal.events[id]["c"];
          rowB.style.backgroundColor = cal.events[id]["b"];
          rowB.onclick = () => cal.show(id);
          rowA.appendChild(rowB);
          var tagsBr = cal.findtags(r);
          if (typeof r !== 'undefined' && r > 0) {
            if (tagsBr <= 9 && cal.findevents(r) > tagsBr) {
              rowC.appendChild(indent);
            }
          }
        }
      }
    }
  },

  findevents: (week) => {
    var numberOfRecords = 0;
    var rowSelector = "#calRow" + week;
    const row = document.querySelector(rowSelector);
    const calRowBack = row.querySelector("div.calRowBack");
    for (const divEl of calRowBack.childNodes) {
      const nodeListEvt = divEl.querySelectorAll("div.calRowEvt");
      if (nodeListEvt.length > numberOfRecords) {
        numberOfRecords = nodeListEvt.length;
      }
    }
    return (numberOfRecords);
  },

  findtags: (week) => {
    var selector = "#week" + week;
    var numberOfRecords = document.querySelectorAll(selector);
    return (numberOfRecords.length);
  },

  // show booking form 
  show: id => {
    // if it is not a new appointment
    if (id) {
      cal.hForm.reset();
      cal.hfID.value = id;
      cal.hfUserEvt.value = cal.events[id]["userId"];
      cal.hfTime.value = cal.events[id]["e"].slice(0, 5);
      cal.hfName.value = cal.events[id]["t"];
      // if event belongs to current user or user is admin
      if (cal.admin == true || cal.userId == cal.hfUserEvt.value) {
        cal.hPhone.value = cal.events[id]["p"];
        cal.hfName.readOnly = false;
        cal.hPhone.readOnly = false;
        cal.hfTime.readOnly = false;
        cal.hfDate.readOnly = false;
        cal.hForm.evtSave.disable = false;
        cal.hfDel.style.display = "inline-block";
        cal.hPhone.type = "text";
        document.getElementById("evtSave").style.visibility = "visible";
      }
      // if event does not belong to current user and user is not admin
      else if (cal.admin == false || (cal.userId == null || cal.userId != cal.hfUserEvt.value)) {
        cal.hfDel.style.display = "none";
        cal.hForm.evtSave.disable = true;
        document.getElementById("evtSave").style.visibility = "hidden";
        cal.hPhone.value = "------------------";
        cal.hPhone.type = "password";
        cal.hfName.value = "------------------";
        cal.hfName.readOnly = true;
        cal.hPhone.readOnly = true;
        cal.hfTime.readOnly = true;
        cal.hfDate.readOnly = true;
      }
      else {
        cal.hfDel.style.display = "inline-block";
      }
      cal.hfDate.value = cal.events[id]["s"].substring(0, 10);
    } else { //new appointment
      cal.hForm.reset();
      cal.hfName.readOnly = false;
      cal.hPhone.readOnly = false;
      cal.hfTime.readOnly = false;
      cal.hfDate.readOnly = false;
      cal.hForm.evtSave.disable = false;
      cal.hPhone.value = cal.phone;
      cal.hPhone.type = "text";
      if (cal.name == "") {
        cal.hfName.value = "------------------";
      }
      else {
        cal.hfName.value = cal.name;
      }
      document.getElementById("evtSave").style.visibility = "visible";
      cal.hfID.value = "";
      cal.hfUserEvt.value = "";
      cal.hfDel.style.display = "none";
    }
    cal.hFormWrap.open = true;
  },

  // save appointment
  save: () => {
    // collect data
    var data = {
      req: "save",
      date: cal.hfDate.value,
      time: cal.hfTime.value,
      name: cal.hfName.value,
      color: "#000000",
      bg: "#efdbff",
      phone: cal.hPhone.value,
      userId: cal.userId
    };

    let varTime = Number(cal.hfTime.value.slice(0, 2));
    let bg = "#efdbff";
    switch (true) {
      case varTime >= 18:
        bg = "#f4f591";
        break;
      case varTime >= 16:
        bg = "#d4f8aa";
        break;
      case varTime >= 14:
        bg = "#aaf7f8";
        break;
      case varTime >= 12:
        bg = "#fee0e3";
        break;
      case varTime >= 10:
        bg = "#e0e2fe";
        break;
      case varTime >= 8:
        bg = "#feede0";
        break;
      default:
    }

    data.bg = bg;

    if (cal.hfID.value != "") { data.id = cal.hfID.value; }

    // Check
    data.req = "check";
    cal.ajax({ req: "check", date: cal.hfDate.value, time: cal.hfTime.value, idd: cal.hfID.value }, res => {
      if (res == "OK") {
        data.req = "save";
        // ajax save
        cal.ajax(data, res => {
          if (res == "OK") {
            cal.hFormWrap.open = false;
            cal.load();
          } else { alert(res); }
        });
        return false;
      } else {
        alert(res); return false;
      }
    });

  },

  // delete appointment
  del: () => {
    if (confirm("Delete appointment?")) {
      cal.ajax({
        req: "del", id: cal.hfID.value
      }, res => {
        if (res == "OK") {
          cal.hFormWrap.open = false;
          cal.load();
        } else { alert(res); }
      });
    }
  }
};
window.onload = cal.init;