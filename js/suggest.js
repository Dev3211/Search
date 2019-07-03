$(document).ready(function(){
    $(document).on('keyup','#search',function(){   
        let value = $(this).val();
        $.getJSON('../php/suggest.php?key=' + value, function (data) {
            let availableTags = data;
            $("#search").autocomplete({
                source: availableTags,
				appendTo: "#containerr",
                select: function(event, ui) {
                $(event.target).val(ui.item.value);
                $('#form').submit();
                return false;
            },
             });
        });        
    });
});
