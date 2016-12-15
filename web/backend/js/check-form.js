/**
 * Created by Khomenko on 16.03.2016.
 */
(function($){
    var forms = $(document).find("form");
    var inputHidden = '<input type="hidden" name="updated" value="1" />';
    forms.each(function(e){

        $(forms[e]).find("input, select, textarea").not('[type="hidden"]').not('[type="submit"]').each(function(){
            var elem = $(this);
            elem.change(function(){
                var form = $(this).parents("form");
                if(form.find("input[name='updated']").length == 0){
                    form.append(inputHidden);
                } else{
                    return false;
                }
            });
        })
    })
})(jQuery);