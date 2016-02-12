var reportModule = (function(){
    var count = function(){
        var total = 0;
        for(var i = 0; i<$(document).find('.hour').length; i++ ){
            var n = '.hour:eq('+ i +')';
            total += parseFloat($(document).find(n).text());
        }
        $(document).find('#totalHours').html("Total: " + total + " hours");
    };
    return {
        init:function(){
            count();
            $('.edit').click( function () {
                var edit = $(this);
                var trElem  = edit.parent().parent();
                var descr   = trElem.find('td:eq(2)').text();
                var hours   = trElem.find('td:eq(3)').text();
                var id      = trElem.find('td:eq(0)').text();
                trElem.find('td:eq(2)').html('<input style="width: 50%; height: 25px;" type="text" value="' + descr + '" class="description">');
                trElem.find('td:eq(3)').html('<input style="height: 25px;" type="text" value="' + hours + '" class="hours">');
                edit.hide();
                if(edit.parent().find('.save').length == 0){
                    edit.after('<button class="save btn btn-success btn-xs" type="submit">SAVE</button>');
                    edit.parent().find('.save').click(function() {
                        var newDescr = trElem.find('.description').val();
                        var newHours = trElem.find('.hours').val();
                        if( ( $.type( newDescr ) != 'string' ) || newDescr == "" || newDescr == " " || ( newHours > 10 || newHours < 0 ) ) {
                            alert( "Please, enter correct data!" );
                            //edit.parent().find('.save').disable(true);
                        }
                        else{
                            $.post("/cp/index/save", {id: id, task: newDescr, hours: newHours}).done(function (data) {
                                console.log("Data Loaded: " + data);
                            });
                            trElem.find('td:eq(2)').text(newDescr);
                            trElem.find('td:eq(3)').text(newHours);
                            count();
                            edit.show();
                            edit.parent().find('.save').hide();
                        }
                    })
                }
                else {
                    edit.parent().find('.save').show();
                }
            });
        }
    }
})();