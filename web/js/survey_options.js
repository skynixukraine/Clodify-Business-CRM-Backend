/**
 * Created by lera on 05.05.16.
 */
var surveysModule = (function() {

    var cfg = {
            findUrl     : '',
            editUrl     : '',
            deleteUrl   : '',
            codeUrl     : '',
            canDelete   : null,
            canEdit     : null
        },
        dataTable,
        dataFilter = {
        },
        deleteModal;


    function actionEdit( id )
    {
        document.location.href = cfg.editUrl + "?id=" + id;
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
            title       : 'Are you sure you wish to completely delete the survey ' + id + "?",
            body        : 'All data related to this survey will be deleted.',
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
                    "orderable" : true,
                    "render"    : function (data, type, row) {

                        return '<a class="code" target="_blank" href="' + cfg.codeUrl + "/" + data + '">' + data + '</a>';

                    }
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
                    "orderable" : true,
                    "render"    : function (data, type, row) {

                        return ( data > 0 ? 'Yes' : 'No');

                    }
                },
                {
                    "targets"   : 6,
                    "orderable" : true
                }
            ];
            if( cfg.canAction){
                columns.push({
                    "targets"   : 7,
                    "orderable" : false,
                    "render"    : function (data, type, row) {
                        var icons = [];
                        //icons.push('<img class="action-icon edit" src="/img/icons/editicon.png">');
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
            }


            dataTable = $('#surveys_table').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": true,
                "pageLength": 25,
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
            var id="", name, a = [];
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

            });

            dataTable.on( 'draw.dt', function (e, settings, data) {

                /*dataTable.find("i[class*=edit]").click(function(){

                 var id = $(this).parents("tr").find("td").eq(0).text();
                 actionEdit( id );

                 });*/


            });

        }
    };

})();
