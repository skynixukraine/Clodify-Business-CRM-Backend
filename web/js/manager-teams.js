/**
 * Created by Oleksii on 09.06.2015.
 */
var managerTeamsModule = (function() {

    var cfg = {
            deleteUrl   : '',
            findUrl     : '',
            viewUrl     : '',
            canDelete   : null,
            canAction   : null,
            canView     :null
        },
        dataTable,
        dataFilter = {
        },
        deleteModal;

    function actionView( id )
    {
        document.location.href = cfg.viewUrl + "?id=" + id;
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
            body        : 'The teams will be unavailable anymore, but all his data reports and project will be left in the system.' +
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
            var columns =[

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
                    }

                ];
            if( cfg.canAction){
                columns.push({
                    "targets"   : 5,
                    "orderable" : false,
                    "render"    : function (data, type, row) {
                        var icons = [];
                        //icons.push('<img class="action-icon edit" src="/img/icons/editicon.png">');
                        if ( cfg.canView ) {

                            icons.push('<i class="fa fa-list-alt view" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="View"></i>');

                        }
                        if ( cfg.canDelete ) {

                            icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Delete"></i>');

                        }
                        return '<div class="actions">' + icons.join(" ") + '</div>';

                    }
                });
            }
            dataTable = $('#teams-table').dataTable({
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

                dataTable.find("td").click(function(){

                    dataTable.find("tr[class*=active]").removeClass( "active" );
                    $(this).parents("tr").addClass("active");
                    id = $(this).parents("tr").find("td").eq(0).text();
                    name   = $(this).parents("tr").find("td").eq(1).text();

                });
                dataTable.find("i[class*=view]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    dataFilter['team_id'] = id;
                    actionView( id );

                });

                dataTable.find("img[class*=edit]").click(function(){

                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionEdit( id );

                });
                dataTable.find("i[class*=delete]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionDelete( id, name, dataTable );

                });

            });

        }
    };

})();