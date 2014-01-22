<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START



Ext.namespace('LaporanAngkutanUdara');

LaporanAngkutanUdara.URL = {
            readLaporanGrid: BASE_URL + 'laporan_aset_kategoribarang/getLaporanGrid',
            readLaporanChart: BASE_URL + 'laporan_aset_kategoribarang/getLaporanChart'
            };
            
LaporanAngkutanUdara.readerLaporanGrid = new Ext.create('Ext.data.JsonReader', {
    id: 'ReaderLaporanAngkutanUdara_LaporanGrid', root: 'results', totalProperty: 'total', idProperty: 'id'
});

LaporanAngkutanUdara.proxyLaporanGrid = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyLaporanAngkutanUdara_LaporanGrid',
                url: LaporanAngkutanUdara.URL.readLaporanGrid, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: LaporanAngkutanUdara.readerLaporanGrid,
            });

LaporanAngkutanUdara.modelLaporanGrid = Ext.define('MLaporanAngkutanUdara_LaporanGrid', {extend: 'Ext.data.Model',
                fields: ['kd_lokasi','no_aset','kd_brg','type','merk','kondisi','kategori_aset','rph_aset']
            });

LaporanAngkutanUdara.DataLaporanGrid = new Ext.create('Ext.data.Store', {
                id: 'Data_LaporanAngkutanUdara_LaporanGrid', storeId: 'DataLaporanAngkutanUdara_LaporanGrid', model: LaporanAngkutanUdara.modelLaporanGrid, noCache: false, autoLoad: true, 
                proxy: LaporanAngkutanUdara.proxyLaporanGrid, groupField: 'tipe'
            });

LaporanAngkutanUdara.readerLaporanChart = new Ext.create('Ext.data.JsonReader', {
    id: 'ReaderLaporanAngkutanUdara_LaporanChart', root: 'results', totalProperty: 'total', idProperty: 'id'
});

LaporanAngkutanUdara.proxyLaporanChart = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyLaporanAngkutanUdara_LaporanGrid',
                url: LaporanAngkutanUdara.URL.readLaporanChart, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: LaporanAngkutanUdara.readerLaporanChart,
            });

LaporanAngkutanUdara.modelLaporanChart = Ext.define('MLaporanAngkutanUdara_LaporanChart', {extend: 'Ext.data.Model',
                fields: ['ur_upb','totalAset']
            });

LaporanAngkutanUdara.DataLaporanChart = new Ext.create('Ext.data.Store', {
                id: 'Data_LaporanAngkutanUdara_LaporanChart', storeId: 'DataLaporanAngkutanUdara_LaporanChart', model: LaporanAngkutanUdara.modelLaporanChart, noCache: false, autoLoad: true, pageSize:100,
                proxy: LaporanAngkutanUdara.proxyLaporanChart, groupField: 'tipe'
            });
            


