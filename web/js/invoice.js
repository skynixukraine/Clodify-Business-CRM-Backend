/**
 * Created by olha on 12.02.16.
 */
var invoiceModule = (function() {

    var cfg = {
            paidUrl     : '',
            canceledUrl : '',
            deleteUrl   : '',
            findUrl     : '',
            viewUrl     : '',
            canDelete   : null,
            canView     : null,
            canPaid     : null,
            canCanceled : null
        },
        dataTable,
        dataFilter = {
        },
        deleteModal;

    function actionView( id )
    {
        document.location.href = cfg.viewUrl + "?id=" + id;
    }

    function actionPaid( id )
    {
        document.location.href = cfg.paidUrl + "?id=" + id;
    }

    function actionCanceled( id )
    {
        document.location.href = cfg.canceledUrl + "?id=" + id;
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
            title       : 'Delete Invoice #' + id + "?",
            body        : 'All data related to this invoice will be deleted.',
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
            dataTable = $('#invoice_table').dataTable({
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
                        "orderable" : true
                    },
                    {
                        "targets"   : 7,
                        "orderable" : true
                    },
                    {
                        "targets"   : 8,
                        "orderable" : true
                    },
                    {
                        "targets"   : 9,
                        "orderable" : true
                    },
                    {
                        "targets"   : 10,
                        "orderable" : true
                    },
                    {
                        "targets"   : 11,
                        "orderable" : false,
                        "render"    : function (data, type, row) {

                            var icons = [];

                            if( row[10] == "NEW") {

                                if (cfg.canPaid) {

                                    icons.push('<i class="fa fa-money paid" style="cursor: pointer" ' +
                                        'data-toggle="tooltip" data-placement="top" title="Mark Invoice as Paid"></i>');

                                }

                            }
                            if( row[10] == "NEW" ) {

                                    if (cfg.canCanceled) {

                                        icons.push('<i class="fa fa-arrows-alt canceled" style="cursor: pointer" ' +
                                            'data-toggle="tooltip" data-placement="top" title="Cancel the invoice"></i>');

                                    }

                            }

                            if( row[10] == "NEW" || row[10] == "PAID" || row[10] == "CANCELED" ) {
                                if (cfg.canView) {

                                    icons.push('<i class="fa fa-list-alt view" style="cursor: pointer" ' +
                                        'data-toggle="tooltip" data-placement="top" title="View"></i>');

                                }
                            }
                            if( row[10] == "NEW" || row[10] == "CANCELED" ){

                                    if (cfg.canDelete) {

                                        icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                            'data-toggle="tooltip" data-placement="top" title="Delete the invoice"></i>');

                                    }
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

            dataTable.on( 'draw.dt', function (e, settings, data) {

                dataTable.find("i[class*=delete]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionDelete( id, name, dataTable );

                });

                dataTable.find("i[class*=view]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    actionView( id );

                });
                dataTable.find("i[class*=paid]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    actionPaid( id );

                });
                dataTable.find("i[class*=canceled]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    actionCanceled( id );

                });

            });

        }
    };

})();