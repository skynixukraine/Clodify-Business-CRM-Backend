/**
 * Created by Oleksii on 09.06.2015.
 */
var projectModule = (function() {

    var cfg = {
            editUrl     : '',
            deleteUrl   : '',
            activateUrl : '',
            suspendUrl  : '',
            findUrl     : '',
            canDelete   : null,
            canEdit     : null,
            canActivate : null,
            canSuspend  : null,
            canSeeHours : null,
            canFunck    : null,
        },
        dataTable,
        dataFilter = {
        },
        deleteModal;

        $(".one input[type='checkbox']").click(function () {

            if ($(".one input[type='checkbox']:checked").length == 1) {

                if( $(".one input[type='radio']:checked").length == 1 ){
                   return ;
                }
                else {
                    $(this).parent().parent().find(" input[type='radio']").attr("checked", "checked")
                }

            }

        });
        $(".two input[type='checkbox']").click(function () {

            if ($(".two input[type='checkbox']:checked").length == 1) {

                if( $(".two input[type='radio']:checked").length == 1 ){
                    return ;
                }
                else {
                    $(this).parent().parent().find(" input[type='radio']").attr("checked", "checked")
                }

            }

        });



    function actionEdit( id )
    {
        document.location.href = cfg.editUrl + "?id=" + id;
    }

    function actionActivate( id )
    {
        document.location.href = cfg.activateUrl + "?id=" + id;
    }

    function actionSuspend( id )
    {
        document.location.href = cfg.suspendUrl + "?id=" + id;
    }

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
            body        : 'All data related to this project will be deleted.',
            winAttrs    : { class : 'modal delete'}
        });
        deleteModal.show();
        deleteModal.getWin().find("button[class*=confirm]").click(function () {
            deleteRequest();
        });

    }
    return {

        init: function( config ){

            cfg = $.extend(cfg, config);
            var columns = [

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
                }
            ], index = 3;

            if( cfg.canSeeHours){
                columns.push({
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
                        "orderable" : true
                    },
                    {
                        "targets"   : 7,
                        "orderable" : false
                    },
                    {
                        "targets"   : 8,
                        "orderable" : false
                    });
            }
            if( !cfg.canSeeHours){
                columns.push(
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
                        "orderable" : false
                    },
                    {
                        "targets"   : 6,
                        "orderable" : false
                    },
                    {
                        "targets"   : 7,
                        "orderable" : false
                    });
            }

            if(cfg.canActivate || cfg.canSuspend || cfg.canDelete || cfg.canEdit || cfg.canPaid)
            columns.push(
                {
                    "targets"   : 10,
                    "orderable" : false,
                    "render"    : function (data, type, row) {

                        var icons = [];

                        //icons.push('<img class="action-icon edit" src="/img/icons/editicon.png">');
                        if( row[9] == "INPROGRESS") {

                            if ( cfg.canSuspend ) {

                                icons.push('<i class="fa fa-clock-o suspend" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Suspend"></i>');

                            }

                        }else {

                            if (cfg.canActivate) {

                                icons.push('<i class="fa fa-check-square-o activate" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Activate"></i>');

                            }
                        }
                        if ( cfg.canEdit ) {

                            icons.push('<i class="fa fa-edit edit" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Edit"></i>');

                        }
                        if ( cfg.canDelete ) {

                            icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Delete"></i>');

                        }
                        return '<div class="actions">' + icons.join(" ") + '</div>';

                    }
                });
            dataTable = $('#project_table').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": true,
                "pageLength": 20,
                "bInfo": false,
                "bAutoWidth": false,
                "order": [[ 0, "desc" ]],
                "columnDefs": columns,
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

            dataTable.on( 'draw.dt', function (e, settings, data) {

                dataTable.find("i[class*=edit]").click(function(){

                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionEdit( id );

                });
                dataTable.find("i[class*=delete]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionDelete( id, name, dataTable );

                });
                dataTable.find("i[class*=activate]").click(function(){

                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionActivate( id );

                });
                dataTable.find("i[class*=suspend]").click(function(){

                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionSuspend( id );

                });

            });

        }
    };

})();