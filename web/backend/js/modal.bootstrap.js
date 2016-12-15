/**
 * Created by Oleksii on 10.06.2015.
 */
function ModalBootstrap ( config ) {

    var cfg = {
            title       : 'Confirm',
            body        : '',
            buttons     : [
                {class : 'btn-default cancel', text : 'Cancel'},
                {class : 'btn-primary confirm', text : 'Confirm'}
            ],
            btnAttrs:  { 'data-dismiss' : "modal" },
            winAttrs : {
                class               : 'modal',
                tabindex            : '-1',
                role                : 'dialog',
                'aria-labelledby'   : '',
                'aria-hidden'       : 'true'
            }
        },
        win = $('<div></div>'),
        structure,
        header,
        body,
        footer,
        btn;
        cfg = $.extend(cfg, config);

    win.attr(cfg.winAttrs);
    structure = '<div class="modal-dialog">' +
                    '<div class="modal-content">' +
        ( cfg.title ?
                        '<div class="modal-header">' +
                            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
                            '<h4 class="modal-title">' + cfg.title + '</h4>' +
                        '</div>'
              :  "" )  +
                        '<div class="modal-body">' + cfg.body + '</div>' +
                        '<div class="modal-footer"></div>' +
                    '</div>' +
                '</div>';

    win.html( structure );
    header  = win.find(".modal-title");
    body    = win.find(".modal-body");
    footer  = win.find(".modal-footer");
    for ( var i =0; i < cfg.buttons.length; i++ ) {

        btn = $('<button type="button" class="btn ' + cfg.buttons[i].class + '" >' + cfg.buttons[i].text + '</button>');

        for ( var j in cfg.btnAttrs) {

            btn.attr( j, cfg.btnAttrs[j] );

        }
        footer.append( btn );

    }

    this.show = function () {

        win.modal("show");

    }
    this.getWin = function() {

        return win;

    }

}