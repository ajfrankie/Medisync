"use strict";

/* eslint-disable require-jsdoc, no-unused-vars */

var CalendarList = [];

function CalendarInfo() {
    this.id = null;
    this.name = null;
    this.checked = true;
    this.color = null;
    this.bgColor = null;
    this.borderColor = null;
    this.dragBgColor = null;
}

function addCalendar(calendar) {
    CalendarList.push(calendar);
}

function findCalendar(id) {
    var found;

    CalendarList.forEach(function (calendar) {
        if (calendar.id === id) {
            found = calendar;
        }
    });

    return found || CalendarList[0];
}

function hexToRGBA(hex) {
    var radix = 16;
    var r = parseInt(hex.slice(1, 3), radix),
        g = parseInt(hex.slice(3, 5), radix),
        b = parseInt(hex.slice(5, 7), radix),
        a = parseInt(hex.slice(7, 9), radix) / 255 || 1;
    var rgba = "rgba(" + r + ", " + g + ", " + b + ", " + a + ")";

    return rgba;
}

//     'pending' => '#ffc107',              // warning - yellow
//     'confirmed' => '#0dcaf0',            // info - cyan
//     'completed' => '#198754',            // success - green
//     'cancelled' => '#dc3545',            // danger - red
//     'schedule next appointment' => '#0d6efd', // primary - blue

(function () {
    var calendar;
    var id = 0;

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "My Calendar";
    calendar.color = "#ffffff";
    calendar.bgColor = "#556ee6";
    calendar.dragBgColor = "#556ee6";
    calendar.borderColor = "#556ee6";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "pending";
    calendar.color = "#ffffff";
    calendar.bgColor = "#ffc107";
    calendar.dragBgColor = "#ffc107";
    calendar.borderColor = "#ffc107";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "confirmed";
    calendar.color = "#ffffff";
    calendar.bgColor = "#0dcaf0";
    calendar.dragBgColor = "#0dcaf0";
    calendar.borderColor = "#0dcaf0";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "completed";
    calendar.color = "#ffffff";
    calendar.bgColor = "#198754";
    calendar.dragBgColor = "#198754";
    calendar.borderColor = "#198754";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "cancelled";
    calendar.color = "#ffffff";
    calendar.bgColor = "#dc3545";
    calendar.dragBgColor = "#dc3545";
    calendar.borderColor = "#dc3545";
    addCalendar(calendar);

    calendar = new CalendarInfo();
    id += 1;
    calendar.id = String(id);
    calendar.name = "schedule next appointment";
    calendar.color = "#ffffff";
    calendar.bgColor = "#0d6efd";
    calendar.dragBgColor = "#0d6efd";
    calendar.borderColor = "#0d6efd";
    addCalendar(calendar);
})();
