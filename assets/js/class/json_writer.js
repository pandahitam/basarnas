Ext.namespace('Ext.ux');

/**
 * Extension of the JsonWriter that doesn't send fields having the config option
 * write set to false
 * @author Friedrich Röhrs
 * @verison 1.0
 *
 */
Ext.ux.AdvJsonWriter = function (config) {
    Ext.ux.AdvJsonWriter.superclass.constructor.call(this, config);
};
Ext.extend(Ext.ux.AdvJsonWriter, Ext.data.JsonWriter, /** @lends Ext.ux.AdvJsonWriter */{
    toHash: function(rec, options) {
        var map = rec.fields.map,
            data = {},
            raw = (this.writeAllFields === false && rec.phantom === false) ? rec.getChanges() : rec.data,
            m;
        Ext.iterate(raw, function(prop, value){
            if((m = map[prop])){
                if (m.write !== false)
                    data[m.mapping ? m.mapping : m.name] = value;
            }
        });
        // we don't want to write Ext auto-generated id to hash.  Careful not to remove it on Models not having auto-increment pk though.
        // We can tell its not auto-increment if the user defined a DataReader field for it *and* that field's value is non-empty.
        // we could also do a RegExp here for the Ext.data.Record AUTO_ID prefix.
        if (rec.phantom) {
            if (rec.fields.containsKey(this.meta.idProperty) && Ext.isEmpty(rec.data[this.meta.idProperty])) {
                delete data[this.meta.idProperty];
            }
        } else {
            data[this.meta.idProperty] = rec.id;
        }
        return data;
    }
});
