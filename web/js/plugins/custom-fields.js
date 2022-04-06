let customField = {

    moduleName: $('#form_page').val(),
    ajaxMethod: 'POST',

    /**
     * Toggle setting dropdown
     *
     * @param element
     */
    toggleSettingDropdown: function (element) {
        $(element).closest('.form-group-old').find('.setting-block').toggleClass('d-block');
    },

    /**
     * Add new section
     *
     * @param element
     */
    addNewSection: function (element) {
        let sections = $('#section-block');
        let cloneSection = $('#card-edit').clone();
        let inputTitle = $('input.card-title-text');

        cloneSection.removeAttr('id'); // Remove id attribute
        sections.append(cloneSection);
        cloneSection.show();

        cloneSection.find('span.card-title-text').hide();
        cloneSection.find('input.card-title-text').show().focus().val(cloneSection.find('input.card-title-text').val());

        // Create section request
        request.addSection(`/crm/${customField.moduleName}/create-section`, cloneSection.find('input.card-title-text').val(), cloneSection);

        $('.delete').bind('click',function(){
            let id = $(this).closest('.card-edit').attr('data-id');
            var res = confirm('Вы уверены что хотите удалить ?');
            if(res){
                deleteSection(`/crm/${customField.moduleName}/delete-section`, id, $(this));
            }
        });
    },

    /**
     * Toggle title input
     *
     * @param element
     */
    editFieldTitle: function (element) {
        $(element).closest('.card-edit').find('span.card-title-text').hide();
        $(element).closest('.card-edit').find('input.card-title-text').show().focus().val($(element).closest('.card-edit').find('input.card-title-text').val());
        $(element).closest('.card-edit').find('.card-title-edit-icon').hide();
    },

    /**
     * Edit field
     *
     * @param element
     */
    toggleEditMode: function (element) {

        if ($(element).hasClass('edit-mode-show')) {
            $(element).closest('.card-edit').find('.hide-blok').show();
            $(element).closest('.card-edit').find('input, select').removeAttr('disabled').removeClass('disabled');
            $(element).closest('.card-edit').find('.setting-icon').removeClass('hide');
            $(element).closest('.card-edit').find('.card-content').show();
            $(element).text('Отменить');
            $(element).removeClass('edit-mode-show');
            $(element).addClass('cancel-edit-mode');
            $(element).closest('.card-edit').find('.crm-custom-field-setting').show();
        } else {
            $(element).closest('.card-edit').find('.hide-blok').hide();
            $(element).closest('.card-edit').find('input,select').attr('disabled', 'disabled').addClass('disabled');
            $(element).text('Изменить');
            $(element).closest('.card-edit').find('.card-content').hide();
            $(element).closest('.card-edit').find('.setting-icon').addClass('hide');
            $(element).addClass('edit-mode-show');
            $(element).removeClass('cancel-edit-mode');
            $(element).closest('.card-edit').find('.crm-custom-field-setting').hide();
        }

    },

    /**
     * Edit field configuration
     *
     * @param element
     * @param field_type_id
     */
    editField: function (element, field_type_id) {


        $('.form-group-old .input-group-for-clone').remove();
        $('.form-group-old .edit-fields-btn-container').remove();
        $('.form-input').show();

        let required = 'checked';
        let buttons = $('.edit-fields-btn-container').first().clone().show();
        let label;
        let uniqueIDs = makeid(5);



        $(element).closest('.form-group-old').find('.form-group').hide();
        $(element).closest('.form-group-old').find('.setting-icon').hide();
        $(element).closest('.form-group-old').removeClass('d-flex');
        $(element).closest('.form-group-old').find('.form-input').hide();

        label = $(element).closest('.form-group-old').find('label').text();

        if (!$(element).closest('.form-group-old').find('.form-input').prop('required')) {
            required = '';
        }

        if (field_type_id !== 2) {

            let cloneEditForm = $('.crm-edit-custom-field-params').clone().show();

            cloneEditForm.find('.element-required').attr('id', `element-required-${uniqueIDs}`).attr(required);
            cloneEditForm.find('.element-required-label').attr('for', `element-required-${uniqueIDs}`);
            $(element).closest('.form-group-old').append(cloneEditForm);
            $(element).closest('.form-group-old').append(buttons);
            $(element).closest('.form-group-old').find('.form-input').val(label);

        } else {
            $(element).closest('.form-group-old').append($('.input-group-for-clone').clone().show());

            $(element).closest('.form-group-old').find('.list').val(label);
            $(element).closest('.form-group-old').append(buttons);
        }

    },

    /**
     * Choose field type
     *
     * @param element
     */
    selectFieldType: function (element) {
        let id = $(element).closest('.card-edit').attr('data-id');
        let type = $(element).attr('data-type');
        let type_id = $(element).attr('data-type-id');
        let label = $(element).find('.create-field-item-title').text();
        let form_group = $('.card-edit[data-id=' + id + '] .form-group').last();
        $(element).closest('.card-edit').find('.new-fields-btn-container').show();
        if(type == 'list') {

            let cloneField = $('.input-group-for-clone-select').clone();
            form_group.html(cloneField.show());
            form_group.parent().show();
            $('.content-block-add-field').click(function () {
                let clone_el = $('.js--add-new-row').first().clone();
                clone_el.find('.list-item').val('');
                clone_el.removeAttr('id').css('margin-top', '1.5rem');
                $('.card-edit[data-id=' + id + '] .form-group .option-group').append(clone_el);
            });

        } else {

            let cloneField = $('.crm-edit-custom-field-params').clone().show();
            let append = cloneField.find('.sk-floating-label, .required-blok');
            append.attr('data-type', type);
            append.attr('data-type-id', type_id);
            append.find('.element-required').attr('id', `element-required-${id}`);
            append.find('.element-required-label').attr('for', `element-required-${id}`);
            form_group.html(append);
            form_group.parent().show();
        }
    },

    /**
     * Cancel field creation
     *
     * @param element
     */
    cancelFieldCreation: function (element) {
        $(element).closest('.form-fields').hide();
        $(element).closest('.form-fields').find('.form-group > *').remove();
    },

    saveField: function (element) {

        let type = $(element).closest('.card-content').find('.input-group-for-clone').attr('data-type');
        let field_type = $(element).closest('.card-content').find('.input-group-for-clone').attr('data-type-id');
        let section_id = $(element).closest('.card-edit').attr('data-id');
        let required = $(element).closest('.card-edit').find('.required-blok input').is(':checked');
        let options = '';
        let name;

        if(required){
            required = 1;
        } else {
            required = 0;
        }

        if(type !== 'list'){
            name = $(element).closest('.card-content').find('.form-input').val();
        } else {
            field_type = 2;
            name = $(element).closest('.card-content').find('.form-input').val();
            $(element).closest('.form-fields').find('.list-item').each(function(){
                let option_val = $(this).val();
                if(option_val) {
                    options += option_val+',';
                }
            });
        }
        customField.addField(`/crm/${customField.moduleName}/add-field`, field_type, type, section_id, name, required, options, element)

    },

    addField: function (url, field_type_id, type, section_id, input_value, required_field, options = '', element) {

        return $.ajax({
            url: url,
            method: customField.ajaxMethod,
            data: {
                section_id: section_id,
                field_type_id: field_type_id,
                value: input_value,
                required: required_field,
                options: options
            },
            dataType: 'json',
            success: function(response){

                $(element).closest('.card-content').find('.sk-floating-label, .required-blok, .new-fields-btn-container,.option-group,.content-add-field').hide();
                $(element).closest('.card-content').find('.content-add-field').remove();
                let required_html;

                if(required_field != 0){
                    required_html = 'required';
                }

                if(field_type_id != 2) {

                    let cloneField = $('.crm-field-display-text').clone().show();
                    cloneField.attr('data-id', response.id).attr('data-type', field_type_id);
                    cloneField.find('label').attr('for', response.id).text(input_value);
                    cloneField.find('.form-input').attr('type', type).attr('id', response.id).attr('name', `Fields[${response.id}]`);
                    cloneField.find('.setting-mode').attr('onclick', 'customField.editField(this, field_type_id)');

                    $(element).closest('.card-edit').find('.form-fields-old').append(cloneField);

                } else {
                    let option_html = '';

                    for(let i in response.options){
                        option_html += '<option value="'+i+'">'+response.options[i]+'</option>';
                    }

                    let cloneField = $('.crm-field-display-select').clone().show();
                    cloneField.attr('data-id', response.id).attr('data-type', field_type_id);
                    cloneField.find('label').attr('for', response.id).text(input_value);
                    cloneField.find('.form-input').attr('id', response.id).attr('name', 'Fields['+response.id+'}]').attr('required',required_html);
                    cloneField.find('.form-input').append(option_html);
                     cloneField.find('.setting-mode').attr('onclick', 'customField.editField(this, field_type_id)');

                    $(element).closest('.card-edit').find('.form-fields-old').append(cloneField);
                }


            }
        });
    }

};

