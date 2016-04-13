/**
 * Created by lera on 25.03.16.
 */
var TeammateModule = (function() {

    var cfg = {
            deleteUrl   : '',
            findUrl     : '',
            canDelete   : null
        },
        dataTable,
        dataFilter = {
        },
        deleteModal;

    function actionDelete( id, name, dataTable )
    {

        function deleteRequest(  )
        {
            var params = {
                url     : cfg.deleteUrl,
                data    : {id : id},
                dataType: 'json',
                type    : 'DELETE',
                success : function ( response ) {

                    if ( response.message ) {

                        var win = new ModalBootstrap({
                            title: 'Message',
                            body: response.message,
                            buttons: [
                                {class: 'btn-default confirm', text: 'Ok'}
                            ]


                        });
                        win.show();
                    }
                    dataTable.api().ajax.reload();

                }
            };

            $.ajax( params );

        }

        deleteModal = new ModalBootstrap({
            title       : 'Delete ' + name + "?",
            body        : 'The teams will be unavailable anymore, but all his data reports and project will be left in the system.' +
            ' Are you sure you wish to delete it?',
            winAttrs    : { class : 'modal delete'}
        });
        deleteModal.show();
        deleteModal.getWin().find("button[class*=confirm]").click(function () {
            deleteRequest();
        });

    }
    function parseGetParams() {

        var __GET = window.location.search.substring(1).split("&");
        for(var i=0; i<__GET.length; i++) {
            var getVar = __GET[i].split("=");
        }
        return  getVar[1];
    }
    var team_id = parseGetParams();
    console.log(team_id);


    return {

        init: function( config ){
            $('#myModal').on('shown.bs.modal', function () {
                $('#myInput').focus()
            });

            dataFilter['teamId'] = team_id;
            /*$('.modal').on('click', '.sendForm', function() {
                var form = $(this).closest('form');
                $.post(
                    form.attr('action'),
                    form.serialize(),
                    function(data) {
                        //window.location.reload();
                        $('.modal').modal('hide');
                    }
                );
                return false;
            });*/

            cfg = $.extend(cfg, config);

            dataTable = $('#teammates-table').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": true,
                "pageLength": 25,
                "bInfo": false,
                "bAutoWidth": false,
                "order": [[ 0, "desc" ]],
                "columnDefs": [

                    {
                        "targets"   : 0,
                        "orderable" : true
                    },
                    {
                        "targets"   : 1,
                        "orderable" : true
                    },
                    {
                        "targets"   : 2,
                        "orderable" : true
                    },
                    {
                        "targets"   : 3,
                        "orderable" : true
                    },
                    {
                        "targets"   : 4,
                        "orderable" : true
                    },
                    {
                        "targets"   : 5,
                        "orderable" : true
                    },
                    {
                        "targets"   : 6,
                        "orderable" : false,
                        "render"    : function (data, type, row) {
                            var icons = [];
                            //icons.push('<img class="action-icon edit" src="/img/icons/editicon.png">');
                            if ( cfg.canDelete ) {

                                icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Delete"></i>');

                            }
                            return '<div class="actions">' + icons.join(" ") + '</div>';

                        }
                    }

                ],
                "ajax": {

                    "url"   :  cfg.findUrl,

                    "data"  : function( data, settings ) {

                        for (var i in dataFilter) {

                            data[i] = dataFilter[i];

                        }

                    }
                },
                "processing": true,
                "serverSide": true
            });






            var id="", name, a = [];
            dataTable.on( 'draw.dt', function (e, settings, data) {


                dataTable.find("i[class*=delete]").click(function(){
                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionDelete( id, name, dataTable );

                });

            });


        }
    };

})();