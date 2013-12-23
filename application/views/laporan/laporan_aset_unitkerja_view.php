<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START
Ext.namespace('LaporanAsetUnitKerja');

LaporanAsetUnitKerja.URL = {
            readLaporanGrid: BASE_URL + 'laporan_aset_unitkerja/getLaporanGrid',
            readLaporanChart: BASE_URL + 'laporan_aset_unitkerja/getLaporanChart'
            };
            
LaporanAsetUnitKerja.readerLaporanGrid = new Ext.create('Ext.data.JsonReader', {
    id: 'ReaderLaporanAsetUnitKerja_LaporanGrid', root: 'results', totalProperty: 'total', idProperty: 'id'
});

LaporanAsetUnitKerja.proxyLaporanGrid = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyLaporanAsetUnitKerja_LaporanGrid',
                url: LaporanAsetUnitKerja.URL.readLaporanGrid, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: LaporanAsetUnitKerja.readerLaporanGrid,
            });

LaporanAsetUnitKerja.modelLaporanGrid = Ext.define('MLaporanAsetUnitKerja_LaporanGrid', {extend: 'Ext.data.Model',
                fields: ['kd_lokasi','no_aset','kd_brg','type','merk','kondisi','kategori_aset','rph_aset']
            });

LaporanAsetUnitKerja.DataLaporanGrid = new Ext.create('Ext.data.Store', {
                id: 'Data_LaporanAsetUnitKerja_LaporanGrid', storeId: 'DataLaporanAsetUnitKerja_LaporanGrid', model: LaporanAsetUnitKerja.modelLaporanGrid, noCache: false, autoLoad: true, 
                proxy: LaporanAsetUnitKerja.proxyLaporanGrid, groupField: 'tipe'
            });

LaporanAsetUnitKerja.readerLaporanChart = new Ext.create('Ext.data.JsonReader', {
    id: 'ReaderLaporanAsetUnitKerja_LaporanChart', root: 'results', totalProperty: 'total', idProperty: 'id'
});

LaporanAsetUnitKerja.proxyLaporanChart = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyLaporanAsetUnitKerja_LaporanGrid',
                url: LaporanAsetUnitKerja.URL.readLaporanChart, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: LaporanAsetUnitKerja.readerLaporanChart,
            });

LaporanAsetUnitKerja.modelLaporanChart = Ext.define('MLaporanAsetUnitKerja_LaporanChart', {extend: 'Ext.data.Model',
                fields: ['nama','totalAset']
            });

LaporanAsetUnitKerja.DataLaporanChart = new Ext.create('Ext.data.Store', {
                id: 'Data_LaporanAsetUnitKerja_LaporanChart', storeId: 'DataLaporanAsetUnitKerja_LaporanChart', model: LaporanAsetUnitKerja.modelLaporanChart, noCache: false, autoLoad: true, pageSize:100,
                proxy: LaporanAsetUnitKerja.proxyLaporanChart, groupField: 'tipe'
            });
            

LaporanAsetUnitKerja.LaporanChart = Ext.create('Ext.chart.Chart', {
                            width:800,
                            height:550,
                            animate: true,
                            renderTo:Ext.getBody(),
                            store: LaporanAsetUnitKerja.DataLaporanChart,
                            theme:'Category6',
                            axes: [{
                                type: 'Category',
                                position: 'bottom',
                                fields: ['nama'],
                                title: 'Kategori Barang',
                                label: {
                                    rotate:{degrees:270}
                                },
                            }, {
                                type: 'Numeric',
                                position: 'left',
                                fields: ['totalAset'],
                                title: 'Aset Dalam Rupiah x 1 jt',
                                label: {
                                        renderer: Ext.util.Format.numberRenderer('0,0')
                                },
                            }],
                            //Add Bar series.
                            series: [{
                                type: 'column',
                                axis: 'bottom',
                                xField: 'nama',
                                yField: 'totalAset',
                                highlight: true,
                                label: {
                                    display: 'insideEnd',
                                    field: 'totalAset',
                                    orientation: 'vertical',
                                    renderer: Ext.util.Format.numberRenderer('0,0'),
                                    color: '#333',
                                   'text-anchor': 'middle'
                                }
                            }]
                        });

