/**
 * Created by olha on 12.02.16.
 */
var adminReportModule = (function() {
    var cfg = {
            editUrl     : '',
            deleteUrl   : '',
            findUrl     : '',
            canDelete   : null
        },
        dataTable,
        filterProjectsSelect = "select[name=project]",
        filterDateStartSelect = "#project-date_start",
        filterDateEndSelect = "#project-date_end",
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
            title       : 'Delete ' + name + "?",
            body        : 'All data related to this report will be deleted.',
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
            filterProjectsSelect = $( filterProjectsSelect );
            filterProjectsSelect.change(function(){
                var id = $(this).val();
                dataFilter['project_id'] = id;
                dataTable.api().ajax.reload();
            });
            filterDateStartSelect = $( filterDateStartSelect );
            filterDateStartSelect.datepicker({
                format : 'dd/mm/yyyy',
                autoclose: true
            }).on("hide", function( event ){
                var startDate = filterDateStartSelect.val();
                dataFilter['date_start'] = startDate;
                dataTable.api().ajax.reload();
            });
            filterDateEndSelect = $( filterDateEndSelect );
            filterDateEndSelect.datepicker({
                format : 'dd/mm/yyyy',
                autoclose: true
            }).on("hide", function( event ){
                var endDate = filterDateEndSelect.val();
                dataFilter['date_end'] = endDate;
                dataTable.api().ajax.reload();
            });
            dataTable = $('#report-table').dataTable({
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
                        "orderable" : false,
                        "render"    : function (data, type, row) {
                            var icons = [];
                            //icons.push('<img class="action-icon edit" src="/img/icons/editicon.png">');
                            /*if ( cfg.canDelete ) {
                             icons.push('<img class="action-icon delete" src="/img/icons/deleteicon.png" style="cursor: pointer">');
                             }*/
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
                dataTable.find("img[class*=edit]").click(function(){
                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionEdit( id );
                });
                dataTable.find("img[class*=delete]").click(function(){
                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionDelete( id, name, dataTable );
                });
            });
        }
    };
})();