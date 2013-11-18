<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START



Ext.namespace('LaporanAsetKategoriBarang');

LaporanAsetKategoriBarang.URL = {
            readLaporanGrid: BASE_URL + 'laporan_aset_kategoribarang/getLaporanGrid',
            readLaporanChart: BASE_URL + 'laporan_aset_kategoribarang/getLaporanChart'
            };
            
LaporanAsetKategoriBarang.readerLaporanGrid = new Ext.create('Ext.data.JsonReader', {
    id: 'ReaderLaporanAsetKategoriBarang_LaporanGrid', root: 'results', totalProperty: 'total', idProperty: 'id'
});

LaporanAsetKategoriBarang.proxyLaporanGrid = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyLaporanAsetKategoriBarang_LaporanGrid',
                url: LaporanAsetKategoriBarang.URL.readLaporanGrid, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: LaporanAsetKategoriBarang.readerLaporanGrid,
            });

LaporanAsetKategoriBarang.modelLaporanGrid = Ext.define('MLaporanAsetKategoriBarang_LaporanGrid', {extend: 'Ext.data.Model',
                fields: ['kd_lokasi','no_aset','kd_brg','type','merk','kondisi','kategori_aset','rph_aset']
            });

LaporanAsetKategoriBarang.DataLaporanGrid = new Ext.create('Ext.data.Store', {
                id: 'Data_LaporanAsetKategoriBarang_LaporanGrid', storeId: 'DataLaporanAsetKategoriBarang_LaporanGrid', model: LaporanAsetKategoriBarang.modelLaporanGrid, noCache: false, autoLoad: true, 
                proxy: LaporanAsetKategoriBarang.proxyLaporanGrid, groupField: 'tipe'
            });

LaporanAsetKategoriBarang.readerLaporanChart = new Ext.create('Ext.data.JsonReader', {
    id: 'ReaderLaporanAsetKategoriBarang_LaporanChart', root: 'results', totalProperty: 'total', idProperty: 'id'
});

LaporanAsetKategoriBarang.proxyLaporanChart = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyLaporanAsetKategoriBarang_LaporanGrid',
                url: LaporanAsetKategoriBarang.URL.readLaporanChart, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: LaporanAsetKategoriBarang.readerLaporanChart,
            });

LaporanAsetKategoriBarang.modelLaporanChart = Ext.define('MLaporanAsetKategoriBarang_LaporanChart', {extend: 'Ext.data.Model',
                fields: ['ur_upb','totalAset']
            });

LaporanAsetKategoriBarang.DataLaporanChart = new Ext.create('Ext.data.Store', {
                id: 'Data_LaporanAsetKategoriBarang_LaporanChart', storeId: 'DataLaporanAsetKategoriBarang_LaporanChart', model: LaporanAsetKategoriBarang.modelLaporanChart, noCache: false, autoLoad: true, pageSize:100,
                proxy: LaporanAsetKategoriBarang.proxyLaporanChart, groupField: 'tipe'
            });
            

//var Tab_PA = Ext.createWidget('tabpanel', {
//	id: 'Tab_PA', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
//  defaults: {autoScroll:true},
//  items: [{
//      id: 'default_Tab_MD', 
//      bodyPadding: 10,
//      closable: false
//  }]
//});