LaporanAsetUnitKerja.LaporanChartContainer = Ext.create(Ext.panel.Panel,{
                    id: 'LaporanAsetUnitKerjaLaporanChartContainer',
                    title: "Chart", 
                    autoScroll: true, 
                    border:false,
                    height: 600,
                    layout:{
                        type:'table',
                        tableAttrs:{
                            style:'width:100%'
                        },
                        tdAttrs:{
                            align:'center'
                        },
                    },
                    items:[LaporanAsetUnitKerja.LaporanChart],
                    });

LaporanAsetUnitKerja.GridLaporan = Ext.create('Ext.grid.Panel', {
                    title: 'Grid Laporan',
                    store: LaporanAsetUnitKerja.DataLaporanGrid,
                    columns: [
                        {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                        { header: 'Kode Aset',  dataIndex: 'kd_brg', width:150},
                        { header: 'Type', dataIndex: 'type', width:150},
                        { header: 'Merk', dataIndex: 'merk', width:150 },
                        { header: 'Kondisi', dataIndex: 'kondisi', width:150,
                        renderer: function(value) {
                                if (value === '1')
                                {
                                    return "BAIK";
                                }
                                else if (value === '2')
                                {
                                    return "RUSAK RINGAN";
                                }
                                else if (value === '3')
                                {
                                    return "RUSAK BERAT";
                                }
                                else if (value === '4')
                                {
                                    return "HILANG";
                                }
                                else
                                {
                                    return "";
                                }
                            }
                        },
                        { header: 'Rph Aset', dataIndex: 'rph_aset', width:150 }
                    ],
                    height: 300,
//                    dockedItems: [{xtype: 'pagingtoolbar', store: LaporanAsetUnitKerja.DataLaporanGrid, dock: 'bottom', displayInfo: true}],
//                    width: 400,
//                    renderTo: Ext.getBody()
                });

LaporanAsetUnitKerja.ContainerLaporan = Ext.create(Ext.panel.Panel,{
                    autoScroll: true, 
                    height: 600,
                    border:false,
                    layout:{
                        type:'table',
                        tableAttrs:{
                            style:'width:100%'
                        },
                        columns:1,
                        
                    },
                    items:[LaporanAsetUnitKerja.GridLaporan,LaporanAsetUnitKerja.LaporanChartContainer]
                    });



LaporanAsetUnitKerja.unker = function(edit) {
            var component = {
                xtype: 'fieldset',
                title: 'UNIT KERJA/UNIT ORGANISASI',
                layout: 'column',
                border: false,
                defaultType: 'container',
                margin: 0,
                items: [{
                        columnWidth: .5,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                xtype:'combo',
                                fieldLabel: 'Unit Kerja',
                                name: 'laporan_aset_unitkerja_nama_unker',
                                id: 'laporan_aset_unitkerja_nama_unker',
                                itemId: 'unker',
                                allowBlank: true,
                                store: Reference.Data.unker,
                                valueField: 'kdlok',
                                displayField: 'ur_upb', emptyText: 'Pilih Unit Kerja',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {

                                            if (value !== null)
                                            {
                                                var unorField = Ext.getCmp('laporan_aset_unitkerja_nama_unor');
                                                if (unorField !== null) {
                                                    if (value.length > 0) {
                                                        unorField.setValue('');
                                                        unorField.enable();
                                                        Reference.Data.unor.changeParams({params: {id_open: 1, kd_lokasi: value}});
                                                    }
                                                    else {
                                                        unorField.disable();
                                                    }
                                                }
                                                else {
                                                    console.error('unit organisasi could not be found');
                                                }
                                            }

                                        },
                                        scope: this
                                    }
                                }
                            },
                            {
                                xtype:'combo',
                                fieldLabel: ' Unit Organisasi',
                                name: 'laporan_aset_unitkerja_nama_unor',
                                id: 'laporan_aset_unitkerja_nama_unor',
                                disabled: true,
                                allowBlank: true,
                                store: Reference.Data.unor,
                                valueField: 'kode_unor',
                                displayField: 'nama_unor', emptyText: 'Pilih Unit Organisasi',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Pilih Unit Kerja',
//                                listeners: {
//                                    'focus': {
//                                        fn: function(comboField) {
//                                            var dataStore = comboField.getStore();
//                                            var kd_lokasi = Utils.getUnkerCombo(form).getValue();
//                                            if (kd_lokasi !== null)
//                                            {
//                                                console.log(Utils.getUnkerCombo(form).getValue());
//                                                dataStore.clearFilter();
//                                                dataStore.filter({property:"kd_lokasi", value:kd_lokasi});
//                                            }
//                                            comboField.expand();
//                                            
//                                        },
//                                        scope: this
//                                    },
//                                    'change': {
//                                        fn: function(obj, value) {
//                                            var kodeUnorField = form.getForm().findField('kode_unor');
//                                            if (kodeUnorField !== null && !isNaN(value)) {
//                                                kodeUnorField.setValue(value);
//                                                console.log(kodeUnorField.getValue());
//                                            }
//                                        }
//                                    }
//                                }
                            }]
                    }, {
                        columnWidth: .5,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                    xtype: 'combo',
                                    fieldLabel: 'Tahun',
                                    id:'laporan_aset_unitkerja_tahun',
                                    name: 'laporan_aset_unitkerja_tahun',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: 'Year',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                            },
                            ]
                    }]
            };


            return component;
        };

