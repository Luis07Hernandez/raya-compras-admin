$(document).ready(function () {
    getCountNotifications();
   
});


$("#m_topbar_notification_icon").click(function(){
    getNotifications();
    $('#notification').modal({
        //show: 'false',
        backdrop: 'static',
        keyboard: false
    }); 
});




function getNotifications(){
    $.ajax({
        type: 'GET',
        url: '/getNotification',
        success: function (data) {
            $('#notifications-table').DataTable().destroy();
            $('#notifications-table').DataTable(
                {
                    "order": [[0, "desc"]],
                    "data": data.notifications,
                    "columns": [
                        { data: "created_at" },
                        { data: "message" },
                    ]
                    ,
                    "bFilter": false,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
                    }
                }
            );


        }
    });
}


function getCountNotifications() {

    $.ajax({
        type: 'GET',
        url: '/getCountNotification',
        success: function (data) {
            //console.log(data);
            $("#countNotifications").text(data.notifications);
        }
    });
    
}


function markReadNotificaction(){
    $.ajax({
        type: 'GET',
        url: '/updateNotification',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function (data) {
            console.log(data);
            window.location.reload();
        }
    });
}