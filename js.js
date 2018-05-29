var cl = console.log.bind(console);
cl("js online");
const url = 'controller.php'
    //doc tab script
$(document).ready(function() {
    $("#tabs li").on("click", function() {
        var tab = $(this).attr("id");
        if ($(this).hasClass("inactive")) {
            $(this).removeClass("inactive");
            $(this).addClass("active");
            $(this).siblings().removeClass("active").addClass("inactive");
            $("#" + tab + "_content").addClass("show");
            $("#" + tab + "_content").siblings("div").removeClass("show");
        }
    });
});

//today date function for default date
//date function
function formatDate(date) {
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    if (day < 10) {
        dd = '0' + dd
    }
    if (month < 10) {
        month = '0' + month
    }
    return year + '-' + month + '-' + day;
}
//add default date of today
$("input[type='date']").val(formatDate(new Date()));

//validation for addForm
$('#addForm').submit(function(e) {
    e.preventDefault();
    id = $('#addForm :input[name="id"]');
    //Name instead of name because js no likey this
    Name = $('#addForm :input[name="name"]');
    recruitment_date = $('#addForm :input[name="recruitment_date"]');
    var errMsg = "";
    cl('addForm submit validation start');
    if (!Name.val()) {
        errMsg += Name.attr("name") + ' input is empty!\n';
    }
    if (!id.val()) {
        errMsg += id.attr("name") + ' input is empty!';
    }
    if (id.val().length > 9) {
        errMsg += id.attr("name") + ' lenght is greater than 9!';
    }
    if (errMsg.length > 0) {
        alert(errMsg);
    } else {
        //$('#addForm').unbind().submit();
        $.ajax({
            type: "POST",
            url: url,
            //contentType: "application/json; charset=utf-8",
            //dataType: "JSON",
            data: {
                id: id.val(),
                name: Name.val(),
                recruitment_date: recruitment_date.val()
            },
            success: function(response) {
                //parsedResponse=JSON.parse(response);
                cl('response', response);
                if (response.error) {
                    alert(JSON.stringify(response.error));
                } else {
                    alert('New entry added!: ' + JSON.stringify(response.newUser));
                }

            }
        });
    }
});

//showAll click
$('#tab_2').click(function(e) {
    e.preventDefault();
    $('#allTable').empty();
    cl('show list');
    $.ajax({
        type: "GET",
        url: url,
        data: { action: 'getAll' },
        //contentType: "application/json; charset=utf-8",
        //dataType: "JSON",
        success: function(response) {
            cl(response.list);
            if (response.list) {
                response.list.forEach(employee => {
                    var tr = $('<tr>').append(
                        $('<td>', { text: employee.id }),
                        $('<td>', { text: employee.name }),
                        $('<td>', { text: employee.recruitment_date }),
                    );
                    tr.appendTo($('#allTable'));
                });
                //$('#allTable').html(JSON.stringify(response.list));
            }
        }
    });
});

//showAll click
$('#getOne').submit(function(e) {
    e.preventDefault();
    id = $('#getOne :input[name="id"]');
    var errMsg = "";
    cl('addForm submit validation start');
    if (!id.val()) {
        errMsg += id.attr("name") + ' input is empty!';
    }
    if (id.val().length > 9) {
        errMsg += id.attr("name") + ' lenght is greater than 9!';
    }
    if (errMsg.length > 0) {
        alert(errMsg);
    } else {
        $.ajax({
            type: "GET",
            url: url,
            data: {
                action: 'getOne',
                id: id.val()
            },
            //contentType: "application/json; charset=utf-8",
            //dataType: "JSON",
            success: function(response) {
                // cl('get one success:', response);
                if (response.error) {
                    alert(JSON.stringify(response.error));
                } else {
                    alert(JSON.stringify(response));
                }
            }
        });
    }
});

//delete click
$('#delete').submit(function(e) {
    e.preventDefault();
    id = $('#delete :input[name="id"]');
    var errMsg = "";
    cl('addForm submit validation start');
    if (!id.val()) {
        errMsg += id.attr("name") + ' input is empty!';
    }
    if (id.val().length > 9) {
        errMsg += id.attr("name") + ' lenght is greater than 9!';
    }
    if (errMsg.length > 0) {
        alert(errMsg);
    } else {
        if (confirm("Are you sure you wish to delete id(" + id.val() + ") ?")) {
            $.ajax({
                type: "DELETE",
                url: url,
                data: {
                    action: 'delete',
                    id: id.val()
                },
                //contentType: "application/json; charset=utf-8",
                //dataType: "JSON",
                success: function(response) {
                    //cl('delete success:', response);
                    if (response.error) {
                        alert(JSON.stringify(response.error));
                    } else {
                        alert('delete request for: id(' + id.val() + ') processed without errors');
                    }
                }
            });
        } else {
            alert('delete request for: id(' + id.val() + ') aborted!');
        }

    }
});