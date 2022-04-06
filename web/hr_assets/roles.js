function getDataOfAddPersons(){
    renderHrRolesList(getData('read/roles'));
    let permissionModulesData = getData('read/permissions_modules');
    let permissionModulesJson = []
    $.each(permissionModulesData, (index, line)=>{
        let existmodule = false;
        $.each(permissionModulesJson, (ind, module)=>{
            if(line.permissions_module_id == module.id){
                existmodule = true;
                permissionModulesJson[ind]["class_permissions"].push({
                    "id": line.permission_id,
                    "title": line.permission_title,
                    "class_permissions_module": line.permissions_module_id,
                    "parent_id": line.permission_parent_id
                })
            }
        })
        if(!existmodule){
            permissionModulesJson.push({
                "id":line.permissions_module_id,
                "title":line.permissions_module_title,
                "parent_id": line.permissions_module_parent_id,
                "class_permissions":[{
                    "id": line.permission_id,
                    "title": line.permission_title,
                    "class_permissions_module": line.permissions_module_id,
                    "parent_id": line.permission_parent_id
                }]
            });
        }
    })

    permissionsModules = permissionModulesJson;

    actions = [
        {"id": 1, "title": "Создать", "icon": "fas fa-edit"}, {
            "id": 2,
            "title": "Читать",
            "icon": "fas fa-book-open"
        }, {
            "id": 3, "title": "Обновить", "icon": "fas fa-sync-alt"
        }, {
            "id": 4,
            "title": "Удалить",
            "icon": "fas fa-trash"
        }, {
            "id": 5, "title": "Экспорт", "icon": "fas fa-upload"
        }, {
            "id": 6,
            "title": "Импорт",
            "icon": "fas fa-download"
        }, {
            "id": 7, "title": "Найти", "icon": "fas fa-book-open"
        }
    ];
    actionsRules = [{"id": 1, "title": "Мои"}, {"id": 2, "title": "Отдел"}, {"id": 3, "title": "Все"}];

    renderHrPermissionsModulesList(permissionsModules, actions, actionsRules, 'permissions_modules');
    $('input[type="checkbox"]').removeAttr("disabled");

    $('input[type="checkbox"]').change(function(){
        $('#new_role_block').removeClass('d-none')
        let selected = $('#role-select :selected').text();
        if(selected != null && selected !='' && selected !='роль'){
            $('#role-input').val($('#role-select :selected').text()+ '_1');
        }else{$('#role-input').val('')}
    })
}

function renderHrPermissionsModulesList(permissionsList, actionsList, rulesList, mainElementId){
    if(!permissionsList || !permissionsList.length){return}
    var rules_template = ``; var table_head_line = ``;
    $.each(actionsList, (index, action)=>{
        table_head_line += `<th scope="col"><span class="green-color mr-2"><i class="${action.icon}"></i></span>${action.title}</th>`;
    })
    var table_body_line = ``;
    console.log(actionsList)
    $.each(actionsList, (index, action)=>{
        rules_template = `<td>`;
        $.each(rulesList, (index, rule)=>{
            rules_template+= `<label class="c-label-checkbox ml-2"><input action="${action.id}" rule="${rule.id}" type="checkbox" disabled><span>${rule.title}</span></label>`;
        });rules_template +=`</td>`;
        table_body_line += rules_template;
    })
    console.log(permissionsList)
    $.each(permissionsList, (index, item)=>{
        var table_lines = ``;   var li_lines = ``;
        $.each(item.class_permissions, (index, line)=>{
            table_lines+=`<tr  permission="${line.id}">
              <td scope="row""><label class="c-label-checkbox"><input type="checkbox" class="row-check full" disabled><span></span></label></td>${table_body_line} </tr>`;
            li_lines +=`<li>${line.title} </li>`;
        });

        $('#'+mainElementId).append(`<section class="permissions_module">
            <div class="c-table-box-list mb-4" id="hr-permissions-table-list-1">
                <div class="c-table-side py-2"><span class="c-table-list-title">${item.title}</span>
                    <ul class="c-table-list permissions_modules_ul"> ${li_lines} </ul>
                </div>
                <div class="c-table-box table-responsive c-border rounded px-4 py-2"><div class=""><table class="table table-hover table-striped c-table ">
                    <thead><tr>
                        <th scope="col"><label class="c-label-checkbox"><input type="checkbox" class="main-check" disabled><span></span></label></th>
                        ${table_head_line}
                    </tr></thead>
                    <tbody>${table_lines}</tbody>
                </table></div></div>
            </div></section>`);table_lines = ``;li_lines = ``;
    });
}
function renderHrRolesList(rolesList){
    if(!rolesList || !rolesList.length){return}             let optionHtml = ``;
    $.each(rolesList, (index, role)=>{optionHtml += `<option value="${role.id}">${role.title}</option>`;});
    $('#role-select').append(optionHtml);
}
getDataOfAddPersons()

