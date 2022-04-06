"use strict";
function createZoneEightTaskTabsTable(table_data, table_type) {
    let table_head=[
        {name: 'Дата', alias: 'data'},
        {name: 'Автор', alias: 'author'},
        {name: 'Где изменилось', alias: 'whereIsChange'},
        {name: 'Изменение', alias: 'change'},
    ];
    const tab_table = $(`<table class = "${table_type === 'story' ? "knbn-story-table" : "knbn-time-table"}"></table>`);
    const tHead = $(`<thead></thead>`);
    const tr = $('<tr>');
    $.each(table_head, (k, v) => {
        tr.append($(`<th data-alias="${v.alias}">${v.name}</th>`));
    });
    tHead.append(tr);
    const tBody = $(`<tbody></tbody>`);
    if (table_type === 'story') {
        table_data.forEach((item)=>{
            let tr = $(`<tr>`);
            tr.append($(`<td data-alias="${table_head[0].alias}">${kanbanDateByString(item.created_at)}</td>`));
            tr.append($(`<td data-alias="${table_head[1].alias}">${item.author.full_name}</td>`));
            tr.append($(`<td data-alias="${table_head[2].alias}">${item.action}</td>`));
            tr.append($(`<td data-alias="${table_head[3].alias}">${item.new_state}</td>`));
            tBody.append(tr);
        });
    }
    else {
        $.each(table_data.body, (k, row) => {
            let tr = $(`<tr data-position="${k}">`);
            $.each(row, (key, val) => {
                tr.append($(`
                        <td data-alias="${val.alias}">
                            <span class="time-table-td-val time-table-td-span">${val.name}</span>
                            <span class="time-table-td-edit-val time-table-td-span"><input type="text" value="${val.name}"></span>
                        </td>`));
            });
            tr.find('td:last-child').append($(`
                    <span class="knbn-time-table-buttons">
                        <button class="knbn-time-table-btn knbn-time-table-edit-btn"><i class="fas fa-pen"></i></button>
                        <button class="knbn-time-table-btn knbn-time-table-delete-btn"><i class="fas fa-times"></i></button>
                    </span>
                `));
            tBody.append(tr);
        });
    }
    tab_table.append(tHead);
    tab_table.append(tBody);
    return tab_table;
}
