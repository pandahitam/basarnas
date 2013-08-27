<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php
            if (isset($title)) {
                echo $title;
            } else {
                echo "SIMASS BASARNAS";
            }
            ?></title>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon" /> 
        <meta http-equiv="content-type" content="text/html; charset=utf-8" /> 
        <meta name="Keywords" content="" />
        <meta name="Description" content="" />

        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/resources/css/ext-all.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/ux/statusbar/css/statusbar.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/ux/grid/css/GridFilters.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/ux/grid/css/RangeMenu.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/ext/ux/css/CheckHeader.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/icon_css.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/allow_select_grid.css"/>

        <style>body {background:#7F99BE;}</style>

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ext-all.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/underscore-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/class/jquery-1.8.3-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ux/CheckColumn.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ux/statusbar/StatusBar.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ux/form/SearchField.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ux/grid/FiltersFeature.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/ext/ux/miframe/ManagedIframe.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/class/allow_select_grid.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/functions/function_override.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/functions/jsDate1.js"></script>

        <script type="text/javascript">
            var BASE_URL = '<?php echo base_url(); ?>';
            var BASE_ICONS = BASE_URL + 'assets/images/icons/';
            var Time_Out = 2400000;
            var Tgl_Skrg = "<?php echo date('d/m/Y'); ?>";
            var Scr_Width = screen.availWidth;
            var Scr_Height = screen.availHeight;
            var type_user = '<?php echo $this->session->userdata("type_zs_simpeg"); ?>';
            var sesi_kode_unker = '<?php echo $this->session->userdata("kode_unker_zs_simpeg"); ?>';
            var Tab_Active = "";
            Ext.BLANK_IMAGE_URL = BASE_URL + 'assets/js/ext/resources/themes/images/access/tree/s.gif';
            Ext.Loader.setConfig({enabled: true});
            Ext.Loader.setPath('Ext.ux', BASE_URL + 'assets/js/ext/ux');
            Ext.require(['*']);

            Ext.form.Field.prototype.msgTarget = 'side';
            Ext.QuickTips.init();

            Ext.namespace('SIMPEG','Dashboard');

            Dashboard.URL = {
            readGrafikUnkerTotalAset: BASE_URL + 'dashboard/grafik_unker_totalaset',
            readGrafikKategoriBarangTotalAset : BASE_URL + 'dashboard/grafik_kategoribarang_totalaset',
            readAlertPemeliharaan: BASE_URL + 'dashboard/alert_pemeliharaan'
            };

            Dashboard.readerGrafikUnkerTotalAset = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderGrafikUnkerTotalAset_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });
            
            Dashboard.readerGrafikKategoriBarangTotalAset = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderGrafikKategoriBarang_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });
            
            Dashboard.readerAlertPemeliharaan = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderAlertPemeliharaan_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.proxyGrafikUnkerTotalAset = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyGrafikUnkerTotalAset_Dashboard',
                url: Dashboard.URL.readGrafikUnkerTotalAset, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerGrafikUnkerTotalAset,
            });
            
            Dashboard.proxyGrafikKategoriBarangTotalAset = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyGrafikKategoriBarangTotalAset_Dashboard',
                url: Dashboard.URL.readGrafikKategoriBarangTotalAset, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerGrafikKategoriBarangTotalAset,
            });
            
            Dashboard.proxyAlertPemeliharaan = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyAlertPemeliharaan _Dashboard',
                url: Dashboard.URL.readAlertPemeliharaan , actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerAlertPemeliharaan ,
            });
            
            
            Dashboard.modelGrafikUnkerTotalAset = Ext.define('MGrafikUnkerTotalAset', {extend: 'Ext.data.Model',
                fields: ['kd_lokasi','ur_upb','totalAset']
            });
            
            Dashboard.modelGrafikKategoriBarangTotalAset = Ext.define('MGrafikKategoriBarangTotalAset', {extend: 'Ext.data.Model',
                fields: ['nama','totalAset']
            });
            
            Dashboard.modelAlertPemeliharaan = Ext.define('MAlertPemeliharaan', {extend: 'Ext.data.Model',
                fields: ['ur_upb','nama','tanggal_kadaluarsa']
            });

            Dashboard.DataGrafikUnkerTotalAset = new Ext.create('Ext.data.Store', {
                id: 'Data_GrafikUnkerTotalAset', storeId: 'DataGrafikUnkerTotalAset', model: Dashboard.modelGrafikUnkerTotalAset, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyGrafikUnkerTotalAset, groupField: 'tipe'
            });
            
            Dashboard.DataGrafikKategoriBarangTotalAset = new Ext.create('Ext.data.Store', {
                id: 'Data_GrafikKategoriBarangTotalAset', storeId: 'DataGrafikKategoriBarangTotalAset', model: Dashboard.modelGrafikKategoriBarangTotalAset, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyGrafikKategoriBarangTotalAset, groupField: 'tipe'
            });
            
            Dashboard.DataAlertPemeliharaan = new Ext.create('Ext.data.Store', {
                id: 'Data_AlertPemeliharaan', storeId: 'DataAlertPemeliharaan', model: Dashboard.modelAlertPemeliharaan, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyAlertPemeliharaan, groupField: 'tipe'
            });
            
            Ext.onReady(function() {
                var clock = Ext.create('Ext.toolbar.TextItem', {text: Ext.Date.format(new Date(), 'd M Y, g:i:s A')});

                var Content_Header = {
                    id: 'content-header', split: false, height: 40, border: false,
                    html: '<div style=\'padding:5px; color:#fff; font-weight:bold; background : #35537e url(' + '<?php echo base_url(); ?>' + 'assets/images/icons/layout-browser-hd-bg.gif) repeat-x;\'>SISTEM INFORMASI ASSET MANAJEMEN<br>BADAN SAR NASIONAL TAHUN <?php echo date("Y"); ?></div>',
                };

                var Content_MainMenu = {
                    id: 'content-mainmenu',
                    xtype: 'toolbar',
                    dock: 'bottom',
                    items: ['',
                        {text: 'UTAMA', id: 'm_utama',
                            iconCls: 'icon-menu_utama',
                            menu: {
                                items: [
                                    {text: 'Pengguna Login', iconCls: 'icon-user', id: 'm_pengguna_login',
                                        handler: function() {
                                            Load_Page('pengguna_login', BASE_URL + 'pengguna_login');
                                        }
                                    },
                                    {text: 'Referensi', iconCls: 'icon-gears', id: 'm_referensi',
                                        handler: function() {
                                            Load_TabPage('master_data', BASE_URL + 'master_data');
                                        }
                                    }, '-',
                                    {text: 'Log Pengguna', iconCls: 'icon-menu_log_pengguna', id: 'm_log',
                                        handler: function() {
                                            Load_TabPage('logs_user', BASE_URL + 'utility_simpeg/logs_user');
                                        }
                                    },
                                    {text: 'Database Tools', iconCls: 'icon-menu_db_tools', id: 'm_db_tool',
                                        handler: function() {
                                            Load_TabPage('db_tools', BASE_URL + 'utility_simpeg/database_tools');
                                        }
                                    }
                                ]
                            }
                        }, '-', {
                            text: 'PENGELOLAAN ASSET', iconCls: 'icon-menu_layanan', id: 'm_pengelolaan_asset',
                            menu: {
                                items: [
                                    {text: 'Inventaris Asset', iconCls: 'icon-menu_impasing', id: 'm_inasset',
                                        handler: function() {
                                            Load_TabPage('pengelolaan_asset', BASE_URL + 'pengelolaan_asset');
                                        }
                                    }, '-',
                                    {text: 'Perencanaan', iconCls: 'icon-menu_impasing', id: 'm_perencanaan',
                                        handler: function() {

                                            Load_TabPage('perencanaan_asset', BASE_URL + 'perencanaan');
                                        }
                                    },
                                    {text: 'Pengadaan', iconCls: 'icon-menu_impasing', id: 'm_pengadaan',
                                        handler: function() {

                                            Load_TabPage('pengadaan_asset', BASE_URL + 'pengadaan');
                                        }
                                    },
                                    {text: 'Pemeliharaan', iconCls: 'icon-menu_impasing', id: 'm_pemeliharaan',
                                        menu: {
                                            items: [{
                                                    text: 'Pemeliharaan Umum ',
                                                    iconCls: 'icon-menu_impasing',
                                                    id: 'm_pemeliharaan_umum',
                                                    menu:{
                                                        items:[{
                                                                text: 'Pemeliharaan Kendaraan Darat',
                                                                iconCls: 'icon-menu_impasing',
                                                                id: 'm_pemeliharaan_umum_kendaraan_darat',
                                                                handler: function() {
                                                                   // Load_TabPage('pemeliharaan_asset_bangunan', BASE_URL + 'pemeliharaan_bangunan');
                                                                },
                                                            },
                                                            {
                                                                text: 'Pemeliharaan Kendaraan Udara',
                                                                iconCls: 'icon-menu_impasing',
                                                                id: 'm_pemeliharaan_umum_kendaraan_udara',
                                                                handler: function() {
                                                                   // Load_TabPage('pemeliharaan_asset_bangunan', BASE_URL + 'pemeliharaan_bangunan');
                                                                },
                                                            },
                                                            {
                                                                text: 'Pemeliharaan Kendaraan Laut',
                                                                iconCls: 'icon-menu_impasing',
                                                                id: 'm_pemeliharaan_umum_kendaraan_laut',
                                                                handler: function() {
                                                                   // Load_TabPage('pemeliharaan_asset_bangunan', BASE_URL + 'pemeliharaan_bangunan');
                                                                },
                                                            },
                                                            {
                                                                text: 'Pemeliharaan Peralatan Lainnya',
                                                                iconCls: 'icon-menu_impasing',
                                                                id: 'm_pemeliharaan_umum_kendaraan_udara',
                                                                handler: function() {
                                                                   // Load_TabPage('pemeliharaan_asset_bangunan', BASE_URL + 'pemeliharaan_bangunan');
                                                                },
                                                            },
                                                            ]
                                                    },
//                                                    handler: function() {
//
//                                                        Load_TabPage('pemeliharaan_asset', BASE_URL + 'pemeliharaan');
//                                                    }
                                                },
                                                {
                                                    text: 'Pemeliharaan Bangunan',
                                                    iconCls: 'icon-menu_impasing',
                                                    id: 'm_pemeliharaan_bangunan',
                                                    handler: function() {
                                                        Load_TabPage('pemeliharaan_asset_bangunan', BASE_URL + 'pemeliharaan_bangunan');
                                                    }
                                                }]
                                        }
                                    },
                                    {text: 'Pendayagunaan', iconCls: 'icon-menu_impasing', id: 'm_pendayagunaan',
                                        handler: function()
                                            {
                                                Load_TabPage('pendayagunaan_asset', BASE_URL + 'pendayagunaan');
                                            }
                                    },
                                    {text: 'Mutasi', iconCls: 'icon-menu_impasing', id: 'm_mutasi',
                                        handler: function()
                                        {
                                            Load_TabPage('mutasi_asset', BASE_URL + 'mutasi');
                                        }
                                    },
                                    {text: 'Penghapusan', iconCls: 'icon-menu_impasing', id: 'm_penghapusan',
                                        handler: function()
                                        {
                                            Load_TabPage('penghapusan_asset', BASE_URL + 'penghapusan');
                                        }

                                    },
                                    {text: 'Peraturan', iconCls: 'icon-menu_impasing', id: 'm_peraturan'},
                                    {text: 'Pengelolaan', iconCls: 'icon-menu_impasing', id: 'm_pengelolaan',
                                        handler: function()
                                        {
                                            Load_TabPage('pengelolaan', BASE_URL + 'pengelolaan')
                                        }
                                    },
                                            
                                    {text: 'Inventory', iconCls: 'icon-menu_impasing', id: 'm_inventory',
                                        menu: {
                                            items: [{
                                                    text: 'Penerimaan ',
                                                    iconCls: 'icon-menu_impasing',
                                                    id: 'm_inventory_penerimaan',
                                                    handler: function() {

                                                        Load_TabPage('inventory_penerimaan', BASE_URL + 'inventory_penerimaan');
                                                    }
                                                },
                                                {
                                                    text: 'Pemeriksaan',
                                                    iconCls: 'icon-menu_impasing',
                                                    id: 'm_inventory_pemeriksaan',
                                                    handler: function() {
                                                        Load_TabPage('inventory_pemeriksaan', BASE_URL + 'inventory_pemeriksaan');
                                                    }
                                                },
                                                {
                                                    text: 'Penyimpanan',
                                                    iconCls: 'icon-menu_impasing',
                                                    id: 'm_inventory_penyimpanan',
                                                    handler: function() {
                                                        Load_TabPage('inventory_penyimpanan', BASE_URL + 'inventory_penyimpanan');
                                                    }
                                                },
                                                {
                                                    text: 'Pengeluaran',
                                                    iconCls: 'icon-menu_impasing',
                                                    id: 'm_inventory_pengeluaran',
                                                    handler: function() {
                                                        Load_TabPage('inventory_pengeluaran', BASE_URL + 'inventory_pengeluaran');
                                                    }
                                                }]
                                        }
                                    }
                                ]
                            }
                        }, '-', {
                            text: 'MAP', iconCls: 'icon-menu_diklat', id: 'm_global_map',
                            handler: function() {
                                Load_TabPage('map_id', BASE_URL + 'global_map');
                            }
                        },'-', {
                            text: 'LAPORAN', iconCls: 'icon-menu_laporan', id: 'm_laporan',
                                    menu:{
                                items:[{
                                        text: 'Aset/Unit Kerja ',
                                        iconCls: 'icon-menu_impasing',
                                        id: 'm_laporan_aset_unker',
                                        handler: function() {
                                            Load_TabPage('laporan_aset_unitkerja', BASE_URL + 'laporan_aset_unitkerja');
                                        }
                                    },
                                    {
                                        text: 'Aset/ Kategori Barang',
                                        iconCls: 'icon-menu_impasing',
                                        id: 'm_laporan_aset_kategoribarang',
                                        handler: function() {
                                            Load_TabPage('laporan_aset_kategoribarang', BASE_URL + 'laporan_aset_kategoribarang');
                                    }
                                }]
                                    },
                        }, '->', {
                            text: 'Ubah Kata Sandi', iconCls: 'icon-key', handler: function() {
                                Load_Popup('winchangepass', BASE_URL + 'pengguna_login/ubahsandi');
                            }
                        }, {
                            text: 'Logout', iconCls: 'icon-minus-circle', handler: function() {
                                do_logout();
                            }
                        },
                        {
                            text: 'MAP SEARCH', iconCls: 'icon-menu_diklat', id: 'm_map_search',
                            handler: function() {
                                Load_MapSearch('tanah_panel', BASE_URL + 'asset_tanah/tanah','DataTanah','Surabaya');
                            }
                        },
                    ]
                };

                var Layout_Header = {id: 'layout-header', region: 'north', split: false, collapsible: false, border: false, items: [Content_Header, Content_MainMenu]};
                
                var GridAlertPemeliharaan = Ext.create('Ext.grid.Panel', {
                    title: 'Alert Pemeliharaan',
                    store: Dashboard.DataAlertPemeliharaan,
                    columns: [
                        { header: 'Unit Kerja',  dataIndex: 'ur_upb', width:200 },
                        { header: 'Nama Aset', dataIndex: 'nama', width:300},
                        { header: 'Tanggal Overdue', dataIndex: 'tanggal_kadaluarsa', width:150 }
                    ],
                    height: 200,
//                    width: 400,
//                    renderTo: Ext.getBody()
                });
                    
                var GrafikUnkerTotalAset = Ext.create('Ext.chart.Chart', {
                            width:800,
                            height:550,
                            animate: true,
                            renderTo:Ext.getBody(),
                            store: Dashboard.DataGrafikUnkerTotalAset,
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
                                title: 'Aset Dalam Rupiah x 1 jt',
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
                        
                var GrafikKategoriBarangTotalAset = Ext.create('Ext.chart.Chart', {
                            width:800,
                            height:550,
                            animate: true,
                            renderTo:Ext.getBody(),
                            store: Dashboard.DataGrafikKategoriBarangTotalAset,
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
                        
                        
                var GrafikUnkerTotalAsetContainer = Ext.create(Ext.panel.Panel,{
                    id: 'GrafikUnkerTotalAsetContainer',
                    title: "Grafik Total Aset/Unit Kerja", 
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
                    items:[GrafikUnkerTotalAset],
                    });
                    
                var GrafikKategoriBarangTotalAsetContainer = Ext.create(Ext.panel.Panel,{
                    id: 'GrafikKategoriBarangTotalAsetContainer',
                    title: "Grafik Total Aset/Kategori Barang", 
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
                    items:[GrafikKategoriBarangTotalAset],
                    });
                        
                var Content_Body_Tabs = Ext.createWidget('tabpanel', {
                    id: 'Content_Body_Tabs', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
                    defaults: {autoScroll: true},
                    items: [{
                            id: 'dashboard', title: 'Dashboard', bodyPadding: 10, iconCls: 'icon-gnome', closable: false,layout:{type: 'table', columns: 1,tableAttrs: { style: {width: '99%'}},},
                            items:[GridAlertPemeliharaan,GrafikUnkerTotalAsetContainer, GrafikKategoriBarangTotalAsetContainer]
                        }],
                    listeners: {
                        'tabchange': function(tabPanel, tab) {
                            switch (tab.title) {
                                // LAYANAN
                                case 'Inpassing':
                                    Ext.getCmp('belum_proses_IMPG').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_IMPG').setValue(true);
                                    break;
                                case 'KGB':
                                    Ext.getCmp('belum_proses_T_KGB').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_KGB').setValue(true);
                                    break;
                                case 'Kenaikan Pangkat':
                                    Ext.getCmp('belum_proses_KP').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_KP').setValue(true);
                                    break;
                                case 'Pensiun':
                                    Ext.getCmp('belum_proses_SK_Pensiun').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_SK_Pensiun').setValue(true);
                                    break;
                                case 'Izin Belajar':
                                    Ext.getCmp('belum_proses_T_IB').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_IB').setValue(true);
                                    break;
                                case 'Ujian Dinas':
                                    Ext.getCmp('belum_proses_T_UD').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_UD').setValue(true);
                                    break;
                                case 'Satya Lencana':
                                    Ext.getCmp('belum_proses_T_SL').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_SL').setValue(true);
                                    break;
                                case 'CUTI':
                                    Ext.getCmp('belum_proses_T_Cuti').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_Cuti').setValue(true);
                                    break;
                                case 'Taperum':
                                    Ext.getCmp('belum_proses_T_Taperum').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_Taperum').setValue(true);
                                    break;
                                case 'SK Rikes':
                                    Ext.getCmp('belum_proses_T_SK_RIKES').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_SK_RIKES').setValue(true);
                                    break;
                                case 'SK Meninggal':
                                    Ext.getCmp('belum_proses_T_DC').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_DC').setValue(true);
                                    break;
                                case 'KARPEG':
                                    Ext.getCmp('belum_proses_T_Karpeg').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_Karpeg').setValue(true);
                                    break;
                                case 'KARIS/KARSU':
                                    Ext.getCmp('belum_proses_T_Karissu').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_Karissu').setValue(true);
                                    break;

                                    // KEPEGAWAIAN
                                case 'SK CPNS':
                                    Ext.getCmp('belum_proses_T_SK_CPNS').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_SK_CPNS').setValue(true);
                                    break;
                                case 'SK PNS':
                                    Ext.getCmp('belum_proses_T_SK_PNS').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_SK_PNS').setValue(true);
                                    break;
                                case 'SK PMK':
                                    Ext.getCmp('belum_proses_PMKG').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_PMKG').setValue(true);
                                    break;
                                case 'SK MPP':
                                    Ext.getCmp('belum_proses_T_SK_MPP').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_SK_MPP').setValue(true);
                                    break;
                                case 'Mutasi Masuk':
                                    Ext.getCmp('belum_proses_T_MTM').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_MTM').setValue(true);
                                    break;
                                case 'Mutasi Keluar':
                                    Ext.getCmp('belum_proses_MTK').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_MTK').setValue(true);
                                    break;
                                case 'Surat Pindah Tugas':
                                    Ext.getCmp('belum_proses_ST').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_ST').setValue(true);
                                    break;
                                case 'Dispilin Pegawai':
                                    Ext.getCmp('belum_proses_T_HukDis').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_HukDis').setValue(true);
                                    break;
                                case 'DP3':
                                    Ext.getCmp('belum_proses_T_DP3').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_DP3').setValue(true);
                                    break;

                                    // DIKLAT
                                case 'Pra Jabatan':
                                    Ext.getCmp('belum_proses_T_PraJab').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_PraJab').setValue(true);
                                    break;
                                case 'Diklat PIM':
                                    Ext.getCmp('belum_proses_T_D_PIM').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_D_PIM').setValue(true);
                                    break;
                                case 'Tugas Belajar':
                                    Ext.getCmp('belum_proses_T_TB').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_TB').setValue(true);
                                    break;
                                case 'Riwayat Pendidikan Formal':
                                    Ext.getCmp('belum_proses_T_Pddk').setValue(true);
                                    break;
                                    Ext.getCmp('semua_periode_T_Pddk').setValue(true);
                                    break;
                                default:
                            }
                        }
                    }
                });

                var Layout_Body = Ext.create('Ext.panel.Panel', {
                    id: 'layout-body', region: 'center', layout: 'fit', border: false, deferredRender: true,
                    items: [{
                            id: 'items-body', border: false, layout: 'card', autoRender: true, closable: false, activeItem: 0,
                            items:[Content_Body_Tabs],
                        }]
                });

                var Layout_Footer = {
                    id: 'layout-footer', region: 'south', layout: 'fit', split: false, border: false, margins: '5 0 0 0',
                    items: [{
                            xtype: 'toolbar', dock: 'bottom', items: ['Pengguna : ' + '<?php echo $this->my_usession->userdata("fullname_zs_simpeg") . " | " . $this->my_usession->userdata("type_zs_simpeg") . " | " . $this->my_usession->userdata("nama_unker_zs_simpeg"); ?>', '->', clock, '-', {id: 'ChatBtn', iconCls: 'icon-smiley', handler: function() {
                                        Show_Chat();
                                    }}],
                            listeners: {
                                render: {
                                    fn: function() {
                                        Ext.fly(clock.getEl().parent()).addCls('x-status-text-panel').createChild({cls: 'spacer'});

                                        // Kick off the clock timer that updates the clock el every second:
                                        Ext.TaskManager.start({
                                            run: function() {
                                                Ext.fly(clock.getEl()).update(Ext.Date.format(new Date(), 'd M Y, g:i:s A'));
                                            },
                                            interval: 1000
                                        });
                                    },
                                    delay: 100
                                }
                            }
                        }]
                };

                //Print All Component     
                Ext.create('Ext.Viewport', {
                    id: 'main_viewport', layout: {type: 'border', padding: 5}, defaults: {split: true}, items: [Layout_Header, Layout_Body, Layout_Footer], renderTo: Ext.getBody()
                });

            });
            function Show_Chat() {
                Ext.MessageBox.show({title: 'Chat !', msg: 'Chatting !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
            }

            function do_logout() {
                Ext.getCmp('layout-body').body.mask("Logout ...", "x-mask-loading");
                Ext.Ajax.request({url: BASE_URL + 'user/ext_logout', method: 'POST', success: function(xhr) {
                        window.location = BASE_URL + 'user';
                    }});
                return false;
            }

            function Load_Page(page_id, page_url) {
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_page_id = Ext.getCmp(page_id);
                if (new_page_id) {
                    Ext.getCmp('items-body').getLayout().setActiveItem(new_page_id);
                    Ext.getCmp('items-body').doLayout();
                    Ext.getCmp('layout-body').body.unmask();
                } else {
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: page_url, method: 'POST', params: {id_open: 1}, scripts: true, renderer: 'data',
                        success: function(response) {
                            // Start Register Javacript On Fly
                            var jsonData = response.responseText.substring(14);
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            // End Register Javacript On Fly
                            if (newpanel != "GAGAL") {
                                Ext.getCmp('items-body').add(newpanel);
                                Ext.getCmp('items-body').getLayout().setActiveItem(newpanel);
                                Ext.getCmp('items-body').doLayout();
                            } else {
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }
                        },
                        failure: function(response) {
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response) {
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_TabPage(tab_id, tab_url) {

                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_tab_id = Ext.getCmp(tab_id);
                if (new_tab_id) {
                    Ext.getCmp('items-body').getLayout().setActiveItem(0);
                    Ext.getCmp('items-body').doLayout();
                    Ext.getCmp('Content_Body_Tabs').setActiveTab(tab_id);
                    Ext.getCmp('layout-body').body.unmask();
                } else {
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true, renderer: 'data',
                        success: function(response) {
                            var jsonData = response.responseText.substring(14);
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            var new_tab = Ext.getCmp('Content_Body_Tabs');
                            if (new_tabpanel != "GAGAL") {
                                Ext.getCmp('items-body').getLayout().setActiveItem(0);
                                Ext.getCmp('items-body').doLayout();
                                new_tab.add(new_tabpanel).show();
                            } else {
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }

                        },
                        failure: function(response) {
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response) {
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_Popup(popup_id, popup_url, popup_title, url_form) {
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_popup_id = Ext.getCmp(popup_id);
                if (new_popup_id) {
                    Ext.getCmp('layout-body').body.unmask();
                    new_popup.show();
                } else {
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: popup_url, method: 'POST', params: {id_open: 1, popup_title: popup_title}, scripts: true, renderer: 'data',
                        success: function(response) {
                            var jsonData = response.responseText;
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            var new_popup = Ext.getCmp(popup_id);
                            if (new_popup != "GAGAL") {
                                new_popup.show();
                            } else {
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }
                        },
                        failure: function(response) {
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response) {
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_Panel_Ref(popup_id, popup_uri, form_name, vfmode, p_key, p_key1, p_key2, p_key3) {
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_popup_id = Ext.getCmp(popup_id);
                if (new_popup_id) {
                    Ext.getCmp('layout-body').body.unmask();
                    var strFunc = "Funct_" + popup_id;
                    var fn = window[strFunc];
                    fn(form_name, vfmode);
                } else {
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: BASE_URL + 'panel_ref/' + popup_uri, method: 'POST', params: {id_open: 1, VKEY: p_key, VKEY1: p_key1, VKEY2: p_key2, VKEY3: p_key3}, scripts: true, renderer: 'data',
                        success: function(response) {
                            var jsonData = response.responseText;
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            var new_popup = Ext.getCmp(popup_id);
                            if (new_popup != "GAGAL") {
                                var strFunc = "Funct_" + popup_id;
                                var fn = window[strFunc];
                                fn(form_name, vfmode);
                            } else {
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }
                        },
                        failure: function(response) {
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response) {
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_Variabel(page_url) {
                Ext.Ajax.request({
                    url: page_url, method: 'POST', params: {id_open: 1}, scripts: true, renderer: 'data',
                    success: function(response) {
                        var jsonData = response.responseText;
                        var aHeadNode = document.getElementsByTagName('head')[0];
                        var aScript = document.createElement('script');
                        aScript.text = jsonData;
                        aHeadNode.appendChild(aScript);
                    },
                    failure: function(response) {
                        Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                    },
                    scope: this
                });
            }

            // Adi Make Functions

            function Load_WidgetFactory(factory) {
                var factoryUrl = BASE_URL + 'widget_factory/';
                switch (factory) {
                    case "form":
                        {
                            factoryUrl += 'form';
                            break;
                        }
                    case "grid":
                        {
                            factoryUrl += 'grid';
                            break;
                        }
                    case "window":
                        {
                            factoryUrl += 'window';
                            break;
                        }
                    case "model":
                        {
                            factoryUrl += 'model';
                            break;
                        }
                    case "data":
                        {
                            factoryUrl += 'data';
                            break;
                        }
                    default:
                        {
                            break;
                        }
                }

                Ext.Ajax.request({
                    url: factoryUrl,
                    method: 'POST',
                    scripts: true,
                    renderer: 'data',
                    success: function(response) {

                        var jsonData = response.responseText.substring(14);
                        var aHeadNode = document.getElementsByTagName('head')[0];
                        var aScript = document.createElement('script');
                        aScript.text = jsonData;
                        aHeadNode.appendChild(aScript);
                    },
                    failure: function(response) {
                        Ext.MessageBox.show({
                            title: 'Peringatan !',
                            msg: 'Gagal memuat dokumen !',
                            buttons: Ext.MessageBox.OK,
                            icon: Ext.MessageBox.ERROR});
                    },
                    scope: this
                });

            }

            Load_WidgetFactory("grid");
            Load_WidgetFactory("form");
            Load_WidgetFactory("window");
            Load_WidgetFactory("model");
            //Load_WidgetFactory("data");

            //Load_Variabel(BASE_URL + 'profil_func');
            //Load_Variabel(BASE_URL + 'arsip_digital_func');
            //Load_Variabel(BASE_URL + 'user/set_var_access');
            
            
            function Load_MapSearch(tab_id,tab_url,dataStoreId,searchValue)
            {
                //LOAD ASSET INVENTARIS TAB
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_tab_id = Ext.getCmp('pengelolaan_asset');
                if (new_tab_id) {
                    Ext.getCmp('items-body').getLayout().setActiveItem(0);
                    Ext.getCmp('items-body').doLayout();
                    Ext.getCmp('Content_Body_Tabs').setActiveTab('pengelolaan_asset');
                    Ext.getCmp('layout-body').body.unmask();
                } else {
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: BASE_URL + 'pengelolaan_asset', method: 'POST', params: {id_open: 1}, scripts: true, renderer: 'data',
                        success: function(response) {
                            var jsonData = response.responseText.substring(14);
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            var new_tab = Ext.getCmp('Content_Body_Tabs');
                            if (new_tabpanel != "GAGAL") {
                                Ext.getCmp('items-body').getLayout().setActiveItem(0);
                                Ext.getCmp('items-body').doLayout();
                                new_tab.add(new_tabpanel).show();
                            } else {
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }

                        },
                        failure: function(response) {
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response) {
                            Ext.getCmp('layout-body').body.unmask();
                            //LOAD SELECTED ASSET INVENTARIS
                            Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                            var new_tab_id = Ext.getCmp(tab_id);
                            if(new_tab_id){
                                    Ext.getCmp('Tab_PA').setActiveTab(tab_id);
                                    Ext.getCmp('layout-body').body.unmask(); 
                            }else{
                                    Ext.Ajax.timeout = Time_Out;
                                    Ext.Ajax.request({
                                    url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true, 
                            success: function(response){
                                    var jsonData = response.responseText.substring(13);   
                                            var aHeadNode = document.getElementsByTagName('head')[0]; 
                                            var aScript = document.createElement('script'); 
                                            aScript.text = jsonData; 
                                            aHeadNode.appendChild(aScript);
                                    if(new_tabpanel_Asset != "GAGAL"){
                                            Ext.getCmp('Tab_PA').add(new_tabpanel_Asset).show();

                                    }else{
                                            Ext.MessageBox.show({title:'Peringatan !', msg:'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});    			
                                    }
                                    },
                            failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
                            callback: function(response){ Ext.getCmp('layout-body').body.unmask(); 
                                    //FILTER DATA
                                   Ext.getStore(dataStoreId).getProxy().extraParams = {'searchUnker':searchValue}; 
                            },
                            scope : this
                                    });
                            }
                        },
                        scope: this
                    });
                }
                
                
                
            }
        </script>
    </head>
    <body>
        <div id="script_area"></div>
        <div id="body_div"></div>
    </body>
</html>