let request = {

    /**
     * Create new section
     *
     * @param url
     * @param value
     * @param el
     */
    addSection: function (url, value, el) {
        return $.ajax({
            url: url,
            method: customField.ajaxMethod,
            data: {value: value},
            dataType: 'json',
            success: function (res) {
                el.closest('.card-edit').attr('data-id', res.result);
            },
        });
    },

    /**
     * Change section title
     *
     * @param url
     * @param id
     * @param value
     */
    changeSectionTitle: function changeSectionTitle(url, id, value) {
        return $.ajax({
            url: url,
            method: customField.ajaxMethod,
            data: {id: id, value: value},
            dataType: 'json',
            complete:function (e) {
                console.log(e);
            }
        });
    }

};

$('body').on('keyup', 'input.card-title-text', function () {
    let form_page = $('#form_page').val();
    let id = $(this).closest('.card-edit').attr('data-id');
    let text = $(this).val();
    request.changeSectionTitle('/crm/'+form_page+'/update-section', id, text);
});

$('body').on('change', 'input.card-title-text', function() {
    let val = $(this).val();
    $(this).closest('.card-edit').find('span.card-title-text').text(val);
    $(this).closest('.card-edit').find('.card-title-edit-icon').css('display', 'inline-block');
    $(this).closest('.card-edit').find('span.card-title-text').show();
    $(this).closest('.card-edit').find('input.card-title-text').hide();
});


