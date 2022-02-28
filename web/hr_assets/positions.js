var positionsData = getData('read/positions')
var listSelect = [];

$.each( positionsData, (index, item) => {
    listSelect.push({text: item.position_title, value:item.id.toString()});
    item.childList='';
    $.each( positionsData, (i, it) => {
        if(item.position_parent_id == it.id){
            item.position_parent= it.position_title;
        }
        // if(it.parent_id == item.id){
        //     item.childList+=it.id+',';
        //     item.childListOfTitles+=it.title+',';
        // }
    });
    // item.childList = item.childList.substring(0, item.childList.length -1);
    // item.childListOfTitles = item.childListOfTitles.substring(0, item.childListOfTitles.length -1);

});

var gridData = positionsData;

const grid = new tui.Grid({
    el: document.getElementById('grid'),
    scrollX: false,
    scrollY: false,
    rowHeaders: ['checkbox'],
    columns: [
        {
            header: 'ИН',
            name: 'id',
            width: '35',
            sortingType: 'desc',
            sortable: true,
        },
        {
            header: 'Название',
            name: 'position_title',
            // editor: 'text',
            sortingType: 'asc',
            sortable: true,
            // filter: 'text',
        },
        {
            header: 'Департамент',
            name: 'department_title',
            // editor: 'text',
            sortingType: 'asc',
            sortable: true,
            // filter: 'text',
        },
        {
            header: 'Руководство',
            name: 'position_parent',
            // editor: 'text',
            sortingType: 'asc',
            sortable: true,
            // filter: 'text',
        },
    ]
});
grid.on('beforeChange', ev => {

    console.log('before change:', ev);
});
grid.on('afterChange', ev => {
    console.log('after change:', ev);

});
grid.resetData(positionsData);

$( document ).ready(function() {

});