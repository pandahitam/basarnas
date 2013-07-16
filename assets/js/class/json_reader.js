Ext.override(Ext.data.JsonReader, {
    readRecords : function(o){
        /**
         * After any data loads, the raw JSON data is available for further custom processing.  If no data is
         * loaded or there is a load exception this property will be undefined.
         * @type Object
         */
        this.jsonData = o;
        if(o.metaData){
            this.onMetaChange(o.metaData);
        }
        var s = this.meta, Record = this.recordType,
            f = Record.prototype.fields, fi = f.items, fl = f.length, v;

        var root = this.getRoot(o) || [], c = root.length, totalRecords = c, success = true;
        if(s.totalProperty){
            v = parseInt(this.getTotal(o), 10);
            if(!isNaN(v)){
                totalRecords = v;
            }
        }
        if(s.successProperty){
            v = this.getSuccess(o);
            if(v === false || v === 'false'){
                success = false;
            }
        }

        // TODO return Ext.data.Response instance instead.  @see #readResponse
        return {
            success : success,
            records : this.extractData(root, true), // <-- true to return [Ext.data.Record]
            totalRecords : totalRecords
        };
    }
});
