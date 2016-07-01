/**
 * Created by olha on 12.02.16.
 */
var adminReportModule = (function() {
    var cfg = {
            editUrl     : '',
            deleteUrl   : '',
            findUrl     : '',
            canDelete   : null,
            canSeeHours : null,
            canSeeInvoice : null
        },
        dataTable,
        filterProjectsSelect = "select[name=project]",
        filterDateStartSelect = "#project-date_start",
        filterDateEndSelect = "#project-date_end",
        filterUsersSelect = "select[name=users]",
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
            filterUsersSelect = $( filterUsersSelect );
            filterUsersSelect.change(function(){
                var id = $(this).val();
                dataFilter['user_develop'] = id;
                dataTable.api().ajax.reload();
            });

            var date = new Date();
            var currentDay = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            filterDateStartSelect = $( filterDateStartSelect );
            filterDateStartSelect.datepicker({
                format : 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true
            }).on("hide", function( event ){
                var startDate = filterDateStartSelect.val();
                dataFilter['date_start'] = startDate;
                dataTable.api().ajax.reload();
            }).datepicker("setDate", currentDay);

            dataFilter['date_start'] = $("#project-date_start").val();

            filterDateEndSelect = $( filterDateEndSelect );
            filterDateEndSelect.datepicker({
                format : 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true
            }).on("hide", function( event ){
                var endDate = filterDateEndSelect.val();
                dataFilter['date_end'] = endDate;
                dataTable.api().ajax.reload();
            });

            cfg = $.extend(cfg, config);
            var columns = [
                {
                    "targets"   : 0,
                    "orderable" : true
                },
                {
                    "targets"   : 1,
                    "orderable" : true,
                    "render" : function (data, type, row) {
                        return row[1].replace(/(<([^>]+)>)/ig,"");
                    }
                }
            ], index=1;
            if( cfg.canSeeHours){
                index++;
                console.log(index);
                columns.push(
                {
                    "targets"   : 2,
                    "orderable" : true,
                    "render"    : function (data, type, row) {
                        return row[7];
                    }
                });
            }
            index++;
            columns.push(
                {
                    "targets"   : index,
                    "orderable" : false,
                    "render"    : function (data, type, row) {
                        return row[3];
                    }
                },
                {
                    "targets"   : ++index,
                    "orderable" : true,
                    "render"    : function (data, type, row) {
                        return row[2];
                    }
                },
                {
                    "targets"   : ++index,
                    "orderable" : true,
                    "render"    : function (data, type, row) {
                        return row[4];
                    }
                },
                {
                    "targets"   : ++index,
                    "orderable" : true,
                    "render"    : function (data, type, row) {
                        return row[5];
                    }
                }

            );
            if( cfg.canSeeInvoice){
                console.log(index);
                columns.push(
                    {
                        "targets": ++index,
                        "orderable": true,
                        "render": function (data, type, row) {
                            return row[6];
                        }
                    });
            }
            dataTable = $('#report-table').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": true,
                "pageLength": 25,
                "bInfo": false,
                "bAutoWidth": false,
                "order": [[ 0, "desc" ]],
                "columnDefs": columns ,
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
                var totalHours = '#total-hours';
                $.ajax({
                    type: "GET",
                    url: '',
                    dataType: 'json',
                    success: function (responce) {
                        alert(response.totalHours);
                    }
                });
                totalHours = settings.json.totalHours || '0';
                $('#total-hours span').text(Math.round(totalHours*100)/100);


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