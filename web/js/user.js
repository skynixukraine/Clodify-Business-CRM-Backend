/**
 * Created by Oleksii on 09.06.2015.
 */
var userModule = (function() {

    var cfg = {
            editUrl: '',
            deleteUrl: '',
            activateUrl: '',
            findUrl: '',
            loginAsUserUrl: '',
            canDelete: null,
            canLoginAs: null,
            canEdit: null,
            changeAuthUrl: ''
        },
        dataTable,
        filterUsersSelect = "select[name=roles]",
        filterActiveOnlySelect = "input[name=is_active]",
        dataFilter = {
            'is_active': true
        },
        deleteModal,
        activateModal;

    function actionEdit(id) {
        document.location.href = cfg.editUrl + "?id=" + id;
    }

    function actionLogin(id) {
        document.location.href = cfg.loginAsUserUrl + "?id=" + id;
    }

    function actionDelete(id, name, dataTable) {

        function deleteRequest() {
            var params = {
                url: cfg.deleteUrl,
                data: {id: id},
                dataType: 'json',
                type: 'DELETE',
                success: function (response) {

                    if (response.message) {

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

            $.ajax(params);

        }

        deleteModal = new ModalBootstrap({
            title: 'Delete ' + name + "?",
            body: 'The user will be unavailable anymore, but all his data reports and project will be left in the system.' +
            ' Are you sure you wish to delete it?',
            winAttrs: {class: 'modal delete'}
        });

        deleteModal.show();
        deleteModal.getWin().find("button[class*=confirm]").click(function () {
            deleteRequest();
        });

    }

    function actionChangeAuth(id, name, dataTable) {

        function changeRequest() {
            var params = {
                url: cfg.changeAuthUrl,
                data: {id: id},
                dataType: 'json',
                type: 'Post',
                success: function (response) {

                    if (response.message) {

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

            $.ajax(params);

        }

        deleteModal = new ModalBootstrap({
            title: 'Change authorization type ' + name + "?",
            body: 'The user will be unavailable anymore, but all his data reports and project will be left in the system.',
            winAttrs: {class: 'modal delete'}
        });

        deleteModal.show();
        deleteModal.getWin().find("button[class*=confirm]").click(function () {
            changeRequest();
        });

    }


    // function actionSuspend(id, action, dataTable) {
    //     function suspendRequest() {
    //         var params = {
    //             url: cfg.activateUrl,
    //             data: {id: id, action: action},
    //             dataType: 'json',
    //             type: 'POST',
    //             success: function (response) {
    //                 dataTable.api().ajax.reload();
    //             }
    //         };
    //         $.ajax(params);
    //     }
    //
    //     if (action == 'active') {
    //         var title = 'Account Suspending.',
    //             body = 'Are you sure you wish suspend the account?';
    //     } else {
    //         var title = 'Account activation.',
    //             body = 'Are you sure you wish activate an account?';
    //     }
    //
    //     suspendModal = new ModalBootstrap({
    //         title: title,
    //         body: body,
    //         winAttrs: {class: 'modal delete'}
    //     });
    //
    //     suspendModal.show();
    //     suspendModal.getWin().find("button[class*=confirm]").click(function (e) {
    //         e.preventDefault();
    //         suspendRequest();
    //     });
    //
    // }
    return {

        init: function( config ){


            cfg = $.extend(cfg, config);

            var columnDefs = [];

            var target = 0;

            //  ID column (only for ADMIN )
            if (cfg.canSeeID == 'true') {
                columnDefs.push(
                {
                    "targets"   : target,
                    "orderable" : true
                });
                target++;
             }
            // Photo column
            columnDefs.push(
                {
                    "targets"   : target,
                    "orderable" : false,
                    "render"    :function(data, type, row) {
                        return '<div style="width:40px; height:40px; overflow:hidden; border-radius:20px;"><img src="' + data + '" class="img-circle" style="max-width: 40px; height: 40px; width:100%; border-radius:0;" alt = "User Image" /></div>';
                    }
                }
            );
            target++;

            // Name column
            columnDefs.push(
                {
                    "targets"   : target,
                    "orderable" : true
                }
            );
            target++;
            // Role is available for ADMIN, SALES and FIN
            if (cfg.canSeeRole == 'true') {
                columnDefs.push(
                    {
                        "targets": target,
                        "orderable": true
                    }
                );
                target++;
            }

            //Email column
            columnDefs.push(
                    {
                        "targets": target,
                        "orderable": true,
                        "render"    : function (data, type, row) {
                            return '<a href="mailto:' + data + '">' + data +'</a>';
                        }
                    }
            );
            target++;
            //Phone column
            columnDefs.push(
                {
                    "targets": target,
                    "orderable": true
                }
            );
            target++;
            //Last Login column
            columnDefs.push(
                {
                    "targets": target,
                    "orderable": true
                }
            );
            target++;
            //Joined column
            columnDefs.push(
                {
                    "targets": target,
                    "orderable": true
                }
            );
            target++;

            //Status column (active or suspended)
            if (cfg.showUserStatus) {
                columnDefs.push(
                    {
                        "targets"   : target,
                        "orderable" : true,
                        "render"    : function (data, type, row) {
                            if(!data) {
                                return '';
                            }
                            return '<a href="#" class="' + data.toLowerCase() + '">' + data +'</a>';
                        }
                    });
                target++;
            }

            if (cfg.showSales) {
                //Salary column
                columnDefs.push(
                    {
                        "targets"   : target,
                        "orderable" : true
                    });
                target++;
                //Salary Up column
                columnDefs.push(
                    {
                        "targets"   : target,
                        "orderable" : true
                    });
            }
            target++;
            if (cfg.canEdit || cfg.canLoginAs || cfg.canDelete || cfg.canChangeAuthType) {
                columnDefs.push({
                    "targets": target,
                    "orderable": false,
                    "render": function (data, type, row) {
                        var icons = [];

                        if (cfg.canEdit) {

                            icons.push('<i class="fa fa-edit edit" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Edit"></i>');
                        }
                        if (cfg.canLoginAs) {

                            icons.push('<i class="fa fa-sign-in" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Login as this user"></i>');
                        }
                        if (cfg.canDelete) {

                            icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Delete"></i>');
                        }
                        if (cfg.canChangeAuthType) {

                            icons.push('<i class="fa fa-arrow-up authchange" style="cursor: pointer" ' +
                                'data-toggle="tooltip" data-placement="top" title="Change authorization type"></i>');
                        }

                        return '<div class="actions">' + icons.join(" ") + '</div>';
                    }
                });
            }
            var rolesHtml = '<form id="w0" action="/user/index" method="post">' +
                '<div class="container-fluid">' +
                ' <div class="row">' +
                ' <div class="col-lg-2"> ' +
                '<label>Roles: </label>' +
                '<select class="form-control" name="roles"> ' +
                '<option value="">All Roles</option> <option value="ADMIN">ADMIN</option>' +
                ' <option value="DEV">DEV</option> <option value="FIN">FIN</option> ' +
                '<option value="CLIENT">CLIENT</option> <option value="PM">' +
                'PM</option> <option value="SALES">SALES</option> ' +
                '</select>' +
                '</div>';

            var activeOnlyHtml = '   <div class="col-lg-2"><label>Active Only: </label>	<div class="is_active"> <input type="checkbox" name="is_active" value="1" checked=""> </div> </div>';


            var resultHtml = '';

            if( cfg.canFilterByRole == 'true') {
                resultHtml += rolesHtml;
            }
            if( cfg.canFilterByStatus  =='true') {

                resultHtml += activeOnlyHtml;
            }
            if((cfg.canFilterByRole == 'true') || ( cfg.canFilterByStatus == 'true')) {
                resultHtml += '</form>';
            }
            
            dataTable = $('#user-table').dataTable({
                "dom": 'l<"toolbar">frtip',
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": true,
                "pageLength": 25,
                "bInfo": false,
                "bAutoWidth": false,
                "order": [[ 0, "desc" ]],
                "columnDefs": columnDefs,
                "ajax": {
                    "url"   :  cfg.findUrl,
                    "data"  : function( data, settings ) {

                        for (var i in dataFilter) {

                            data[i] = dataFilter[i];

                        }

                    }
                },
                "processing": true,
                "serverSide": true,
                "initComplete": function(){
                    $("div.toolbar").html(resultHtml);
                    filterUsersSelect = $( filterUsersSelect );
                    filterUsersSelect.change(function(){
                        var role = $(this).val();
                        dataFilter['role'] = role;
                        dataTable.api().ajax.reload();
                    });

                    filterActiveOnlySelect = $( filterActiveOnlySelect );
                    filterActiveOnlySelect.change(function(){
                        var is_active = $(this).is(':checked');
                        dataFilter['is_active'] = is_active;
                        dataTable.api().ajax.reload();
                    });

                }
            });



            var id="", name, a = [];

            dataTable.on( 'draw.dt', function (e, settings, data) {
                dataTable.find("td").click(function(){

                    dataTable.find("tr[class*=active]").removeClass( "active" );
                    $(this).parents("tr").addClass("active");
                    id = $(this).parents("tr").find("td").eq(0).text();
                    name   = $(this).parents("tr").find("td").eq(1).text();

                });
                $(document).keydown(function(e){
                    if (e.keyCode == 46) {

                        actionDelete( id, name, dataTable );
                    }
                });

                dataTable.find("i[class*=sign-in]").click(function(){

                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionLogin(id);

                });
                dataTable.find("i[class*=delete]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionDelete( id, name, dataTable );

                });

                dataTable.find("i[class*=edit]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text();
                    actionEdit( id );

                });

                dataTable.find("i[class*=authchange]").click(function(){

                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        name   = $(this).parents("tr").find("td").eq(1).text();
                    actionChangeAuth( id, name, dataTable );

                });
                dataTable.find('td:contains("Suspend")').parent('tr').addClass('suspend');
                dataTable.find('td:contains("Active")').parent('tr').removeClass('suspend');
                dataTable.find('a.active, a.suspended').on('click', (function(e){
                    e.preventDefault();
                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        action = $(this).attr('class');
                    //actionSuspend(id, action, dataTable);
                }));
            });
        }
    };

})();