LaporanAsetUnitKerja.kode = function(edit) {
            var component = {
                xtype: 'fieldset',
                title: 'BARANG',
                layout: 'column',
                border: false,
                defaultType: 'container',
                margin: 0,
                items: [{
                        defaultType: 'hidden',
                        items: [{
                                name: 'kd_gol',
                                id: 'kd_gol',
                                listeners: {
                                    change: function(obj, value) {
//                                        if (edit)
//                                        {
                                            var comboGolongan = Ext.getCmp('nama_golongan');
                                            if (comboGolongan !== null)
                                            {
                                                comboGolongan.setValue(value);
                                            }
//                                        }
                                    }
                                }
                            }, {
                                name: 'kd_bid',
                                id: 'kd_bid',
                                listeners: {
                                    change: function(obj, value) {
//                                        if (edit)
//                                        {
                                            var comboBidang = Ext.getCmp('nama_bidang');
                                            if (comboBidang !== null)
                                            {
                                                comboBidang.setValue(value);
                                            }
//                                        }
                                    }
                                }
                            }, {
                                name: 'kd_kelompok',
                                id: 'kd_kelompok',
                                listeners: {
                                    change: function(obj, value) {
//                                        if (edit)
//                                        {
                                            var comboKelompok = Ext.getCmp('nama_kelompok');
                                            if (comboKelompok !== null)
                                            {
                                                comboKelompok.setValue(value);
                                            }
//                                        }
                                    }
                                }
                            }, {
                                name: 'kd_skel',
                                id: 'kd_skel',
                                listeners: {
                                    change: function(obj, value) {
                                        if (edit)
                                        {
                                            var comboSubKelompok = Ext.getCmp('nama_subkel');
                                            if (comboSubKelompok !== null)
                                            {
                                                comboSubKelompok.setValue(value);
                                            }
                                        }
                                    }
                                }
                            }, 
//                            {
//                                name: 'kd_sskel',
//                                id: 'kd_sskel',
//                                listeners: {
//                                    change: function(obj, value) {
//                                        if (edit)
//                                        {
//                                            var comboSubSubKelompok = Ext.getCmp('nama_subsubkel');
//                                            if (comboSubSubKelompok !== null)
//                                            {
//                                                comboSubSubKelompok.setValue(value);
//                                            }
//                                        }
//                                    }
//                                }
//                            }
                            ]
                    }, {
                        columnWidth: .5,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Golongan',
                                name: 'nama_golongan',
                                id: 'nama_golongan',
                                hideLabel: false,
                                allowBlank: false,
                                store: Reference.Data.golongan,
                                valueField: 'kd_gol',
                                displayField: 'ur_gol', emptyText: 'Golongan',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Golongan',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            if (value !== null)
                                            {
                                                var bidangField = Ext.getCmp('nama_bidang');
                                                var golonganField = Ext.getCmp('kd_gol');
                                                if (golonganField !== null && bidangField !== null) {
                                                    if (!isNaN(value) && value.length > 0 || edit === true) {
                                                        bidangField.enable();
                                                        golonganField.setValue(value);
                                                        Reference.Data.bidang.changeParams({params: {id_open: 1, kd_gol: value}});
                                                    }
                                                    else {
                                                        bidangField.disable();
                                                    }
                                                }
                                                else {
                                                    console.error('error');
                                                }
                                            }

                                        },
                                        scope: this
                                    }
                                }
                            },
                            {
                                fieldLabel: 'Kelompok',
                                name: 'nama_kelompok',
                                id: 'nama_kelompok',
                                disabled: true,
                                allowBlank: true,
                                store: Reference.Data.kelompok,
                                valueField: 'kd_kel',
                                displayField: 'ur_kel', emptyText: 'Kelompok',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Kelompok',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var subKelompokField = Ext.getCmp('nama_subkel');
                                            var kelompokField = Ext.getCmp('kd_kelompok');
                                            var bidangFieldValue = Ext.getCmp('kd_bid').getValue();
                                            var golonganFieldValue = Ext.getCmp('kd_gol').getValue();

                                            if (kelompokField !== null && subKelompokField !== null && !isNaN(value)) {
                                                kelompokField.setValue(value);
                                                subKelompokField.enable();
                                                Reference.Data.subKelompok.changeParams({params: {id_open: 1,
                                                        kd_gol: golonganFieldValue,
                                                        kd_bid: bidangFieldValue,
                                                        kd_kel: value}});
                                            }
                                        }
                                    }
                                }
                            }]
                    }, {
                        columnWidth: .5,
                        layout: 'anchor',
                        defaults: {
                            anchor: '95%'
                        },
                        defaultType: 'combo',
                        items: [{
                                fieldLabel: 'Bidang',
                                name: 'nama_bidang',
                                id: 'nama_bidang',
                                disabled: true,
                                allowBlank: true,
                                store: Reference.Data.bidang,
                                valueField: 'kd_bid',
                                displayField: 'ur_bid', emptyText: 'Bidang',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Bidang',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
                                            var kelompokField = Ext.getCmp('nama_kelompok');
                                            var bidangField = Ext.getCmp('kd_bid');
                                            var golonganField = Ext.getCmp('kd_gol').getValue();
                                            if (kelompokField !== null && bidangField !== null) {
                                                if (!isNaN(value) && value.length > 0 || edit === true) {
                                                    kelompokField.enable();
                                                    bidangField.setValue(value);
                                                    Reference.Data.kelompok.changeParams({params: {id_open: 1, kd_gol: golonganField, kd_bid: value}});
                                                }
                                                else {
                                                    kelompokField.disable();
                                                }
                                            }
                                            else {
                                                console.error('error');
                                            }
                                        }
                                    }
                                }
                            },
                            {
                                fieldLabel: 'Sub Kelompok',
                                name: 'nama_subkel',
                                id: 'nama_subkel',
                                disabled: true,
                                allowBlank: true,
                                store: Reference.Data.subKelompok,
                                valueField: 'kd_skel',
                                displayField: 'ur_skel', emptyText: 'Sub Kelompok',
                                typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Sub Kelompok',
                                listeners: {
                                    'focus': {
                                        fn: function(comboField) {
                                            comboField.expand();
                                        },
                                        scope: this
                                    },
                                    'change': {
                                        fn: function(obj, value) {
//                                            var subSubKelompokField = Ext.getCmp('nama_subsubkel');
//                                            var kelompokFieldValue = Ext.getCmp('kd_kelompok').getValue();
//                                            var bidangFieldValue = Ext.getCmp('kd_bid').getValue();
//                                            var golonganFieldValue = Ext.getCmp('kd_gol').getValue();
//                                            var subkelField = Ext.getCmp('kd_skel');
//
//                                            if (subkelField !== null && subSubKelompokField !== null && !isNaN(value)) {
//                                                subkelField.setValue(value);
//                                                subSubKelompokField.enable();
//                                                Reference.Data.subSubKelompok.changeParams({params: {id_open: 1,
//                                                        kd_gol: golonganFieldValue,
//                                                        kd_bid: bidangFieldValue,
//                                                        kd_kel: kelompokFieldValue,
//                                                        kd_skel: value}});
//                                            }
                                        }
                                    }
                                }
                            }
                            ]
                    }]
            };


            return component;
        };
      

