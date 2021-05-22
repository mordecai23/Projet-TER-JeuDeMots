/**
 * Récupère un objet contenant la durée du compte à rebours.
 */
function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  return {
    total: t,
    days: days,
    hours: hours,
    minutes: minutes,
    seconds: seconds
  };
}

/**
 * Initialise les paramètres du compte à rebours
 * @param {} endtime 
 */
function initializeClockMonth(endtime) {
  var daysSpan = document.getElementById("days-month");
  var hoursSpan = document.getElementById("hours-month");
  var minutesSpan = document.getElementById("minutes-month");
  var secondsSpan = document.getElementById("seconds-month");

  function updateClock() {
    var t = getTimeRemaining(endtime);

    if (t.total <= 0) {
      clearInterval(timeintervalMonth);
      var dateNowMonth = new Date(); 
      var deadlineMonth = new Date(dateNowMonth.getFullYear(), dateNowMonth.getMonth() + 1, 1);
      initializeClockMonth(deadlineMonth);
    }

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ("0" + t.hours).slice(-2);
    minutesSpan.innerHTML = ("0" + t.minutes).slice(-2);
    secondsSpan.innerHTML = ("0" + t.seconds).slice(-2);
  }

  updateClock();
  var timeintervalMonth = setInterval(updateClock, 1000);
}

/**
 * Lancement du compte à rebours mensuel (Chaque début de mois).
 */
function timerMonth() {
  var dateNowMonth = new Date(); 
  var deadlineMonth = new Date(dateNowMonth.getFullYear(), dateNowMonth.getMonth() + 1, 1);
  initializeClockMonth(deadlineMonth);
}

/**
 * Initialise les paramètres du compte à rebours hebdomadaire
 * @param {} endtime 
 */
 function initializeClockWeek(endtime) {
  var daysSpan = document.getElementById("days-week");
  var hoursSpan = document.getElementById("hours-week");
  var minutesSpan = document.getElementById("minutes-week");
  var secondsSpan = document.getElementById("seconds-week");

  function updateClock() {
    var t = getTimeRemaining(endtime);

    if (t.total <= 0) {
      clearInterval(timeintervalWeek);
      var deadlineWeek = new Date();
      deadlineWeek.setDate(deadlineWeek.getDate() + (7-deadlineWeek.getDay())%7+1);
      deadlineWeek.setHours(0);
      deadlineWeek.setMinutes(0);
      deadlineWeek.setSeconds(0);
      initializeClockWeek(deadlineWeek);
    }

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ("0" + t.hours).slice(-2);
    minutesSpan.innerHTML = ("0" + t.minutes).slice(-2);
    secondsSpan.innerHTML = ("0" + t.seconds).slice(-2);
  }

  updateClock();
  var timeintervalWeek = setInterval(updateClock, 1000);
}

/**
 * Lancement du compte à rebours hebdomadaire (Chaque lundi de la semaine).
 */
function timerWeek() {
  var deadlineWeek = new Date();
  deadlineWeek.setDate(deadlineWeek.getDate() + (7-deadlineWeek.getDay())%7+1);
  deadlineWeek.setHours(0);
  deadlineWeek.setMinutes(0);
  deadlineWeek.setSeconds(0);
  initializeClockWeek(deadlineWeek);
}

