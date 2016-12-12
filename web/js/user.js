/**
 * Created by Oleksii on 09.06.2015.
 */
var userModule = (function() {

    var cfg = {
            editUrl     : '',
            deleteUrl   : '',
            activateUrl : '',
            findUrl     : '',
            loginAsUserUrl  : '',
            canDelete   : null,
            canLoginAs  : null,
            canEdit     : null
        },
        dataTable,
        filterUsersSelect       = "select[name=roles]",
        filterActiveOnlySelect  = "input[name=is_active]",
        dataFilter = {
            'is_active': true
        },
        deleteModal,
        activateModal;

    function actionEdit( id )
    {
        document.location.href = cfg.editUrl + "?id=" + id;
    }

    function actionLogin( id )
    {
        document.location.href = cfg.loginAsUserUrl + "?id=" + id;
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
            body        : 'The user will be unavailable anymore, but all his data reports and project will be left in the system.' +
                          ' Are you sure you wish to delete it?',
            winAttrs    : { class : 'modal delete'}
        });

        deleteModal.show();
        deleteModal.getWin().find("button[class*=confirm]").click(function () {
            deleteRequest();
        });

    }
    
    function actionSuspend(id, action, dataTable) 
    {
        function suspendRequest()
        {
            var params = {
                url: cfg.activateUrl,
                data: {id: id, action: action},
                dataType: 'json',
                type: 'POST',
                success: function (response) {
                    dataTable.api().ajax.reload();
                }
            };
            $.ajax(params);
        }

        if (action == 'active') {
            var title = 'Account Suspending.',
                    body = 'Are you sure you wish suspend the account?';
        } else {
            var title = 'Account activation.',
                    body = 'Are you sure you wish activate an account?';
        }

        deleteModal = new ModalBootstrap({
            title: title,
            body: body,
            winAttrs: {class: 'modal delete'}
        });

        deleteModal.show();
        deleteModal.getWin().find("button[class*=confirm]").click(function (e) {
            e.preventDefault();
            suspendRequest();
        });

    }
    return {

        init: function( config ){


            cfg = $.extend(cfg, config);
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
            dataTable = $('#user-table').dataTable({
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
                        "orderable" : true,
                        "render"    : function (data, type, row) {
                            return '<a href="/profile/' + data.toLowerCase().replace(' ', '-')+'/'+row[11] + '">' + data +'</a>';
                        }
                    },
                    {
                        "targets"   : 2,
                        "orderable" : true

                    },
                    {
                        "targets"   : 3,
                        "orderable" : true,
                        "render"    : function (data, type, row) {
                            return '<a href="mailto:' + data + '">' + data +'</a>';
                        }
                    },
                    {
                        "targets"   : 4,
                        "orderable" : true,
                        "render"    : function (data, type, row) {
                            if(!data) {
                                data = '';
                            }
                            return '<a href="tel:' + data + '">' + data +'</a>';
                        }
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
                        "orderable" : true,
                        "render"    : function (data, type, row) {
                            return '<a href="#" class="' + data.toLowerCase() + '">' + data +'</a>';
                        }
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
                            var icons = [];
                            
                            if ( cfg.canEdit ) {

                                icons.push('<i class="fa fa-edit edit" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Edit"></i>');
                            }
                            if ( cfg.canLoginAs ) {

                                icons.push('<i class="fa fa-sign-in" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Login as this user"></i>');
                            }
                            if ( cfg.canDelete ) {

                                icons.push('<i class="fa fa-times delete" style="cursor: pointer" ' +
                                    'data-toggle="tooltip" data-placement="top" title="Delete"></i>');
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
                
                
                dataTable.find('a.active, a.suspended').on('click', (function(e){
                    e.preventDefault();
                    var id     = $(this).parents("tr").find("td").eq(0).text(),
                        action = $(this).attr('class');
                    actionSuspend(id, action, dataTable);
                }));
            });
        }
    };

})();