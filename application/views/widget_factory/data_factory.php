<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<script>
////// Data In View

Ext.namespace('AssetData','ProcessData','AssetUrl');
Ext.namespace('ProcessUrl','ProcessUrl.Pengadaan');

ProcessUrl = {
    Pengadaan : {
        read : BASE_URL + 'pengadaan/getAllData',
        createUpdate : BASE_URL + 'pengadaan/modifyPengadaan',
        remove : BASE_URL + 'pengadaan/deletePengadaan',
    }
};

ProcessData.reader = new Ext.create('Ext.data.JsonReader', {
    root: 'results', totalProperty: 'total', idProperty: 'id'    
});

ProcessData.proxy = new Ext.create('Ext.data.AjaxProxy', {
    url: ProcessUrl.Pengadaan.read, actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
    reader: ProcessData.Reader
});

ProcessData.pengadaan = new Ext.create('Ext.data.Store', {
    id: 'Data_Pengadaan', storeId: 'DataPengadaan', model: 'MPengadaan', pageSize: 20,noCache: false, autoLoad: false,
    proxy: ProcessData.proxy, groupField: 'tipe'
});