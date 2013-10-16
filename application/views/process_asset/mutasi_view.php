<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START
var Params_M_Mutasi= null;

Ext.namespace('Mutasi','Mutasi.reader', 'Mutasi.proxy', 'Mutasi.Data','Mutasi.Grid','Mutasi.Window','Mutasi.Form','Mutasi.Action','Mutasi.URL');

Mutasi.URL = {
    read : BASE_URL + 'Mutasi/getAllData',
    createUpdate : BASE_URL + 'Mutasi/modifyMutasi',
    remove : BASE_URL + 'Mutasi/deleteMutasi'
};


Mutasi.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader_Mutasi', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

Mutasi.proxy = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Mutasi',
    timeout: 500000,
    url: Mutasi.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
    reader: Mutasi.reader,
    afterRequest: function(request, success) {
        Params_M_TB = request.operation.params;

        //USED FOR MAP SEARCH
        var paramsUnker = request.params.searchUnker;
        if(paramsUnker != null && paramsUnker != undefined)
        {
            Mutasi.Data.clearFilter();
            Mutasi.Data.filter([{property: 'kd_lokasi', value: paramsUnker, anyMatch:true}]);
        }

    }
});
        
        
Mutasi.Data = new Ext.create('Ext.data.Store', {
    id: 'Data_Mutasi', storeId: 'DataMutasi', model: 'MMutasi', pageSize: 50, noCache: false, autoLoad: true,
    proxy: Mutasi.proxy
});

Mutasi.Form.create = function(data,edit){
            var form = Form.assetNoButton(null, Mutasi.Data, edit);
            form.insert(0, Form.Component.penghapusanDanMutasi());
            if (data !== null)
            {
                form.getForm().setValues(data);
            }

            return form;
};

Mutasi.Action.add = function (){
//    var _form = Mutasi.Form.create(null,false);
//    Modal.processCreate.setTitle('Create Mutasi');
//    Modal.processCreate.add(_form);
//    Modal.processCreate.show();
};

Mutasi.Action.edit = function (){
 var selected = Mutasi.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Mutasi');
                }
                var _form = Mutasi.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
            }
};

Mutasi.Action.remove = function(){
//    var selected = Mutasi.Grid.grid.getSelectionModel().getSelection();
//    var arrayDeleted = [];
//    _.each(selected, function(obj){
//            var data = {
//                id : obj.data.id
//            };
//            arrayDeleted.push(data);
//    });
//    Modal.deleteAlert(arrayDeleted,Mutasi.URL.remove,Mutasi.Data);
};

Mutasi.Action.print = function (){
    
};
    
var setting = {
        grid : {
            id : 'grid_Mutasi',
            title : 'DAFTAR MUTASI',
            column : [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'NO SPPA', dataIndex: 'no_sppa', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'KD BARANG', dataIndex: 'kd_brg', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'NAMA BARANG', dataIndex: 'ur_baru', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'No Awal', dataIndex: 'no_awal', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'No Akhir', dataIndex: 'no_akhir', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Tahun Anggaran', dataIndex: 'thn_ang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Tgl Peroleh', dataIndex: 'tgl_perlh', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 150, hidden: false, groupable: false, filter: {type: 'string'},renderer: function(value) {
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
                            else
                            {
                                return "";
                            }
                        }
                    },
                    {header: 'jns_trn', dataIndex: 'jns_trn', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Jenis Trn', dataIndex: 'jenis_transaksi', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Rph Aset', dataIndex: 'rph_aset', width: 150, hidden: false, groupable: false, filter: {type: 'string'},renderer: function(value) {
                            return Math.abs(value);
                        }
                    },
                    {header: 'Merk Type', dataIndex: 'merk_type', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Asal Perolehan', dataIndex: 'asal_perlh', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'No SK', dataIndex: 'no_dsr_mts', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Tgl SK', dataIndex: 'tgl_dsr_mts', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
            ]
                    
        },
        search : {
            id : 'search_Mutasi'
        },
        toolbar : {
            id : 'toolbar_Mutasi',
            edit : {
                id : 'button_edit_Mutasi',
                action : Mutasi.Action.edit
            },
            print : {
                id : 'button_pring_Mutasi',
                /*action : Mutasi.Action.print*/
            }
        }
};

Mutasi.Grid.grid = Grid.mutasiGridNoCRUD(setting,Mutasi.Data);

/*var new_tabpanel = {
    xtype:'panel',
    id: 'mutasi_asset', title: 'Mutasi', iconCls: 'icon-menu_impasing', border: false, closable: true, 
    layout: 'border', items: [Region.filterPanelMutasi(Mutasi.Data),Mutasi.Grid.grid]
};*/
var new_tabpanel = {
    id: 'mutasi_asset', title: 'Mutasi', iconCls: 'icon-menu_impasing', closable: true, border: false,
    layout: 'border',items: [Region.filterPanelPenghapusanDanMutasi(Mutasi.Data),Mutasi.Grid.grid]
}
      
<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>