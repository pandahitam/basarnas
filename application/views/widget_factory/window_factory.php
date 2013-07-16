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
                        handler: function() {
                            console.log('Button Press');
                        }
                    }, '-', {
                        text: 'Penghapusan',
                        textAlign: 'left',
                        handler: function() {
                            console.log('Button Press');
                        }
                    }, '-', {
                        text: 'Pendayagunaan',
                        textAlign: 'left',
                        handler: function() {
                            console.log('Button Press');
                        }
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
                _tab.add({
                    title: title,
                    id: tabid,
                    closable: true,
                    border: false,
                    items: [items],
                });

                _tab.setActiveTab(tabid);
            }
        };

        Tab.tempcreate = function() {
            var _tab = Ext.create('Ext.tab.Panel', {
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

    <?php } else {
        echo "var new_tabpanel_MD = 'GAGAL';";
    } ?>