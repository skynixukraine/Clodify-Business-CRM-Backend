/**
 * Created by dmytro on 22.12.16.
 */
var contractCreateModule = (function() {
    var cfg = {
            findUrl     : '',
        },
        dataFilter = {

        },
        filterDateStartSelect = "#contract-start_date",
        filterDateEndSelect = "#contract-end_date";
    filterDateActSelect = "#contract-act_date";
    return {
        init:function (config) {
            cfg = $.extend(cfg, config);
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
                        "orderable" : false
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
                        "orderable" : false,
                        "render"    : function (data, type, row) {

                            var icons   = [],
                                status  =  row[9];

                            if( status == "NEW") {

                                if (cfg.canPaid) {

                                    icons.push('<i class="fa fa-money paid" style="cursor: pointer" ' +
                                        'data-toggle="tooltip" data-placement="top" title="Mark Invoice as Paid"></i>');

                                }

                            }
                            if( status == "NEW" ) {

                                if (cfg.canCanceled) {

                                    icons.push('<i class="fa fa-arrows-alt canceled" style="cursor: pointer" ' +
                                        'data-toggle="tooltip" data-placement="top" title="Cancel the invoice"></i>');

                                }

                            }

                            if( status == "NEW" || status == "PAID" || status == "CANCELED" ) {
                                if (cfg.canView) {

                                    icons.push('<i class="fa fa-list-alt view" style="cursor: pointer" ' +
                                        'data-toggle="tooltip" data-placement="top" title="View"></i>');

                                }
                            }
                            if( status == "NEW" || status == "CANCELED" ){

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
