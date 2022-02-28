baseURL = "http://billing.loc/hr/default/";
token =  $('meta[name="csrf-token"]').attr("content");

function getData(url, data = null){

    console.log(baseURL+url)
    let result = {};
    if(data == null){
        $.ajax(baseURL+url, {
            type: "GET", dataType: "json", contentType: 'application/json', async: false}).done(function(data) {result = data;
        }).fail(async function(error) {alert("something wrong"); console.log(error); result = false;});
    }


    return result;
}

function addData(url, data){let result = {};
    // data.append('_csrf',$('meta[name="csrf-token"]').attr("content"))
    $.ajax({type: 'POST',
        url: baseURL+url,
        data: data,
        async: false}).done(function (data) {
        result = data;}).fail(async function(error) {alert("something wrong"); console.log(error); result = false;});
    return result;
}

function addDataRequest(url, data){let result = {};
    var request = new XMLHttpRequest();
    request.open("POST", baseURL+url);

    request.onload = function () {
        console.log('DONE', request.readyState); // readyState будет равно 4
        return request.readyState;
    };

    request.send(data);
}

function editData(url, data){let result = {};
    $.ajax({type: 'POST',    url: baseURL+url, contentType: 'application/json', data: JSON.stringify(data), async: false}).done(function (data) {
        result = data;}).fail(async function(error) {alert("something wrong"); console.log(error); result = false;});
    return result;
}

function deleteData(url){let result = {};
    $.ajax({type: 'DELETE', url: baseURL+url, contentType: 'application/json', async: false}).done(function (data) {
        result = data;}).fail(async function(error) {alert("something wrong"); console.log(error); result = false;});
    return result;
}