LaporanAsetUnitKerja.Container = {
  region: 'center', id:'laporan_aset_unit_kerja_container', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: false, autoScroll: true,
  items: [LaporanAsetUnitKerja.ContainerLaporan],
  tbar: Ext.create('Ext.toolbar.Toolbar', {
	  layout: 'column',
		items: [
                            LaporanAsetUnitKerja.unker(),{xtype:'splitter'},
                            LaporanAsetUnitKerja.kode(),{xtype:'splitter'},
                            {xtype:'fieldset',title:'TINDAKAN',items:[
                            {
                            xtype : 'button',
                            text : "Tampilkan",
                            handler: function(){
                                var unker = Ext.getCmp('laporan_aset_unitkerja_nama_unker').value;
                                var unor = Ext.getCmp('laporan_aset_unitkerja_nama_unor').value;
                                var tahun = Ext.getCmp('laporan_aset_unitkerja_tahun').value;
                                debugger;
                                var golongan = Ext.getCmp('kd_gol').value;
                                var bidang = Ext.getCmp('kd_bid').value;
                                var kelompok = Ext.getCmp('kd_kelompok').value;
                                var sub_kelompok = Ext.getCmp('kd_skel').value;
                                if(unker != null && tahun != null)
                                {
                                    LaporanAsetUnitKerja.DataLaporanGrid.changeParams({params: {id_open: 1, kd_lokasi: unker, kd_unor:unor, tahun:tahun, golongan:golongan, bidang:bidang, kelompok:kelompok, sub_kelompok:sub_kelompok}});
                                    LaporanAsetUnitKerja.DataLaporanChart.changeParams({params: {id_open: 1, kd_lokasi: unker, kd_unor:unor, tahun:tahun, golongan:golongan, bidang:bidang, kelompok:kelompok, sub_kelompok:sub_kelompok}});
//                                    Ext.getCmp('laporan_aset_unit_kerja_container').add(LaporanAsetUnitKerja.ContainerLaporan).show();
                                }
                                else
                                {
                                    Ext.MessageBox.alert('Error','Harap mengisi unit kerja dan tahun terlebih dahulu');
                                }
                                
                                },
                            },
                        {
                            xtype : 'button',
                            text : "Cetak",
                            iconCls:'icon-printer',
                            handler: function(){
                                var unker = Ext.getCmp('laporan_aset_unitkerja_nama_unker').value;
                                var unor = Ext.getCmp('laporan_aset_unitkerja_nama_unor').value;
                                var tahun = Ext.getCmp('laporan_aset_unitkerja_tahun').value;
                                var golongan_val = Ext.getCmp('kd_gol').value;
                                var bidang_val = Ext.getCmp('kd_bid').value;
                                var kelompok_val = Ext.getCmp('kd_kelompok').value;
                                var sub_kelompok_val = Ext.getCmp('kd_skel').value;
                                var nama_unker = Ext.getCmp('laporan_aset_unitkerja_nama_unker').rawValue;
                                
                                var golongan = (golongan_val == undefined || golongan_val == "")?"":"/"+golongan_val;
                                var bidang = (bidang_val == undefined || bidang_val == "")?"":"/"+bidang_val;
                                var kelompok = (kelompok_val == undefined || kelompok_val == "")?"":"/"+kelompok_val;
                                var sub_kelompok = (sub_kelompok_val == undefined || sub_kelompok_val == "")?"":"/"+sub_kelompok_val;
                                
                                var param_barang = golongan+bidang+kelompok+sub_kelompok;
                                
                                if(unker != null && tahun != null)
                                {
                                      if(unor !=  null && unor != '')
                                      {
                                          window.location.href= BASE_URL+'excel_management/exportLaporanUnkerTotalAset/'+nama_unker+'/'+unker+'/'+tahun+'/'+unor+param_barang;
                                      }
                                      else
                                      {
                                          window.location.href= BASE_URL+'excel_management/exportLaporanUnkerTotalAset/'+nama_unker+'/'+unker+'/'+tahun+'/0'+param_barang;
                                      }
                                      
                                    
//                                    LaporanAsetUnitKerja.DataLaporanGrid.changeParams({params: {id_open: 1, kd_lokasi: unker, kd_unor:unor, tahun:tahun}});
//                                    LaporanAsetUnitKerja.DataLaporanChart.changeParams({params: {id_open: 1, kd_lokasi: unker, kd_unor:unor, tahun:tahun}});
//                                    Ext.getCmp('laporan_aset_unit_kerja_container').add(LaporanAsetUnitKerja.ContainerLaporan).show();
                                }
                                else
                                {
                                    Ext.MessageBox.alert('Error','Harap mengisi unit kerja dan tahun terlebih dahulu');
                                }
                                
                            }
                        }
                        ]}]
  })
};



//var Container_PA = {
//	xtype: 'container', region: 'center', layout: 'border', border: false,
//  items: []
//};

var new_tabpanel = {
    id: 'laporan_aset_unitkerja_panel', title: 'Laporan Aset Unit Kerja', iconCls: 'icon-menu_impasing', border: false, closable: true, 
    layout: 'border', items: [LaporanAsetUnitKerja.Container]
};
            
<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>