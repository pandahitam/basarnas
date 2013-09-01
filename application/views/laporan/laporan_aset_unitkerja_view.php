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
                fields: ['kd_lokasi','no_aset','kd_brg','type','merk','kondisi','kategori_aset']
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
            

var Tab_PA = Ext.createWidget('tabpanel', {
	id: 'Tab_PA', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [{
      id: 'default_Tab_MD', 
      bodyPadding: 10,
      closable: false
  }]
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
                    height: 600,
                    layout:{
                        type:'table',
                        tableAttrs:{
                            style:'width:99%'
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
                        { header: 'Nama', dataIndex: 'type', width:150},
                        { header: 'Merk', dataIndex: 'merk', width:150 },
                        { header: 'Kondisi', dataIndex: 'kondisi', width:150 }
                    ],
                    height: 300,
                    dockedItems: [{xtype: 'pagingtoolbar', store: LaporanAsetUnitKerja.DataLaporanGrid, dock: 'bottom', displayInfo: true}],
//                    width: 400,
//                    renderTo: Ext.getBody()
                });

LaporanAsetUnitKerja.ContainerLaporan = Ext.create(Ext.panel.Panel,{
                    id: 'LaporanAsetUnitKerja_Container',
                    title: "Laporan Aset Unit Kerja", 
                    autoScroll: true, 
                    height: 600,
                    layout:{
                        type:'table',
                        tableAttrs:{
                            style:'width:100%'
                        },
                        columns:1,
                        
                    },
                    items:[LaporanAsetUnitKerja.GridLaporan,LaporanAsetUnitKerja.LaporanChartContainer]
                    });

var Center_PA = {
  region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: true, autoScroll: true,
  items: [Tab_PA],
  tbar: Ext.create('Ext.toolbar.Toolbar', {
	  layout: {overflowHandler: 'Menu'},
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
                            },
                            {
                                    xtype: 'combo',
                                    fieldLabel: 'Tahun',
                                    id:'laporan_aset_unitkerja_tahun',
                                    name: 'laporan_aset_unitkerja_tahun',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: 'Year',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                            },'|',{
                            xtype : 'button',
                            text : "Tampilkan",
                            handler: function(){
                                var unker = Ext.getCmp('laporan_aset_unitkerja_nama_unker').value;
                                var unor = Ext.getCmp('laporan_aset_unitkerja_nama_unor').value;
                                var tahun = Ext.getCmp('laporan_aset_unitkerja_tahun').value;
                                if(unker != null && tahun != null)
                                {
                                    LaporanAsetUnitKerja.DataLaporanGrid.changeParams({params: {id_open: 1, kd_lokasi: unker, kd_unor:unor, tahun:tahun}});
                                    LaporanAsetUnitKerja.DataLaporanChart.changeParams({params: {id_open: 1, kd_lokasi: unker, kd_unor:unor, tahun:tahun}});
                                    Ext.getCmp('Tab_PA').add(LaporanAsetUnitKerja.ContainerLaporan).show();
                                }
                                
                            }
                            }]
  })
};

var Container_PA = {
	xtype: 'container', region: 'center', layout: 'border', border: false,
  items: [Center_PA]
};

var new_tabpanel = {
	id: 'laporan_aset_unitkerja_panel', title: 'Laporan Aset Unit Kerja', iconCls: 'icon-menu_impasing', border: false, closable: true, 
	layout: 'fit', items: [Container_PA]
};

//function Load_TabPage_Asset(tab_id,tab_url){
//	Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
//	var new_tab_id = Ext.getCmp(tab_id);
//	if(new_tab_id){
//		Ext.getCmp('Tab_PA').setActiveTab(tab_id);
//		Ext.getCmp('layout-body').body.unmask(); 
//	}else{
//		Ext.Ajax.timeout = Time_Out;
//		Ext.Ajax.request({
//  		url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true, 
//    	success: function(response){
//    		var jsonData = response.responseText.substring(13);   
//			var aHeadNode = document.getElementsByTagName('head')[0]; 
//			var aScript = document.createElement('script'); 
//			aScript.text = jsonData; 
//			aHeadNode.appendChild(aScript);
//    		if(new_tabpanel_Asset != "GAGAL"){
//    			Ext.getCmp('Tab_PA').add(new_tabpanel_Asset).show();
//    		}else{
//    			Ext.MessageBox.show({title:'Peringatan !', msg:'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});    			
//    		}
//   		},
//    	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
//    	callback: function(response){ Ext.getCmp('layout-body').body.unmask(); },
//    	scope : this
//		});
//	}	
//}

<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>