/**
 * Created by lera on 25.03.16.
 */

var TeamModule = (function() {

    var cfg = {
            findUrl     : '',
            viewUrl     : '',
            findTeamUrl     : '',
            canView     :null
        },
        dataTable,
        dataShowTable,
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
                        "orderable" : false,
                        "render"     :function (data, type, row){
                            $(document).find('#teams-table').eq(0).find('tr').find('input').eq(0).attr("checked",false);

                            var icons = [];

                            icons.push( '<input type = "checkbox" class = "editor-active" >');

                            return '<div class="actions">' + icons.join(" ") + '</div>';
                        }
                    },
                    {
                        "targets"   : 1,
                        "data"  :   6,
                        "orderable" : true
                    },
                    {
                        "targets"   : 2,
                        "data"  :   5,
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

            dataShowTable = $('#teams-show-table').dataTable({
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
                        "data"      : 6,
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
                            if ( cfg.canView ) {

                                icons.push('<i class="fa fa-list view" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="List of teammates"></i>');
                            }
                            return '<div class="actions">' + icons.join(" ") + '</div>';
                        }
                    }
                ],
                "ajax": {
                    "url"   :  cfg.findTeamUrl,
                    "data"  : function( data, settings ) {

                        for (var i in dataFilter) {

                            data[i] = dataFilter[i];

                        }
                    }
                },
                "processing": true,
                "serverSide": true
            });

            var team_id=$(document).find('#teams-table').eq(0).find('tr').find('input').eq(0).text(), name, a = [];


            dataTable.on( 'draw.dt', function (e, settings, data) {

                $('td input[type="checkbox"]').eq(0).attr("checked",true);
                dataTable.find('td input[type="checkbox"]').click(function() {
                    dataTable.find('tr input[checked="checked"]').attr("checked",false);
                    $(this).attr("checked",true);
                });

                dataTable.find("input[class*=editor-active]").click(function(){
                    var team_id = $(this).parents("tr").find("td").eq(1).text();
                    console.log(team_id);

                    dataShowTable.api().ajax.reload();
                });

            });
            dataShowTable.on( 'draw.dt', function (e, settings, data) {});
            console.log(team_id);
        }
    };

})();