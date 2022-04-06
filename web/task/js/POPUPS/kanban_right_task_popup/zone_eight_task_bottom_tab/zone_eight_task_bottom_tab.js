"use strict";
function createZoneEightTaskBottomTab(task_id) {
    let zone_eight_task_bottom = $(`<div class = "knbn-tt-tabs" id = "knbn-tt-tabs"></div>`);
    zone_eight_task_bottom.append(templatesGenerationZoneEightTaskBottomTab({
        item_get: "get-bottom-tab-names",
    }));
    zone_eight_task_bottom.append(templatesGenerationZoneEightTaskBottomTab({
        item_get: "get-bottom-tab-comments",
        task_id:task_id,
    }));
    zone_eight_task_bottom.append(templatesGenerationZoneEightTaskBottomTab({
        item_get: "get-bottom-tab-story",
    }));
    zone_eight_task_bottom.append(templatesGenerationZoneEightTaskBottomTab({
        item_get: "get-bottom-tab-time",
    }));
    // $(`.knbn-tt-comments-container`, zone_eight_task_bottom).prepend(createComments(tabsCommentsJSON));
    // $("#knbn-tt-story", zone_eight_task_bottom).append(createZoneEightTaskTabsTable(getTaskHistory(task_id), 'story'));
    // $("#knbn-tt-time", zone_eight_task_bottom).prepend(createZoneEightTaskTabsTable(tabsTableTimeJSON, 'time'));
    return zone_eight_task_bottom;
}
// function createComments(comment_data) {
//     if (comment_data && comment_data.length) {
//         let knbnCommentsCont = $('<div class="knbn-comments-cont">');
//         $.each(comment_data, (k, comment) => {
//             let tab_comment = $(`<div class = "knbn-comment">
//                 <div class = "knbn-comment-left">
//                     <img  class = "knbn-comment-user-foto" src ="${comment.image}" alt ="icon">
//                 </div>
//                 <div class = "knbn-comment-right">
//                     <div class = "knbn-com-r-top">
//                         <div class = "knbn-comment-userdate">
//                             <span class="knbn-comment-name">${comment.name}</span>
//                             <span class="knbn-comment-date">${comment.date}</span>
//                         </div>
//                         <div class = "knbn-comment-data">${comment.comment}</div>
//                     </div>
//                     <div class = "knbn-comment-like-answer">
//                         <button class="c-btn-inert c-btn-inert-secondary knbn-comment-btn-like">Нравиться</button>
//                         <button class="c-btn-inert c-btn-inert-secondary knbn-comment-btn-answer">Ответить</button>
//                         <button class="c-btn-inert c-btn-inert-secondary knbn-comment-btn-more">Еще</button>
//                     </div>
//                 </div>
//             </div>`);
//             knbnCommentsCont.append(tab_comment);
//         });
//         return knbnCommentsCont;
//     }
// }
function templatesGenerationZoneEightTaskBottomTab(options = {}) {
    switch (options.item_get) {
        case 'get-bottom-tab-names':
            return $(`
                <ul>
                    <li><a href = '#knbn-tt-comments'><span>Комментарии</span><span>(12)</span></a></li>
                    <li><a href = '#knbn-tt-story'><span>История</span><span>(23)</span></a></li>
                    <li><a href = '#knbn-tt-time'><span>Время</span><span>(00:00:00)</span></a></li>
                </ul>`);
            break;
        case 'get-bottom-tab-comments':
            return $(`
                 <div id = "knbn-tt-comments">
                    <div class = "knbn-tt-comments-container">
                    <iframe src="http://basic.loc/index.php?r=site%2Fdetailnews&id=3&user_id=1" frameborder="0"></iframe>
<!--                        <div class = "knbn-comments-add">-->
<!--                            <div class = "knbn-comment-left">-->
<!--                                <img  class = "knbn-comment-user-foto" src ="./images/image.png" alt ="">-->
<!--                            </div>-->
<!--                            <div class="knbn-comment-text-box"><textarea class="knbn-comment-textarea" placeholder="Добвавить комментарий"></textarea></div>-->
<!--                        </div>-->
                    </div>
                 </div>`);
            break;

        case 'get-bottom-tab-story':
            return $(`
                <div id = "knbn-tt-story"></div>`);
            break;
        case 'get-bottom-tab-time':
            return $(`
                <div id = "knbn-tt-time">
<!--                    <table class = "knbn-time-table">-->
                        
<!--                    </table>-->
                    <div class="knbn-add-task-date-box">
                        <div class = "knbn-add-task-date">
                            <div><input type="date" class="knbn-add-task-date-day"></div>
                            <div class = "knbn-add-task-date-times-box">
                                <div><input type = "text" class="c-input knbn-add-task-date-input knbn-add-task-date-time" value="1"><span>ч</span></div>
                                <div><input type = "text" class="c-input knbn-add-task-date-input knbn-add-task-date-minute" value="00"><span>м</span></div>
                                <div><input type = "text" class="c-input knbn-add-task-date-input knbn-add-task-date-second" value="00"><span>с</span></div>
                            </div>
                            <div>
                                <input type = "text" class="c-input knbn-add-task-date-comment">
                                <button class="knbn-add-task-date-btns knbn-add-task-date-save"><i class="fas fa-check"></i></button>
                                <button class="knbn-add-task-date-btns knbn-add-task-delete"><i class="fas fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="knbn-tt-add-btn-box">
                        <button class="c-btn-dashed-show knbn-tt-time-add-btn">Добавить</button>
                    </div>
                </div>`);
            break;
        default:
            return $(`<div>Some Error Occured</div>`);
    }
    return $(`<div>Some Error Occured</div>`);
}
function addZoneEightTaskBottomTabListeners() {
    // open task time box
    $('.knbn-tt-time-add-btn').on('click', function () {
        $(this).closest('#knbn-tt-time').find('.knbn-add-task-date-box').show('blind');
    });
    // close task time box
    $('.knbn-add-task-delete').on('click', function () {
        $(this).closest('.knbn-add-task-date-box').hide('blind').find('input').val('');
    });
    // save task time box data in table
    $('.knbn-add-task-date-save').on('click', function () {
        const knbnAddTaskDate = $(this).closest('.knbn-add-task-date');
        const table = $(this).closest('#knbn-tt-time').find('.knbn-time-table');
        const day = knbnAddTaskDate.find('.knbn-add-task-date-day').val();
        const time = knbnAddTaskDate.find('.knbn-add-task-date-time').val();
        const minute = knbnAddTaskDate.find('.knbn-add-task-date-minute').val();
        const second = knbnAddTaskDate.find('.knbn-add-task-date-second').val();
        const comment = knbnAddTaskDate.find('.knbn-add-task-date-comment').val();
        const tr = `<tr>
            <td>
                <span class="time-table-td-val time-table-td-span">${day}</span>
                <span class="time-table-td-edit-val time-table-td-span"><input type="text" value="${day}"></span>
            </td>
            <td><span class="time-table-td-val">имя автора</span></td>
            <td>
                <span class="time-table-td-val time-table-td-span">${time}:${minute}:${second}</span>
                <span class="time-table-td-edit-val time-table-td-span"><input type="text" value="${time}:${minute}:${second}"></span>
            </td>
            <td>
                <span class="time-table-td-val time-table-td-span">${comment}</span>
                <span class="time-table-td-edit-val time-table-td-span"><input type="text" value="${comment}"></span>

                <span class="knbn-time-table-buttons">
                    <button class="knbn-time-table-btn knbn-time-table-edit-btn"><i class="fas fa-pen"></i></button>
                    <button class="knbn-time-table-btn knbn-time-table-delete-btn"><i class="fas fa-times"></i></button>
                </span>
            </td>
        </tr>`;
        table.find('tbody').append(tr);
        $(this).closest('.knbn-add-task-date-box').hide().find('input').val('');
    });
    // remove task time table row
    $('.knbn-time-table').on('click', '.knbn-time-table-delete-btn', function () {
        $(this).closest('tr').hide('normal', function () { $(this).remove(); });
    });
    // edit task time table row
    $('.knbn-time-table').on('click', '.knbn-time-table-edit-btn', function () {
        const lastTd = $(this).closest('tr').find('td:last-child');
        lastTd.find('.knbn-time-table-buttons').hide();
        $(this).closest('tr').find('td[data-alias != "author"]').find('.time-table-td-span').toggle();
        lastTd.append(`
            <span class="knbn-time-table-edit-buttons">
                <button class="knbn-time-table-btn edit-table-save-btn"><i class="fas fa-check"></i></button>
                <button class="knbn-time-table-btn edit-table-delete-btn"><i class="fas fa-times"></i></button>
            </span>
        `);
    });
    // cancel task time table editing row
    $('.knbn-time-table').on('click', '.edit-table-delete-btn', function () {
        console.log(this);
        $(this).closest('tr').find('td[data-alias != "author"]').find('.time-table-td-span').toggle();
        const tdList = $(this).closest('tr').find('td[data-alias != "author"]');
        const timeTableTdVal = tdList.find('.time-table-td-val');
        const inputs = tdList.find('.time-table-td-edit-val').find('input');
        $.each(timeTableTdVal, (k, v) => {
            $(inputs[k]).val(timeTableTdVal[k].textContent);
        });
        $(this).closest('.knbn-time-table-edit-buttons').toggle();
        $(this).closest('td').find('.knbn-time-table-buttons').toggle();
    });
    // save task time table edited row
    $('.knbn-time-table').on('click', '.edit-table-save-btn', function () {
        console.log(this);
        $(this).closest('tr').find('td[data-alias != "author"]').find('.time-table-td-span').toggle();
        const tdList = $(this).closest('tr').find('td[data-alias != "author"]');
        const timeTableTdVal = tdList.find('.time-table-td-val');
        const inputs = tdList.find('.time-table-td-edit-val').find('input');
        $.each(inputs, (k, v) => {
            $(timeTableTdVal[k]).text($(inputs[k]).val());
            $(inputs[k]).attr('value', $(inputs[k]).val());
        });
        $(this).closest('.knbn-time-table-edit-buttons').toggle();
        $(this).closest('td').find('.knbn-time-table-buttons').toggle();
    });
}
