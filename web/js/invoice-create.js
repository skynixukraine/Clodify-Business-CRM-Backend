/**
 * Created by olha on 17.02.16.
 */

var invoiceCreateModule = (function() {
    var cfg = {
            findUrl     : ''
        },
        dataTable,
        filterProjectsSelect = "#invoice-user_id",
        filterDateStartSelect = "#date_start",
        filterDateEndSelect = "#date_end",
        dataFilter = {
        },
        deleteModal;
    document.getElementById("date_start").required = true;
    document.getElementById("date_end").required = true;

    return {
        init: function( config ){

            cfg = $.extend(cfg, config);

            filterProjectsSelect = $( filterProjectsSelect );
            filterProjectsSelect.change(function(){
                var id = $(this).val();
                dataFilter['user_id'] = id;
                dataTable.api().ajax.reload();
                console.log(id);
            });



            var date = new Date();
            var currentDay = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            var firstDayOfCurrMonth = new Date(date.getFullYear(), date.getMonth(), 1);

            filterDateStartSelect = $( filterDateStartSelect );
            filterDateStartSelect.datepicker({
                format : 'dd/mm/yyyy',
                autoclose: true,
                defaultViewDate: firstDayOfCurrMonth
            }).on("hide", function( event ){
                var startDate = filterDateStartSelect.val();
                dataFilter['date_start'] = startDate;
                dataTable.api().ajax.reload();
            }).datepicker("setDate", firstDayOfCurrMonth);

            //dataFilter['date_start'] = $("#date_start").val();

            filterDateEndSelect = $( filterDateEndSelect );
            filterDateEndSelect.datepicker({
                format : 'dd/mm/yyyy',
                autoclose: true,
                defaultViewDate: currentDay,
                endDate : currentDay
            }).on("hide", function( event ){
                var endDate = filterDateEndSelect.val();
                dataFilter['date_end'] = endDate;
                dataTable.api().ajax.reload();
            }).datepicker("setDate", currentDay);

            //dataFilter['date_end'] = $("#date_end").val();


            dataTable = $('#invoice-create-table').dataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": false,
                "pageLength": 1000,
                "bInfo": false,
                "bAutoWidth": false,
                "order": [[ 0, "desc" ]],
                deferLoading: 0,
                "columnDefs": [
                    {
                        "targets"   : 0,
                        "data"      : 0,
                        "orderable" : true
                    },
                    {
                        "targets"   : 1,
                        "data"      : 4,
                        "orderable" : true
                    },
                    {
                        "targets"   : 2,
                        "data"      : 3,
                        "orderable" : true
                    },
                    {
                        "targets"   : 3,
                        "data"      : 5,
                        "orderable" : true
                    },
                    {
                        "targets"   : 4,
                        "data"      : 1,
                        "orderable" : true
                    },
                    {
                        "targets"   : 5,
                        "data"      : 7,
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
        }
    };
})();
