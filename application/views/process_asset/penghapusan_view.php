<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START
var Params_M_Penghapusan= null;

Ext.namespace('Penghapusan','Penghapusan.reader', 'Penghapusan.proxy', 'Penghapusan.Data','Penghapusan.Grid','Penghapusan.Window','Penghapusan.Form','Penghapusan.Action','Penghapusan.URL');

/*Penghapusan.URL = {
    read : BASE_URL + 'Penghapusan/getAllData',
    createUpdate : BASE_URL + 'Penghapusan/modifyPenghapusan',
    remove : BASE_URL + 'Penghapusan/deletePenghapusan'
};

Ext.define('MPenghapusan', {extend: 'Ext.data.Model',
    fields: ['id', 'kd_brg', 'kd_lokasi', 'kd_register', 'no_aset',
        'kode_unker', 'kode_unor', 'nama_unker', 'nama_unor','jenis', 'nama', 
        'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 'kondisi', 
        'deskripsi', 'harga', 'kode_angaran', 'freq_waktu', 
        'freq_pengunaan', 'status', 'durasi', 'rencana_waktu', 
        'rencana_pengunaan', 'rencana_keterangan', 'alert','image_url','document_url']
});

Penghapusan.reader = new Ext.create('Ext.data.JsonReader', {
    id: 'Reader.Penghapusan', root: 'results', totalProperty: 'total', idProperty: 'id'    
});

Penghapusan.proxy = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Penghapusan', 
    url: Penghapusan.URL.read, actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
    reader: Penghapusan.reader,
    afterRequest: function(request, success) {
        Params_M_Penghapusan = request.operation.params;
    }
});

Penghapusan.Data = new Ext.create('Ext.data.Store', {
    id: 'Data_Penghapusan', storeId: 'DataPenghapusan', model: 'MPenghapusan', pageSize: 20,noCache: false, autoLoad: true,
    proxy: Penghapusan.proxy, groupField: 'tipe'
});

Penghapusan.Form.create = function(data,edit){
	var form = Form.Penghapusan(Penghapusan.URL.createUpdate,Penghapusan.Data,false,true,data);
	if (data !== null)
	{
		form.getForm().setValues(data);
	}
	return form;
};

Penghapusan.Action.add = function (){
    var _form = Penghapusan.Form.create(null,false);
    Modal.processCreate.setTitle('Create Penghapusan');
    Modal.processCreate.add(_form);
    Modal.processCreate.show();
};

Penghapusan.Action.edit = function (){
    var selected = Penghapusan.Grid.grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {
        var data = selected[0].data;
        delete data.nama_unker;
        console.log(data);
        if (Modal.processEdit.items.length === 0)
        {
                Modal.processEdit.setTitle('Edit Penghapusan');
        }
        var _form = Penghapusan.Form.create(data,true);
        Modal.processEdit.add(_form);
        Modal.processEdit.show();
    }
};

Penghapusan.Action.remove = function(){
    var selected = Penghapusan.Grid.grid.getSelectionModel().getSelection();
    var arrayDeleted = [];
    _.each(selected, function(obj){
            var data = {
                id : obj.data.id
            };
            arrayDeleted.push(data);
    });
    Modal.deleteAlert(arrayDeleted,Penghapusan.URL.remove,Penghapusan.Data);
};

Penghapusan.Action.print - function (){
    
};*/
    
var setting = {
        grid : {
            id : 'grid_Penghapusan',
            title : 'DAFTAR PENGHAPUSAN',
            column : [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID',              dataIndex: 'id',                width: 50, groupable: false, filter:{type:'number'}},]
                    
        },
        search : {
            id : 'search_Penghapusan'
        },
        toolbar : {
            id : 'toolbar_Penghapusan',
            add : {
                id : 'button_add_Penghapusan',
               /* action : Penghapusan.Action.add*/
            },
            edit : {
                id : 'button_edit_Penghapusan',
                /*action : Penghapusan.Action.edit*/
            },
            remove : {
                id : 'button_remove_Penghapusan',
                /*action : Penghapusan.Action.remove*/
            },
            print : {
                id : 'button_pring_Penghapusan',
                /*action : Penghapusan.Action.print*/
            }
        }
};

Penghapusan.Grid.grid = Grid.inventarisGrid(setting,'');

/*var new_tabpanel = {
    xtype:'panel',
    id: 'penghapusan_asset', title: 'Penghapusan', iconCls: 'icon-menu_impasing', border: false, closable: true, 
    layout: 'border', items: [Region.filterPanelPenghapusan(Penghapusan.Data),Penghapusan.Grid.grid]
};*/
var new_tabpanel = {
    id: 'penghapusan_asset', title: 'Penghapusan', iconCls: 'icon-menu_impasing', closable: true, border: false,
    items: [Penghapusan.Grid.grid]
}
      
<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>