LaporanAsetKategoriBarang.LaporanChart = Ext.create('Ext.chart.Chart', {
                            width:800,
                            height:550,
                            animate: true,
                            renderTo:Ext.getBody(),
                            store: LaporanAsetKategoriBarang.DataLaporanChart,
                            theme:'Category6',
                            axes: [{
                                type: 'Category',
                                position: 'bottom',
                                fields: ['ur_upb'],
                                title: 'Unit Kerja',
                                label: {
                                    rotate:{degrees:270}
                                },
                            }, {
                                type: 'Numeric',
                                position: 'left',
                                fields: ['totalAset'],
                                title: 'Aset Dalam Rupiah',
                                label: {
                                        renderer: Ext.util.Format.numberRenderer('0,0')
                                },
                            }],
                            //Add Bar series.
                            series: [{
                                type: 'column',
                                axis: 'bottom',
                                xField: 'ur_upb',
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

LaporanAsetKategoriBarang.LaporanChartContainer = Ext.create(Ext.panel.Panel,{
                    id: 'LaporanAsetKategoriBarangLaporanChartContainer',
                    title: "Chart", 
                    autoScroll: true, 
                    height: 600,
                    border:false,
                    layout:{
                        type:'table',
                        tableAttrs:{
                            style:'width:99%'
                        },
                        tdAttrs:{
                            align:'center'
                        },
                    },
                    items:[LaporanAsetKategoriBarang.LaporanChart],
                    });

LaporanAsetKategoriBarang.GridLaporan = Ext.create('Ext.grid.Panel', {
                    title: 'Grid Laporan',
                    store: LaporanAsetKategoriBarang.DataLaporanGrid,
                    columns: [
                        {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                        { header: 'Kode Aset',  dataIndex: 'kd_brg', width:150},
                        { header: 'Nama', dataIndex: 'type', width:150},
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
//                    dockedItems: [{xtype: 'pagingtoolbar', store: LaporanAsetKategoriBarang.DataLaporanGrid, dock: 'bottom', displayInfo: true}],
//                    width: 400,
//                    renderTo: Ext.getBody()
                });

LaporanAsetKategoriBarang.ContainerLaporan = Ext.create(Ext.panel.Panel,{
//                    id: 'LaporanAsetKategoriBarang_Container',
//                    title: "Laporan Aset Unit Kerja", 
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
                    items:[LaporanAsetKategoriBarang.GridLaporan,LaporanAsetKategoriBarang.LaporanChartContainer]
                    });

LaporanAsetKategoriBarang.Container = {
  region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0',  border: false, autoScroll: true,
  items: [LaporanAsetKategoriBarang.ContainerLaporan],
  tbar: Ext.create('Ext.toolbar.Toolbar', {
	  layout: {overflowHandler: 'Menu'},
		items: [{
                                    xtype: 'combo',
                                    fieldLabel: 'Kategori Barang',
                                    id:'laporan_aset_kategoribarang_kategori',
                                    name: 'laporan_aset_kategoribarang_kategori',
                                    allowBlank: true,
                                    store: Reference.Data.kategoriAset,
                                    valueField: 'value',
                                    displayField: 'kategori', emptyText: 'Kategori',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Kategori',
                            },
                            {
                                    xtype: 'combo',
                                    fieldLabel: 'Tahun',
                                    id:'laporan_aset_kategoribarang_tahun',
                                    name: 'laporan_aset_kategoribarang_tahun',
                                    allowBlank: true,
                                    store: Reference.Data.year,
                                    valueField: 'year',
                                    displayField: 'year', emptyText: 'Year',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Year',
                            },'|',{
                            xtype : 'button',
                            text : "Tampilkan",
                            handler: function(){
                                var kategori = Ext.getCmp('laporan_aset_kategoribarang_kategori').value;
                                var tahun = Ext.getCmp('laporan_aset_kategoribarang_tahun').value;
                                if(kategori != null && tahun != null)
                                {
                                    LaporanAsetKategoriBarang.DataLaporanGrid.changeParams({params: {id_open: 1, kategori: kategori, tahun:tahun}});
                                    LaporanAsetKategoriBarang.DataLaporanChart.changeParams({params: {id_open: 1, kategori: kategori, tahun:tahun}});
//                                    Ext.getCmp('Tab_PA').add(LaporanAsetKategoriBarang.ContainerLaporan).show();
                                }
                                else
                                {
                                    Ext.MessageBox.alert('Error','Harap mengisi kategori barang dan tahun terlebih dahulu');
                                }
                                
                            }
                            }]
  })
};

//var Container_PA = {
//	xtype: 'container', region: 'center', layout: 'border', border: false,
//  items: [Center_PA]
//};

var new_tabpanel = {
	id: 'laporan_aset_kategoribarang_panel', title: 'Laporan Aset Kategori Barang', iconCls: 'icon-menu_impasing', border: false, closable: true, 
	layout: 'fit', items: [LaporanAsetKategoriBarang.Container]
};



<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>