function editeField(this_){

    var form_page = $('#form_page').val();
    var type = $(this_).closest('.form-group-old').find('.form-input').attr('data-type');
    var section_id = $(this_).closest('.card-edit').attr('data-id');
    var field_id = $(this_).closest('.form-group-old').attr('data-id');
    var field_type = $(this_).closest('.card-content').find('.sk-floating-label').attr('data-type-id');

    var required = $(this_).closest('.card-edit').find('.required-blok input').is(':checked');
    if(required){
        required = 1;
    } else {
        required = 0;
    }
    var options = '';
    var field_type = 1;
    if(type != 'list'){
        type = $(this_).closest('.form-group-old').find('.form-input').attr('type');
        var name = $(this_).closest('.form-group-old').find('.input-group-for-clone .form-input').val();
    } else {
        field_type = 2;
        var name = $(this_).closest('.form-group-old').find('.list').val();

        $(this_).closest('.form-group-old').find('.field-blok').each(function(){
            let option_val = $(this).find('.list-item').val();
            if(option_val){
                options+= option_val+',';
            }
        });
    }
    updateField('/crm/'+form_page+'/update-field',field_type,type, section_id, name, required, field_id, $(this_), options);
    $(this_).closest('.card-content').find('.input-group-for-clone').remove();
    $(this_).closest('.card-content').find('.new-fields-btn-container').hide();
    return true;
}

function updateField(url,field_type_id, type, section_id, value, required, field_id, this_, options = '') {

    $.ajax({
        url: url,
        method: 'post',
        data: {section_id: section_id,field_type_id:field_type_id, value: value, required:required, field_id:field_id, options: options},
        dataType: 'json',
        success: function(res){
            var required_html = 'required';

            $(this_).closest('.form-group-old').addClass('d-flex');
            if(required == 0){
                required_html = '';
            }
            if(field_type_id != 2) {
                this_.closest('.form-group-old').html(`<div class="form-group w-100 sk-floating-label">
                                                           <input class="form-input form-control" type="type" id="${res.id}" name="Fields[${res.id}]" ${required_html}>
                                                           <label for="${res.id}">${value}</label>
                                                       </div>
                                                       <div class="btn-group mb-3 crm-custom-field-setting showed">
                                                       <button type="button" class="setting-icon border-0 p-0 showed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="customField.toggleSettingDropdown(this)"></button>
                                                           <ul class="dropdown-menu dropdown-menu-right">
                                                               <li class="dropdown-item hide">Скрыть</li>
                                                               <li class="dropdown-item setting-mode" onclick="editeMode($(this),`+field_type_id+`)">Настроить</li>
                                                               <li class="dropdown-item remove-mode" onclick="removeField()">Удалить</li>
                                                           </ul>
                                                       </div>`);
                $('.remove-mode').bind('click',function(){
                    let id = $(this).closest('.form-group-old').attr('data-id');
                    let res = confirm('Вы уверены что хотите удалить ?');
                    let type = $(this).closest('.form-group-old').attr('data-id');
                    if(res){
                        deleteField('/crm/'+form_page+'/delete-field', id, $(this));
                    }
                });
            } else {
                let option_html = '';
                for( var i in res.options){
                    option_html +='<option value="'+i+'">'+res.options[i]+'</option>';
                }
                this_.closest('.form-group-old').html(`
                        <label for="` + res.id + `">` + value + `</label>
                        <select class="form-input form-control" type="text" id="` + res.id + `" name="Fields[` + res.id + `]" ` + required_html + `  >
                           `+option_html+`
                        </select>
                          <div class="btn-group mb-3 crm-custom-field-setting showed">
                           <button type="button" class="setting-icon border-0 p-0 showed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="customField.toggleSettingDropdown(this)"></button>
                               <ul class="dropdown-menu dropdown-menu-right">
                                   <li class="dropdown-item hide">Скрыть</li>
                                   <li class="dropdown-item setting-mode" onclick="editeMode($(this),`+field_type_id+`)">Настроить</li>
                                   <li class="dropdown-item remove-mode" onclick="removeField()">Удалить</li>
                               </ul>
                           </div>
                      `);
                $('.remove-mode').bind('click',function(){
                    let id = $(this).closest('.form-group-old').attr('data-id');
                    let res = confirm('Вы уверены что хотите удалить ?');
                    let type = $(this).closest('.form-group-old').attr('data-id');
                    if(res){
                        deleteField('/crm/'+form_page+'/delete-field', id, $(this));
                    }
                });
            }

        },
    });
    return true;
}

