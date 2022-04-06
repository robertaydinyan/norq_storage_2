"use strict";

/**
 *
 * @param data
 * @param type
 */
function arrangeTaskByColumns(data, type) {
    let columns = [
        { alias: "expired", title: "Просрочены", color: "#ff5752", column_tasks: [] },
        { alias: "today", title: "На Сегодня", color: "#9dcf00", column_tasks: [] },
        { alias: "current_week", title: "На этой неделе", color: "#2fc6f6", column_tasks: [] },
        { alias: "next_week", title: "На следующей неделе", color: "#55d0e0", column_tasks: [] },
        { alias: "no_limit", title: "Без срока", color: "#a8adb4", column_tasks: [] },
        { alias: "more_two_weeks", title: "Больше двух недель", color: "#468ee5", column_tasks: [] }
    ];
    data.forEach(item => {
        if (!item.deadline) {
            columns[4].column_tasks.push(item);
        }
        else {
            const today = moment();
            const deadline = moment(item.deadline);
            const this_week = moment().endOf('isoWeek');
            const start_of_next_week = moment().endOf('isoWeek').add(1, "days");
            const end_of_next_week = start_of_next_week.endOf('isoWeek');
            switch (true) {
                case (deadline < today):
                    columns[0].column_tasks.push(item);
                    break;
                case (deadline.endOf('day') <= today.endOf('day') && deadline.endOf('day') >= today.endOf('day')):
                    columns[1].column_tasks.push(item);
                    break;
                case (deadline < this_week):
                    columns[2].column_tasks.push(item);
                    break;
                case (deadline < start_of_next_week):
                    columns[3].column_tasks.push(item);
                    break;
                case (deadline > end_of_next_week):
                    columns[5].column_tasks.push(item);
                    break;
                default:
            }
        }
    });
    $('.kanban-main-section').html(createKanban(columns, type));
}
/**
 * getKanbanDate
 * @param date
 * @param today
 */
function getKanbanDate(date, today = moment()) {
    let deadline = moment(date);
    let draw_date = '';
    let difference_minutes = Math.floor((deadline - today) / (1000 * 60));
    if (!Math.floor(difference_minutes / (60 * 24))) {
        draw_date += `Сегодня ${deadline.hours() > 9 ? deadline.hours() : '0' + deadline.hours()} : ${deadline.minutes() > 9 ? deadline.minutes() : '0' + deadline.minutes()}`;
    } else if (difference_minutes > 0) {
        draw_date += drawDateWithLetters(deadline);
    } else {
        difference_minutes = Math.abs(difference_minutes);
        let hours = Math.floor(difference_minutes / 60);
        let days = Math.floor(hours / 24);
        let weeks = Math.floor(days / 7);
        let months = Math.floor(days / 31);
        let years = Math.floor(months / 12);
        switch (true) {
            case (difference_minutes < 60):
                draw_date += `- ${difference_minutes} `;
                draw_date += difference_minutes === 1 ? "минута" : "минут";
                break;
            case (difference_minutes < (60 * 24)):
                draw_date += `- ${hours} `;
                draw_date += difference_minutes === 1 ? "час" : "часа";
                break;
            case (difference_minutes < (60 * 24 * 7)):
                draw_date += `- ${days} `;
                draw_date += days === 1 ? "день" : "дней";
                break;
            case (difference_minutes < (60 * 24 * 31)):
                draw_date += `- ${weeks} `;
                draw_date += weeks === 1 ? "неделя" : "недель(и)";
                break;
            case (difference_minutes < (60 * 24 * 365)):
                draw_date += `- ${months} `;
                draw_date += months === 1 ? "месяц" : "месяца";
                break;
            default:
                draw_date += `- ${years} `;
                draw_date += years === 1 ? "год" : "год";
        }
    }
    return draw_date;
}

/**
 *
 * @param date
 * @returns {string}
 */
