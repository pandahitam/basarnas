<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?php
            if(isset($title))
            {
                echo $title;
            }
            else
            {
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

            Ext.namespace('SIMPEG', 'Dashboard', 'AlertKendaraanDarat', 'AlertKendaraanDarat.Form', 'AlertPemeliharan', 'AlertPemeliharaan.Form');

            Dashboard.URL = {
                readGrafikUnkerTotalAset: BASE_URL + 'dashboard/grafik_unker_totalaset',
                readGrafikKategoriBarangTotalAset: BASE_URL + 'dashboard/grafik_kategoribarang_totalaset',
                readAlertPemeliharaan: BASE_URL + 'dashboard/alert_pemeliharaan',
                readInventarisAssetUmum: BASE_URL + 'dashboard/cari_global',
                readAlertPengadaan: BASE_URL + 'dashboard/alert_pengadaan',
                readAlertKendaraanDarat: BASE_URL + 'dashboard/alert_kendaraan_darat',
                readAlertPengelolaan: BASE_URL + 'dashboard/alert_pengelolaan',
                readAlertPendayagunaan: BASE_URL + 'dashboard/alert_pendayagunaan',
                readMemo: BASE_URL +'dashboard/memo',
                readAlertPerlengkapan: BASE_URL +'dashboard/alert_perlengkapan'
            };
            
            Dashboard.readerAlertPerlengkapan= new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderAlertPerlengkapan_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });
            
            Dashboard.readerMemo = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderMemo_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });
            
            Dashboard.readerAlertPendayagunaan = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderAlertPendayagunaan_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.readerAlertPengelolaan = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderAlertPengelolaan_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.readerAlertKendaraanDarat = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderAlertKendaraanDarat_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.readerAlertPengadaan = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderAlertPengadaaan_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.readerGrafikUnkerTotalAset = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderGrafikUnkerTotalAset_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.readerGrafikKategoriBarangTotalAset = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderGrafikKategoriBarang_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.readerAlertPemeliharaan = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderAlertPemeliharaan_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });

            Dashboard.readerInventarisAssetUmum = new Ext.create('Ext.data.JsonReader', {
                id: 'ReaderInventarisAssetUmum_Dashboard', root: 'results', totalProperty: 'total', idProperty: 'id'
            });
            
            Dashboard.proxyAlertPerlengkapan = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyAlertPerlengkapan_Dashboard',
                url: Dashboard.URL.readAlertPerlengkapan, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerAlertPerlengkapan,
            });
            
            Dashboard.proxyMemo = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyMemo_Dashboard',
                url: Dashboard.URL.readMemo, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerMemo,
            });

            Dashboard.proxyAlertPendayagunaan = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyAlertPendayagunaan_Dashboard',
                url: Dashboard.URL.readAlertPendayagunaan, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerAlertPendayagunaan,
            });

            Dashboard.proxyAlertPengelolaan = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyAlertPengelolaan_Dashboard',
                url: Dashboard.URL.readAlertPengelolaan, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerAlertPengelolaan,
            });

            Dashboard.proxyAlertPengadaan = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyAlertPengadaan_Dashboard',
                url: Dashboard.URL.readAlertPengadaan, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerAlertPengadaan,
            });

            Dashboard.proxyAlertKendaraanDarat = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyAlertKendaraanDarat_Dashboard',
                url: Dashboard.URL.readAlertKendaraanDarat, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerAlertKendaraanDarat,
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
                id: 'ProxyAlertPemeliharaan_Dashboard',
                url: Dashboard.URL.readAlertPemeliharaan, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerAlertPemeliharaan,
            });

            Dashboard.proxyInventarisAssetUmum = new Ext.create('Ext.data.AjaxProxy', {
                id: 'ProxyInventarisAssetUmum_Dashboard',
                url: Dashboard.URL.readInventarisAssetUmum, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
                reader: Dashboard.readerInventarisAssetUmum,
            });
            
            Dashboard.modelAlertPerlengkapan = Ext.define('MAlertPerlengkapan', {extend: 'Ext.data.Model',
                fields: ['id','warehouse_id','ruang_id','rak_id','nama_warehouse','nama_ruang','nama_rak','alert','nama_unker','nama_unor',
                'serial_number', 'part_number','kd_brg','kd_lokasi','nama_kelompok','jenis_asset',
                'no_aset','kondisi', 'kuantitas', 'dari',
                'tanggal_perolehan','no_dana','penggunaan_waktu',
                'penggunaan_freq','unit_waktu','unit_freq','disimpan', 
                'dihapus','image_url','document_url'
                ,'kd_klasifikasi_aset','nama_klasifikasi_aset','kode_unor','id_pengadaan','no_induk_asset','nama_part','umur']
            });
            
            Dashboard.modelMemo = Ext.define('MAlertPengelolaan', {extend: 'Ext.data.Model',
                fields: ['id', 'kd_brg', 'kd_lokasi', 'no_aset', 'created_date', 'created_by','date_created', 'isi', 'nama_unker', 'nama_unor','nama']
            });

            Dashboard.modelAlertPendayagunaan = Ext.define('MAlertPengelolaan', {extend: 'Ext.data.Model',
                fields: ['id', 'kd_lokasi', 'kd_brg', 'no_aset', 'nama', 'pihak_ketiga', 'nama_unor',
                    'part_number', 'serial_number', 'mode_pendayagunaan', 'tanggal_start', 'description',
                    'tanggal_end', 'document',
                    'nama_unker',
                    'kd_gol', 'kd_bid', 'kd_kelompok', 'kd_skel', 'kd_sskel'
                            , 'nama_klasifikasi_aset', 'kd_klasifikasi_aset',
                    'kd_lvl1', 'kd_lvl2', 'kd_lvl3']
            });

            Dashboard.modelAlertPengelolaan = Ext.define('MAlertPengelolaan', {extend: 'Ext.data.Model',
                fields: ['id', 'nama_operasi', 'pic', 'tanggal_mulai', 'tanggal_selesai', 'deskripsi', 'image_url', 'document_url', 'kd_lokasi', 'kode_unor', 'kd_brg', 'no_aset', 'nama', 'nama_unker']
            });

            Dashboard.modelAlertPengadaan = Ext.define('MAlertPengadaan', {extend: 'Ext.data.Model',
                fields: ['id', 'nama_unker', 'kd_brg', 'nama', 'tanggal_garansi_expired']
            });

            Dashboard.modelAlertKendaraanDarat = Ext.define('MAlertKendaraanDarat', {extend: 'Ext.data.Model',
                fields: ['id', 'kd_lokasi',
                    'kd_brg', 'no_aset',
                    'kuantitas', 'no_kib',
                    'merk', 'type',
                    'pabrik', 'thn_rakit',
                    'thn_buat', 'negara',
                    'muat', 'bobot',
                    'daya', 'msn_gerak',
                    'jml_msn', 'bhn_bakar',
                    'no_mesin', 'no_rangka',
                    'no_polisi', 'no_bpkb',
                    'lengkap1', 'lengkap2',
                    'lengkap3', 'jns_trn',
                    'dari', 'tgl_prl',
                    'rph_aset', 'dasar_hrg',
                    'sumber', 'no_dana',
                    'tgl_dana', 'unit_pmk',
                    'alm_pmk', 'catatan',
                    'kondisi', 'tgl_buku',
                    'rphwajar', 'status',
                    'id', 'nama_unker', 'nama_unor', // Field from ext bangunan
                    'kode_unor', 'image_url', 'document_url',
                    'kd_gol', 'kd_bid', 'kd_kelompok', 'kd_skel', 'kd_sskel' // kode barang
                            , 'ur_sskel'
                            , 'kd_klasifikasi_aset', 'nama_klasifikasi_aset',
                    'kd_lvl1', 'kd_lvl2', 'kd_lvl3',
                    'darat_no_stnk', 'darat_masa_berlaku_stnk', 'darat_masa_berlaku_pajak',
                    'darat_jumlah_pajak', 'darat_keterangan_lainnya']
            });

            Dashboard.modelGrafikUnkerTotalAset = Ext.define('MGrafikUnkerTotalAset', {extend: 'Ext.data.Model',
                fields: ['kd_lokasi', 'ur_upb', 'totalAset']
            });

            Dashboard.modelGrafikKategoriBarangTotalAset = Ext.define('MGrafikKategoriBarangTotalAset', {extend: 'Ext.data.Model',
                fields: ['nama', 'totalAset']
            });

            Dashboard.modelAlertPemeliharaan = Ext.define('MAlertPemeliharaan', {extend: 'Ext.data.Model',
                fields: ['id', 'kd_brg', 'kd_lokasi', 'no_aset', 'total_penggunaan',
                    'kode_unor', 'nama_unker', 'nama_unor', 'jenis', 'nama',
                    'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 'kondisi',
                    'deskripsi', 'harga', 'kode_angaran', 'unit_waktu', 'unit_pengunaan', 'freq_waktu',
                    'freq_pengunaan', 'status', 'durasi', 'rencana_waktu',
                    'rencana_pengunaan', 'rencana_keterangan', 'alert', 'image_url', 'document_url', 'tanggal_kadaluarsa']
            });

            Dashboard.modelInventarisAssetUmum = Ext.define('MInventarisAssetUmum', {extend: 'Ext.data.Model',
                fields: ['kode_barang', 'kode_lokasi', 'no_aset', 'nama_unker', 'nama_barang', 'tanggal_perolehan', 'kondisi', 'merk',
                    'kd_brg', 'kd_lokasi', 'tipe', 'gol',
                    //tanah
                    'kd_lokasi', 'kd_brg', 'no_aset', // Field from asset tanah
                    'kuantitas', 'rph_aset', 'no_kib', 'luas_tnhs',
                    'luas_tnhb', 'luas_tnhl', 'luas_tnhk', 'kd_prov',
                    'kd_kab', 'kd_kec', 'kd_kel', 'kd_rtrw',
                    'alamat', 'batas_u', 'batas_s', 'batas_t',
                    'batas_b', 'jns_trn', 'sumber', 'dari',
                    'dasar_hrg', 'no_dana', 'tgl_dana', 'surat1',
                    'surat2', 'surat3', 'rph_m2', 'unit_pmk',
                    'alm_pmk', 'catatan', 'tgl_prl', 'tgl_buku',
                    'rphwajar', 'rphnjop', 'status', 'smilik',
                    'id', 'nama_unker', 'nama_unor', // Field from ext tanah
                    'kode_unor', 'image_url', 'document_url',
                    'nop', 'njkp', 'waktu_pembayaran', 'setoran_pajak', 'keterangan',
                    'kd_gol', 'kd_bid', 'kd_kelompok', 'kd_skel', 'kd_sskel', // kode barang
                    'ur_sskel',
                    , 'kd_klasifikasi_aset', 'nama_klasifikasi_aset',
                    'kd_lvl1', 'kd_lvl2', 'kd_lvl3'
                            //end tanah
                ]
            });
            
            Dashboard.DataAlertPerlengkapan = new Ext.create('Ext.data.Store', {
                id: 'Data_AlertPerlengkapan', storeId: 'DataAlertPerlengkapan', model: Dashboard.modelAlertPerlengkapan, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyAlertPerlengkapan, groupField: 'tipe'
            });
            
            Dashboard.DataMemo = new Ext.create('Ext.data.Store', {
                id: 'Data_Memo', storeId: 'DataMemo', model: Dashboard.modelMemo, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyMemo, groupField: 'tipe'
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
                proxy: Dashboard.proxyAlertPemeliharaan,
            });

            Dashboard.DataInventarisAssetUmum = new Ext.create('Ext.data.Store', {
                id: 'Data_InventarisAssetUmum', storeId: 'DataInventarisAssetUmum', model: Dashboard.modelInventarisAssetUmum, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyInventarisAssetUmum, groupField: 'tipe'
            });

            Dashboard.DataAlertPengadaan = new Ext.create('Ext.data.Store', {
                id: 'Data_AlertPengadaan', storeId: 'DataAlertPengadaan', model: Dashboard.modelAlertPengadaan, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyAlertPengadaan
            });

            Dashboard.DataAlertKendaraanDarat = new Ext.create('Ext.data.Store', {
                id: 'Data_AlertKendaraanDarat', storeId: 'DataAlertKendaraanDarat', model: Dashboard.modelAlertKendaraanDarat, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyAlertKendaraanDarat,
            });

            Dashboard.DataAlertPengelolaan = new Ext.create('Ext.data.Store', {
                id: 'Data_AlertPengelolaan', storeId: 'DataAlertPengelolaan', model: Dashboard.modelAlertPengelolaan, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyAlertPengelolaan,
            });

            Dashboard.DataAlertPendayagunaan = new Ext.create('Ext.data.Store', {
                id: 'Data_AlertPendayagunaan', storeId: 'DataAlertPendayagunaan', model: Dashboard.modelAlertPendayagunaan, noCache: false, autoLoad: true,
                proxy: Dashboard.proxyAlertPendayagunaan,
            });

            Ext.onReady(function(){
                var clock = Ext.create('Ext.toolbar.TextItem', {text: Ext.Date.format(new Date(), 'd M Y, g:i:s A')});

                var Content_Header = {
                    id: 'content-header', split: false, height: 40, border: false,
                    html: '<div style=\'padding:5px; color:#fff; font-weight:bold; background : #35537e url(' + '<?php echo base_url(); ?>' + 'assets/images/icons/layout-browser-hd-bg.gif) repeat-x;\'>SISTEM INFORMASI ASSET MANAJEMEN<br>BADAN SAR NASIONAL TAHUN <?php echo date("Y"); ?></div>',
                };

                var Content_MainMenu = {
                    id: 'content-mainmenu',
                    xtype: 'toolbar',
                    dock: 'bottom',
                    items: [/*'',
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
                     Load_TabPage('pemeliharaan_asset_kendaraan_darat', BASE_URL + 'pemeliharaan_darat');
                     },
                     },
                     {
                     text: 'Pemeliharaan Kendaraan Udara',
                     iconCls: 'icon-menu_impasing',
                     id: 'm_pemeliharaan_umum_kendaraan_udara',
                     handler: function() {
                     Load_TabPage('pemeliharaan_asset_kendaraan_udara', BASE_URL + 'pemeliharaan_udara');
                     },
                     },
                     {
                     text: 'Pemeliharaan Kendaraan Laut',
                     iconCls: 'icon-menu_impasing',
                     id: 'm_pemeliharaan_umum_kendaraan_laut',
                     handler: function() {
                     Load_TabPage('pemeliharaan_asset_kendaraan_laut', BASE_URL + 'pemeliharaan_laut');
                     },
                     },
                     {
                     text: 'Pemeliharaan Peralatan Lainnya',
                     iconCls: 'icon-menu_impasing',
                     id: 'm_pemeliharaan_umum_peralatan_lainnya',
                     handler: function() {
                     Load_TabPage('pemeliharaan_asset', BASE_URL + 'pemeliharaan');
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
                     {text: 'Peraturan', iconCls: 'icon-menu_impasing', id: 'm_peraturan',
                     handler: function()
                     {
                     Load_TabPage('peraturan', BASE_URL + 'peraturan');
                     }
                     },
                     {text: 'Pengelolaan', iconCls: 'icon-menu_impasing', id: 'm_pengelolaan',
                     handler: function()
                     {
                     Load_TabPage('pengelolaan', BASE_URL + 'pengelolaan')
                     }
                     },
                     
                     {text: 'Inventory', iconCls: 'icon-menu_impasing', id: 'm_inventory',
                     menu: {
                     items: [{
                     text: 'Penerimaan/Pemeriksaan ',
                     iconCls: 'icon-menu_impasing',
                     id: 'm_inventory_penerimaan_pemeriksaan',
                     handler: function() {
                     
                     Load_TabPage('inventory_penerimaan_pemeriksaan_panel', BASE_URL + 'inventory_penerimaan_pemeriksaan');
                     }
                     },
                     {
                     text: 'Penyimpanan',
                     iconCls: 'icon-menu_impasing',
                     id: 'm_inventory_penyimpanan',
                     handler: function() {
                     Load_TabPage('inventory_penyimpanan_panel', BASE_URL + 'inventory_penyimpanan');
                     }
                     },
                     {
                     text: 'Pengeluaran',
                     iconCls: 'icon-menu_impasing',
                     id: 'm_inventory_pengeluaran',
                     handler: function() {
                     Load_TabPage('inventory_pengeluaran_panel', BASE_URL + 'inventory_pengeluaran');
                     }
                     }]
                     }
                     }
                     ]
                     }
                     }, '-', {
                     text: 'MAP', icon: 'icon-map1', id: 'm_global_map',
                     handler: function() {
                     Load_TabPage('map_asset', BASE_URL + 'global_map');
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
                     },*/<?php echo $MenuDashboard; ?>,
                       {text:'MEMO', iconCls: 'icon-add',handler:function(){
                                Load_Popup('memo', BASE_URL + 'memo');
                       }},'->', {
                            text: 'Ubah Kata Sandi', iconCls: 'icon-key', handler: function(){
                                Load_Popup('winchangepass', BASE_URL + 'pengguna_login/ubahsandi');
                            }
                        }, {
                            text: 'Logout', iconCls: 'icon-minus-circle', handler: function(){
                                do_logout();
                            }
                        },
                        /*
                         {
                         text: 'MAP SEARCH', iconCls: 'icon-menu_diklat', id: 'm_map_search',
                         handler: function() {
                         Load_MapSearch('tanah_panel', BASE_URL + 'asset_tanah/tanah','DataTanah','107012500414500000KP');
                         }
                         },
                         */
                    ]
                };

                var Layout_Header = {id: 'layout-header', region: 'north', split: false, collapsible: false, border: false, items: [Content_Header, Content_MainMenu]};


                var search = [{
                        xtype: 'searchfield',
                        //id:settingGrid.search.id,
                        store: Dashboard.DataInventarisAssetUmum,
                        width: 220
                    }];

                var DashboardMyPanel = Ext.create('Ext.panel.Panel', {
                    height: 200,
                    renderTo: Ext.getBody(),
                    layout: {
                        type: 'hbox',
                        align: 'stretch',
                        padding: 5,
                    },
                    items: [{
                            title: 'Pencarian Asset',
                            id: 'dashboard_pencarian_aset',
                            xtype: 'grid',
                            store: Dashboard.DataInventarisAssetUmum,
                            flex: 1,
                            columns: [
                                {header: 'Nama Barang', dataIndex: 'nama_barang', width: 150},
                                {header: 'Kode Barang', dataIndex: 'kd_brg', width: 100},
                                {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150},
                                {header: 'No. Asset', dataIndex: 'no_aset', width: 60},
                                {header: 'Kategori', dataIndex: 'gol', width: 100},
                                {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                                {header: 'Merek', dataIndex: 'merk', width: 150},
                                {header: 'Tipe', dataIndex: 'type', width: 150}
                            ],
                            listeners: {
                                itemdblclick: function(thisx, record, item, index, e, eOpts){
                                    var data = record.data;
                                    if(data){
                                        if(data.id == null || data.id == undefined || new String(data.id).length <= 0){
                                            data['id'] = undefined;
                                            delete data['id'];
                                        }
                                        switch(data.gol){
                                            case 'Peralatan' : //peralatan
                                                Load_TabPage_Asset_Semar('alatbesar_panel', BASE_URL + 'asset_alatbesar/alatbesar', function(cmpx){
//												SemarObjTemp['AlatbesarGrid'] = Alatbesar.Grid.grid;
                                                    Alatbesar.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
//												Alatbesar.Action.edit();
                                                    var formData = null;
                                                    $.ajax({
                                                        url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                        type: "POST",
                                                        dataType: 'json',
                                                        async: false,
                                                        data: {jenis_asset: data.gol, kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                        success: function(response, status){
                                                            formData = response;

                                                        }
                                                    });

                                                    delete formData.nama_unker;
                                                    delete formData.nama_unor;
                                                    if(Modal.assetEdit.items.length === 0)
                                                    {
                                                        Modal.assetEdit.setTitle('Edit Peralatan');
                                                        Modal.assetEdit.add(Region.createSidePanel(Alatbesar.Window.actionSidePanels()));
                                                        Modal.assetEdit.add(Tab.create());
                                                    }
                                                    var _form = Alatbesar.Form.create(formData, true);
                                                    Tab.addToForm(_form, 'alatbesar-details', 'Simak Details');
                                                    Modal.assetEdit.show();


                                                });
                                                break;
                                            case 'Angkutan' : //angkurtan
                                                if(data.kd_brg){
                                                    if(data.kd_brg.split('')[4] == '1' || data.kd_brg.split('')[4] == '2'){
                                                        Load_TabPage_Asset_Semar('angkutan_darat_panel', BASE_URL + 'asset_angkutan_darat/angkutan_darat', function(cmpx){
//														SemarObjTemp['AngkutanDaratGrid'] = AngkutanDarat.Grid.grid;
                                                            AngkutanDarat.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
//														AngkutanDarat.Action.edit();
                                                            //AngkutanDarat.Grid.grid = SemarObjTemp['AngkutanDaratGrid'];
                                                            var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: "angkutan_darat", kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                            });
                                                            delete formData.nama_unker;
                                                            delete formData.nama_unor;

                                                            if(Modal.assetEdit.items.length === 0)
                                                            {
                                                                Modal.assetEdit.setTitle('Edit Angkutan Darat');
                                                                Modal.assetEdit.add(Region.createSidePanel(AngkutanDarat.Window.actionSidePanels()));
                                                                Modal.assetEdit.add(Tab.create());
                                                            }

                                                            var _form = AngkutanDarat.Form.create(formData, true);
                                                            Tab.addToForm(_form, 'angkutanDarat-details', 'Simak Details');
                                                            Modal.assetEdit.show();
                                                            AngkutanDarat.dataStorePerlengkapanAngkutanDarat.changeParams({params: {open: '1', id_ext_asset: formData.id}});
                                                            AngkutanDarat.dataStoreDetailPenggunaanAngkutan.changeParams({params: {open: '1', id_ext_asset: formData.id}});

                                                            AngkutanDarat.addDetailPenggunaan = function()
                                                            {
                                                                delete formData.nama_unker;
                                                                delete formData.nama_unor;

                                                                if(Modal.assetSecondaryWindow.items.length === 0)
                                                                {
                                                                    Modal.assetSecondaryWindow.setTitle('Tambah Penggunaan');
                                                                }
                                                                var form = Form.detailPenggunaanAngkutan(AngkutanDarat.URL.createUpdateDetailPenggunaanAngkutan, AngkutanDarat.dataStoreDetailPenggunaanAngkutan, false, 'darat');
                                                                form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(formData.id, 'darat'));
                                                                Modal.assetSecondaryWindow.add(form);
                                                                Modal.assetSecondaryWindow.show();
                                                            };

                                                            AngkutanDarat.addPerlengkapan = function()
                                                            {
                                                                    delete formData.nama_unker;
                                                                    delete formData.nama_unor;

                                                                    if(Modal.assetSecondaryWindow.items.length === 0)
                                                                    {
                                                                        Modal.assetSecondaryWindow.setTitle('Tambah Perlengkapan');
                                                                    }
                                                                    var form = Form.perlengkapanAngkutan(AngkutanDarat.URL.createUpdatePerlengkapanAngkutanDarat, AngkutanDarat.dataStorePerlengkapanAngkutanDarat, false);
                                                                    form.insert(0, Form.Component.dataPerlengkapanAngkutanDarat(formData.id));
                                                                    Modal.assetSecondaryWindow.add(form);
                                                                    Modal.assetSecondaryWindow.show();
                                                                    Reference.Data.assetPerlengkapanPart.changeParams({params: {id_open: 1}});

                                                                
                                                            };


                                                        });
                                                    } else if(data.kd_brg.split('')[4] == '3' || data.kd_brg.split('')[4] == '4'){
                                                        Load_TabPage_Asset_Semar('angkutan_laut_panel', BASE_URL + 'asset_angkutan_laut/angkutan_laut', function(cmpx){
//														SemarObjTemp['AngkutanLautGrid'] = AngkutanLaut.Grid.grid;
                                                            AngkutanLaut.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
                                                            var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: "angkutan_laut", kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                            });

                                                            delete data.nama_unker;
                                                            delete data.nama_unor;

                                                            if(Modal.assetEdit.items.length === 0)
                                                            {
                                                                Modal.assetEdit.setTitle('Edit Angkutan Laut');
                                                                Modal.assetEdit.add(Region.createSidePanel(AngkutanLaut.Window.actionSidePanels()));
                                                                Modal.assetEdit.add(Tab.create());
                                                            }
                                                            var _form = AngkutanLaut.Form.create(formData, true);
                                                            Tab.addToForm(_form, 'angkutanLaut-details', 'Simak Details');
                                                            Modal.assetEdit.show();
                                                            AngkutanLaut.dataStorePerlengkapanAngkutanLaut.changeParams({params: {open: '1', id_ext_asset: formData.id}});
                                                            AngkutanLaut.dataStoreDetailPenggunaanAngkutan.changeParams({params: {open: '1', id_ext_asset: formData.id}});
                                                            
                                                            AngkutanLaut.addDetailPenggunaan = function()
                                                            {
                                                                delete formData.nama_unker;
                                                                delete formData.nama_unor;

                                                                if(Modal.assetSecondaryWindow.items.length === 0)
                                                                {
                                                                    Modal.assetSecondaryWindow.setTitle('Tambah Penggunaan');
                                                                }
                                                                var form = Form.detailPenggunaanAngkutan(AngkutanLaut.URL.createUpdateDetailPenggunaanAngkutan, AngkutanLaut.dataStoreDetailPenggunaanAngkutan, false, 'laut');
                                                                form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(formData.id, 'laut'));
                                                                Modal.assetSecondaryWindow.add(form);
                                                                Modal.assetSecondaryWindow.show();
                                                            };

                                                            AngkutanLaut.addPerlengkapan = function()
                                                            {
                                                                    delete formData.nama_unker;
                                                                    delete formData.nama_unor;

                                                                    if(Modal.assetSecondaryWindow.items.length === 0)
                                                                    {
                                                                        Modal.assetSecondaryWindow.setTitle('Tambah Perlengkapan');
                                                                    }
                                                                    var form = Form.perlengkapanAngkutan(AngkutanLaut.URL.createUpdatePerlengkapanAngkutanLaut, AngkutanLaut.dataStorePerlengkapanAngkutanLaut, false);
                                                                    form.insert(0, Form.Component.dataPerlengkapanAngkutanLaut(formData.id));
                                                                    Modal.assetSecondaryWindow.add(form);
                                                                    Modal.assetSecondaryWindow.show();
                                                                    Reference.Data.assetPerlengkapanPart.changeParams({params: {id_open: 1}});
                                                            };

                                                                    
//														AngkutanLaut.Action.edit();
                                                            //AngkutanLaut.Grid.grid = SemarObjTemp['AngkutanLautGrid'];
                                                        });
                                                    } else if(data.kd_brg.split('')[4] == '5'){
                                                        Load_TabPage_Asset_Semar('angkutan_udara_panel', BASE_URL + 'asset_angkutan_udara/angkutan_udara', function(cmpx){
//                                                            SemarObjTemp['AngkutanUdaraGrid'] = AngkutanUdara.Grid.grid;
                                                            AngkutanUdara.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
//                                                            AngkutanUdara.Action.edit();
                                                            //AngkutanUdara.Grid.grid = SemarObjTemp['AngkutanUdaraGrid'];
                                                            var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: "angkutan_udara", kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                            });

                                                            delete formData.nama_unker;
                                                            delete formData.nama_unor;

                                                            if (Modal.assetEdit.items.length === 0)
                                                            {
                                                                Modal.assetEdit.setTitle('Edit Angkutan Udara');
                                                                Modal.assetEdit.add(Region.createSidePanel(AngkutanUdara.Window.actionSidePanels()));
                                                                Modal.assetEdit.add(Tab.create());
                                                            }
                                                                var _form = AngkutanUdara.Form.create(formData, true);
                                                                Tab.addToForm(_form, 'angkutanUdara-details', 'Simak Details');
                                                                Modal.assetEdit.show();
                                                                AngkutanUdara.dataStorePerlengkapanAngkutanUdara.changeParams({params:{open:'1',id_ext_asset:formData.id}});
                                                                AngkutanUdara.dataStoreDetailPenggunaanAngkutanUdara.changeParams({params:{open:'1',id_ext_asset:formData.id}});
                                                            
                                                                AngkutanUdara.addDetailPenggunaan = function()
                                                                {
                                                                        delete formData.nama_unker;
                                                                        delete formData.nama_unor;

                                                                        if (Modal.assetSecondaryWindow.items.length === 0)
                                                                        {
                                                                            Modal.assetSecondaryWindow.setTitle('Tambah Penggunaan');
                                                                        }
                                                                            var form = Form.detailPenggunaanAngkutanUdara(AngkutanUdara.URL.createUpdateDetailPenggunaanAngkutanUdara, AngkutanUdara.dataStoreDetailPenggunaanAngkutanUdara, false,'1');
                                                                            form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(formData.id,'udara'));
                                                                            Modal.assetSecondaryWindow.add(form);
                                                                            Modal.assetSecondaryWindow.show();
                                                                };
                                                                
                                                                AngkutanUdara.addPerlengkapan = function()
                                                                {
                                                                        var data = selected[0].data;
                                                                        delete data.nama_unker;
                                                                        delete data.nama_unor;
                                                                        if (Modal.assetSecondaryWindow.items.length === 0)
                                                                        {
                                                                            Modal.assetSecondaryWindow.setTitle('Tambah Perlengkapan');
                                                                        }
                                                                            var form = Form.perlengkapanAngkutan(AngkutanUdara.URL.createUpdatePerlengkapanAngkutanUdara, AngkutanUdara.dataStorePerlengkapanAngkutanUdara, false);
                                                                            form.insert(0, Form.Component.dataPerlengkapanAngkutanUdara(formData.id));
                                                                            Modal.assetSecondaryWindow.add(form);
                                                                            Modal.assetSecondaryWindow.show();
                                                                            Reference.Data.assetPerlengkapanPart.changeParams({params: {id_open: 1}});
                                                                };
                                                            
                                                        });
                                                    }
                                                }
                                                break;
                                            case 'Bangunan' : //Bangunan
                                                Load_TabPage_Asset_Semar('bangunan_panel', BASE_URL + 'asset_bangunan/bangunan', function(cmpx){

//                                                    SemarObjTemp['BangunanGrid'] = Bangunan.Grid.grid;
//
                                                    Bangunan.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
                                                    var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: data.gol, kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                     });
                                                    delete formData.nama_unker;
                                                    delete formData.nama_unor;


                                                    if (Modal.assetEdit.items.length <= 1)
                                                    {
                                                        Modal.assetEdit.setTitle('Edit Bangunan');
                                                        Modal.assetEdit.insert(0, Region.createSidePanel(Bangunan.Window.actionSidePanels()));
                                                        Modal.assetEdit.add(Tab.create());
                                                    }

                                                        var _form = Bangunan.Form.create(formData, true);
                                                        Tab.addToForm(_form, 'bangunan-details', 'Simak Details');
                                                        Modal.assetEdit.show();
                                                        Bangunan.dataStoreRiwayatPajak.changeParams({params:{open:'1',id_ext_asset:formData.id}});
                                                        
                                                        Bangunan.addRiwayatPajak = function()
                                                        {
                                                                delete formData.nama_unker;
                                                                delete formData.nama_unor;

                                                                if (Modal.assetSecondaryWindow.items.length === 0)
                                                                {
                                                                    Modal.assetSecondaryWindow.setTitle('Tambah Riwayat Pajak');
                                                                }
                                                                var uploadRiwayatPajak = {
                                                                        xtype: 'fieldset',
                                                                        itemId: 'fileUpload',
                                                                        layout: 'column',
                                                                        border: false,
                                                                        title: 'FILE UPLOAD',
                                                                        defaultType: 'container',
                                                                        style: {
                                                                            marginTop: '10px'
                                                                        },
                                                                        items: [{
                                                                        columnWidth: .99,
                                                                        layout: 'anchor',
                                                                        defaults: {
                                                                            anchor: '95%'
                                                                        },
                                                                        items:[Form.Component.fileUploadDocumentOnly('file_setoran','BangunanRiwayatPajakFile')]
                                                                    }]
                                                                    };

                                                                    var form = Form.riwayatPajak(Bangunan.URL.createUpdateRiwayatPajak, Bangunan.dataStoreRiwayatPajak, false,'bangunan');
                                                                    form.insert(0, Form.Component.dataRiwayatPajakTanahDanBangunan(formData.id));
                                                                    form.insert(1, uploadRiwayatPajak);
                                                                    Modal.assetSecondaryWindow.add(form);
                                                                    Modal.assetSecondaryWindow.show();

                                                            
                                                        };
//                                                    Bangunan.Action.edit();

                                                    //Bangunan.Grid.grid = SemarObjTemp['BangunanGrid'];
                                                });
                                                break;
                                            case 'Dil' : //luar
                                                Load_TabPage_Asset_Semar('luar_panel', BASE_URL + 'asset_luar/luar', function(cmpx){
//                                                    SemarObjTemp['LuarGrid'] = Luar.Grid.grid;
//
                                                    Luar.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
                                                    var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: data.gol, kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                    });
                                                    delete formData.nama_unker;
                                                    delete formData.nama_unor;

                                                    if (Modal.assetEdit.items.length === 0)
                                                    {
                                                        Modal.assetEdit.setTitle('Edit Luar');
                                                        Modal.assetEdit.add(Region.createSidePanel(Luar.Window.actionSidePanels()));
                                                        Modal.assetEdit.add(Tab.create());
                                                    }
                                                    var _form = Luar.Form.create(formData, true);
                                                    Tab.addToForm(_form, 'luar-details', 'Simak Details');
                                                    Modal.assetEdit.show();
//                                                    Luar.Action.edit();

                                                    //Luar.Grid.grid = SemarObjTemp['LuarGrid'];
                                                });
                                                break;
                                            case 'Perairan' : //Perairan
                                                Load_TabPage_Asset_Semar('perairan_panel', BASE_URL + 'asset_perairan/perairan', function(cmpx){
//                                                    SemarObjTemp['PerairanGrid'] = Perairan.Grid.grid;
//
                                                    Perairan.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
//                                                    Perairan.Action.edit();

                                                    //Perairan.Grid.grid = SemarObjTemp['PerairanGrid'];
                                                    
                                                    var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: data.gol, kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                    });
                                                    delete formData.nama_unker;
                                                    delete formData.nama_unor;

                                                    if (Modal.assetEdit.items.length === 0)
                                                    {
                                                        Modal.assetEdit.setTitle('Edit Perairan');
                                                        Modal.assetEdit.add(Region.createSidePanel(Perairan.Window.actionSidePanels()));
                                                        Modal.assetEdit.add(Tab.create());
                                                    }

                                                    var _form = Perairan.Form.create(formData, true);
                                                    Tab.addToForm(_form, 'perairan-details', 'Simak Details');
                                                    Modal.assetEdit.show();
                                                });
                                                break;
                                            case 'Ruang' : //Ruang
                                                Load_TabPage_Asset_Semar('ruang_panel', BASE_URL + 'asset_ruang/ruang', function(cmpx){
//                                                    SemarObjTemp['RuangGrid'] = Ruang.Grid.grid;
//
                                                    Ruang.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
//                                                    Ruang.Action.edit();

                                                    //Ruang.Grid.grid = SemarObjTemp['RuangGrid'];
                                                    
                                                    var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: data.gol, kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                    });
                                                    
                                                    delete formData.nama_unker;
                                                    delete formData.nama_unor;
                                                    
                                                    if (Modal.assetEdit.items.length <= 1)
                                                    {
                                                        Modal.assetEdit.setTitle('Edit Ruang');
                                                        Modal.assetEdit.insert(0, Region.createSidePanel(Ruang.Window.actionSidePanels()));
                                                        Modal.assetEdit.add(Tab.create());
                                                    }

                                                    var _form = Ruang.Form.create(formData, true);
                                                    Tab.addToForm(_form, 'bangunan-details', 'Simak Details');
                                                    Modal.assetEdit.show();
                                                });
                                                break;
                                            case 'Senjata' : //Senjata
                                                Load_TabPage_Asset_Semar('senjata_panel', BASE_URL + 'asset_senjata/senjata', function(cmpx){
//                                                    SemarObjTemp['SenjataGrid'] = Senjata.Grid.grid;
//
                                                    Senjata.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
//                                                    Senjata.Action.edit();

                                                    //Senjata.Grid.grid = SemarObjTemp['SenjataGrid'];
                                                    
                                                    var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: data.gol, kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                    });
                                                    
                                                    delete formData.nama_unker;
                                                    delete formData.nama_unor;

                                                    if (Modal.assetEdit.items.length === 0)
                                                    {
                                                        Modal.assetEdit.setTitle('Edit Senjata');
                                                        Modal.assetEdit.add(Region.createSidePanel(Senjata.Window.actionSidePanels()));
                                                        Modal.assetEdit.add(Tab.create());
                                                    }

                                                    var _form = Senjata.Form.create(formData, true);
                                                    Tab.addToForm(_form, 'senjata-details', 'Simak Details');
                                                    Modal.assetEdit.show();
                                                });
                                                break;
                                            case 'Tanah' : //Tanah
                                                Load_TabPage_Asset_Semar('tanah_panel', BASE_URL + 'asset_tanah/tanah', function(cmpx){
//                                                    SemarObjTemp['TanahGrid'] = Tanah.Grid.grid;
                                                    Tanah.Grid.grid = Ext.getCmp('dashboard_pencarian_aset');
//                                                    Tanah.Action.edit();
                                                    //Tanah.Grid.grid = SemarObjTemp['TanahGrid'];
                                                    var formData = null;
                                                            $.ajax({
                                                                url: BASE_URL + 'dashboard/cari_global_getFormData',
                                                                type: "POST",
                                                                dataType: 'json',
                                                                async: false,
                                                                data: {jenis_asset: data.gol, kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                                success: function(response, status){
                                                                    formData = response;

                                                                }
                                                    });
                                                    
                                                    delete formData.nama_unker;
                                                    delete formData.nama_unor;

                                                    if (Modal.assetEdit.items.length === 0)
                                                    {
                                                        Modal.assetEdit.setTitle('Edit Tanah');
                                                        Modal.assetEdit.add(Region.createSidePanel(Tanah.Window.actionSidePanels()));
                                                        Modal.assetEdit.add(Tab.create());
                                                    }

                                                        var _form = Tanah.Form.create(formData, true);
                                                        Tab.addToForm(_form, 'tanah-details', 'Simak Details');
                                                        Modal.assetEdit.show();
                                                        Tanah.dataStoreRiwayatPajak.changeParams({params:{open:'1',id_ext_asset:formData.id}});
                                                    
                                                    Tanah.addRiwayatPajak = function()
                                                    {
                                                            delete data.nama_unker;
                                                            delete data.nama_unor;

                                                            if (Modal.assetSecondaryWindow.items.length === 0)
                                                            {
                                                                Modal.assetSecondaryWindow.setTitle('Tambah Riwayat Pajak');
                                                            }
                                                                var uploadRiwayatPajak = {
                                                                    xtype: 'fieldset',
                                                                    itemId: 'fileUpload',
                                                                    layout: 'column',
                                                                    border: false,
                                                                    title: 'FILE UPLOAD',
                                                                    defaultType: 'container',
                                                                    style: {
                                                                        marginTop: '10px'
                                                                    },
                                                                    items: [{
                                                                    columnWidth: .99,
                                                                    layout: 'anchor',
                                                                    defaults: {
                                                                        anchor: '95%'
                                                                    },
                                                                    items:[Form.Component.fileUploadDocumentOnly('file_setoran','TanahRiwayatPajakFile')]
                                                                }]
                                                                };

                                                                var form = Form.riwayatPajak(Tanah.URL.createUpdateRiwayatPajak, Tanah.dataStoreRiwayatPajak, false,'tanah');
                                                                form.insert(0, Form.Component.dataRiwayatPajakTanahDanBangunan(formData.id));
                                                                form.insert(1, uploadRiwayatPajak);
                                                                Modal.assetSecondaryWindow.add(form);
                                                                Modal.assetSecondaryWindow.show();

                                                        

                                                    };
                                                });
                                                break;
                                        }
                                    }
                                    ;
                                }
                            },
                            dockedItems: [
                                {xtype: 'toolbar',
                                    dock: 'top',
                                    items: [
                                        {
                                            text: 'Clear Filter  ', iconCls: 'icon-filter_clear',
                                            handler: function(){
                                                // _grid.filters.clearFilters();
                                            }
                                        }, search
                                    ]}
                            ]

                        }
                    ]
                });


                var GridAlertPerlengkapan = Ext.create('Ext.grid.Panel', {
                    title: 'Alert Perlengkapan',
                    id:'dashboard_grid_alert_perlengkapan',
                    store: Dashboard.DataAlertPerlengkapan,
                    tools: [{
                            type: 'refresh',
                            tooltip: 'Load Ulang Data',
                            handler: function(event, toolEl, panel){
                                Dashboard.DataAlertPerlengkapan.load();
                            }
                        }],
                    columns: [
                        {
                            xtype: 'actioncolumn', width: 30,
                            items: [{
                                    icon: '../basarnas/assets/images/icons/edit.png',
                                    tooltip: 'Ubah',
                                    handler: function(grid, rowIndex, colIndex, obj)
                                    {
                                        var gridStore = grid.getStore();
                                        var data = gridStore.getAt(rowIndex).data;
                                      
                                      Load_TabPage_Asset_Semar('perlengkapan_panel', BASE_URL + 'asset_perlengkapan/perlengkapan', function(cmpx){    
                                                Perlengkapan.Action.pemeliharaanAdd = function()
                                                {
                                                    var dataForm = {
                                                        kd_lokasi: data.kd_lokasi,
                                                        kd_brg: data.kd_brg,
                                                        no_aset: data.no_aset
                                                    };

                                                    var form = Perlengkapan.Form.createPemeliharaan(Perlengkapan.dataStorePemeliharaan, dataForm, false);

                                        //            Tab.addToForm(form, 'asset_perlengkapan-add-pemeliharaan', 'Add Pemeliharaan');
                                                        if (Modal.assetSecondaryWindow.items.length === 0)
                                                        {
                                                            Modal.assetSecondaryWindow.setTitle('Tambah Pemeliharaan');
                                                        }
                                                        Modal.assetSecondaryWindow.add(form);
                                                        Modal.assetSecondaryWindow.show();
                                                };
                                                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.kd_lokasi = data.kd_lokasi;
                                                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.kd_brg = data.kd_brg;
                                                Perlengkapan.dataStorePemeliharaan.getProxy().extraParams.no_aset = data.no_aset;
                                                Perlengkapan.dataStorePemeliharaan.load();
                                                var toolbarIDs = {};
                                                toolbarIDs.idGrid = "asset_perlengkapan_grid_pemeliharaan";
                                                toolbarIDs.add = Perlengkapan.Action.pemeliharaanAdd;
                                                toolbarIDs.remove = Perlengkapan.Action.pemeliharaanRemove;
                                                toolbarIDs.edit = Perlengkapan.Action.pemeliharaanEdit;
                                                var setting = {
                                                    data: data,
                                                    dataStore: Perlengkapan.dataStorePemeliharaan,
                                                    toolbar: toolbarIDs,
                                                    isPerlengkapan: true,
                                                    dataMainGrid: Perlengkapan.data,
                                                };
                                                
                                                if (Modal.assetCreate.items.length <= 1)
                                                {
                                                    Modal.assetCreate.setTitle('Edit Perlengkapan');
                                                }
                                                
                                                var _perlengkapanPemeliharaanGrid = Grid.pemeliharaanPerlengkapanGrid(setting);
//                                                Tab.addToForm(_perlengkapanPemeliharaanGrid, 'perlengkapan-pemeliharaan', 'Pemeliharaan');
                                                Modal.assetCreate.addListener("close", function(){ gridStore.load() }, this);
                                                Modal.assetCreate.add(_perlengkapanPemeliharaanGrid);
                                                Modal.assetCreate.show();
                                                
                                                
                                                
                                                
                                      });
                                        
                                    }
                            }]
                        },
                        {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                        {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 150},
                        {header: 'No Induk Asset', dataIndex: 'no_induk_asset', width: 150},
                        {header: 'Nama Part', dataIndex: 'nama_part', width: 150},
                        {header: 'Part Number', dataIndex: 'part_number', width: 150},
                        {header: 'Serial Number', dataIndex: 'serial_number', width: 150},
                        {header: 'Sisa Umur', dataIndex: 'umur', width: 150},
                    ],
                    height: 200,
                });
                
                 var GridAlertPemeliharaan = Ext.create('Ext.grid.Panel', {
                    title: 'Alert Pemeliharaan',
                    store: Dashboard.DataAlertPemeliharaan,
                    tools: [{
                            type: 'refresh',
                            tooltip: 'Load Ulang Data',
                            handler: function(event, toolEl, panel){
                                Dashboard.DataAlertPemeliharaan.load();
                            }
                        }],
                    columns: [
                        {
                            xtype: 'actioncolumn', width: 30,
                            items: [{
                                    icon: '../basarnas/assets/images/icons/edit.png',
                                    tooltip: 'Ubah',
                                    handler: function(grid, rowIndex, colIndex, obj)
                                    {
                                        var gridStore = grid.getStore();
                                        var data = gridStore.getAt(rowIndex).data;
                                        AlertPemeliharaan.data = data;
                                        AlertPemeliharaan.store = gridStore;
                                        var golongan = data.kd_brg.substr(0,5);
                                        if(golongan == '30201' || golongan == '30202') //Pemeliharan Angkutan Darat
                                        {
                                            Load_Dashboard_Pemeliharaan_Data('pemeliharaan_asset_kendaraan_darat', BASE_URL + 'pemeliharaan_darat', function(cmpx){
                                                    var data =  AlertPemeliharaan.data;
                                                    delete data.nama_unker;

                                                    if (Modal.processEdit.items.length === 0)
                                                    {
                                                        Modal.processEdit.setTitle('Edit Pemeliharaan Darat');
                                                    }

                                                     var id_ext_asset = 0;
                                                    $.ajax({
                                                           url:BASE_URL + 'asset_angkutan_darat/getIdExtAsset',
                                                           type: "POST",
                                                           dataType:'json',
                                                           async:false,
                                                           data:{kd_brg:data.kd_brg, kd_lokasi:data.kd_lokasi, no_aset:data.no_aset},
                                                           success:function(response, status){
                                                            if(status == 'success')
                                                            {
                                                                id_ext_asset = response.idExt;
                                                                PemeliharaanDarat.dataStorePemeliharaanParts.changeParams({params:{id_ext_asset:id_ext_asset}});
                                                                PemeliharaanDarat.dataStorePemeliharaanParts.removed = [];
                                                            }     
                                                           }
                                                        });

                                                    $.ajax({
                                                        url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                                                        type: "POST",
                                                        dataType:'json',
                                                        async:false,
                                                        data:{tipe_angkutan:'darat',id_ext_asset:id_ext_asset},
                                                        success:function(response, status){
                                                         if(response.status == 'success')
                                                         {
                                                             data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Km';
                                                         }

                                                        }
                                                     });

                                                    var _form = PemeliharaanDarat.Form.create(data, true);
                                                    Modal.processEdit.addListener("close", function(){ AlertPemeliharaan.store.load() }, this);
                                                    Modal.processEdit.add(_form);
                                                    Modal.processEdit.show();
                                                    
                                                });
                                        }
                                        else if(golongan == '30203' || golongan == '30204') //Pemeliharaan Angkutan Laut
                                        {
                                            Load_Dashboard_Pemeliharaan_Data('pemeliharaan_asset_kendaraan_laut', BASE_URL + 'pemeliharaan_laut', function(cmpx){
                                                    var data =  AlertPemeliharaan.data;
                                                    delete data.nama_unker;

                                                    if (Modal.processEdit.items.length === 0)
                                                    {
                                                        Modal.processEdit.setTitle('Edit Pemeliharaan Laut');
                                                    }
                                                     var id_ext_asset = 0;
                                                    $.ajax({
                                                           url:BASE_URL + 'asset_angkutan_laut/getIdExtAsset',
                                                           type: "POST",
                                                           dataType:'json',
                                                           async:false,
                                                           data:{kd_brg:data.kd_brg, kd_lokasi:data.kd_lokasi, no_aset:data.no_aset},
                                                           success:function(response, status){
                                                            if(status == 'success')
                                                            {
                                                                id_ext_asset = response.idExt;
                                                                PemeliharaanLaut.dataStorePemeliharaanParts.changeParams({params:{id_ext_asset:id_ext_asset}});
                                                                PemeliharaanLaut.dataStorePemeliharaanParts.removed = [];
                                                            }     
                                                           }
                                                        });

                                                    $.ajax({
                                                        url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                                                        type: "POST",
                                                        dataType:'json',
                                                        async:false,
                                                        data:{tipe_angkutan:'laut',id_ext_asset:id_ext_asset},
                                                        success:function(response, status){
                                                         if(response.status == 'success')
                                                         {
                                                             data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Jam';
                                                         }

                                                        }
                                                     });
                                                    var _form = PemeliharaanLaut.Form.create(data, true);
                                                    Modal.processEdit.addListener("close", function(){ AlertPemeliharaan.store.load() }, this);
                                                    Modal.processEdit.add(_form);
                                                    Modal.processEdit.show();
                                                });
                                        }
                                        else if(golongan == '30205') //Pemeliharaan Angkutan Udara
                                        {
                                            Load_Dashboard_Pemeliharaan_Data('pemeliharaan_asset_kendaraan_udara', BASE_URL + 'pemeliharaan_udara', function(cmpx){
                                                    var data =  AlertPemeliharaan.data;
                                                    delete data.nama_unker;

                                                    if (Modal.processEdit.items.length === 0)
                                                    {
                                                        Modal.processEdit.setTitle('Edit Pemeliharaan Udara');
                                                    }
                                                    var id_ext_asset = 0;
                                                    $.ajax({
                                                           url:BASE_URL + 'asset_angkutan_udara/getIdExtAsset',
                                                           type: "POST",
                                                           dataType:'json',
                                                           async:false,
                                                           data:{kd_brg:data.kd_brg, kd_lokasi:data.kd_lokasi, no_aset:data.no_aset},
                                                           success:function(response, status){
                                                            if(status == 'success')
                                                            {
                                                                id_ext_asset = response.idExt;
                                                                PemeliharaanUdara.dataStorePemeliharaanParts.changeParams({params:{id_ext_asset:id_ext_asset}});
                                                                PemeliharaanUdara.dataStorePemeliharaanParts.removed = [];
                                                            }     
                                                           }
                                                        });

                                                    $.ajax({
                                                        url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaanAngkutanUdara',
                                                        type: "POST",
                                                        dataType:'json',
                                                        async:false,
                                                        data:{tipe_angkutan:'udara',id_ext_asset:id_ext_asset},
                                                        success:function(response, status){
                                                         if(response.status == 'success')
                                                         {
                                                             if(response.total_mesin1 == null)
                                                             {
                                                                 response.total_mesin1 = 0;
                                                             }

                                                             if(response.total_mesin2 == null)
                                                             {
                                                                 response.total_mesin2 = 0;
                                                             }
                                                             var total_penggunaan_mesin1 = response.total_mesin1 + ' Jam';
                                                             var total_penggunaan_mesin2 = response.total_mesin2 + ' Jam';

                                                             data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = 'Mesin 1:' + total_penggunaan_mesin1  +'<br />' + 'Mesin 2:' + total_penggunaan_mesin2;
                                                         }

                                                        }
                                                     });

                                                    var _form = PemeliharaanUdara.Form.create(data, true);
                                                    Modal.processEdit.addListener("close", function(){ AlertPemeliharaan.store.load() }, this);
                                                    Modal.processEdit.add(_form);
                                                    Modal.processEdit.show();
                                                });
                                        }
                                        else //Others
                                        {
                                            Load_Dashboard_Pemeliharaan_Data('pemeliharaan_asset', BASE_URL + 'pemeliharaan', function(cmpx){
                                                    var data =  AlertPemeliharaan.data;
                                                    delete data.nama_unker;

                                                    if (Modal.processEdit.items.length === 0)
                                                    {
                                                        Modal.processEdit.setTitle('Edit Pemeliharaan');
                                                    }
                                                    var _form = Pemeliharaan.Form.create(data, true);
                                                    Modal.processEdit.addListener("close", function(){ AlertPemeliharaan.store.load() }, this);
                                                    Modal.processEdit.add(_form);
                                                    Modal.processEdit.show();
                                    //                 Pemeliharaan.dataStorePemeliharaanParts.changeParams({params:{id_pemeliharaan:data.id}});
                                    //                Pemeliharaan.dataStorePemeliharaanParts.removed = [];
                                                });
                                        }
//                                      Ext.Msg.alert('Status','Not Yet Implemented');
                                        
                                    }
                            }]
                        },
                        {header: 'Unit Pemeliharaan', dataIndex: 'unit_waktu', width: 100,
                            renderer: function(value){
                                if(value == '1')
                                {
                                    return "Waktu";
                                }
                                else if(value == '0')
                                {
                                    return "Penggunaan";
                                }
                                else
                                {
                                    return "ERROR";
                                }
                            }},
                        {header: 'Tanggal Expire', dataIndex: 'rencana_waktu', width: 150,
                            renderer: function(value){
                                if(value === '0000-00-00')
                                {
                                    return "";
                                }
                                else
                                {
                                    return value;
                                }
                            }},
                        {header: 'Total Penggunaan', dataIndex: 'total_penggunaan', width: 150},
                        {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                        {header: 'Kode Barang', dataIndex: 'kd_brg', width: 200},
                        {header: 'Nama Aset', dataIndex: 'nama', width: 200},
                    ],
                    height: 200,
                });
                
                var GridMemo = Ext.create('Ext.grid.Panel', {
                    title: 'Memo',
                    store: Dashboard.DataMemo,
                    tools: [{
                            type: 'refresh',
                            tooltip: 'Load Ulang Data',
                            handler: function(event, toolEl, panel){
                                Dashboard.DataMemo.load();
                            }
                        }],
                    columns: [
                        {xtype: 'actioncolumn', width: 30,
                            items: [{
                                    icon: '../basarnas/assets/images/icons/check.gif',
                                    tooltip: 'Tandai sudah dilihat',
                                    handler: function(grid, rowIndex, colIndex, obj)
                                    {
                                        var gridStore = grid.getStore();
                                        var id = gridStore.getAt(rowIndex).data.id;
                                        $.ajax({
                                            type: "POST",
                                            url: BASE_URL + 'memo/isRead',
                                            data: {id: id},
                                            dataType: 'json',
                                            async: false,
                                            success: function(response, status)
                                            {
                                                gridStore.load();
                                            }
                                        });
                                    }
                                }]
                        },
                        {header: 'Tanggal Dibuat', dataIndex: 'date_created', width:150},
                        {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                        {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 150},
                        {header: 'Isi', dataIndex:'isi', width:300},
                        {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150},
                        {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 200},
                        {header: 'No Aset', dataIndex: 'no_aset', width: 200},
                        {header: 'Nama Barang', dataIndex:'nama', width:150},
                        {header: 'Dibuat Oleh', dataIndex:'created_by', width:150},
                        
                        
                    ],
                    height: 200,
                });

                var GridAlertPengadaan = Ext.create('Ext.grid.Panel', {
                    title: 'Alert Pengadaan',
                    store: Dashboard.DataAlertPengadaan,
                    tools: [{
                            type: 'refresh',
                            tooltip: 'Load Ulang Data',
                            handler: function(event, toolEl, panel){
                                Dashboard.DataAlertPengadaan.load();
                            }
                        }],
                    columns: [
                        {xtype: 'actioncolumn', width: 30,
                            items: [{
                                    icon: '../basarnas/assets/images/icons/check.gif',
                                    tooltip: 'Tandai sudah dilihat',
                                    handler: function(grid, rowIndex, colIndex, obj)
                                    {
                                        var gridStore = grid.getStore();
                                        var id = gridStore.getAt(rowIndex).data.id;
                                        $.ajax({
                                            type: "POST",
                                            url: BASE_URL + 'pengadaan/alertPengadaanAction',
                                            data: {id: id},
                                            dataType: 'json',
                                            async: false,
                                            success: function(response, status)
                                            {
                                                gridStore.load();
                                            }
                                        });
                                    }
                                }]
                        },
                        {header: 'Tanggal Expire Garansi', dataIndex: 'tanggal_garansi_expired', width: 150},
                        {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                        {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150},
                        {header: 'Nama Aset', dataIndex: 'nama', width: 200},
                    ],
                    height: 200,
                });

                var GridAlertKendaraan = Ext.create('Ext.grid.Panel', {
                    title: 'Alert Kendaraan Darat',
                    store: Dashboard.DataAlertKendaraanDarat,
                    tools: [{
                            type: 'refresh',
                            tooltip: 'Load Ulang Data',
                            handler: function(event, toolEl, panel){
                                Dashboard.DataAlertKendaraanDarat.load();
                            }
                        }],
                    columns: [
                        {xtype: 'actioncolumn', width: 30,
                            items: [{
                                    icon: '../basarnas/assets/images/icons/edit.png',
                                    tooltip: 'Ubah',
                                    handler: function(grid, rowIndex, colIndex, obj)
                                    {
                                        var gridStore = grid.getStore();
                                        var data = gridStore.getAt(rowIndex).data;
                                        AlertKendaraanDarat.data = data;
                                        AlertKendaraanDarat.store = gridStore;

                                        AlertKendaraanDarat.URL = {
                                            read: BASE_URL + 'asset_angkutan_darat/getAllData',
                                            createUpdate: BASE_URL + 'asset_angkutan_darat/modifyAngkutanDarat',
                                            remove: BASE_URL + 'asset_angkutan_darat/deleteAngkutanDarat',
                                            createUpdatePemeliharaan: BASE_URL + 'Pemeliharaan/modifyPemeliharaan',
                                            removePemeliharaan: BASE_URL + 'Pemeliharaan/deletePemeliharaan',
                                            createUpdatePerlengkapanAngkutanDarat: BASE_URL + 'asset_angkutan_darat/modifyPerlengkapanAngkutanDarat',
                                            removePerlengkapanAngkutanDarat: BASE_URL + 'asset_angkutan_darat/deletePerlengkapanAngkutanDarat',
                                            createUpdatePendayagunaan: BASE_URL + 'pendayagunaan/modifyPendayagunaan',
                                            removePendayagunaan: BASE_URL + 'pendayagunaan/deletePendayagunaan',
                                            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
                                            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart',
                                            createUpdateDetailPenggunaanAngkutan: BASE_URL + 'asset_angkutan_detail_penggunaan/modifyDetailPenggunaanAngkutan',
                                            removeDetailPenggunaanAngkutan: BASE_URL + 'asset_angkutan_detail_penggunaan/deleteDetailPenggunaanAngkutan',
                                            createUpdatePengelolaan: BASE_URL + 'pengelolaan/modifyPengelolaan',
                                            removePengelolaan: BASE_URL + 'pengelolaan/deletePengelolaan'

                                        };

                                        AlertKendaraanDarat.dataStorePerlengkapanAngkutanDarat = new Ext.create('Ext.data.Store', {
                                            model: MAngkutanDaratPerlengkapan, autoLoad: false, noCache: false,
                                            proxy: new Ext.data.AjaxProxy({
                                                url: BASE_URL + 'asset_angkutan_darat/getSpecificPerlengkapanAngkutanDarat', actionMethods: {read: 'POST'},
                                                reader: new Ext.data.JsonReader({
                                                    root: 'results', totalProperty: 'total', idProperty: 'id'})
                                            })
                                        });

                                        AlertKendaraanDarat.dataStoreDetailPenggunaanAngkutan = new Ext.create('Ext.data.Store', {
                                            model: MDetailPenggunaanAngkutan, autoLoad: false, noCache: false,
                                            proxy: new Ext.data.AjaxProxy({
                                                url: BASE_URL + 'asset_angkutan_detail_penggunaan/getSpecificDetailPenggunaanAngkutan', actionMethods: {read: 'POST'},
                                                reader: new Ext.data.JsonReader({
                                                    root: 'results', totalProperty: 'total', idProperty: 'id'})
                                            })
                                        });

                                        AlertKendaraanDarat.addPerlengkapan = function()
                                        {
                                            var data = AlertKendaraanDarat.data;
                                            delete data.nama_unker;
                                            delete data.nama_unor;

                                            if(Modal.assetSecondaryWindow.items.length === 0)
                                            {
                                                Modal.assetSecondaryWindow.setTitle('Tambah Perlengkapan');
                                            }
                                            var form = Form.perlengkapanAngkutan(AlertKendaraanDarat.URL.createUpdatePerlengkapanAngkutanDarat, AlertKendaraanDarat.dataStorePerlengkapanAngkutanDarat, false);
                                            form.insert(0, Form.Component.dataPerlengkapanAngkutanDarat(data.id));
                                            Modal.assetSecondaryWindow.add(form);
                                            Modal.assetSecondaryWindow.show();

                                        };

                                        AlertKendaraanDarat.editPerlengkapan = function()
                                        {
                                            var selected = Ext.getCmp('grid_angkutanDarat_perlengkapan').getSelectionModel().getSelection();
                                            if(selected.length === 1)
                                            {

                                                var data = selected[0].data;


                                                if(Modal.assetSecondaryWindow.items.length === 0)
                                                {
                                                    Modal.assetSecondaryWindow.setTitle('Edit Perlengkapan');
                                                }
                                                var form = Form.perlengkapanAngkutan(AlertKendaraanDarat.URL.createUpdatePerlengkapanAngkutanDarat, AlertKendaraanDarat.dataStorePerlengkapanAngkutanDarat, false);
                                                form.insert(0, Form.Component.dataPerlengkapanAngkutanDarat(data.id));

                                                if(data !== null)
                                                {
                                                    Ext.Object.each(data, function(key, value, myself){
                                                        if(data[key] == '0000-00-00')
                                                        {
                                                            data[key] = '';
                                                        }
                                                    });
                                                    form.getForm().setValues(data);
                                                }
                                                Modal.assetSecondaryWindow.add(form);
                                                Modal.assetSecondaryWindow.show();

                                            }
                                        };

                                        AlertKendaraanDarat.removePerlengkapan = function()
                                        {
                                            var selected = Ext.getCmp('grid_angkutanDarat_perlengkapan').getSelectionModel().getSelection();
                                            var arrayDeleted = [];
                                            _.each(selected, function(obj){
                                                var data = {
                                                    id: obj.data.id,
                                                };
                                                arrayDeleted.push(data);
                                            });
                                            console.log(arrayDeleted);
                                            Modal.deleteAlert(arrayDeleted, AlertKendaraanDarat.URL.removePerlengkapanAngkutanDarat, AlertKendaraanDarat.dataStorePerlengkapanAngkutanDarat);
                                        };

                                        AlertKendaraanDarat.addDetailPenggunaan = function()
                                        {


                                            var data = AlertKendaraanDarat.data;
                                            delete data.nama_unker;
                                            delete data.nama_unor;

                                            if(Modal.assetSecondaryWindow.items.length === 0)
                                            {
                                                Modal.assetSecondaryWindow.setTitle('Tambah Penggunaan');
                                            }
                                            var form = Form.detailPenggunaanAngkutan(AlertKendaraanDarat.URL.createUpdateDetailPenggunaanAngkutan, AlertKendaraanDarat.dataStoreDetailPenggunaanAngkutan, false, 'darat');
                                            form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(data.id, 'darat'));
                                            Modal.assetSecondaryWindow.add(form);
                                            Modal.assetSecondaryWindow.show();


                                        };

                                        AlertKendaraanDarat.editDetailPenggunaan = function()
                                        {
                                            var selected = Ext.getCmp('grid_angkutanDarat_detail_penggunaan').getSelectionModel().getSelection();
                                            if(selected.length === 1)
                                            {

                                                var data = selected[0].data;


                                                if(Modal.assetSecondaryWindow.items.length === 0)
                                                {
                                                    Modal.assetSecondaryWindow.setTitle('Edit Penggunaan');
                                                }
                                                var form = Form.detailPenggunaanAngkutan(AlertKendaraanDarat.URL.createUpdateDetailPenggunaanAngkutan, AlertKendaraanDarat.dataStoreDetailPenggunaanAngkutan, true, 'darat');
                                                form.insert(0, Form.Component.dataDetailPenggunaanAngkutan(data.id, 'darat'));

                                                if(data !== null)
                                                {
                                                    Ext.Object.each(data, function(key, value, myself){
                                                        if(data[key] == '0000-00-00')
                                                        {
                                                            data[key] = '';
                                                        }
                                                    });
                                                    form.getForm().setValues(data);
                                                }
                                                Modal.assetSecondaryWindow.add(form);
                                                Modal.assetSecondaryWindow.show();

                                            }
                                        };

                                        AlertKendaraanDarat.removeDetailPenggunaan = function()
                                        {
                                            var selected = Ext.getCmp('grid_angkutanDarat_detail_penggunaan').getSelectionModel().getSelection();
                                            var arrayDeleted = [];
                                            _.each(selected, function(obj){
                                                var data = {
                                                    id: obj.data.id,
                                                    id_ext_asset: obj.data.id_ext_asset,
                                                };
                                                arrayDeleted.push(data);
                                            });
                                            console.log(arrayDeleted);
                                            Modal.deleteAlertDetailPenggunaanAngkutan(arrayDeleted, AlertKendaraanDarat.URL.removeDetailPenggunaanAngkutan, AlertKendaraanDarat.dataStoreDetailPenggunaanAngkutan, 'darat');


                                        };



                                        AlertKendaraanDarat.Form.create = function(data, edit){
                                            var setting_grid_detail_penggunaan = {
                                                id: 'grid_angkutanDarat_detail_penggunaan',
                                                toolbar: {
                                                    add: AlertKendaraanDarat.addDetailPenggunaan,
                                                    edit: AlertKendaraanDarat.editDetailPenggunaan,
                                                    remove: AlertKendaraanDarat.removeDetailPenggunaan
                                                },
                                                dataStore: AlertKendaraanDarat.dataStoreDetailPenggunaanAngkutan,
                                            };

                                            var setting_grid_perlengkapan = {
                                                id: 'grid_angkutanDarat_perlengkapan',
                                                toolbar: {
                                                    add: AlertKendaraanDarat.addPerlengkapan,
                                                    edit: AlertKendaraanDarat.editPerlengkapan,
                                                    remove: AlertKendaraanDarat.removePerlengkapan
                                                },
                                                dataStore: AlertKendaraanDarat.dataStorePerlengkapanAngkutanDarat
                                            };

                                            var form = Form.asset(AlertKendaraanDarat.URL.createUpdate, AlertKendaraanDarat.store, edit, true);
                                            var tab = Tab.formTabs();
                                            tab.add({
                                                title: 'Utama',
                                                closable: false,
                                                border: false,
                                                deferredRender: false,
                                                bodyStyle: {background: 'none'},
                                                items: [
                                                    Form.Component.unit(edit, form),
                                                    Form.Component.kode(edit),
                                                    Form.Component.klasifikasiAset(edit),
                                                    Form.Component.basicAsset(edit),
                                                    Form.Component.mechanical(),
                                                    Form.Component.angkutan(),
                                                    Form.Component.detailPenggunaanAngkutan(setting_grid_detail_penggunaan, edit),
                                                    Form.Component.fileUpload(),
                                                ],
                                                listeners: {
                                                    'beforeclose': function(){
                                                        Utils.clearDataRef();
                                                    }
                                                }
                                            });

                                            tab.add({
                                                title: 'Tambahan',
                                                closable: false,
                                                border: false,
                                                layout: 'fit',
                                                deferredRender: false,
                                                bodyStyle: {background: 'none'},
                                                items: [
                                                    Form.Component.tambahanAngkutanDarat(setting_grid_perlengkapan, edit),
                                                ],
                                                listeners: {
                                                    'beforeclose': function(){
                                                        Utils.clearDataRef();
                                                    }
                                                }
                                            });

                                            tab.setActiveTab(1);

                                            form.insert(0, tab);

                                            if(data !== null)
                                            {
                                                $.ajax({
                                                    url: BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                                                    type: "POST",
                                                    dataType: 'json',
                                                    async: false,
                                                    data: {tipe_angkutan: 'darat', id_ext_asset: data.id},
                                                    success: function(response, status){
                                                        if(response.status == 'success')
                                                        {
                                                            data.total_detail_penggunaan_angkutan = response.total + ' Km';
                                                        }

                                                    }
                                                });

                                                Ext.Object.each(data, function(key, value, myself){
                                                    if(data[key] == '0000-00-00')
                                                    {
                                                        data[key] = '';
                                                    }
                                                });

                                                form.getForm().setValues(data);
                                            }

                                            return form;
                                        };


                                        var flagExtAsset = false;
                                        var data = AlertKendaraanDarat.data;
                                        delete data.nama_unker;
                                        delete data.nama_unor;

                                        if(Modal.assetCreate.items.length === 0)
                                        {
                                            Modal.assetCreate.setTitle('Edit Angkutan Darat');
                                        }

                                        if(data.id == null || data.id == undefined)
                                        {
                                            $.ajax({
                                                url: BASE_URL + 'asset_angkutan_darat/requestIdExtAsset',
                                                type: "POST",
                                                dataType: 'json',
                                                async: false,
                                                data: {kd_brg: data.kd_brg, kd_lokasi: data.kd_lokasi, no_aset: data.no_aset},
                                                success: function(response, status){
                                                    if(response.status == 'success')
                                                    {
                                                        flagExtAsset = true;
                                                        data.id = response.idExt;
                                                    }

                                                }
                                            });
                                        }
                                        else
                                        {
                                            flagExtAsset = true;
                                        }
                                        if(flagExtAsset == true)
                                        {
                                            var _form = AlertKendaraanDarat.Form.create(data, true);
                                            Modal.assetCreate.add(_form);
                                            Modal.assetCreate.show();
                                            AlertKendaraanDarat.dataStorePerlengkapanAngkutanDarat.changeParams({params: {open: '1', id_ext_asset: data.id}});
                                            AlertKendaraanDarat.dataStoreDetailPenggunaanAngkutan.changeParams({params: {open: '1', id_ext_asset: data.id}});
                                        }


                                    }
                                }]
                        },
                        {header: 'Masa Berlaku STNK', dataIndex: 'darat_masa_berlaku_stnk', width: 150},
                        {header: 'Masa Berlaku Pajak', dataIndex: 'darat_masa_berlaku_pajak', width: 150},
                        {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                        {header: 'Kode Barang', dataIndex: 'kd_brg', width: 200},
                        {header: 'Merk', dataIndex: 'merk', width: 200},
                    ],
                    height: 200,
                    //renderTo: Ext.getBody()
                });


                var GridAlertPengelolaan = Ext.create('Ext.grid.Panel', {
                    title: 'Alert Pengelolaan',
                    store: Dashboard.DataAlertPengelolaan,
                    tools: [{
                            type: 'refresh',
                            tooltip: 'Load Ulang Data',
                            handler: function(event, toolEl, panel){
                                Dashboard.DataAlertPengelolaan.load();
                            }
                        }],
                    columns: [
                        {xtype: 'actioncolumn', width: 30,
                            items: [{
                                    icon: '../basarnas/assets/images/icons/check.gif',
                                    tooltip: 'Tandai sudah dilihat',
                                    handler: function(grid, rowIndex, colIndex, obj)
                                    {
                                        var gridStore = grid.getStore();
                                        var id = gridStore.getAt(rowIndex).data.id;
                                        $.ajax({
                                            type: "POST",
                                            url: BASE_URL + 'pengelolaan/alertPengelolaanAction',
                                            data: {id: id},
                                            dataType: 'json',
                                            async: false,
                                            success: function(response, status)
                                            {
                                                gridStore.load();
                                            }
                                        });
                                    }
                                }]
                        },
                        {header: 'Tanggal Selesai', dataIndex: 'tanggal_selesai', width: 150},
                        {header: 'Tanggal Mulai', dataIndex: 'tanggal_mulai', width: 150},
                        {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                        {header: 'Nama Operasi', dataIndex: 'nama_operasi', width: 150},
                        {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150},
                        {header: 'Nama Aset', dataIndex: 'nama', width: 200},
                    ],
                    height: 200,
                });

                var GridAlertPendayagunaan = Ext.create('Ext.grid.Panel', {
                    title: 'Alert Pendayagunaan',
                    store: Dashboard.DataAlertPendayagunaan,
                    tools: [{
                            type: 'refresh',
                            tooltip: 'Load Ulang Data',
                            handler: function(event, toolEl, panel){
                                Dashboard.DataAlertPendayagunaan.load();
                            }
                        }],
                    columns: [
                        {xtype: 'actioncolumn', width: 30,
                            items: [{
                                    icon: '../basarnas/assets/images/icons/check.gif',
                                    tooltip: 'Tandai sudah dilihat',
                                    handler: function(grid, rowIndex, colIndex, obj)
                                    {
                                        var gridStore = grid.getStore();
                                        var id = gridStore.getAt(rowIndex).data.id;
                                        $.ajax({
                                            type: "POST",
                                            url: BASE_URL + 'pendayagunaan/alertPendayagunaanAction',
                                            data: {id: id},
                                            dataType: 'json',
                                            async: false,
                                            success: function(response, status)
                                            {
                                                gridStore.load();
                                            }
                                        });
                                    }
                                }]
                        },
                        {header: 'Tanggal Selesai', dataIndex: 'tanggal_end', width: 150},
                        {header: 'Tanggal Mulai', dataIndex: 'tanggal_start', width: 150},
                        {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 150},
                        {header: 'Mode Pendayagunaan', dataIndex: 'mode_pendayagunaan', width: 150},
                        {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150},
                        {header: 'Nama Aset', dataIndex: 'nama', width: 200},
                    ],
                    height: 200,
                });
                
                var AlertRow1 = Ext.create('Ext.panel.Panel', {
                    renderTo: Ext.getBody(),
                    layout: {
                        type: 'column',
                    },
                    border: false,
                    items: [{
                            columnWidth: 1,
                            padding: 5,
                            items: [GridMemo]
                            }
                    ]
                })
                

                var AlertRow2 = Ext.create('Ext.panel.Panel', {
                    renderTo: Ext.getBody(),
                    layout: {
                        type: 'column',
                    },
                    border: false,
                    items: [{
                            columnWidth: .333,
                            padding: 5,
                            items: [GridAlertPerlengkapan]
                        },{
                            columnWidth: .333,
                            padding: 5,
                            items: [
                                GridAlertPemeliharaan,
                            ]
                        },
                        {
                            columnWidth: .334,
                            padding: 5,
                            items: [
                                GridAlertKendaraan
                            ]
                        },
                    ]
                });

                var AlertRow3 = Ext.create('Ext.panel.Panel', {
                    renderTo: Ext.getBody(),
                    layout: {
                        type: 'column',
                    },
                    border: false,
                    items: [{
                            columnWidth: .333,
                            padding: 5,
                            items: [
                                GridAlertPengelolaan,
                            ]
                        },
                        {
                            columnWidth: .333,
                            padding: 5,
                            items: [
                                GridAlertPendayagunaan
                            ]
                        },
                        {
                            columnWidth: .334,
                            padding: 5,
                            items: [
                                GridAlertPengadaan,
                            ]
                        },
                    ]
                });

                var AlertContainer = Ext.create('Ext.panel.Panel', {
                    height: 640,
                    renderTo: Ext.getBody(),
                    layout: {
                        type: 'table',
                        columns: '1',
                        tableAttrs: {
                            style: {
                                width: '100%',
                            }
                        }
                    },
                    items: [AlertRow1,
                        AlertRow2,
                        AlertRow3
                    ]
                });


                var GrafikUnkerTotalAset = Ext.create('Ext.chart.Chart', {
                    width: 800,
                    height: 550,
                    animate: true,
                    renderTo: Ext.getBody(),
                    store: Dashboard.DataGrafikUnkerTotalAset,
                    theme: 'Category6',
                    axes: [{
                            type: 'Category',
                            position: 'bottom',
                            fields: ['ur_upb'],
                            title: 'Unit Kerja',
                            label: {
                                rotate: {degrees: 270}
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
                    width: 800,
                    height: 550,
                    animate: true,
                    renderTo: Ext.getBody(),
                    store: Dashboard.DataGrafikKategoriBarangTotalAset,
                    theme: 'Category6',
                    axes: [{
                            type: 'Category',
                            position: 'bottom',
                            fields: ['nama'],
                            title: 'Kategori Barang',
                            label: {
                                rotate: {degrees: 270}
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


                var GrafikUnkerTotalAsetContainer = Ext.create(Ext.panel.Panel, {
                    id: 'GrafikUnkerTotalAsetContainer',
                    title: "Grafik Total Aset/Unit Kerja",
                    autoScroll: true,
                    height: 600,
                    padding: 5,
                    layout: {
                        type: 'table',
                        tableAttrs: {
                            style: 'width:99%'
                        },
                        tdAttrs: {
                            align: 'center'
                        },
                    },
                    items: [GrafikUnkerTotalAset],
                });

                var GrafikKategoriBarangTotalAsetContainer = Ext.create(Ext.panel.Panel, {
                    id: 'GrafikKategoriBarangTotalAsetContainer',
                    title: "Grafik Total Aset/Kategori Barang",
                    autoScroll: true,
                    height: 600,
                    padding: 5,
                    layout: {
                        type: 'table',
                        tableAttrs: {
                            style: 'width:99%'
                        },
                        tdAttrs: {
                            align: 'center'
                        },
                    },
                    items: [GrafikKategoriBarangTotalAset],
                });

                var Content_Body_Tabs = Ext.createWidget('tabpanel', {
                    id: 'Content_Body_Tabs', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
                    defaults: {autoScroll: true},
                    items: [{
                            id: 'dashboard', title: 'Dashboard', bodyPadding: 0, iconCls: 'icon-gnome', closable: false, layout: {type: 'table', columns: 1, tableAttrs: {style: {width: '99%'}}, },
                            items: [DashboardMyPanel, AlertContainer, GrafikUnkerTotalAsetContainer, GrafikKategoriBarangTotalAsetContainer]
                        }],
                    listeners: {
                        'tabchange': function(tabPanel, tab){
                            switch(tab.title){
                                // LAYANAN
                                case 'Dashboard' :
                                    var t_dsh = Ext.getCmp('Content_Body_Tabs');
                                    for(var inx = 1; inx < 50; inx++){
                                        t_dsh.remove(t_dsh.items.getAt(inx));
                                    }
                                    break;
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
                            items: [Content_Body_Tabs],
                        }]
                });

                var Layout_Footer = {
                    id: 'layout-footer', region: 'south', layout: 'fit', split: false, border: false, margins: '5 0 0 0',
                    items: [{
                            xtype: 'toolbar', dock: 'bottom', items: ['Pengguna : ' + '<?php echo $this->my_usession->userdata("fullname_zs_simpeg") . " | " . $this->my_usession->userdata("type_zs_simpeg") . " | " . $this->my_usession->userdata("nama_unker_zs_simpeg"); ?>', '->', clock, '-', {id: 'ChatBtn', iconCls: 'icon-smiley', handler: function(){
                                        Show_Chat();
                                    }}],
                            listeners: {
                                render: {
                                    fn: function(){
                                        Ext.fly(clock.getEl().parent()).addCls('x-status-text-panel').createChild({cls: 'spacer'});

                                        // Kick off the clock timer that updates the clock el every second:
                                        Ext.TaskManager.start({
                                            run: function(){
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
            function Show_Chat(){
                Ext.MessageBox.show({title: 'Chat !', msg: 'Chatting !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
            }

            function do_logout(){
                Ext.getCmp('layout-body').body.mask("Logout ...", "x-mask-loading");
                Ext.Ajax.request({url: BASE_URL + 'user/ext_logout', method: 'POST', success: function(xhr){
                        window.location = BASE_URL + 'user';
                    }});
                return false;
            }

            function Load_Page(page_id, page_url){
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_page_id = Ext.getCmp(page_id);
                if(new_page_id){
                    Ext.getCmp('items-body').getLayout().setActiveItem(new_page_id);
                    Ext.getCmp('items-body').doLayout();
                    Ext.getCmp('layout-body').body.unmask();
                } else{
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: page_url, method: 'POST', params: {id_open: 1}, scripts: true, renderer: 'data',
                        success: function(response){
                            // Start Register Javacript On Fly
                            var jsonData = response.responseText.substring(14);
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            // End Register Javacript On Fly
                            if(newpanel != "GAGAL"){
                                Ext.getCmp('items-body').add(newpanel);
                                Ext.getCmp('items-body').getLayout().setActiveItem(newpanel);
                                Ext.getCmp('items-body').doLayout();
                            } else{
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }
                        },
                        failure: function(response){
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response){
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_TabPage(tab_id, tab_url){

                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_tab_id = Ext.getCmp(tab_id);
                if(new_tab_id){
                    Ext.getCmp('items-body').getLayout().setActiveItem(0);
                    Ext.getCmp('items-body').doLayout();
                    Ext.getCmp('Content_Body_Tabs').setActiveTab(tab_id);
                    Ext.getCmp('layout-body').body.unmask();
                } else{
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true, renderer: 'data',
                        success: function(response){
                            var jsonData = response.responseText.substring(14);
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            var new_tab = Ext.getCmp('Content_Body_Tabs');
                            if(new_tabpanel != "GAGAL"){
                                Ext.getCmp('items-body').getLayout().setActiveItem(0);
                                Ext.getCmp('items-body').doLayout();
                                new_tab.add(new_tabpanel).show();
                            } else{
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }

                        },
                        failure: function(response){
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response){
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_Popup(popup_id, popup_url, popup_title, url_form){
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_popup_id = Ext.getCmp(popup_id);
                if(new_popup_id){
                    Ext.getCmp('layout-body').body.unmask();
                    new_popup.show();
                } else{
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: popup_url, method: 'POST', params: {id_open: 1, popup_title: popup_title}, scripts: true, renderer: 'data',
                        success: function(response){
                            var jsonData = response.responseText;
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            var new_popup = Ext.getCmp(popup_id);
                            if(new_popup != "GAGAL"){
                                new_popup.show();
                            } else{
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }
                        },
                        failure: function(response){
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response){
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_Panel_Ref(popup_id, popup_uri, form_name, vfmode, p_key, p_key1, p_key2, p_key3){
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_popup_id = Ext.getCmp(popup_id);
                if(new_popup_id){
                    Ext.getCmp('layout-body').body.unmask();
                    var strFunc = "Funct_" + popup_id;
                    var fn = window[strFunc];
                    fn(form_name, vfmode);
                } else{
                    Ext.Ajax.timeout = Time_Out;
                    Ext.Ajax.request({
                        url: BASE_URL + 'panel_ref/' + popup_uri, method: 'POST', params: {id_open: 1, VKEY: p_key, VKEY1: p_key1, VKEY2: p_key2, VKEY3: p_key3}, scripts: true, renderer: 'data',
                        success: function(response){
                            var jsonData = response.responseText;
                            var aHeadNode = document.getElementsByTagName('head')[0];
                            var aScript = document.createElement('script');
                            aScript.text = jsonData;
                            aHeadNode.appendChild(aScript);
                            var new_popup = Ext.getCmp(popup_id);
                            if(new_popup != "GAGAL"){
                                var strFunc = "Funct_" + popup_id;
                                var fn = window[strFunc];
                                fn(form_name, vfmode);
                            } else{
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }
                        },
                        failure: function(response){
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response){
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_Variabel(page_url){
                Ext.Ajax.request({
                    url: page_url, method: 'POST', params: {id_open: 1}, scripts: true, renderer: 'data',
                    success: function(response){
                        var jsonData = response.responseText;
                        var aHeadNode = document.getElementsByTagName('head')[0];
                        var aScript = document.createElement('script');
                        aScript.text = jsonData;
                        aHeadNode.appendChild(aScript);
                    },
                    failure: function(response){
                        Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                    },
                    scope: this
                });
            }

            // Adi Make Functions

            function Load_WidgetFactory(factory){
                var factoryUrl = BASE_URL + 'widget_factory/';
                switch(factory){
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
                    success: function(response){

                        var jsonData = response.responseText.substring(14);
                        var aHeadNode = document.getElementsByTagName('head')[0];
                        var aScript = document.createElement('script');
                        aScript.text = jsonData;
                        aHeadNode.appendChild(aScript);
                    },
                    failure: function(response){
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
            Load_Variabel(BASE_URL + 'user/set_var_access');

            function Load_MapSearch(tab_id, tab_url, dataStoreId, searchValue)
            {
                /* var wFilter = Ext.util.Filter({	property: 'searchUnker', value: searchValue }); */
                Load_TabPage('pengelolaan_asset', BASE_URL + 'pengelolaan_asset');
                Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
                var new_tab_id = Ext.getCmp(tab_id);
                if(new_tab_id){
                    Ext.getCmp('Tab_PA').setActiveTab(tab_id);
                    Ext.getStore(dataStoreId).getProxy().extraParams = {'searchUnker': searchValue};
                    Ext.getCmp('layout-body').body.unmask();
                    Ext.getStore(dataStoreId).load()
                } else{
                    Ext.getBody().mask('Loading...');
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
                                setTimeout(function(){
                                    Ext.getCmp('Tab_PA').add(new_tabpanel_Asset).show();
                                    Ext.getStore(dataStoreId).getProxy().extraParams = {'searchUnker': searchValue};
                                    Ext.getStore(dataStoreId).load()
                                    Ext.getBody().unmask();
                                }, 1000);
                            } else{
                                Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                            }
                        },
                        failure: function(response){
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        },
                        callback: function(response){
                            Ext.getCmp('layout-body').body.unmask();
                        },
                        scope: this
                    });
                }
            }

            function Load_TabPage_Asset_Semar(tab_id, tab_url, fn_callback){
                Ext.getBody().mask('Loading...');

                Ext.Ajax.timeout = Time_Out;
                Ext.Ajax.request({
                    url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true,
                    async:false,
                    success: function(response){
                        var jsonData = response.responseText.substring(13);
                        var aHeadNode = document.getElementsByTagName('head')[0];
                        var aScript = document.createElement('script');
                        aScript.text = jsonData;
                        aHeadNode.appendChild(aScript);
                        if(new_tabpanel_Asset != "GAGAL"){
                            fn_callback(new_tabpanel_Asset);
                        } else{
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        }
                    },
                    failure: function(response){
                        Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                    },
                    callback: function(response){
                        Ext.getBody().unmask('Loading...');
                    },
                    scope: this
                });
            }
            
            function Load_Dashboard_Pemeliharaan_Data(tab_id, tab_url, fn_callback){
                Ext.getBody().mask('Loading...');

                Ext.Ajax.timeout = Time_Out;
                Ext.Ajax.request({
                    url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true,
                    async:false,
                    success: function(response){
                        var jsonData = response.responseText.substring(14);
                        var aHeadNode = document.getElementsByTagName('head')[0];
                        var aScript = document.createElement('script');
                        aScript.text = jsonData;
                        aHeadNode.appendChild(aScript);
                        if(new_tabpanel != "GAGAL"){
                            fn_callback(new_tabpanel);
                        } else{
                            Ext.MessageBox.show({title: 'Peringatan !', msg: 'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                        }
                    },
                    failure: function(response){
                        Ext.MessageBox.show({title: 'Peringatan !', msg: 'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
                    },
                    callback: function(response){
                        Ext.getBody().unmask('Loading...');
                    },
                    scope: this
                });
            }
            SemarObjTemp = {};
        </script>
    </head>
    <body>
        <div id="script_area"></div>
        <div id="body_div"></div>
    </body>
</html>