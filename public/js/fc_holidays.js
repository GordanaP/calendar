/**
 * Highlight the holidays.
 *
 * @param  FullCalendar\Object fcDay
 * @param  string className
 */
function highlightHolidays(fcDay, className="holiday")
{
    var year = fcDay.date.getFullYear();
    var fcDate = formatDateObj(fcDay.date, 'YYYY-MM-DD');
    var calendarEl = fcDay.el;

    holidays(year).map(function(holiday) {
        holiday.dates.map(function(date){
            var holidayDate = formatDateObj(date, 'YYYY-MM-DD');

            $('.fc-day[data-date="' + holidayDate + '"]').addClass(className);

            if(fcDate == holidayDate) {
                calendarEl.insertAdjacentHTML('beforeend', '<i class="fc-content" aria-hidden="true">'+ holiday.name +'</i>');
            }
        });
    });
}

/**
 * Determine if the given date is holiday.
 *
 * @param  Javascript\Date  date
 * @return boolean
 */
function isHoliday(date)
{
    var year = date.getFullYear();
    var formattedDate = formatDateObj(date, 'YYYY-MM-DD');

    return holidayDates(year).includes(formattedDate);
}

/**
 * The holidays' dates.
 *
 * @param  integer year
 * @return array ['YYYY-MM-DD']
 */
function holidayDates(year)
{
    return holidays(year).map(function(holiday) {
         return holiday.dates.filter(function(holiday){
            return holiday != null;
        }).map(function(day){
            return formatDateObj(day, 'YYYY-MM-DD');
        });
    }).flat();
}

/**
 * All holidays - dates & names.
 *
 * @param  integer year
 * @return array
 */
function holidays(year)
{
    var public = publicHolidays(year);
    var religious = religiousHolidays(year);

    return $.merge(public, religious);
}

/**
 * The public holidays - dates & names.
 *
 * @param  integer year
 * @return array
 */
function publicHolidays(year)
{
    var january1 = new Date(year, 0, 1);
    var january2 = new Date(year, 0, 2);
    var january3 = isSunday(january1) || isSunday(january2) ?  new Date(year, 0, 3) : null;
    var february15 = new Date(year, 1, 15);
    var february16 = new Date(year, 1, 16);
    var february17 = isSunday(february15) || isSunday(february16) ?  new Date(year, 1, 17) : null;
    var may1 = new Date(year, 4, 1);
    var may2 = new Date(year, 4, 2);
    var may3 = isSunday(may1) || isSunday(may2) ?  new Date(year, 4, 3) : null;
    var november11 = new Date(year, 10, 11);
    var november12 = isSunday(november11) ?  new Date(year, 10, 12) : null;

    return [
        {
            dates: [ january1, january2, january3 ],
            name: 'New Year'
        },
        {
            dates: [ february15, february16, february17 ],
            name: 'Sovereignity Day'
        },
        {
            dates: [ may1, may2, may3 ],
            name: 'Labor Day'
        },
        {
            dates: [ november11, november12 ],
            name: 'Armistice Day'
        },
    ];
}

/**
 * The religious holidays - dates & names.
 *
 * @param  integer year
 * @return array
 */
function religiousHolidays(year)
{
    var christmasDay = new Date(year, 0, 7);
    var easterSunday = moment(orthodoxEasterSunday(year));
    var goodFriday = moment(easterSunday).subtract(2, 'd').toDate();
    var easterMonday = moment(easterSunday).add(1, 'd').toDate();

    return [
        {
            dates: [ christmasDay ],
            name: 'Christmas Day'
        },
        {
            dates: [ goodFriday ],
            name: 'Good Friday'
        },
        {
            dates: [ easterSunday.toDate() ],
            name: 'Easter Sunday'
        },
        {
            dates: [ easterMonday ],
            name: 'Easter Monday'
        },
    ];
}

/**
 * The Orthodox Easter Sunday.
 *
 * @param  integer year
 * @return Javascript\Date
 */
function orthodoxEasterSunday(year)
{
    d = (year%19*19+15)%30;

    e = (year%4*2+year%7*4-d+34)%7+d+127;

    month = Math.floor(e/31);

    a = e%31 + 1 + (month > 4);

    return new Date(year, (month-1), a);
}