function drawDateWithLetters(date) {
    if (Math.round((date - moment()) / (1000 * 60 * 60 * 24))) {
        const monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"];
        return `${monthNames[date.month()]} ${date.date()} ${date.hours() > 9 ? date.hours() : '0' + date.hours()}:${date.minutes() > 9 ? date.minutes() : '0' + date.minutes()}`;
    }
    return `Сегодня ${date.hours() > 9 ? date.hours() : '0' + date.hours()}:${date.minutes() > 9 ? date.minutes() : '0' + date.minutes()}`;
}
function getDateWhenTaskChangesColumnOrAddNewDate(options) {
    let week;
    switch (options.week) {
        case 'current_week':
            week = 0;
            break;
        case 'next_week':
            week = 7;
            break;
        case 'more_two_weeks':
            week = 14;
            break;
        default:
            week = -1;
    }
    let date = new Date();
    if (week >= 0) {
        let last_day_of_month = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
        let friday = date.getDate() + week;
        if (friday > last_day_of_month) {
            friday = friday - last_day_of_month;
            date.setMonth(date.getMonth() + 1);
        }
        date.setDate(friday);
        for (let i = 0; i < 7; i++) {
            date.setDate(friday);
            if (date.getDay() === 5) {
                break;
            }
            friday++;
            if (friday > last_day_of_month) {
                friday = friday - last_day_of_month;
                date.setMonth(date.getMonth() + 1);
                date.setDate(friday);
            }
        }
    }
    date.setHours(19);
    date.setMinutes(0);
    return moment(date);
}
function generateKanbanTaskColorAndDate(elem) {
    let elem_date = elem.find('.knbn-tc-date');
    let elem_sort = elem.attr("data-sort");
    let parent = elem.closest('ul');
    let parent_color = parent.data('taskContInfo').column_color;
    let parent_alias = parent.data('taskContInfo').column_alias;
    if (elem.data("taskInfo").alias !== parent_alias) {
        if (!(elem.data("taskInfo").status === "delayed" || elem.data("taskInfo").status === "completed")) {
            elem.data('taskInfo').alias = parent_alias;
            elem.css('border-right-color', `${parent_color}`);
            switch (parent_alias) {
                case 'today':
                    elem_date.text(`Сегодня 19:00`);
                    elem_date.css('background-color', `${parent_color}`);
                    elem_date.removeClass("knbn-tc-date-grey");
                    let today = moment();
                    today.hours(19);
                    today.minutes(0);
                    selectColumnForTask(elem.attr('id'), today.format(), elem_sort);
                    break;
                case 'current_week':
                case 'next_week':
                case 'more_two_weeks':
                    elem_date.css('background-color', `${parent_color}`);
                    elem_date.removeClass("knbn-tc-date-grey");
                    let date = getDateWhenTaskChangesColumnOrAddNewDate({ week: parent_alias });
                    elem_date.text(drawDateWithLetters(date));
                    selectColumnForTask(elem.attr('id'), date, elem_sort);
                    break;
                case 'no_limit':
                    elem_date.addClass("knbn-tc-date-grey");
                    elem_date.text("Не указано");
                    elem_date.css('background-color', `#ffffff`);
                    selectColumnForTask(elem.attr('id'), 'no_limit', elem_sort);
                    break;
                default:
                    alert('new week was  added?');
            }
        }
        else {
            console.log(elem.data("taskInfo").status);
        }
    }
    elem.css('border-left-color', `${parent_color}`);
}
function myFunc(){

}
function knabanDateUTSandISO(date) {
    let date_deadline = new Date(date);
    let date_utc = new Date(date_deadline + 'UTC');
    return date_utc.toISOString();
}
function kanbanDateByString(deadline) {
    let date = new Date(deadline);
    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    let day = date.getDate();
    let hour = date.getHours();
    let minute = date.getMinutes();
    let second = date.getSeconds();
    let date_string = `${day > 9 ? day : '0' + day}.${month > 9 ? month : '0' + month}.${year} ${hour > 9 ? hour : '0' + hour}:${minute > 9 ? minute : '0' + minute}`;
    return date_string;
}
function calulateStartEndDate(planning_start, time, dhm) {
    let date = moment(planning_start);
    let end_date;
    if (dhm === "minutes") {
        end_date = date.add(time, "minutes");
    }
    else if (dhm === "hours") {
        end_date = date.add(time, "hours");
    }
    else {
        end_date = date.add(time, "days");
    }
    return end_date._d;
}
function calculateColumnAppearanceOfTask(date) {
    let column_alias = "";
    let today = new Date();
    let difference = Math.floor((date - today) / (1000 * 60 * 60 * 24));
    let today_week = today.getDay();
    let date_week = date.getDay();
    let today_day = today.getDate();
    let date_day = date.getDate();
    switch (true) {
        case (difference > 7 && (date_week - today_week) < 0) || difference > 14:
            column_alias = "more_two_weeks";
            break;
        case (difference < 7 && (date_week - today_week) < 0) || difference >= 7:
            column_alias = "next_week";
            break;
        case difference < 7 && (date_week - today_week) > 0:
            column_alias = "current_week";
            break;
        case !(date_day - today_day) && !difference:
            column_alias = "today";
            break;
        default:
            console.log("some error occured while checking in which column should appear task");
    }
    return column_alias;
}
function calculateDurationStartEndDate(dhm, duration, planning_start) {
    let finish_date = moment(planning_start);
    switch (dhm) {
        case "minutes":
            finish_date.add(duration, "minutes");
            break;
        case "hours":
            finish_date.add(duration, "hours");
            break;
        case "days":
            finish_date.add(duration, "days");
            break;
    }

    return finish_date.format('YYYY-MM-DD HH:mm:ss');
}
function calculateDurationOfNewTAsk(planning_start, planning_end, dhm) {
    let duration;
    let start = new Date(planning_start);
    let end = new Date(planning_end);
    switch (dhm) {
        case "minutes":
            duration = Math.floor((end - start) / (1000 * 60));
            break;
        case "hours":
            duration = Math.floor((end - start) / (1000 * 60 * 60));
            break;
        case "days":
            duration = Math.floor((end - start) / (1000 * 60 * 60 * 24));
            break;
        default:
            console.log("dhm error");
    }
    return duration;
}
function generateTimesForTracker(time_seconds){
    let time ="";
    let seconds = time_seconds;
    let minutes = 0;
    let hours = 0;
    if(time_seconds > 59){
        seconds = time_seconds%60;
        minutes = (time_seconds - seconds)/60;
        if (minutes > 59){
            let x = minutes%60;
            hours = (minutes - x)/60;
            minutes = x;
        }
    }
    time = {
        time_text:`${hours < 9 ?"0"+hours:hours}:${minutes < 9 ?"0"+ minutes:minutes}:${seconds < 9 ?"0"+ seconds:seconds}`,
        seconds : seconds,
        minutes : minutes,
        hours : hours,
    };
    return time;
}
function timeTracker(time, container){
    time.seconds++ ;
    if (time.seconds == 60) {
        time.minutes += 1;
        time.seconds = 0;
        if (time.minutes == 60) {
            time.minutes = 0;
            time.hours += 1;
        }
    }
    container.text(`${time.hours < 9 ?"0"+time.hours:time.hours}:${time.minutes < 9 ?"0"+ time.minutes:time.minutes}:${time.seconds < 9 ?"0"+ time.seconds:time.seconds}`);
}
