define('togglebtn', function(require, exports, module) {
    var $=require("jquery");
    var fn={
        toggle:function(){
            $('.mwui-switch-btn').each(function(index,domEle) {
                $(domEle).bind("click", function() {
                    var btn = $(domEle).find("span");
                    var change = btn.attr("change");
                    btn.toggleClass('off');

                    if(btn.attr("class") == 'off') {
                        $(domEle).find("input").val("0");
                        btn.attr("change", btn.html());
                        btn.html(change);
                    } else {
                        $(domEle).find("input").val("1");
                        btn.attr("change", btn.html());
                        btn.html(change);
                    }

                    return false;
                });
            });

            //$("#submit").click(function() {
            //    var form = $(this).parent()[0];
            //    var inputs = form.getElementsByTagName('input');
            //    var params = [];
            //    $('#debuger').html('');
            //
            //    for (var i=0; i < inputs.length; i++) {
            //        params.push(inputs[i].name+"="+inputs[i].value);
            //    }
            //
            //    $.post("post.php", params.join("&")+"&temp="+Math.random(), function(data) {
            //        $('#debuger').html(data);
            //    });
            //
            //    return false;
            //});
        }
    };

    module.exports=fn;

    fn.toggle();

    $('#datetimepicker').datetimepicker({lang:'ch'});
});