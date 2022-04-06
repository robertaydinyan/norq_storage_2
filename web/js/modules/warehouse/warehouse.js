$(document).ready(function() {

    var table = $('#wh-products').DataTable( {
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "searching": true,
        "info": false,
        "lengthChange": false,
        "filter": true,         // this is for disable filter (search box)
        "orderMulti": true,     // for disable multiple column at once
        "responsive": true,
        "pageLength": 10,
        "searchDelay":1000,
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Որոնում "
        },
        "language": {
            "paginate": {
                "previous": "Նախորդ",
                "next": "Հաջորդ",
            }
        }

  });

} );