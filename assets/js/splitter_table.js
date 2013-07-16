function splitTable(table, maxHeight) {
    var header = table.children("thead");
    if (!header.length)
        return false;

    var headerHeight = header.innerHeight();
    var header = header.detach();

    var splitIndices = [0];
    var rows = table.children("tbody").children();

    //maxHeight -= headerHeight;
    var currHeight = headerHeight;
    var varHeight = headerHeight;
    rows.each(function(i, row) {
        if((i+1) == 42){ 
        	//varHeight = $('tr').eq(i).innerHeight() + ' | ' + $('tr').eq(i).text();
        }
        varHeight = varHeight + ' | ' + $('tr').eq(i).innerHeight();
        //currHeight += $(rows[i]).innerHeight();
        currHeight += $('tr').eq(i).innerHeight();
        if (currHeight >= maxHeight) {
            splitIndices.push(i);
            //currHeight = $(rows[i]).innerHeight();
            currHeight = headerHeight;
        }
    });
    splitIndices.push(undefined);

    table = table.replaceWith('<div id="_split_table_wrapper"></div>');
    table.empty();

    for(var i=0; i < splitIndices.length-1; i++) {
        var newTable = table.clone();
        header.clone().appendTo(newTable);
        $('<tbody />').appendTo(newTable);
        rows.slice(splitIndices[i], splitIndices[i+1]).appendTo(newTable.children('tbody'));
        newTable.appendTo("#_split_table_wrapper");
        if (splitIndices[i+1] !== undefined) {
            //$('<div style="page-break-after: always; margin:0; padding:0; border: none;">&nbsp;</div>').appendTo("#_split_table_wrapper");
            $('<div style="page-break-before: always;">'+currHeight+'X</div>').appendTo("#_split_table_wrapper");
        }
    }
}

$(document).ready(function () {
	splitTable($(".report"), 1124);
});