var myReportPageModule = (function() {

    return {
        init: function() {

            var fieldTask = $('.field-task');
            var submitDiv = $('.submit-div');
            var submitButton = $('.submit-div button[type=submit]'),
                editButton = $('.edit');
            // submitButton.css("visibility", "hidden");
            // submitDiv.hide();
            // fieldTask.removeClass("col-lg-6").addClass("col-lg-7");

            $('form').submit(function(event) {
                event.preventDefault();
            });

            var projectId = $("#report-project_id"),
                reportDate = $('#date_report'),
                reportText = $('#report-task'),
                reportHours = $('#report-hours'),
                tableLoad = $('.load'),
                formInput = [projectId, reportDate, reportText, reportHours];
            var dataArr = {
                'projectId': '',
                'reportDate': '',
                'reportText': '',
                'reportHours': '',
            };



            function changeTableRow() {
                var tableLoad = $('.load');
                var clonedSelect = projectId.clone();
                var tableLoadRow = tableLoad.find('tr:not(.changed-row)');
                tableLoadRow.each(function() {
                    var thisRow = $(this);
                    thisRow.addClass("changed-row");
                    var thisRowTd = thisRow.find('td');
                    var tableArr = [];
                    thisRowTd.each(function(i) {
                        var thisTd = $(this);
                        var thisValue = thisTd.text();
                        switch (i) {
                            case 1:
                                thisTd.empty();
                                thisTd.append(clonedSelect);
                                thisTd.find("option:contains('" + thisValue + "')").prop('selected', true)
                                    // thisTd.find("option[value = '" + thisValue + "']").prop('selected', true)
                                break;
                            case 2:
                                thisTd.empty();
                                thisTd.append('<input class="form-control" type = "text" value = "' + thisValue + '">')
                                break
                            case 3:
                                thisTd.empty();
                                thisTd.append('<input class="form-control" type = "text" value = "' + thisValue + '">')
                                break
                            case 4:
                                thisTd.empty();
                                thisTd.append('<div class="input-group date" ><input class="form-control" type = "text" value = "' + thisValue + '"><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>')
                                var input = thisTd;

                                var date = new Date();
                                date = new Date(thisValue);
                                var currentDay = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                                $(input).datepicker({
                                    format: 'dd/mm/yyyy',
                                    autoclose: true,
                                    defaultViewDate: currentDay,

                                }).datepicker("setDate", currentDay);
                                break
                        }


                    })

                })
            }


            function addReport() {
                $.each(formInput, function(num) {
                    thisInput = $(this);
                    thisInput.change(function() {
                        var count = 0;
                        var thisChange = $(this);
                        var thisChangeVal = thisChange.val();
                        var thisSelect = $('#report-project_id option:selected');
                        switch (num) {
                            case 0:
                                if (thisSelect != "") {
                                    dataArr.projectId = thisSelect.text();
                                }
                                break;
                            case 1:
                                if (thisChangeVal != "") {
                                    dataArr.reportDate = thisChangeVal;
                                }
                                break;

                            case 2:
                                if (thisChangeVal.length >= 20) {
                                    dataArr.reportText = thisChangeVal;
                                }
                                break;
                            case 3:
                                if (thisChangeVal != "" && thisChangeVal < 10 && thisChangeVal != 0) {
                                    dataArr.reportHours = thisChangeVal;
                                }
                                break;
                        }

                        $.each(dataArr, function(i) {
                            if (dataArr[i].length > 0) {
                                count++;
                            }
                            if (count == 4) {
                                jsonData = JSON.stringify(dataArr);
                                $.ajax({
                                    type: "POST",
                                    url: "index",
                                    data: jsonData,
                                    dataType: 'json',
                                    success: function(data) {

                                    },
                                    error: function(data) {
                                        console.log(data);
                                        console.log('error');

                                        tableLoad.append("<tbody><tr><td></td><td>" + dataArr.projectId + "</td><td>" + dataArr.reportText + "</td><td>" + dataArr.reportHours + "</td><td>" + dataArr.reportDate + "</td><td><i class='fa fa-times delete' style='cursor: pointer' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'></i></td></tr></tbody>");
                                        $('form').trigger("reset");
                                        $.each(dataArr, function(i) {
                                            delete dataArr[i];
                                        })
                                        changeTableRow();
                                        editReport();
                                    }
                                })

                            }
                        })



                    })
                })
            }

            function saveDataInObject(el) {
                var selectVal = el.parent().parent().find('td:nth-child(2)').find('select option:selected').text();
                dataArr.projectId = selectVal;
                dataArr.reportDate = el.parent().parent().find('td:nth-child(5) div>input').val();
                dataArr.reportText = el.parent().parent().find('td:nth-child(3) input').val();
                dataArr.reportHours = el.parent().parent().find('td:nth-child(4) input').val();
                return dataArr;
            }

            function editReport() {
                var tableLoadRow = tableLoad.find('tr');
                tableLoadRow.each(function() {
                    var thisChange = $(this).find('td input,td select');
                    thisChange.change(function() {
                        var thisInput = $(this);
                        saveDataInObject(thisInput);
                        jsonData = JSON.stringify(dataArr);
                        $.ajax({
                            type: "POST",
                            url: "index",
                            data: jsonData,
                            dataType: 'json',
                            success: function(data) {
                                console.log('success');
                                console.log(data);
                            },
                            error: function(data) {
                                console.log('error');
                                console.log('Data were send:');
                                $.each(dataArr, function(i) {
                                    console.log(dataArr[i]);
                                    delete dataArr[i];
                                });
                            }
                        })
                    })
                })
            }

            function removeReport() {
                var deleteButton = $('.load>.delete');
                daleteButton.each(function() {
                    var thisButton = $(this);
                    thisButton.click(function() {
                        var clickedButton = $(this);
                        saveDataInObject(clickedButton);
                         jsonData = JSON.stringify(dataArr);
                         $.ajax({
                            type: "POST",
                            url: "index",
                            data: jsonData,
                            dataType: 'json',
                            success: function(data) {
                                console.log('success');
                                console.log(data);
                            },
                            error: function(data) {
                                console.log('error');
                                console.log('Data were send:');
                                thisButton.parent().parent().parent('tr').remove();
                                $.each(dataArr, function(i) {
                                    console.log(dataArr[i]);
                                    delete dataArr[i];
                                });
                            }
                        })
                    })
                })
            }


            addReport();
            changeTableRow();
            editReport();

        }
    }

})();
