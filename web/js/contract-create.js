/**
 * Created by dmytro on 22.12.16.
 */
var contractCreateModule = (function() {
    var cfg = {
            findUrl     : '',
            editUrl     : '',
            deleteUrl   : '',
            viewUrl     : '',
            invoiceUrl  : '',
            canDelete   : '',
            canEdit     : '',
            canInvoice  : '',
            canView     : ''
        },
        dataFilter = {

        },
        customerIDs = {

        },
        filterCustomersSelect = "select[name=customers]",
        filterDateStartSelect = "#contract-start_date",
        filterDateEndSelect = "#contract-end_date";
    filterDateActSelect = "#contract-act_date";
    function actionEdit( id )
    {
        document.location.href = cfg.editUrl + "?id=" + id;
    }
    function actionInvoice( contractId )
    {

        document.location.href = cfg.invoiceUrl + "/" + contractId;

    }
    function actionView( id )
    {
        document.location.href = cfg.viewUrl + "?id=" + id;
    }
    return {
        init:function (config) {
            cfg = $.extend(cfg, config);
            filterCustomersSelect = $( filterCustomersSelect );
            filterCustomersSelect.change(function(){
                var id = $(this).val();
                dataFilter['customer_id'] = id;
                dataTable.api().ajax.reload();
            });
            dataTable = $('#contract_table').dataTable({
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
                        "orderable" : false
                    },
                    {
                        "targets"   : 9,
                        "orderable" : false
                    },
                    {
                        "targets"   : 10,
                        "orderable" : false,
                        "render"    : function (data, type, row) {

                            var icons   = [];
                            if (cfg.canView) {

                                icons.push('<i class="fa fa-list-alt view" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="View"></i>');

                            }
                            if (cfg.canEdit) {

                                icons.push('<i class="fa fa-edit edit" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Edit"></i>');

                            }

                            if (cfg.canInvoice) {

                                icons.push('<i class="fa fa-money paid" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" data-id="'+row[12]+'" title="Invoice"></i>');

                            }

                            if (row[11]) {

                                icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Delete the contract"></i>');

                            }
                            customerIDs[row[0]] = row[10];

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

                        }
                    };

                    $.ajax( params );
                    dataTable.api().ajax.reload();

                }

                deleteModal = new ModalBootstrap({
                    title       : 'Delete ' + name + "?",
                    body        : 'All data related to this contract will be deleted.',
                    winAttrs    : { class : 'modal delete'}
                });
                deleteModal.show();
                deleteModal.getWin().find("button[class*=confirm]").click(function () {
                    deleteRequest();
                });

            }

            dataTable.on( 'draw.dt', function (e, settings, data) {

                dataTable.find("i[class*=delete]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionDelete( id, name, dataTable );

                });

                dataTable.find("i[class*=view]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionView( id, name, dataTable );

                });

                dataTable.find("i[class*=edit]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionEdit( id, name, dataTable );

                });

                dataTable.find("i[class*=paid]").click(function(){

                    actionInvoice( $(this).data('id') );

                });

            });




            var date = new Date();
            var currentDay = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            var firstDayOfCurrMonth = new Date(date.getFullYear(), date.getMonth(), 1);

            filterDateStartSelect = $( filterDateStartSelect );
            filterDateStartSelect.datepicker({
                format : 'yyyy-mm-dd',
                autoclose: true,
                defaultViewDate: firstDayOfCurrMonth
            }).on("hide", function( event ){
                var startDate = filterDateStartSelect.val();
                dataFilter['start_date'] = startDate;
                console.log(filterDateStartSelect.val());
                if(startDate != '' && filterDateEndSelect.val() != ''){
                    dataTable.api().ajax.reload();
                }

            }).datepicker("setDate", firstDayOfCurrMonth);

            filterDateEndSelect = $( filterDateEndSelect );
            filterDateEndSelect.datepicker({
                format : 'yyyy-mm-dd',
                autoclose: true,
                defaultViewDate: currentDay,
                endDate : currentDay
            }).on("hide", function( event ){
                var endDate = filterDateEndSelect.val();
                dataFilter['end_date'] = endDate;
                if(endDate != '' && filterDateStartSelect.val() != ''){
                    dataTable.api().ajax.reload();
                }
            }).datepicker("setDate", currentDay);

            filterDateActSelect = $( filterDateActSelect );
            filterDateActSelect.datepicker({
                format : 'yyyy-mm-dd',
                autoclose: true,
                defaultViewDate: currentDay,
                endDate : currentDay
            }).on("hide", function( event ){
                var endDate = filterDateActSelect.val();
                dataFilter['end_date'] = endDate;
                if(endDate != '' && filterDateActSelect.val() != ''){
                    dataTable.api().ajax.reload();
                }
            }).datepicker("setDate", currentDay);



            dataFilter['start_date'] = filterDateStartSelect.val();
            dataFilter['end_date'] = filterDateEndSelect.val();

        }
    }




})();
