/**
 * Created by lera on 25.03.16.
 */

var TeamModule = (function() {

    var cfg = {
            findUrl     : '',
            viewUrl     : '',
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
            dataTable = $('#teams-table').dataTable({
                "bPaginate": false,
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
                        data:   "active",
                        "orderable" : false,
                        "render"     :function (data, type, row){
                            if ( type === 'display' ){
                                return '<input type = "checkbox" class = "editor-active">';
                            }
                            return data;
                        }
                    },
                    /* $(document).ready(function (){
                     var table = $('#teams-table').DataTable({ 'ajax': { 'url': '/lab/articles/jquery-datatables-how-to-add-a-checkbox-column/ids-arrays.txt' },
                     'columnDefs': [{ 'targets': 0,
                     'searchable': false,
                     'orderable': false,
                     'className': 'dt-body-center',
                     'render': function (data, type, full, meta){
                     return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">'; } }], 'order': [[1, 'asc']] });
                     }),*/



                    {
                        "targets"   : 1,
                        "data"  :   6,
                        "orderable" : true
                    },
                    {
                        "targets"   : 2,
                        "data"  :   7,
                        "orderable" : true
                    },
                    {
                        "targets"   : 3,
                        "data"  :   8,
                        "orderable" : true
                    },
                    {
                        "targets"   : 4,
                        "data"  :   9,
                        "orderable" : true
                    }

                ],
                /*select: {
                 style: 'os',
                 selector: 'td:not(:first-child)'
                 },
                 "rowCallback": function ( row, data ) {

                 $('input.editor-active', row).prop( 'checked', data.active == 1 );
                 },*/

                "ajax": {
                    "url"   :  cfg.findUrl,
                    "data"  : function( data, settings ) {

                        for (var i in dataFilter) {

                            data[i] = dataFilter[i];

                        }

                    },

                },
                "processing": true,
                "serverSide": true
            });
            dataTable = $('#teams-show-table').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
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
                        "data"  :   7,
                        "orderable" : true
                    },
                    {
                        "targets"   : 2,
                        "data"  :   8,
                        "orderable" : true
                    },
                    {
                        "targets"   : 3,
                        "data"  :   10,
                        "orderable" : true
                    },
                    {
                        "targets"   : 4,
                        "orderable" : false,
                        "render"    : function (data, type, row) {
                            var icons = [];
                            //icons.push('<img class="action-icon edit" src="/img/icons/editicon.png">');
                            if ( cfg.canView ) {

                                icons.push('<i class="fa fa-list view" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="List of teammates"></i>');

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

                    },

                },
                "processing": true,
                "serverSide": true
            });

            var id="", name, a = [];
            dataTable.on( 'draw.dt', function (e, settings, data) {

                dataTable.find("i[class*=view]").click(function(){

                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionView( id );

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