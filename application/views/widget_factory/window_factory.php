<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    ///////////

        Ext.namespace('Modal', 'Region', 'Tab');

        var Measurement = {
            windowHeight: 550,
            windowWidth: 950,
        };

        Modal.processCreate = Ext.create('Ext.window.Window', {
            iconCls: 'icon-course',
            modal: true,
            closable: true,
            autoDestroy: true,
            closeAction: 'hide',
            layout: 'fit',
            width: Measurement.windowWidth, height: Measurement.windowHeight, bodyStyle: 'padding: 5px;',
            buttons: [{
                    text: "close",
                    id: 'close-modalprocess',
                    handler: function() {
                        Modal.processCreate.close();
                    }
                }],
            listeners: {
                'beforeclose': function() {
                    Modal.processCreate.removeAll(true);
                }
            }
        });

        Modal.processEdit = Ext.create('Ext.window.Window', {
            iconCls: 'icon-course',
            modal: true,
            closable: true,
            autoDestroy: true,
            closeAction: 'hide',
            layout: 'fit',
            width: Measurement.windowWidth, height: Measurement.windowHeight, bodyStyle: 'padding: 5px;',
            buttons: [{
                    text: "close",
                    handler: function() {
                        Modal.processEdit.close();
                    }
                }],
            listeners: {
                'beforeclose': function() {
                    Modal.processEdit.removeAll(true);
                }
            }
        });

        Modal.closeProcessWindow = function() {
            if (Modal.processEdit.isVisible(true))
            {
                Modal.processEdit.close();
            }
            else if (Modal.processCreate.isVisible(true))
            {
                Modal.processCreate.close();
            }
        };

        Modal.assetCreate = Ext.create('Ext.window.Window', {
            iconCls: 'icon-course',
            modal: true,
            closable: true,
            autoDestroy: true,
            closeAction: 'hide',
            layout: 'fit',
            width: Measurement.windowWidth, height: Measurement.windowHeight, bodyStyle: 'padding: 5px;',
            listeners: {
                'beforeclose': function() {
                    Modal.assetCreate.removeAll(true);
                }
            }
        }),
        Modal.assetEdit = Ext.create('Ext.window.Window', {
            iconCls: 'icon-course',
            modal: true,
            closable: true,
            autoDestroy: true,
            closeAction: 'hide',
            layout: {
                type: 'hbox',
                pack: 'start',
                align: 'stretch'
            },
            width: Measurement.windowWidth, height: Measurement.windowHeight, bodyStyle: 'padding: 5px;',
            listeners: {
                'beforeclose': function() {
                    Modal.assetEdit.removeAll(true);

                }
            }
        });
        
        //used when adding/editing data with a grid inside a form
        Modal.assetSecondaryWindow = Ext.create('Ext.window.Window', {
            iconCls: 'icon-course',
            modal: true,
            closable: true,
            autoDestroy: true,
            closeAction: 'hide',
            layout: {
                type: 'hbox',
                pack: 'start',
                align: 'stretch'
            },
            width: Measurement.windowWidth, height: Measurement.windowHeight, bodyStyle: 'padding: 5px;',
            listeners: {
                'beforeclose': function() {
                    Modal.assetSecondaryWindow.removeAll(true);

                }
            }
        });

        Modal.closeAssetWindow = function() {
            if (Modal.assetEdit.isVisible(true))
            {
                Modal.assetEdit.close();
            }
            else if (Modal.assetCreate.isVisible(true))
            {
                Modal.assetCreate.close();
            }
        };

        Modal.assetSelection = Ext.create('Ext.window.Window', {
            iconCls: 'icon-course',
            modal: true,
            closable: true,
            autoRender: true,
            autoDestroy: true,
            closeAction: 'hide',
            layout: 'fit',
            width: 900, height: 400, bodyStyle: 'padding: 5px;',
            buttons: [{
                    text: "close",
                    handler: function() {
                        Modal.assetSelection.close();
                    }
                }],
            listeners: {
                'beforeclose': function() {
                    Modal.assetSelection.removeAll();
                }
            }

        });

        Modal.deleteAlert = function(arrayDeleted, url, dataGrid) {
            /*debugger;*/
            Ext.Msg.show({
                title: 'Konfirmasi',
                msg: 'Apakah Anda yakin untuk menghapus ?',
                buttons: Ext.Msg.YESNO,
                icon: Ext.Msg.Question,
                fn: function(btn) {
                    if (btn === 'yes')
                    {
                        /*debugger;*/
                        var dataSend = {
                            data: arrayDeleted
                        };

                        $.ajax({
                            type: 'POST',
                            data: dataSend,
                            dataType: 'json',
                            url: url,
                            success: function(data) {
                                /*var a = dataGrid;
                                 debugger;*/
                                console.log('success to delete');
                                dataGrid.load();
                            }
                        });
                    }
                }
            })
        };
        
        Region.filterPanelAsetPerlengkapan = function(data,id) {
            var panel = {
                region: 'west',
                title: 'Filter',
                width: 200,
                split: true,
                collapsible: true,
                floatable: false,
                frame: true,
                items: [{
                        xtype: 'label',
                        text: 'Filter By Kode Barang',
                        height: 30,
                        style: 'font-weight:bold; display:block',
                        
                    },{
                        xtype: 'label',
                        text: 'Part',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Part',
                        name: 'aset-part' +id,
                        id: 'aset-part'+id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.partNumber,
                        valueField: 'kd_brg',
                        displayField: 'nama', emptyText: 'Part',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Part',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter([{property: 'kd_brg', value: value}]);
                                        
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: '   ',
                        height: 20,
                        style: 'display:block',
                        
                    },
                    {
                        xtype: 'label',
                        text: 'Filter By Klasifikasi Aset',
                        height: 30,
                        style: 'font-weight:bold; display:block',
                        
                    },
                    {
                        xtype: 'label',
                        text: 'Level 1',
                        height: 30,
                        
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Level1',
                        name: 'aset-klasifikasiAset-lvl1'+id,
                        id: 'aset-klasifikasiAset-lvl1'+id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.klasifikasiAset_lvl1,
                        valueField: 'kd_lvl1',
                        displayField: 'nama', emptyText: 'Klasifikasi Aset',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter([{property: 'kd_klasifikasi_aset', value: value}]);
                                        var filterByLevel1 = value;
                                        var filterByLevel2 = Ext.getCmp('aset-klasifikasiAset-lvl2'+id);
                                                if (filterByLevel1 !== null && filterByLevel2 !== null) {
                                                    if (!isNaN(value) && value.length > 0) {
                                                        filterByLevel2.enable();
                                                        Reference.Data.klasifikasiAset_lvl2.changeParams({params: {id_open: 1, kd_lvl1: value}});
                                                    }
                                                    else {
                                                        filterByLevel2.disable();
                                                    }
                                                }
                                                else {
                                                    console.error('error');
                                                }
                                        
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: 'Level 2',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Level 2',
                        name: 'aset-klasifikasiAset-lvl2'+id,
                        id: 'aset-klasifikasiAset-lvl2'+id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        disabled:true,
                        store: Reference.Data.klasifikasiAset_lvl2,
                        valueField: 'kd_lvl2',
                        displayField: 'nama', emptyText: 'Klasifikasi Aset',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByLevel1Value = Ext.getCmp('aset-klasifikasiAset-lvl1'+id).value;
                                        data.filter({property: 'kd_klasifikasi_aset', value: filterByLevel1Value+value});
                                        
                                            var filterByLevel3 = Ext.getCmp('aset-klasifikasiAset-lvl3'+id);
                                            var filterByLevel2 = value;
                                            if (filterByLevel3 !== null && filterByLevel2 !== null) {
                                                if (!isNaN(value) && value.length > 0) {
                                                    filterByLevel3.enable();
                                                    Reference.Data.klasifikasiAset_lvl3.changeParams({params: {id_open: 1, kd_lvl1: filterByLevel1Value, kd_lvl2: value}});
                                                }
                                                else {
                                                    filterByLevel3.disable();
                                                }
                                            }
                                            else {
                                                console.error('error');
                                            }
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: 'Level 3',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Level 3',
                        name: 'aset-klasifikasiAset-lvl3'+id,
                        id: 'aset-klasifikasiAset-lvl3'+id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.klasifikasiAset_lvl3,
                        disabled:true,
                        valueField: 'kd_lvl3',
                        displayField: 'nama', emptyText: 'Klasifikasi Aset',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByLevel1Value = Ext.getCmp('aset-klasifikasiAset-lvl1'+id).value;
                                        var filterByLevel2Value = Ext.getCmp('aset-klasifikasiAset-lvl2'+id).value;
                                        data.filter({property: 'kd_klasifikasi_aset', value: filterByLevel1Value+filterByLevel2Value+value});
                                    }
                                }
                            }
                        }
                    },
                    ]
            };

            return panel;
        };
        
        Region.filterPanelAset = function(data,id) {
            var panel = {
                region: 'west',
                title: 'Filter',
                width: 200,
                split: true,
                collapsible: true,
                floatable: false,
                frame: true,
                items: [{
                        xtype: 'label',
                        text: 'Filter By Kode Barang',
                        height: 30,
                        style: 'font-weight:bold; display:block',
                        
                    },{
                        xtype: 'label',
                        text: 'Golongan',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Golongan',
                        name: 'aset-golongan' + id,
                        id: 'aset-golongan' + id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.golongan,
                        valueField: 'kd_gol',
                        displayField: 'ur_gol', emptyText: 'Golongan',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Golongan',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter([{property: 'kd_brg', value: value}]);
                                        var filterByGolongan = value;
                                        var filterByBidang = Ext.getCmp('aset-bidang'+ id);
                                                if (filterByGolongan !== null && filterByBidang !== null) {
                                                    if (!isNaN(value) && value.length > 0) {
                                                        filterByBidang.enable();
                                                        Reference.Data.bidang.changeParams({params: {id_open: 1, kd_gol: value}});
                                                    }
                                                    else {
                                                        filterByBidang.disable();
                                                    }
                                                }
                                                else {
                                                    console.error('error');
                                                }
                                        
                                    }
                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Bidang',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Bidang',
                        name: 'aset-bidang'+ id,
                        id: 'aset-bidang'+ id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.bidang,
                        disabled:true,
                        valueField: 'kd_bid',
                        displayField: 'ur_bid', emptyText: 'Bidang',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Bidang',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByGolonganValue = Ext.getCmp('aset-golongan'+ id).value;
                                        data.filter({property: 'kd_brg', value: filterByGolonganValue+value});
                                        
                                            var filterByKelompok = Ext.getCmp('aset-kelompok'+ id);
                                            var filterByBidang = value;
                                            if (filterByKelompok !== null && filterByBidang !== null) {
                                                if (!isNaN(value) && value.length > 0) {
                                                    filterByKelompok.enable();
                                                    Reference.Data.kelompok.changeParams({params: {id_open: 1, kd_gol: filterByGolonganValue, kd_bid: value}});
                                                }
                                                else {
                                                    filterByKelompok.disable();
                                                }
                                            }
                                            else {
                                                console.error('error');
                                            }
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: 'Kelompok',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Kelompok',
                        name: 'aset-kelompok'+ id,
                        id: 'aset-kelompok'+ id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        disabled:true,
                        store: Reference.Data.kelompok,
                        valueField: 'kd_kel',
                        displayField: 'ur_kel', emptyText: 'Kelompok',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Kelompok',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByGolonganValue = Ext.getCmp('aset-golongan'+ id).value;
                                        var filterByBidangValue = Ext.getCmp('aset-bidang'+ id).value;
                                        data.filter({property: 'kd_brg', value: filterByGolonganValue+filterByBidangValue+value});
                                        
                                        var filterBySubKelompok = Ext.getCmp('aset-subkel'+ id);
                                        var filterByKelompok = value;
                                        if (filterByKelompok !== null && filterBySubKelompok !== null && !isNaN(value)) {
                                            filterBySubKelompok.enable();
                                            Reference.Data.subKelompok.changeParams({params: {id_open: 1,
                                                    kd_gol: filterByGolonganValue,
                                                    kd_bid: filterByBidangValue,
                                                    kd_kel: value}});
                                            }
                                    
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: 'Sub Kelompok',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Sub Kelompok',
                        name: 'aset-subkel'+ id,
                        id: 'aset-subkel'+ id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        disabled:true,
                        store: Reference.Data.subKelompok,
                        valueField: 'kd_skel',
                        displayField: 'ur_skel', emptyText: 'Sub Kelompok',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Sub Kelompok',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByGolonganValue = Ext.getCmp('aset-golongan'+ id).value;
                                        var filterByBidangValue = Ext.getCmp('aset-bidang'+ id).value;
                                        var filterByKelompokValue = Ext.getCmp('aset-kelompok'+ id).value;
                                        data.filter({property: 'kd_brg', value: filterByGolonganValue+filterByBidangValue+filterByKelompokValue+value});
                                        
                                        var filterBySubSubKelompok = Ext.getCmp('aset-subsubkel'+ id);
                                        var filterBySubKelompok = value;

                                        if (filterBySubKelompok !== null && filterBySubSubKelompok !== null && !isNaN(value)) {
                                            filterBySubSubKelompok.enable();
                                            Reference.Data.subSubKelompok.changeParams({params: {id_open: 1,
                                                    kd_gol: filterByGolonganValue,
                                                    kd_bid: filterByBidangValue,
                                                    kd_kel: filterByKelompokValue,
                                                    kd_skel: value}});
                                        }
                                    
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: 'Sub Sub Kelompok',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Sub Sub Kelompok',
                        name: 'aset-subsubkel'+ id,
                        id: 'aset-subsubkel'+ id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        disabled:true,
                        store: Reference.Data.subSubKelompok,
                        valueField: 'kd_sskel',
                        displayField: 'ur_sskel', emptyText: 'Sub Sub Kelompok',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Sub Sub Kelompok',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByGolonganValue = Ext.getCmp('aset-golongan'+ id).value;
                                        var filterByBidangValue = Ext.getCmp('aset-bidang'+ id).value;
                                        var filterByKelompokValue = Ext.getCmp('aset-kelompok'+ id).value;
                                        var filterBySubKelompokValue = Ext.getCmp('aset-subkel'+ id).value;
                                        data.filter({property: 'kd_brg', value: filterByGolonganValue+filterByBidangValue+filterByKelompokValue+filterBySubKelompokValue+value});
                                        
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: '   ',
                        height: 20,
                        style: 'display:block',
                        
                    },
                    {
                        xtype: 'label',
                        text: 'Filter By Klasifikasi Aset',
                        height: 30,
                        style: 'font-weight:bold; display:block',
                        
                    },
                    {
                        xtype: 'label',
                        text: 'Level 1',
                        height: 30,
                        
                    },
                    {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Level1',
                        name: 'aset-klasifikasiAset-lvl1'+ id,
                        id: 'aset-klasifikasiAset-lvl1'+ id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.klasifikasiAset_lvl1,
                        valueField: 'kd_lvl1',
                        displayField: 'nama', emptyText: 'Klasifikasi Aset',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter([{property: 'kd_klasifikasi_aset', value: value}]);
                                        var filterByLevel1 = value;
                                        var filterByLevel2 = Ext.getCmp('aset-klasifikasiAset-lvl2'+ id);
                                                if (filterByLevel1 !== null && filterByLevel2 !== null) {
                                                    if (!isNaN(value) && value.length > 0) {
                                                        filterByLevel2.enable();
                                                        Reference.Data.klasifikasiAset_lvl2.changeParams({params: {id_open: 1, kd_lvl1: value}});
                                                    }
                                                    else {
                                                        filterByLevel2.disable();
                                                    }
                                                }
                                                else {
                                                    console.error('error');
                                                }
                                        
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: 'Level 2',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Level 2',
                        name: 'aset-klasifikasiAset-lvl2'+ id,
                        id: 'aset-klasifikasiAset-lvl2'+ id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        disabled:true,
                        store: Reference.Data.klasifikasiAset_lvl2,
                        valueField: 'kd_lvl2',
                        displayField: 'nama', emptyText: 'Klasifikasi Aset',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByLevel1Value = Ext.getCmp('aset-klasifikasiAset-lvl1'+ id).value;
                                        data.filter({property: 'kd_klasifikasi_aset', value: filterByLevel1Value+value});
                                        
                                            var filterByLevel3 = Ext.getCmp('aset-klasifikasiAset-lvl3'+ id);
                                            var filterByLevel2 = value;
                                            if (filterByLevel3 !== null && filterByLevel2 !== null) {
                                                if (!isNaN(value) && value.length > 0) {
                                                    filterByLevel3.enable();
                                                    Reference.Data.klasifikasiAset_lvl3.changeParams({params: {id_open: 1, kd_lvl1: filterByLevel1Value, kd_lvl2: value}});
                                                }
                                                else {
                                                    filterByLevel3.disable();
                                                }
                                            }
                                            else {
                                                console.error('error');
                                            }
                                    }
                                }
                            }
                        }
                    },
                    {
                        xtype: 'label',
                        text: 'Level 3',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Level 3',
                        name: 'aset-klasifikasiAset-lvl3'+ id,
                        id: 'aset-klasifikasiAset-lvl3'+ id,
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.klasifikasiAset_lvl3,
                        disabled:true,
                        valueField: 'kd_lvl3',
                        displayField: 'nama', emptyText: 'Klasifikasi Aset',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Klasifikasi Aset',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        var filterByLevel1Value = Ext.getCmp('aset-klasifikasiAset-lvl1'+ id).value;
                                        var filterByLevel2Value = Ext.getCmp('aset-klasifikasiAset-lvl2'+ id).value;
                                        data.filter({property: 'kd_klasifikasi_aset', value: filterByLevel1Value+filterByLevel2Value+value});
                                    }
                                }
                            }
                        }
                    },
                    ]
            };

            return panel;
        };

        Region.filterPanelPemeliharaanBangunan = function(data) {
            var panel = {
                region: 'west',
                title: 'Filter',
                width: 200,
                split: true,
                collapsible: true,
                floatable: false,
                frame: true,
                items: [{
                        xtype: 'label',
                        text: 'Filter by Unit Kerja',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Unker',
                        name: 'pemeliharaan-unker',
                        id: 'pemeliharaan-unker',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.unker,
                        valueField: 'kdlok',
                        displayField: 'ur_upb', emptyText: 'Unit Kerja',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Kerja',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter([{property: 'kd_lokasi', value: value}]);
                                    }

                                    var filterJenis = Ext.getCmp('filter-jenis');
                                    if (filterJenis !== null)
                                    {
                                        var jenisValue = filterJenis.getValue();
                                        if (jenisValue !== null && jenisValue.length > 0)
                                        {
                                            data.filter({property: 'jenis', value: filterJenis.getValue()});
                                        }
                                    }
                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Filter by Jenis',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Jenis',
                        name: 'filter-jenis',
                        id: 'filter-jenis',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.jenisPemeliharaanBangunan,
                        valueField: 'id',
                        value: -1,
                        displayField: 'nama', emptyText: 'Jenis',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Jenis',
                        editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    var subjenis = Ext.getCmp('filter-subjenis');
                                    data.clearFilter();
                                    subjenis.clearValue();
                                    subjenis.applyEmptyText();
                                    if (value !== null || value != -1)
                                    {
                                        data.filter({property: 'jenis', value: value});
                                        if (value == 1)
                                        {
                                            subjenis.bindStore(Reference.Data.jenisSubPemeliharaanBangunanPemeliharaan);
                                        }
                                        else if (value == 2)
                                        {
                                            subjenis.bindStore(Reference.Data.jenisSubPemeliharaanBangunanPerawatan);
                                        }
                                        subjenis.enable();

                                    }

                                    var filterUnker = Ext.getCmp('pemeliharaan-unker');
                                    if (filterUnker !== null)
                                    {
                                        var unkerValue = filterUnker.getValue();
                                        if (unkerValue !== null && unkerValue.length > 0)
                                        {
                                            data.filter({property: 'kd_lokasi', value: filterUnker.getValue()});
                                        }
                                    }
                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Filter by Sub Jenis',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Sub Jenis',
                        name: 'filter-subjenis',
                        id: 'filter-subjenis',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        valueField: 'id',
                        displayField: 'nama', emptyText: 'SubJenis',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'SubJenis',
                        disabled: true, editable: false,
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter({property: 'subjenis', value: value});
                                    }

                                    var filterUnker = Ext.getCmp('pemeliharaan-unker');
                                    if (filterUnker !== null)
                                    {
                                        var unkerValue = filterUnker.getValue();
                                        if (unkerValue !== null && unkerValue.length > 0)
                                        {
                                            data.filter({property: 'kd_lokasi', value: filterUnker.getValue()});
                                        }
                                    }
                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Filter by Periode',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by year',
                        name: 'pemeliharaan-year',
                        id: 'pemeliharaan-year',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.year,
                        valueField: 'year',
                        displayField: 'year', emptyText: 'Year',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter({property: 'pelaksana_startdate', value: value});
                                    }

                                }
                            }
                        }
                    }]
            };

            return panel;
        };


        Region.filterPanelPemeliharaan = function(data) {
            var panel = {
                region: 'west',
                title: 'Filter',
                width: 200,
                split: true,
                collapsible: true,
                floatable: false,
                frame: true,
                items: [{
                        xtype: 'label',
                        text: 'Filter by Unit Kerja',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Unker',
                        name: 'pemeliharaan-unker',
                        id: 'pemeliharaan-unker',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.unker,
                        valueField: 'kdlok',
                        displayField: 'ur_upb', emptyText: 'Unit Kerja',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Kerja',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter([{property: 'kd_lokasi', value: value}]);
                                    }

                                    var filterJenis = Ext.getCmp('filter-jenis');
                                    if (filterJenis !== null)
                                    {
                                        var jenisValue = filterJenis.getValue();
                                        if (jenisValue !== null && jenisValue.length > 0)
                                        {
                                            data.filter({property: 'jenis', value: filterJenis.getValue()});
                                        }
                                    }
                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Filter by Jenis',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Jenis',
                        name: 'filter-jenis',
                        id: 'filter-jenis',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.jenisPemeliharaan,
                        valueField: 'id',
                        displayField: 'nama', emptyText: 'Jenis',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Jenis',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter({property: 'jenis', value: value});
                                    }

                                    var filterUnker = Ext.getCmp('pemeliharaan-unker');
                                    if (filterUnker !== null)
                                    {
                                        var unkerValue = filterUnker.getValue();
                                        if (unkerValue !== null && unkerValue.length > 0)
                                        {
                                            data.filter({property: 'kd_lokasi', value: filterUnker.getValue()});
                                        }
                                    }
                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Filter by Periode',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by year',
                        name: 'pemeliharaan-year',
                        id: 'pemeliharaan-year',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.year,
                        valueField: 'year',
                        displayField: 'year', emptyText: 'Year',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter({property: 'pelaksana_tgl', value: value});
                                    }
                                }
                            }
                        }
                    }]
            };

            return panel;
        };

        Region.filterPanelPengadaan = function(data) {
            var panel = {
                region: 'west',
                title: 'Filter',
                width: 200,
                split: true,
                collapsible: true,
                floatable: false,
                frame: true,
                items: [{
                        xtype: 'label',
                        text: 'Filter by Unit Kerja',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Unker',
                        name: 'pengadaan-unker',
                        id: 'pengadaan-unker',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.unker,
                        valueField: 'kdlok',
                        displayField: 'ur_upb', emptyText: 'Unit Kerja',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Kerja',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    data.filter([{property: 'kd_lokasi', value: value}]);

                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Filter by Tanggal Perolehan',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by year',
                        name: 'pengadaan-year',
                        id: 'pengadaan-year',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.year,
                        valueField: 'year',
                        displayField: 'year', emptyText: 'Year',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {

                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter({property: 'perolehan_tanggal', value: value});
                                    }
                                }
                            }
                        }
                    }]
            };

            return panel;
        }

        Region.filterPanelPerencanaan = function(data) {
            var panel = {
                region: 'west',
                title: 'Filter',
                width: 200,
                split: true,
                collapsible: true,
                floatable: false,
                frame: true,
                items: [{
                        xtype: 'label',
                        text: 'Filter by Unit Kerja',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by Unker',
                        name: 'perencanaan-unker',
                        id: 'perencanaan-unker',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.unker,
                        valueField: 'kdlok',
                        displayField: 'ur_upb', emptyText: 'Unit Kerja',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Unit Kerja',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    data.filter([{property: 'kd_lokasi', value: value}]);

                                }
                            }
                        }
                    }, {
                        xtype: 'label',
                        text: 'Filter by Tahun Anggaran',
                        height: 30
                    }, {
                        xtype: 'combo',
                        fieldLabel: 'Filter by year',
                        name: 'perencanaan-year',
                        id: 'perencanaan-year',
                        allowBlank: true,
                        hideLabel: true,
                        layout: 'anchor',
                        anchor: '100%',
                        width: 190,
                        store: Reference.Data.year,
                        valueField: 'year',
                        displayField: 'year', emptyText: 'Year',
                        typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                        listeners: {
                            'change': {
                                fn: function(obj, value) {
                                    data.clearFilter();
                                    if (value !== null)
                                    {
                                        data.filter({property: 'tahun_angaran', value: value});
                                    }
                                }
                            }
                        }
                    }]
            };

            return panel;
        }


        Region.createSidePanel = function(actions) {
            var _panels = Ext.create('Ext.panel.Panel', {
                width: 155,
                id: 'asset-window-side',
                title: 'Selection',
                collapsible: false,
                floatable: false,
                frame: true,
                border: 0,
                style: {
                    padding: 0,
                    margin: 0
                },
                lbar: [{
                        xtype: 'button',
                        text: 'Data Utama',
                        textAlign: 'left',
                        width: 150,
                        handler: actions.details
                    }, '-', {
                        xtype: 'button',
                        text: 'Data Tambahan',
                        textAlign: 'left',
                        width: 150,
                        handler: function() {
                            console.log('Button Press');
                        }
                    }, '-', {
                        text: 'Pengadaan',
                        textAlign: 'left',
                        handler: actions.pengadaan
                    }, '-', {
                        text: 'Pemeliharaan',
                        textAlign: 'left',
                        handler: actions.pemeliharaan
                    }, '-', {
                        text: 'Pemindahan',
                        textAlign: 'left',
                        handler: actions.pemindahan
                    }, '-', {
                        text: 'Penghapusan',
                        textAlign: 'left',
                        handler: actions.penghapusan
                    }, '-', {
                        text: 'Pendayagunaan',
                        textAlign: 'left',
                        handler: actions.pendayagunaan
                    }, /*'-',{
                     text:'Perencanaan',
                     textAlign:'left',
                     handler:actions.perencanaan
                     }*/]
            });

            return _panels;
        };

        Tab.create = function() {
            var _tab = Ext.create('Ext.tab.Panel', {
                flex: 2,
                id: 'asset-window-tab',
                itemId: 'asset-window-tab',
                title: 'Navigation',
                border: 0,
                split: true,
                floatable: true,
                frame: true,
                defaults: {
                    autoScroll: true,
                }
            });
            return _tab;
        };

        Tab.addToForm = function(items, tabid, title) {
            var _tab = Modal.assetEdit.getComponent('asset-window-tab');
            if (_tab !== null)
            {
                var tabpanel = _tab.getComponent(tabid);
                if (tabpanel === null || tabpanel === undefined)
                {
                    _tab.add({
                        title: title,
                        id: tabid,
                        closable: true,
                        border: false,
                        items: [items],
                    });
                }

                _tab.setActiveTab(tabid);
            }
        };

        Tab.formTabs = function() {
            var _tab = Ext.create('Ext.tab.Panel', {
                title: '',
                border: 0,
                split: true,
                floatable: true,
                frame: true,
                deferredRender: false,
                id:'form_tabs',
                defaults: {
                    autoScroll: true,
                }
            });
            return _tab;
        };

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>