/**
 * Created by olha on 26.05.16.
 */
var extensionModule = (function() {

    var cfg = {
            editUrl         : '',
            downloadUrl     : '',
            deleteUrl       : '',
            findUrl         : ''
        },
        dataTable,
        dataFilter = {
        },
        deleteModal;

    function actionEdit( id )
    {
        document.location.href = cfg.editUrl + "?id=" + id;
    }

    function actionDownload( id )
    {
        document.location.href = cfg.downloadUrl + "?id=" + id;
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
            body        : 'The user will be unavailable anymore, but all his data reports and project will be left in the system.' +
            ' Are you sure you wish to delete it?',
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
            dataTable = $('#extension_table').dataTable({
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
                        "orderable" : false,
                        "render"    : function (data, type, row) {
                            var icons = [];


                            icons.push('<i class="fa fa-download download" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Download"></i>');

                            icons.push('<i class="fa fa-edit  edit" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Edit"></i>');

                            icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Delete"></i>');

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

                dataTable.find("i[class*=download]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    actionDownload( id );

                });

                dataTable.find("i[class*=edit]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    actionEdit( id );

                });
                
                dataTable.find("i[class*=delete]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    actionDelete( id, name, dataTable );

                });

            });

        }
    };

})();