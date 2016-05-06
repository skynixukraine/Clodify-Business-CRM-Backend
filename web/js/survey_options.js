/**
 * Created by lera on 05.05.16.
 */
var surveysModule = (function() {

    var cfg = {
            findUrl     : ''
        },
        dataTable,
        dataFilter = {
        },
        deleteModal;


    function actionEdit( id )
    {
        document.location.href = cfg.editUrl + "?id=" + id;
    }


    return {

        init: function( config ){

            cfg = $.extend(cfg, config);
            var columns = [

                {
                    "targets"   : 0,
                    "data"  :   0,
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
                }
            ];



            dataTable = $('#surveys_table').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bSort": true,
                "pageLength": 25,
                "bInfo": false,
                "bAutoWidth": false,
                "order": [[ 0, "desc" ]],
                "columnDefs": columns,
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

                dataTable.find("i[class*=edit]").click(function(){

                    var id = $(this).parents("tr").find("td").eq(0).text();
                    actionEdit( id );

                });


            });

        }
    };

})();