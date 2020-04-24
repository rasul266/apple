$(document).ready(function () {


    $('.apple').click(function () {

        var percent = $(this).prev().val();
        var id = $(this).data('id');

        if(percent == '')
        {
            alert('Заполните поле');
            return 0;
        }

       if(Number.isInteger(parseInt(percent))==false)
       {
           alert('Процент должен быть целым числом');
           return 0;
       }

        $.get('/backend/apple/eat', {id: id, percent: percent}, function (data) {

            alert(data);

        });
        return false;
    });

 });