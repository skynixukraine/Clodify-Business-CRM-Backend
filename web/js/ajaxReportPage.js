var ajaxReportPageModule = (function() {

    return {
        init: function() {

            //for submit button
            // var fieldTask = $('.field-task');
            // var submitDiv = $('.submit-div');
            // var submitButton = $('.submit-div button[type=submit]'),
            //     editButton = $('.edit');
            // submitButton.css("visibility", "hidden");
            // submitDiv.hide();
            // fieldTask.removeClass("col-lg-6").addClass("col-lg-7");

            $('form').submit(function(event) {
                event.preventDefault();
            });

            var projectId = $(".form-add-report #report-project_id"),
                report,
                reportDate = $('#date_report'),
                reportText = $('#report-task'),
                reportHours = $('#report-hours'),
                tableLoad = $('.load'),
                formInput = [projectId, reportDate, reportText, reportHours];
            var dataArr = {
                'project_id': '',
                'date_report': '',
                'task': '',
                'hours': '',
            };
            var lastForm = $('form:last');


            ////////////////////////////////////////////////////////////////////////////
            ///Function changes load-table elements and do their input or select elements
            function changeTableRow() {
                var tableLoad = $('.load'),
                    tableLoadRow = tableLoad.find('tr:not(.changed-row)');
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
                                var clonedSelect = projectId.clone();
                                clonedSelect.addClass('report-project-id');
                                thisTd.append(clonedSelect);

                                if (thisTd.hasClass('created-project-id')) {
                                    thisTd.find("option[value = '" + thisValue + "']").prop('selected', true)
                                } else {
                                    thisTd.find("option:contains('" + thisValue + "')").prop('selected', true)
                                }
                                break;
                            case 3:
                                thisTd.empty();
                                thisTd.append('<input class="form-control report-text" type = "text" value = "' + thisValue + '">')
                                break
                            case 4:
                                thisTd.empty();
                                var time = +thisValue;
                                thisTd.append('<input class="form-control report-hour" type = "text" value = "' + time.toFixed(2) + '">')
                                break
                            case 2:
                                thisTd.empty();
                                thisTd.append('<div class="input-group date"><input class="form-control created-date" data-date-format="dd/mm/yyyy" data-provide="datepicker" type = "text" ><span class="input-group-addon"><i class="fa fa-calendar"></i></span></div>');
                                var input = thisTd.find('div');
                                if (!input.find(input).hasClass('created-date')) {
                                    thisValue = thisValue.split('-');
                                    thisValue = thisValue.reverse();
                                    thisValue = thisValue.join('/');
                                }
                                $(input).datepicker({
                                    format: 'dd/mm/yyyy'
                                }).datepicker("setDate", thisValue);
                                break
                        }
                    })
                })
            }

            ////////////////////////////////////////////////////////////////////////////
            ///Function for adding report in load-table and sending data trough ajax/////////

            function addReport() {
                $.each(formInput, function(num) {
                    thisInput = $(this);
                    //remove error message
                    thisInput.click(function() {
                        var ajaxError = $('.ajax-error');
                        ajaxError.remove();
                    })
                    thisInput.change(function() {
                        var count = 0,
                            thisChange = $(this);
                        saveDataInObject();
                        $.each(dataArr, function(i) {
                            if (i == "project_id") {
                                if (dataArr.project_id.length == 0) {
                                    count++;
                                }
                            }
                            if (dataArr[i].length > 0) {
                                count++;
                            }
                            if (count == 4) {
                                report = JSON.stringify(dataArr);
                                $.ajax({
                                    type: "POST",
                                    url: "index",
                                    data: 'jsonData=' + report,
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data.success) {
                                            var ajaxError = $('.ajax-error');
                                            ajaxError.remove();
                                            id = data.id;
                                            tableLoad.append("<tbody><tr><td class = 'report-id'>" + id + "</td><td class='created-project-id'>" + dataArr.project_id + "</td><td>" + dataArr.date_report + "</td><td>" + dataArr.task + "</td><td>" + dataArr.hours + "</td><td><i class='fa fa-times delete' style='cursor: pointer' data-toggle='tooltip' data-placement='top' title='' data-original-title='Delete'></i></td></tr></tbody>");
                                            var form = $('.form-add-report');
                                            form.find('#report-task, #report-hours, .form-add-report #report-project_id').val('');
                                            $.each(dataArr, function(i) {
                                                delete dataArr[i];
                                            })
                                            changeTableRow();
                                            editReport();
                                            removeReport();
                                            countHours();
                                        } else {
                                            $.each(dataArr, function(i) {
                                                delete dataArr[i];
                                            });
                                            var ajaxError = $('.ajax-error');
                                            ajaxError.remove();
                                            lastForm.append('<p class = "ajax-error">' + data.errors.message + '</p>')

                                        }

                                    },
                                    error: function(data) {
                                        var ajaxError = $('.ajax-error');
                                        ajaxError.remove();
                                        lastForm.append('<p class = "ajax-error">' + data.errors.message + '</p>');
                                    }
                                })
                            }
                        })
                    })
                })
            }


            //////////////////////////////////////////////////////////////////////////////
            ///Function saves data from "load-table", when it changing and from /////////
            ///"add-report" table, when report adding //////////////////////////////////
            function saveDataInObject(el) {
                if (el != undefined) {
                    var thisSelect = el.closest('tr').find('select option:selected').val(),
                        id = el.closest('tr').find('.report-id').text(),
                        dateReport = el.closest('tr').find('.created-date').val(),
                        reportTask = el.closest('tr').find('.report-text').val(),
                        reportHours = el.closest('tr').find('.report-hour').val();
                    dataArr.id = id;

                } else {
                    var thisSelect = $('.form-add-report #report-project_id :selected').val(),
                        dateReport = $('#date_report').val(),
                        reportTask = $('#report-task').val(),
                        reportHours = $('#report-hours').val();
                }

                ///checking entered data, and saving their////////////////////////////////
                if (thisSelect != "") {
                    dataArr.project_id = thisSelect;
                } else {
                    dataArr.project_id = "";
                }

                if (dateReport != "") {
                    dataArr.date_report = dateReport;

                } else {
                    dataArr.date_report = "";
                }

                if (reportTask.length >= 20) {
                    dataArr.task = reportTask;
                } else {
                    dataArr.task = "";
                }
                if (reportHours != "" && reportHours < 10 && reportHours != 0) {
                    dataArr.hours = reportHours;
                } else {
                    dataArr.hours = "";
                }
                return dataArr;
            }



            function deleteHelpBlock(thisHelp, all) {
                if (all == "all") {
                    var helpSpan = thisHelp.closest('td').find('.help-block');
                    var hasErrorTd = thisHelp.closest('td');
                    helpSpan.remove();
                    hasErrorTd.removeClass('has-error');
                }
                var helpSpan = thisHelp.next('.help-block');
                var hasErrorTd = thisHelp.closest('td');
                helpSpan.remove();
                hasErrorTd.removeClass('has-error');

            }

            ///////////////////////////////////////////////////////////////////////////////////////
            ///Function for editing information in load-table, saves its and sends data trough ajax 
            function editReport() {
                var tableLoadRow = tableLoad.find('tr');
                tableLoadRow.each(function() {
                    var thisChange = $(this).find('td input,td select');
                    thisChange.change(function() {
                        var thisInput = $(this);
                        if (thisInput.hasClass('report-text') && thisInput.val().length < 20 && thisInput.val().length > 0) {
                            if (thisInput.closest('td').hasClass("has-error")) {
                                deleteHelpBlock(thisInput);
                            }
                            thisInput.closest('td').addClass("has-error");
                            thisInput.after('<span class = "help-block" id= "helpblockEr">Task should contain at least 20 characters.</span>');
                        } else if (thisInput.hasClass('report-text') && thisInput.val().length == 0) {
                            if (thisInput.closest('td').hasClass("has-error")) {
                                deleteHelpBlock(thisInput);
                            }
                            thisInput.closest('td').addClass("has-error");
                            thisInput.after('<span class = "help-block" id= "helpblockEr">Task cannot be blank.</span>');
                        } else if (thisInput.hasClass('report-hour') && thisInput.val() > 10) {

                            if (thisInput.closest('td').hasClass("has-error")) {
                                deleteHelpBlock(thisInput);
                            }
                            thisInput.closest('td').addClass("has-error");
                            thisInput.after('<span class = "help-block" id= "helpblockEr">Hours must be no greater than 10.</span>');
                        } else if (thisInput.hasClass('report-hour') && thisInput.val() <= 0) {
                            if (thisInput.closest('td').hasClass("has-error")) {
                                deleteHelpBlock(thisInput);
                            }
                            thisInput.closest('td').addClass("has-error");
                            thisInput.after('<span class = "help-block" id= "helpblockEr">Hours must be no less than 0.1.</span>');
                        } else if (thisInput.hasClass('report-hour') && thisInput.val().length == 0) {
                            if (thisInput.closest('td').hasClass("has-error")) {
                                deleteHelpBlock(thisInput);
                            }
                            thisInput.closest('td').addClass("has-error");
                            thisInput.after('<span class = "help-block" id= "helpblockEr">Task cannot be blank.</span>');
                        } else if (thisInput.hasClass('report-project-id') && thisInput.val() == "") {
                            if (thisInput.closest('td').hasClass("has-error")) {
                                deleteHelpBlock(thisInput);
                            }
                            thisInput.closest('td').addClass("has-error");
                            thisInput.after('<span class = "help-block" id= "helpblockEr">Project ID cannot be blank.</span>');
                        } else {

                            deleteHelpBlock(thisInput, "all");
                            var count = 0;
                            saveDataInObject(thisInput);
                            $.each(dataArr, function(i) {

                                if (dataArr[i] != "") {
                                    count++;
                                }

                            })
                            if (count == 5) {
                                report = JSON.stringify(dataArr);
                                $.ajax({
                                    type: "POST",
                                    url: "index",
                                    data: 'jsonData=' + report,
                                    dataType: 'json',
                                    success: function(data) {
                                        if (data.success) {
                                            var ajaxError = $('.ajax-error');
                                            ajaxError.remove();
                                            $.each(dataArr, function(i) {
                                                delete dataArr[i];
                                            });
                                            countHours();
                                        } else {
                                            var ajaxError = $('.ajax-error');
                                            ajaxError.remove();
                                            lastForm.append('<p class = "ajax-error">' + data.errors.message + '</p>')
                                        }

                                    },
                                    error: function(data) {
                                        var ajaxError = $('.ajax-error');
                                        ajaxError.remove();
                                        lastForm.append('<p class = "ajax-error">' + data.errors.message + '</p>')
                                    }
                                })
                            }
                        }
                    })
                })
            }


            //////////////////////////////////////////////////////////////////////////////////////
            ///Function for removing reports from load-table, saves its and sends data trough ajax 
            function removeReport() {
                var deleteButton = $('.load .delete');
                deleteButton.each(function() {
                    var thisButton = $(this);
                    thisButton.unbind();
                    thisButton.click(function() {
                        var clickedButton = $(this);
                        saveDataInObject(clickedButton);
                        report = JSON.stringify(dataArr);
                        $.ajax({
                            type: "POST",
                            url: "delete",
                            data: 'jsonData=' + report,
                            dataType: 'json',
                            success: function(data) {
                                if (data.success) {
                                    var ajaxError = $('.ajax-error');
                                    ajaxError.remove();
                                    $.each(dataArr, function(i) {
                                        delete dataArr[i];
                                    });
                                    clickedButton.parent().parent('tr').parent('tbody').remove();
                                    countHours();
                                } else {
                                    var ajaxError = $('.ajax-error');
                                    ajaxError.remove();
                                    lastForm.append('<p class = "ajax-error">' + data.errors.message + '</p>');
                                }

                            },
                            error: function(data) {
                                var ajaxError = $('.ajax-error');
                                ajaxError.remove();
                                lastForm.append('<p class = "ajax-error">' + data.errors.message + '</p>');
                            }
                        })
                    })
                })
            }

            //function gets value of sort-select (view report of this day, this week, this month, last month)
            // and counts hour depending on the chosen option///////////////////////////////////////////////

            function countHours() {
                var totalHours = 0;
                var dateInp = $('.load .date input');

                var day = new Date();
                var date = (day.getDate()).toString();
                var month = (day.getMonth() + 1).toString();
                var today = (day.getDay()).toString();

                var dateFilterVal = $("#dateFilter").val();
                //for today reports
                if (dateFilterVal == 1) {
                    dateInp.each(function() {
                        var thisDate = $(this);
                        var thisDateVal = thisDate.val();
                        var splitDate = thisDateVal.split('/');
                        var hour = thisDate.closest('tr').find('.report-hour').val();
                        if (date == parseInt(splitDate[0], 10) && month == parseInt(splitDate[1], 10)) {
                            totalHours += +hour;
                            totalHours = totalHours.toFixed(2);
                            totalHours = countMinutes(totalHours);
                        }

                    })

                }
                //for this month reports
                else if (dateFilterVal == 3) {
                    dateInp.each(function() {
                        var thisDate = $(this);
                        var thisDateVal = thisDate.val();
                        var splitDate = thisDateVal.split('/');
                        if (month == parseInt(splitDate[1], 10)) {
                            var hour = thisDate.closest('tr').find('.report-hour').val();
                            totalHours += +hour;
                            totalHours = totalHours.toFixed(2);
                            totalHours = countMinutes(totalHours);
                        }

                    })
                }
                //for last month reports
                else if (dateFilterVal == 4) {
                    dateInp.each(function() {
                        var thisDate = $(this);
                        var thisDateVal = thisDate.val();
                        var splitDate = thisDateVal.split('/');
                        if (month - 1 == parseInt(splitDate[1], 10)) {
                            var hour = thisDate.closest('tr').find('.report-hour').val();
                            totalHours += +hour;
                            totalHours = totalHours.toFixed(2);
                            totalHours = countMinutes(totalHours);
                        }

                    })
                }
                //for this week reports
                else if (dateFilterVal == 2) {
                    var monday = getMonday(new Date());
                    var mondayDate = (monday.getDate()).toString();
                    var mondayMonth = (monday.getMonth() + 1).toString();
                    var tuesday, wednesday, thursday, friday, saturday, sunday;
                    var week = [tuesday, wednesday, thursday, friday, saturday, sunday];
                    var thisDayArr = []; //array for saving days of week(date/month)
                    var countI = 1;
                    //for every day of week, except monday, pushing date/month in array
                    $.each(week, function() {
                        var thisDay = $(this);
                        thisDay = new Date(monday);
                        thisDay.setDate(monday.getDate() + countI);
                        var thisDayDate = thisDay.getDate().toString();
                        var thisDayMonth = (thisDay.getMonth() + 1).toString();
                        var dayMonth = [];
                        dayMonth.push(thisDayDate, thisDayMonth);
                        var d = dayMonth.join('/');
                        thisDayArr.push(d);
                        countI++;

                    })
                    dateInp.each(function() {
                        var thisDate = $(this);
                        var thisDateVal = thisDate.val();
                        var splitDate = thisDateVal.split('/');
                        var hour = thisDate.closest('tr').find('.report-hour').val();

                        $.each(thisDayArr, function(i) {
                            var thisDate = thisDayArr[i].split('/');
                            if (thisDate[0] == parseInt(splitDate[0], 10) && thisDate[1] == parseInt(splitDate[1], 10)) {
                                totalHours += +hour;
                                totalHours = totalHours.toFixed(2);
                                totalHours = countMinutes(totalHours);
                            }
                        })
                        if (mondayDate == parseInt(splitDate[0], 10) && mondayMonth == parseInt(splitDate[1], 10)) {
                            totalHours += +hour;
                            totalHours = totalHours.toFixed(2);
                            totalHours = countMinutes(totalHours);
                        }

                    })
                }
                var showTotalHours = $('#totalHours');
                showTotalHours.text("Total: " + totalHours + " hours");
            }

            //function gets date for monday of the week
            function getMonday(date) {
                var day = date.getDay() || 7;
                if (day !== 1)
                    date.setHours(-24 * (day - 1));
                return date;
            }

            function countMinutes(val) {
                var hours = String(val);
                var splitHour = hours.split('.');
                var hour = +splitHour[0];
                var minutes = +splitHour[1];
                var time;
                if (minutes > 59) {
                    hour += 1;
                    splitHour[0] = hour;
                    minutes = minutes % 60;
                    if (minutes < 10) {
                        minutes = "0" + minutes;
                    }
                    splitHour[1] = minutes;
                    time = splitHour.join('.');
                }
                time = splitHour.join('.');
                return +time;
            }



            removeReport();
            addReport();
            changeTableRow();
            editReport();
            countHours();

        }
    }

})();
