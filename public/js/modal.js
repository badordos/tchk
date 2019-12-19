$(document).ready(function () {

    $(".table tr").on('click', function () {
        var id = $(this).data('id');
        var item = localStorage.getItem(id);
        if (item != null) {
            printData(JSON.parse(item));
            console.log('хранилище');
            $('#modal').modal('toggle');
        }
        else {
            $.ajax({
                method: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')},
                url: '/api/v1/task/' + id,
                success: function (data) {
                    printData(data);
                    $('#modal').modal('toggle');
                    console.log(data['id'] + ' запрос');
                    localStorage.setItem(data['id'], JSON.stringify(data));
                }
            });
        }
    });

    function printData(data) {
        $.each(data, function (key, value) {
            $("#" + key).text(value);
        });
    }

});
