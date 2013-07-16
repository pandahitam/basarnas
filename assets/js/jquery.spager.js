/*

Author: Julijan Andjelic
Plugin name: spager
Description: simple jQuery plugin which allows you to paginate your table
             can be very useful when you want to split up large tables into
             smaller chunks
             
             
             usage:
             $("#someTable").jpager({
                    
                    items:    10,
                    ctrls:    "mycontrols",
                    animate:  false,
                    opts:     [5,10,20,30,50]
                    
                    })
                    
          In this example we are paginating the table with id someTable into pages, each containing 10 items
          items - how many items to show on each page, default is the first opts item [optional]
          ctrls - here we are specifying our container for controls (page numbers and items per page selector)
          animate - little animation triggered upon page switch, by default it's true but you can set it to false [optional]
          opts - user can pick from these options, default is 10, 15, 25 and 50 [optional]

*/

(function($) {

jQuery.fn.spager=function(settings) {

var controlsElement=settings.ctrls;
var itemsPerPage=settings.items;
var opts=settings.opts;
var animation=settings.animate;
var tg=$(this);
var rows=$(tg).children().find("tr");
var rowCount=rows.size();
var tableHeight;

if (opts==null) {
opts=[10,15,25,50];
}

if (itemsPerPage==null) {
itemsPerPage=opts[0];
}

jQuery.page=function(pg) {
          stP=itemsPerPage*(pg-1);
          enP=parseInt(stP)+parseInt(itemsPerPage)-1;
          
          
$("#"+controlsElement+" #currentlyShowing").text("Currently showing: "+parseInt(stP+1)+" - "+parseInt(enP+1));
$(rows).show();
$(rows).filter(":lt("+stP+")").hide();
$(rows).filter(":gt("+enP+")").hide();

          if (animation!=false) {
                    $(tg).animate({
                    height: 2,
                    duration: 500
                    })
          }
          
}

jQuery.generatePages=function(max) {
var page=0;
if (max!=null) {
          parseInt(itemsPerPage=max);
}
           $("#"+controlsElement+" #pages").empty();
           i=0;
           while (i<rowCount) {
           i+=itemsPerPage;
           page++;
           $("#"+controlsElement+" #pages").append(" <a onclick='$.page($(this).text()); $(this).parent().children().removeClass(); $(this).addClass(\"action\")' style='color: gray; font-size: 16px;'>"+page+"</a> ");
           }

lastPageProducts=rowCount-($("#"+controlsElement+" #pages a:last").text()*itemsPerPage);
if (lastPageProducts>0) {
page++;
$("#"+controlsElement+" #pages").append(" <a onclick='$.page($(this).text()); $(this).parent().children().removeClass(); $(this).addClass(\"action\")' style='color: gray; font-size: 16px;'>"+page+"</a> ");
}
         
$("#"+controlsElement+"#pages a:eq(0)").addClass("action");
$.page(1);
}

$("#"+controlsElement).empty().append("<div id='currentlyShowing'></div><div id='pages'></div><div id='ssp'>Show <select id='pager' onchange='$.generatePages(parseInt($(this).val()));'></select></div>").css("text-align","center");

          for(i=0; i<opts.length; i++) {
          
                    $("#pager").append("\n<option value='"+opts[i]+"'>"+opts[i]+"</option>");
          
          }


          var ind=0;
          $("#pager option").each(function() {
          if ($(this).text()==itemsPerPage) {
                    $(this).attr("selected","true");
                    return;
                    }
          ind++;
          })

$.generatePages();

return this;

}

})(jQuery);