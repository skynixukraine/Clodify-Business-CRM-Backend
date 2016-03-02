var reportModule = (function(){
    var count = function(){
            var total = 0;
            for(var i = 0; i<$(document).find('.hour').length; i++ ){
                var n = '.hour:eq('+ i +')';
                total += parseFloat($(document).find(n).text());
            }
            $(document).find('#totalHours').html("Total: " + total + " hours");
            $(document).find('#totalHours').parent().css('text-align', 'center');
        },
        cfg = {
            deleteUrl: "",
            saveUrl: ""
        };

    return {
        init:function( config ) {

            cfg = $.extend( cfg, config);

            var trElem;
            count();
            var win = new ModalBootstrap({
                title: 'Message',
                body: "Are you sure you want to delete this report?"
            });
            $('.delete').click(function() {
                trElem  = $(this).parent().parent();
                win.show();
            });
            win.getWin().find(".confirm").click(function() {
                var id  = trElem.find('td:eq(0)').text();
                console.log(id);
                $.get( cfg.deleteUrl, {id: id} ).done(function () {
                    trElem.remove();
                    console.log("Data Removed");
                    count();
                });
            });
            $('.edit').click( function () {
                var edit = $(this);
                var trElem  = edit.parent().parent();
                var descr   = trElem.find('td:eq(2)').text();
                var hours   = trElem.find('td:eq(3)').text();
                var id      = trElem.find('td:eq(0)').text();
                trElem.find('td:eq(2)').css('width:', '75%').html('<input style="width: 640px; height: 25px;" type="text" value="' + descr + '" class="description">');
                trElem.find('td:eq(3)').css('width:', '40px').html('<input style="height: 25px; width: 40px; text-align: center;" type="text" value="' + hours + '" class="hours">');
                edit.hide();
                if(edit.parent().find('.save').length == 0){
                    edit.after('<button class="save btn btn-success btn-xs" type="submit">SAVE</button>');

                    $('.hours').keypress(function(e) {
                        if (!(e.which==8 || e.which==44 ||e.which==45 ||e.which==46 ||(e.which>47 && e.which<58))) return false;
                    });

                    edit.parent().find('.save').click(function() {
                        var newDescr = trElem.find('.description').val();
                        var newHours = trElem.find('.hours').val();

                        if( ( $.type( newDescr ) != 'string' ) || newDescr == "" || newDescr == " " || ( newHours > 10 || newHours <= 0 ) ) {
                            alert( "Please, enter correct data!" );
                            //edit.parent().find('.save').disable(true);
                        }
                        else{
                            $.post(cfg.saveUrl, {id: id, task: newDescr, hours: newHours}).done(function (data) {
                                console.log("Data Loaded: " + data);
                            });
                            trElem.find('td:eq(2)').text(newDescr);
                            trElem.find('td:eq(3)').text(newHours);
                            edit.show();
                            edit.parent().find('.save').hide();
                            count();
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