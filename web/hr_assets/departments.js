var departmentsData = getData('read/departments')
var listSelect = [];

console.log(departmentsData)

$.each( departmentsData, (index, item) => {
    listSelect.push({text: item.title, value:item.id.toString()});
    item.childList='';
    item.childListOfTitles='';
    item.parent='';
    $.each( departmentsData, (i, it) => {
        if(item.parent_id == it.id){
            item.parent = it.title;
        }
        // if(it.parent_id == item.id){
        //     item.childList+=it.id+',';
        //     item.childListOfTitles+=it.title+',';
        // }
    });
    // item.childList = item.childList.substring(0, item.childList.length -1);
    // item.childListOfTitles = item.childListOfTitles.substring(0, item.childListOfTitles.length -1);
});

var gridData = departmentsData;

const grid = new tui.Grid({
    el: document.getElementById('grid'),
    scrollX: false,
    scrollY: false,
    rowHeaders: ['checkbox'],
    columns: [
        {
            header: 'ИН',
            name: 'id',
            width: '15',
            sortingType: 'desc',
            sortable: true,
        },
        {
            header: 'Название',
            name: 'title',
            // editor: 'text',
            sortingType: 'asc',
            sortable: true,
            // filter: 'text',
        },
        {
            header: 'Руководство',
            name: 'parent',
            // editor: 'text',
            sortingType: 'asc',
            sortable: true,
            // filter: 'text',
        },
        // {
        //     header: 'Отделы',
        //     // name: 'childList',
        //     name: 'childListOfTitles',
        //     // editor: 'text',
        //     sortingType: 'asc',
        //     sortable: true,
        //     // formatter: 'listItemText',
        //     // filter: 'select',
        //     // editor: {
        //     //     type: 'checkbox',
        //     //     options: {listItems: listSelect}
        //     // },
        // }
    ]
});
grid.on('beforeChange', ev => {
    // let property    = ev.changes[0].columnName;         let value       = ev.changes[0].nextValue;
    // let itemId      = gridData[ev.changes[0].rowKey].id;let changeData ={};changeData[property] = value;
    // if(itemId>0){setApiDepartment(itemId, changeData);
    // }else{addApiPositions(changeData);location.reload();}
    console.log('before change:', ev);
});
grid.on('afterChange', ev => {
    console.log('after change:', ev);
    /*let colName = ev.changes[0].columnName;
    let value = ev.changes[0].value;
    let prevValue = ev.changes[0].prevValue
    let formData = {};
    formData[colName] = value;
    if(colName == 'staff_class_positions_data'){
        alert('Подключение и удаление должностей к департаментам только в таблице должностей');
        window.location.reload();
    }*/
    // let rowData = grid.getRow(ev.changes[0].rowKey);
    // setApiDepartment(rowData.id, formData);
});
grid.resetData(departmentsData);

$( document ).ready(function() {

});