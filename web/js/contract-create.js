/**
 * Created by dmytro on 22.12.16.
 */
var contractCreateModule = (function() {
    var cfg = {

        },
        dataFilter = {

        },
        filterDateStartSelect = "#contract-start_date",
        filterDateEndSelect = "#contract-end_date";
    filterDateActSelect = "#contract-act_date";
    return {
        init:function (config) {
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