$('#role-select').change(function () {
    $('input[type="checkbox"]').prop("checked", false);
    $('#role-input').val('');
    let selectedRoleId =  $('#role-select').find(':selected').val();
    let rulesActionsPermissionsForRole = getData('read/role_permissions?id='+selectedRoleId);

    $.each(rulesActionsPermissionsForRole, (index, permission)=>{
        let permissionId= permission.permission_id;

        if(permission.create_rule_id>0){
            $('#permissions_modules').find('[permission="'+permissionId+'"]').find('[action="1"][rule="'+permission.create_rule_id+'"]').prop( "checked", true );
        }

        if(permission.read_rule_id>0){
            $('#permissions_modules').find('[permission="'+permissionId+'"]').find('[action="2"][rule="'+permission.read_rule_id+'"]').prop( "checked", true );
        }

        if(permission.update_rule_id>0){
            $('#permissions_modules').find('[permission="'+permissionId+'"]').find('[action="3"][rule="'+permission.update_rule_id+'"]').prop( "checked", true );
        }

        if(permission.delete_rule_id>0){
            $('#permissions_modules').find('[permission="'+permissionId+'"]').find('[action="4"][rule="'+permission.delete_rule_id+'"]').prop( "checked", true );
        }

        if(permission.export_rule_id>0){
            $('#permissions_modules').find('[permission="'+permissionId+'"]').find('[action="5"][rule="'+permission.export_rule_id+'"]').prop( "checked", true );
        }

        if(permission.import_rule_id>0){
            $('#permissions_modules').find('[permission="'+permissionId+'"]').find('[action="6"][rule="'+permission.import_rule_id+'"]').prop( "checked", true );
        }

        if(permission.find_rule_id>0){
            $('#permissions_modules').find('[permission="'+permissionId+'"]').find('[action="7"][rule="'+permission.find_rule_id+'"]').prop( "checked", true );
        }

    });
});

$('#save').click(function () {if($('#role-input').val() == null || $('#role-input').val() == ""){
    alert('Пожалуйста заполните поле названия новой роли'); return false;}else{
    let roleData = {"HrClassRoles": {title: $('#role-input').val()}};
    let newRoleID  = addData('create/roles', roleData);

    $.each($('#permissions_modules table tbody tr'), (index, tr)=> {
        let permissionData = {
            "role_id": newRoleID,
            "create_rule_id":"",
            "read_rule_id":"",
            "update_rule_id":"",
            "delete_rule_id":"",
            "export_rule_id":"",
            "import_rule_id":"",
            "find_rule_id":"",
        }
        let permissionId = $(tr).attr('permission');
        if(permissionId != null && permissionId != ""){
            permissionData["permission_id"] = permissionId;
        }
        let addPermissionAction = false;

        $.each($(tr).find('input:checked'), (index, input)=> {
            let action = $(input).attr('action');
            if(action != null && action != ""){
                addPermissionAction = true;
                switch (action){
                    case "1":
                        permissionData["create_rule_id"] = $(input).attr('rule');
                        break;
                    case "2":
                        permissionData["read_rule_id"] = $(input).attr('rule');
                        break;
                    case "3":
                        permissionData["update_rule_id"] = $(input).attr('rule');
                        break;
                    case "4":
                        permissionData["delete_rule_id"] = $(input).attr('rule');
                        break;
                    case "5":
                        permissionData["export_rule_id"] = $(input).attr('rule');
                        break;
                    case "6":
                        permissionData["import_rule_id"] = $(input).attr('rule');
                        break;
                    case "7":
                        permissionData["find_rule_id"] = $(input).attr('rule');
                        break;
                }

            }
        })
        if(addPermissionAction){
            addData('create/permissions', {"HrObjectRolesPermissionsActionsRulesModules":permissionData});
            window.location.reload();
        }
    })

}});

$(document).ready(function () {
    $('#logout-action').click(function (e) {e.preventDefault();e.stopPropagation();logoutAction();});
    $($('#hr-menu').children()[5]).addClass('hr-menu-link-active');
    $('.container-fluid').css("max-height", (window.innerHeight-300) +'px');
    $('.c-table').on('change', '.main-check', function(){let rowChecks = $(this).closest('.c-table').find('.row-check');
        $(this).is(':checked') ? rowChecks.prop('checked', true).trigger('change') : rowChecks.prop('checked', false).trigger('change');});

    $('.c-table').on('change', '.row-check', function(){
        $(this).is(':checked') ? $(this).closest('tr').addClass('tr-checked') : $(this).closest('tr').removeClass('tr-checked');
        $.each($(this).closest('tr').find('input[type=checkbox]'), (index, item)=>{
            $(item).prop( "checked", $(this).is(':checked') )})
    });
    $('.select-editing-check').on('change', function () {const editingElems = $(this).closest('.check-editing-box').find('.select-editing-elem');editingElems.toggleClass('d-none')})
});