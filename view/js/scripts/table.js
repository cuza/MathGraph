$(function () {

    //para tablas con id = da-ex-datatable
    var dontSort = [];
    $('table#da-ex-datatable thead th').each(function () {
        if ($(this).hasClass('no_sort')) {
            dontSort.push({"bSortable": false});
        } else {
            dontSort.push(null);
        }
    });
    $("table#da-ex-datatable").dataTable({
        sPaginationType: "two_button",
        "aaSorting": [
            [1, "asc"]
        ],
        "aoColumns": dontSort
    });


    $("#check_all_item").click(function () {
        if ($(this).attr('checked') == 'checked') {
            $(".check_item").attr('checked', 'checked');
        }
        else {
            $(".check_item").removeAttr('checked');
        }
    });

});