<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START
var Params_M_Mutasi= null;

Ext.namespace('Mutasi','Mutasi.reader', 'Mutasi.proxy', 'Mutasi.Data','Mutasi.Grid','Mutasi.Window','Mutasi.Form','Mutasi.Action','Mutasi.URL');

/*Mutasi.URL = {
    read : BASE_URL + 'Mutasi/getAllData',
    createUpdate : BASE_URL + 'Mutasi/modifyMutasi',
    remove : BASE_URL + 'Mutasi/deleteMutasi'
};

Ext.define('MMutasi', {extend: 'Ext.data.Model',
    fields: ['id', 'kd_brg', 'kd_lokasi', 'kd_register', 'no_aset',
        'kode_unker', 'kode_unor', 'nama_unker', 'nama_unor','jenis', 'nama', 
        'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 'kondisi', 
        'deskripsi', 'harga', 'kode_angaran', 'freq_waktu', 
        'freq_pengunaan', 'status', 'durasi', 'rencana_waktu', 
        'rencana_pengunaan', 'rencana_keterangan', 'alert','image_url','document_url']
});

Mutasi.reader = new Ext.create('Ext.data.JsonReader', {
    id: 'Reader.Mutasi', root: 'results', totalProperty: 'total', idProperty: 'id'    
});

Mutasi.proxy = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Mutasi', 
    url: Mutasi.URL.read, actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
    reader: Mutasi.reader,
    afterRequest: function(request, success) {
        Params_M_Mutasi = request.operation.params;
    }
});

Mutasi.Data = new Ext.create('Ext.data.Store', {
    id: 'Data_Mutasi', storeId: 'DataMutasi', model: 'MMutasi', pageSize: 20,noCache: false, autoLoad: true,
    proxy: Mutasi.proxy, groupField: 'tipe'
});

Mutasi.Form.create = function(data,edit){
	var form = Form.Mutasi(Mutasi.URL.createUpdate,Mutasi.Data,false,true,data);
	if (data !== null)
	{
		form.getForm().setValues(data);
	}
	return form;
};

Mutasi.Action.add = function (){
    var _form = Mutasi.Form.create(null,false);
    Modal.processCreate.setTitle('Create Mutasi');
    Modal.processCreate.add(_form);
    Modal.processCreate.show();
};

Mutasi.Action.edit = function (){
    var selected = Mutasi.Grid.grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {
        var data = selected[0].data;
        delete data.nama_unker;
        console.log(data);
        if (Modal.processEdit.items.length === 0)
        {
                Modal.processEdit.setTitle('Edit Mutasi');
        }
        var _form = Mutasi.Form.create(data,true);
        Modal.processEdit.add(_form);
        Modal.processEdit.show();
    }
};

Mutasi.Action.remove = function(){
    var selected = Mutasi.Grid.grid.getSelectionModel().getSelection();
    var arrayDeleted = [];
    _.each(selected, function(obj){
            var data = {
                id : obj.data.id
            };
            arrayDeleted.push(data);
    });
    Modal.deleteAlert(arrayDeleted,Mutasi.URL.remove,Mutasi.Data);
};

Mutasi.Action.print - function (){
    
};*/
    
var setting = {
        grid : {
            id : 'grid_Mutasi',
            title : 'DAFTAR MUTASI',
            column : [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID',              dataIndex: 'id',                width: 50, groupable: false, filter:{type:'number'}},]
                    
        },
        search : {
            id : 'search_Mutasi'
        },
        toolbar : {
            id : 'toolbar_Mutasi',
            add : {
                id : 'button_add_Mutasi',
               /* action : Mutasi.Action.add*/
            },
            edit : {
                id : 'button_edit_Mutasi',
                /*action : Mutasi.Action.edit*/
            },
            remove : {
                id : 'button_remove_Mutasi',
                /*action : Mutasi.Action.remove*/
            },
            print : {
                id : 'button_pring_Mutasi',
                /*action : Mutasi.Action.print*/
            }
        }
};

Mutasi.Grid.grid = Grid.inventarisGrid(setting,'');

/*var new_tabpanel = {
    xtype:'panel',
    id: 'mutasi_asset', title: 'Mutasi', iconCls: 'icon-menu_impasing', border: false, closable: true, 
    layout: 'border', items: [Region.filterPanelMutasi(Mutasi.Data),Mutasi.Grid.grid]
};*/
var new_tabpanel = {
    id: 'mutasi_asset', title: 'Mutasi', iconCls: 'icon-menu_impasing', closable: true, border: false,
    items: [Mutasi.Grid.grid]
}
      
<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>