//LaporanAngkutanUdara.LaporanChart = Ext.create('Ext.chart.Chart', {
//                            width:800,
//                            height:550,
//                            animate: true,
//                            renderTo:Ext.getBody(),
//                            store: LaporanAngkutanUdara.DataLaporanChart,
//                            theme:'Category6',
//                            axes: [{
//                                type: 'Category',
//                                position: 'bottom',
//                                fields: ['ur_upb'],
//                                title: 'Unit Kerja',
//                                label: {
//                                    rotate:{degrees:270}
//                                },
//                            }, {
//                                type: 'Numeric',
//                                position: 'left',
//                                fields: ['totalAset'],
//                                title: 'Aset Dalam Rupiah',
//                                label: {
//                                        renderer: Ext.util.Format.numberRenderer('0,0')
//                                },
//                            }],
//                            //Add Bar series.
//                            series: [{
//                                type: 'column',
//                                axis: 'bottom',
//                                xField: 'ur_upb',
//                                yField: 'totalAset',
//                                highlight: true,
//                                label: {
//                                    display: 'insideEnd',
//                                    field: 'totalAset',
//                                    orientation: 'vertical',
//                                    renderer: Ext.util.Format.numberRenderer('0,0'),
//                                    color: '#333',
//                                   'text-anchor': 'middle'
//                                }
//                            }]
//                        });
//
//LaporanAngkutanUdara.LaporanChartContainer = Ext.create(Ext.panel.Panel,{
//                    id: 'LaporanAngkutanUdaraLaporanChartContainer',
//                    title: "Chart", 
//                    autoScroll: true, 
//                    height: 600,
//                    border:false,
//                    layout:{
//                        type:'table',
//                        tableAttrs:{
//                            style:'width:99%'
//                        },
//                        tdAttrs:{
//                            align:'center'
//                        },
//                    },
//                    items:[LaporanAngkutanUdara.LaporanChart],
//                    });
//
//LaporanAngkutanUdara.GridLaporan = Ext.create('Ext.grid.Panel', {
//                    title: 'Grid Laporan',
//                    store: LaporanAngkutanUdara.DataLaporanGrid,
//                    columns: [
//                        {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
//                        { header: 'Kode Aset',  dataIndex: 'kd_brg', width:150},
//                        { header: 'Type', dataIndex: 'type', width:150},
//                        { header: 'Merk', dataIndex: 'merk', width:150 },
//                        { header: 'Kondisi', dataIndex: 'kondisi', width:150,
//                            renderer: function(value) {
//                                if (value === '1')
//                                {
//                                    return "BAIK";
//                                }
//                                else if (value === '2')
//                                {
//                                    return "RUSAK RINGAN";
//                                }
//                                else if (value === '3')
//                                {
//                                    return "RUSAK BERAT";
//                                }
//                                else if (value === '4')
//                                {
//                                    return "HILANG";
//                                }
//                                else
//                                {
//                                    return "";
//                                }
//                            }
//                        },
//                        { header: 'Rph Aset', dataIndex: 'rph_aset', width:150 }
//                    ],
//                    height: 300,
//                });
//
//LaporanAngkutanUdara.ContainerLaporan = Ext.create(Ext.panel.Panel,{
//                    autoScroll: true, 
//                    height: 600,
//                    border:false,
//                    layout:{
//                        type:'table',
//                        tableAttrs:{
//                            style:'width:100%'
//                        },
//                        columns:1,
//                        
//                    },
//                    items:[LaporanAngkutanUdara.GridLaporan,LaporanAngkutanUdara.LaporanChartContainer]
//                    });

LaporanAngkutanUdara.Container = {
  region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0',  border: false, autoScroll: true,
  items: [],
  tbar: Ext.create('Ext.toolbar.Toolbar', {
	  layout: {overflowHandler: 'Menu'},
		items: [{
                                    xtype: 'combo',
                                    fieldLabel: 'Angkutan Udara',
                                    id:'combo_laporan_angkutan_udara',
                                    name: 'combo_laporan_angkutan_udara',
                                    width:500,
                                    allowBlank: false,
                                    editable:false,
                                    store: Reference.Data.listAngkutanUdara,
                                    valueField: 'no_induk_asset',
                                    displayField: 'merk', emptyText: 'Angkutan Udara',
                                    typeAhead: true, forceSelection: false, selectOnFocus: true, valueNotFoundText: 'Angkutan Udara',
                            },'|',
//                            {
//                            xtype : 'button',
//                            text : "Tampilkan",
//                            handler: function(){
//                                var kategori = Ext.getCmp('laporan_aset_kategoribarang_kategori').value;
//                                var tahun = Ext.getCmp('laporan_aset_kategoribarang_tahun').value;
//                                if(kategori != null && tahun != null)
//                                {
//                                    LaporanAngkutanUdara.DataLaporanGrid.changeParams({params: {id_open: 1, kategori: kategori, tahun:tahun}});
//                                    LaporanAngkutanUdara.DataLaporanChart.changeParams({params: {id_open: 1, kategori: kategori, tahun:tahun}});
//                                }
//                                else
//                                {
//                                    Ext.MessageBox.alert('Error','Harap mengisi kategori barang dan tahun terlebih dahulu');
//                                }
//                                
//                            }
//                            },
                            {
                            xtype : 'button',
                            text : "Cetak",
                            iconCls:'icon-printer',
                            handler: function(){
                                var combo = Ext.getCmp('combo_laporan_angkutan_udara');
                                var angkutan = Ext.getCmp('combo_laporan_angkutan_udara').value;
                                if(angkutan != null && angkutan != "")
                                {
                                    window.location.href= BASE_URL+'excel_management/exportLaporanUdara/'+angkutan;
                                }
                                else
                                {
                                    Ext.MessageBox.alert('Error','Harap memilih angkutan udara terlebih dahulu');
                                }
                                
                            }
                        }
                        ]
  })
};


var new_tabpanel = {
	id: 'laporan_angkutan_udara_panel', title: 'Laporan Angkutan Udara', iconCls: 'icon-menu_impasing', border: false, closable: true, 
	layout: 'fit', items: [LaporanAngkutanUdara.Container]
};



<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>