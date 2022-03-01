function confirmDeletion (text){
    let  confirm_deletion_popup_cont =$(".erp-confirm-deletion")
    let confirm_deletion_popup = $(` 
        <div class = "confirm-del-popup">
            <div class = "confirm-del-warning-icon"><i class="fas fa-exclamation-circle"></i></div>
            <div class = "confirm-del-text-1">Подтвердите действие!<br>Действие необратимо.</div>
            <div class = "confirm-del-text-2">
                <span><strong>Вы действительно хотите удалить <span>${text}</span></strong></span>
            </div>
            <div>
                <button id = "cancel-deletion-btn" class = "c-btn c-btn-secondary c-btn-ol">отменить</button>
                <button id = "confirm-deletion-btn" class = "c-btn c-btn-danger">УДАЛИТЬ</button>
            </div>
        </div>`);
    confirm_deletion_popup_cont.html(confirm_deletion_popup).show();
    $("#cancel-deletion-btn", confirm_deletion_popup).on("click", function (e) {
        confirm_deletion_popup_cont.hide();
    });
    let delete_btn = $("#confirm-deletion-btn", confirm_deletion_popup);
    return {delete_btn: delete_btn, confirm_deletion_popup_cont: confirm_deletion_popup_cont};
}
function zoneNineHideShow(popup, status){
    if(status === "show"){
        popup.animate({ width: "100%", right: "+=75px"}, 300 );
    } else {
        popup.animate({ width: "0", right: "-=75px"}, 300);
    }
}
// $(document).ready(() => {
//     // let now = moment();
//     // $(`.jobTime`).text(`${now.hours() > 9? now.hours() :"0"+ now.hours()}  : ${now.minutes()> 9? now.minutes() :"0"+ now.minutes()}`);
//     // let job_time = setInterval(function () {
//     //     let now = moment();
//     //     $(`.jobTime`).text(`${now.hours() > 9? now.hours() :"0"+ now.hours()}  : ${now.minutes()> 9? now.minutes() :"0"+ now.minutes()}`);
//     // },1000)
//     let speed = 300;
//     let easing ="linear";
//     $('.iconNav').on('click', function () {
//         let container =$(".main-content");
//         let sidebar = $('.zone2-div');
//         let zone_six = $('.zone6');
//         let zone_width = "150";
//         if ($(this).hasClass('opened')) {
//             sidebar.animate({
//                 width: '40px'
//             }, speed, easing);
//             $(this).removeClass('opened');
//             container.animate({
//                 marginLeft: `-=${zone_width}px`,
//             }, speed, easing);
//             zone_six.animate({
//                 width: `+=${zone_width}px`,
//             }, speed, easing);
//         } else {
//             sidebar.animate({
//                 width: `190px`
//             }, speed, easing);
//             $(this).addClass('opened');
//             container.animate({
//                 marginLeft: `+=${zone_width}px`,
//             }, speed, easing);
//             zone_six.animate({
//                 width: `-=${zone_width}px`,
//             }, speed, easing);
//         }
//     });
//     $('.starCheck').on('click', function () {
//         if (!$(this).hasClass('checked')) {
//             $(this).css('color', '#007bff');
//             $(this).addClass('checked');
//         } else {
//             $(this).css('color', '#bababa');
//             $(this).removeClass('checked');
//         }
//     });
//     $('.arrowUp').on('click', function () {
//         let zone_seven = $('.zone7');
//         let zone_height = "200";
//         if (!zone_seven.hasClass('opened')) {
//             $({rotation: 0}).animate({rotation: 180}, {
//                 duration: 500,
//                 easing: 'linear',
//                 step: function () {
//                     $('.arrowZ7').css({transform: 'rotate(' + this.rotation + 'deg)'});
//                 }
//             });
//             zone_seven.animate({
//                 height: `+${zone_height}px`,
//             }, speed, easing);
//             zone_seven.addClass("opened");
//         } else {
//             $({rotation: 180}).animate({rotation: 0}, {
//                 duration: 500,
//                 easing: 'linear',
//                 step: function () {
//                     $('.arrowZ7').css({transform: 'rotate(' + this.rotation + 'deg)'});
//                 }
//             });
//             zone_seven.animate({
//                 height: `-${zone_height}px`,
//             }, speed, easing);
//             zone_seven.removeClass("opened");
//         }
//     });
//
//     $('.arrowLeft').on('click', function (e) {
//         let zone_eight = $('.zone8');
//         let container =$(".main-content");
//         let zone_six = $('.zone6');
//         let zone_width = "304";
//         if (!zone_eight.hasClass('opened')) {
//             $({rotation: 0}).animate({rotation: 180}, {
//                 duration: 500,
//                 easing: 'linear',
//                 step: function () {
//                     $('.arrowZ8').css({transform: 'rotate(' + this.rotation + 'deg)'});
//                 }
//             });
//             zone_six.animate({
//                 width: `-=${zone_width}px`,
//             }, speed, easing);
//             container.animate({
//                 marginRight: `+=${zone_width}px`
//             }, speed, easing);
//             zone_eight.animate({
//                 width: `+${zone_width}px`,
//             }, speed, easing);
//             zone_eight.addClass('opened');
//             zone_eight.addClass('opened');
//         } else {
//             $({rotation: 180}).animate({rotation: 0}, {
//                 duration: 500,
//                 easing: 'linear',
//                 step: function () {
//                     $('.arrowZ8').css({transform: 'rotate(' + this.rotation + 'deg)'});
//                 }
//             });
//             zone_six.animate({
//                 width: `+=${zone_width}px`,
//             }, speed, easing);
//             container.animate({
//                 marginRight: `-=${zone_width}px`
//             }, speed, easing);
//             zone_eight.animate({
//                 width: `-${zone_width}px`,
//             }, speed, easing);
//             zone_eight.css('width', '0');
//             zone_eight.removeClass('opened');
//         }
//     });
//     $('.zone-nine-new-task').on('click', function (e) {
//         let popup = $('.popup2');
//         drawZoneNine(addNewTaskPopup, popup)
//         zoneNineHideShow(popup, "show");
//     });
//     // $(".userImage").attr("src", user.avatar? `${url}${user.avatar.url}`: "images/image.png");
//     // $(".userName").text(`${user.full_name}`);
//
// });