function addField(url,field_type_id,type, section_id, value, required, options = '', this_) {

    $.ajax({
        url: url,
        method: 'post',
        data: {section_id: section_id,field_type_id:field_type_id, value: value, required:required, options: options},
        dataType: 'json',
        success: function(res){
            var required_html = 'required';
            if(required == 0){
                required_html = '';
            }
            if(field_type_id != 2) {
                this_.closest('.card-edit').find('.form-fields-old').append(`<div class="form-group-old d-flex align-items-center relative-blok" data-id="`+res.id+`" data-type="`+field_type_id+`">
                      <div class="form-group w-100 sk-floating-label">
                          <label for="` + res.id + `">` + value + `</label>
                          <input class="form-group w-100 sk-floating-label" type="`+type+`" id="` + res.id + `" name="Fields[` + res.id + `]" ` + required_html + `  >
                      </div>
                      <div class="btn-group mb-3 crm-custom-field-setting showed">
                           <button type="button" class="setting-icon border-0 p-0 showed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="customField.toggleSettingDropdown(this)"></button>
                               <ul class="dropdown-menu dropdown-menu-right">
                                   <li class="dropdown-item hide">Скрыть</li>
                                   <li class="dropdown-item setting-mode" onclick="editeMode($(this),`+field_type_id+`)">Настроить</li>
                                   <li class="dropdown-item remove-mode" onclick="removeField()">Удалить</li>
                               </ul>
                           </div>
                  </div>`);

            } else {
                let option_html = '';
                for( var i in res.options){
                    option_html +='<option value="'+i+'">'+res.options[i]+'</option>';
                }
                this_.closest('.card-edit').find('.form-fields-old').append(`<div class="form-group-old d-flex align-items-center relative-blok" data-id="`+res.id+`" data-type="`+field_type_id+`">
                        <div class="form-group w-100 sk-floating-label">
                        <label for="` + res.id + `">` + value + `</label>
                        <select class="form-group w-100 sk-floating-label" type="text" id="` + res.id + `" name="Fields[` + res.id + `]" ` + required_html + `  >
                           `+option_html+`
                        </select>
                        </div>
                          <div class="btn-group mb-3 crm-custom-field-setting showed">
                           <button type="button" class="setting-icon border-0 p-0 showed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="customField.toggleSettingDropdown(this)"></button>
                               <ul class="dropdown-menu dropdown-menu-right">
                                   <li class="dropdown-item hide">Скрыть</li>
                                   <li class="dropdown-item setting-mode" onclick="editeMode($(this),`+field_type_id+`)">Настроить</li>
                                   <li class="dropdown-item remove-mode" onclick="removeField()">Удалить</li>
                               </ul>
                           </div>
                      </div>`);
            }

        }
    });
}

function addSection(url, value, el) {
    $.ajax({
        url: url,
        method: 'post',
        data: {value: value},
        dataType: 'json',
        success: function(res){
            el.closest('.card-edit').attr('data-id',res.result);
        },
    });
}

function changeSectionTitle(url, id, value) {
    $.ajax({
        url: url,
        method: 'post',
        data: {id: id, value: value},
        dataType: 'json',
        complete:function (e) {
            console.log(e);
        }
    });
}

function deleteSection(url, id, el) {
    $.ajax({
        url: url,
        method: 'post',
        data: {id: id},
        dataType: 'json',
        success: function(e){
            el.closest('.card-edit').remove();
        }
    });
}

function deleteField(url, id, el, type) {
    $.ajax({
        url: url,
        method: 'post',
        data: {id: id, type:type},
        dataType: 'json',
        success: function(e){
            el.closest('.form-group-old').remove();
        }
    });
}
