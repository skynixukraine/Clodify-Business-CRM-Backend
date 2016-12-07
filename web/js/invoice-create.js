/**
 * Created by olha on 17.02.16.
 */

var invoiceCreateModule = (function() {
    var cfg = {
            findUrl     : '',
            findProjects : ''
        },
        dataTable,
        filterProjectsSelect = "#invoice-user_id",
        filterOneProjectSelect = "#invoice-project_id",
        filterDateStartSelect = "#date_start",
        filterDateEndSelect = "#date_end",
        dataFilter = {
        },
        deleteModal;

    document.getElementById("date_start").required = true;
    document.getElementById("date_end").required = true;
    document.getElementById("invoice-user_id").required = true;
    document.getElementById("invoice-project_id").required = true;
    $(filterProjectsSelect).click(function () {
       if ($(filterProjectsSelect).val() != '') {
           document.getElementById("invoice-project_id").required = false;
       }
    });

    $(filterOneProjectSelect).click(function () {
        if ($(filterOneProjectSelect).val() != '') {
            document.getElementById("invoice-user_id").required = false;
        }
    });

    function changeDropdown(item, index) {
        if (index == 0) {
            $(filterOneProjectSelect).empty();
        }
        $(filterOneProjectSelect).append($('<option value=' + item.id + '>' + item.name + '</option>'));
    }
    return {
        init: function( config ){

            cfg = $.extend(cfg, config);

            filterProjectsSelect = $( filterProjectsSelect );
            filterProjectsSelect.change(function(){
                var id = $(this).val();
                dataFilter['user_id'] = id;
                if(filterDateEndSelect.val() != '' && filterDateStartSelect.val() != '') {
                    $.ajax({
                        url: cfg.findProjects + '?customer=' + id,
                        success: function(data){
                            data.forEach(changeDropdown);
                        }
                    });

                    dataTable.api().ajax.reload();
                }
            });

            filterOneProjectSelect = $( filterOneProjectSelect );
            filterOneProjectSelect.change(function(){
                var id = $(this).val();
                dataFilter['project_id'] = id;
                if(filterDateEndSelect.val() != '' && filterDateStartSelect.val() != '') {
                    dataTable.api().ajax.reload();
                }
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
                console.log(filterDateStartSelect.val());
                if(startDate != '' && filterDateEndSelect.val() != ''){
                    dataTable.api().ajax.reload();
                }

            }).datepicker("setDate", firstDayOfCurrMonth);

            filterDateEndSelect = $( filterDateEndSelect );
            filterDateEndSelect.datepicker({
                format : 'dd/mm/yyyy',
                autoclose: true,
                defaultViewDate: currentDay,
                endDate : currentDay
            }).on("hide", function( event ){
                var endDate = filterDateEndSelect.val();
                dataFilter['date_end'] = endDate;
                if(endDate != '' && filterDateStartSelect.val() != ''){
                    dataTable.api().ajax.reload();
                }
            }).datepicker("setDate", currentDay);

            dataFilter['date_start'] = filterDateStartSelect.val();
            dataFilter['date_end'] = filterDateEndSelect.val();


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
            dataTable.on( 'draw.dt', function (e, settings, data) {

                var sum = 0;
                var MyRows = $('#invoice-create-table').find('tr');
                for (var i = 1; i < MyRows.length; i++){

                    var hours = $(MyRows[i]).find('td:eq(5)').html();
                    if(hours != '') {

                        sum += parseFloat(hours);

                    }

                }
                if( isNaN(sum) || sum == null ) {
                    $(document).find('#invoice-total_hours').val('');

                } else {
                    $(document).find('#invoice-total_hours').val(sum.toFixed(2));

                }
            });
        }
    };
})();
