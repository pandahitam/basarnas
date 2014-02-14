<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START
var Params_M_Pengadaan = null;
Ext.namespace('Pengadaan','Pengadaan.reader', 'Pengadaan.proxy', 'Pengadaan.Data','Pengadaan.Grid','Pengadaan.Window','Pengadaan.Form','Pengadaan.Action','Pengadaan.URL');

Pengadaan.dataStoreParts = new Ext.create('Ext.data.Store', {
            model: MPartsPengadaan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'inventory_perlengkapan/getSpecificPengadaanPerlengkapan',
                create: BASE_URL + 'inventory_perlengkapan/createPengadaanPerlengkapan',
                update: BASE_URL + 'inventory_perlengkapan/updatePengadaanPerlengkapan',
                destroy: BASE_URL + 'inventory_perlengkapan/destroyPengadaanPerlengkapan'
                },
                writer: {
                type: 'json',
                writeAllFields: true,
                root: 'data',
                encode:true,
                },
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'}),
                extraParams:{open:'0'}
            }),
        });

Pengadaan.dataStoreSubParts = new Ext.create('Ext.data.Store', {
            model: MSubPartsPengadaan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'inventory_perlengkapan/getSpecificPengadaanPerlengkapanSubPart',
                create: BASE_URL + 'inventory_perlengkapan/createPengadaanPerlengkapanSubPart',
                update: BASE_URL + 'inventory_perlengkapan/updatePengadaanPerlengkapanSubPart',
                destroy: BASE_URL + 'inventory_perlengkapan/destroyPengadaanPerlengkapanSubPart'
                },
                writer: {
                type: 'json',
                writeAllFields: true,
                root: 'data',
                encode:true,
                },
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'}),
                extraParams:{open:'0'}
            }),
        });

Pengadaan.dataStoreSubSubParts = new Ext.create('Ext.data.Store', {
            model: MSubSubPartsPengadaan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'inventory_perlengkapan/getSpecificPengadaanPerlengkapanSubSubPart',
                create: BASE_URL + 'inventory_perlengkapan/createPengadaanPerlengkapanSubSubPart',
                update: BASE_URL + 'inventory_perlengkapan/updatePengadaanPerlengkapanSubSubPart',
                destroy: BASE_URL + 'inventory_perlengkapan/destroyPengadaanPerlengkapanSubSubPart'
                },
                writer: {
                type: 'json',
                writeAllFields: true,
                root: 'data',
                encode:true,
                },
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'}),
                extraParams:{open:'0'}
            }),
        });

Pengadaan.URL = {
    read : BASE_URL + 'pengadaan/getAllData',
    createUpdate : BASE_URL + 'pengadaan/modifyPengadaan',
    remove : BASE_URL + 'pengadaan/deletePengadaan'
}

Pengadaan.reader = new Ext.create('Ext.data.JsonReader', {
    id: 'Reader.Pengadaan', root: 'results', totalProperty: 'total', idProperty: 'id'    
});

Pengadaan.proxy = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Pengadaan', 
    url: Pengadaan.URL.read, actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
    reader: Pengadaan.reader,
    afterRequest: function(request, success) {
        Params_M_Pengadaan = request.operation.params;
    }
});

Pengadaan.Data = new Ext.create('Ext.data.Store', {
    id: 'Data_Pengadaan', storeId: 'DataPengadaan', model: 'MPengadaan', pageSize: 20,noCache: false, autoLoad: true,
    proxy: Pengadaan.proxy
});

Pengadaan.Form.create = function(data,edit){
    
    var setting_grid_pengadaan_parts = {
                id:'grid_pengadaan_parts',
                toolbar:{
                    add: Pengadaan.addParts,
                    edit: Pengadaan.editParts,
                    remove: Pengadaan.removeParts
                },
                dataStore:Pengadaan.dataStoreParts,
            };
    
    var setting_grid_pengadaan_sub_parts = {
                id:'grid_pengadaan_sub_parts',
                toolbar:{
                    add: Pengadaan.addSubParts,
                    edit: Pengadaan.editSubParts,
                    remove: Pengadaan.removeSubParts
                },
                dataStore:Pengadaan.dataStoreSubParts,
            };
    
    var setting_grid_pengadaan_sub_sub_parts = {
                id:'grid_pengadaan_sub_sub_parts',
                toolbar:{
                    add: Pengadaan.addSubSubParts,
                    edit: Pengadaan.editSubSubParts,
                    remove: Pengadaan.removeSubSubParts
                },
                dataStore:Pengadaan.dataStoreSubSubParts,
            };
    
    var setting = {
            url : Pengadaan.URL.createUpdate,
            data : Pengadaan.Data,
            isEditing : edit,
            addBtn : {
                isHidden : edit,
                text : 'Add Reference',
                fn : function() {
                    if (Modal.assetSelection.items.length === 0)
                    {
                        //Modal.assetSelection.add(Grid.selectionReference());
						Modal.assetSelection.add(Grid.selectionAsset());
                        Modal.assetSelection.show();
                    }
                    else
                    {
                        console.error('There is existing grid in the popup selection - pengadaan');
                    }
                }
            },
            selectionAsset: {
                noAsetHidden : false
            }
    };
    
    var form = Form.pengadaan(setting, setting_grid_pengadaan_parts,setting_grid_pengadaan_sub_parts,setting_grid_pengadaan_sub_sub_parts);

    if (data !== null)
    {
        Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
        form.getForm().setValues(data);
    }

    return form;
};

Pengadaan.addParts = function()
{
        if (Modal.assetSecondaryWindow.items.length === 0)
        {
            Modal.assetSecondaryWindow.setTitle('Tambah Part');
        }
            var form = Form.secondaryWindowAsset(Pengadaan.dataStoreParts,'add');
            form.insert(0, Form.Component.dataInventoryPerlengkapan());
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
};
        
Pengadaan.editParts = function()
{
    var grid = Ext.getCmp('grid_pengadaan_parts');
    var selected = grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {

        var data = selected[0].data;
        var storeIndex = grid.store.indexOf(selected[0]);

        if (Modal.assetSecondaryWindow.items.length === 0)
        {
            Modal.assetSecondaryWindow.setTitle('Edit Part');
        }
            var form = Form.secondaryWindowAsset(Pengadaan.dataStoreParts, 'edit',storeIndex);
            form.insert(0, Form.Component.dataInventoryPerlengkapan());

            if (data !== null)
            {
                Ext.Object.each(data,function(key,value,myself){
                    if(data[key] == '0000-00-00')
                    {
                        data[key] = '';
                    }
                });
                 form.getForm().setValues(data);
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();

}};
        
Pengadaan.removeParts = function()
{
    var grid = Ext.getCmp('grid_pengadaan_parts');
    var selected = grid.getSelectionModel().getSelection();
    if(selected.length > 0)
    {
        Ext.Msg.show({
            title: 'Konfirmasi',
            msg: 'Apakah Anda yakin untuk menghapus ?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.Question,
            fn: function(btn) {
                if (btn === 'yes')
                {
                    Ext.each(selected, function(obj){
                        var storeIndex = grid.store.indexOf(obj);
                        var record = grid.store.getAt(storeIndex);
                        grid.store.remove(record);
                    });
                }
            }
        });
    }
};

Pengadaan.addSubParts = function()
{
        if (Modal.assetSecondaryWindow.items.length === 0)
        {
            Modal.assetSecondaryWindow.setTitle('Tambah Sub Part');
        }
            var form = Form.secondaryWindowAsset(Pengadaan.dataStoreSubParts,'add');
            form.insert(0, Form.Component.dataInventoryPerlengkapanSubPart(false,form));
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
};
        
Pengadaan.editSubParts = function()
{
    var grid = Ext.getCmp('grid_pengadaan_sub_parts');
    var selected = grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {

        var data = selected[0].data;
        var storeIndex = grid.store.indexOf(selected[0]);

        if (Modal.assetSecondaryWindow.items.length === 0)
        {
            Modal.assetSecondaryWindow.setTitle('Edit Sub Part');
        }
            var form = Form.secondaryWindowAsset(Pengadaan.dataStoreSubParts, 'edit',storeIndex);
            form.insert(0, Form.Component.dataInventoryPerlengkapanSubPart(true,form));

            if (data !== null)
            {
                Ext.Object.each(data,function(key,value,myself){
                    if(data[key] == '0000-00-00')
                    {
                        data[key] = '';
                    }
                });
                 form.getForm().setValues(data);
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();

}};
        
Pengadaan.removeSubParts = function()
{
    var grid = Ext.getCmp('grid_pengadaan_sub_parts');
    var selected = grid.getSelectionModel().getSelection();
    if(selected.length > 0)
    {
        Ext.Msg.show({
            title: 'Konfirmasi',
            msg: 'Apakah Anda yakin untuk menghapus ?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.Question,
            fn: function(btn) {
                if (btn === 'yes')
                {
                    Ext.each(selected, function(obj){
                        var storeIndex = grid.store.indexOf(obj);
                        var record = grid.store.getAt(storeIndex);
                        grid.store.remove(record);
                    });
                }
            }
        });
    }
};

Pengadaan.addSubSubParts = function()
{
        if (Modal.assetSecondaryWindow.items.length === 0)
        {
            Modal.assetSecondaryWindow.setTitle('Tambah Sub Sub Part');
        }
            var form = Form.secondaryWindowAsset(Pengadaan.dataStoreSubSubParts,'add');
            form.insert(0, Form.Component.dataInventoryPerlengkapanSubSubPart(false,form));
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
};
        
Pengadaan.editSubSubParts = function()
{
    var grid = Ext.getCmp('grid_pengadaan_sub_sub_parts');
    var selected = grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {

        var data = selected[0].data;
        var storeIndex = grid.store.indexOf(selected[0]);

        if (Modal.assetSecondaryWindow.items.length === 0)
        {
            Modal.assetSecondaryWindow.setTitle('Edit Sub Sub Part');
        }
            var form = Form.secondaryWindowAsset(Pengadaan.dataStoreSubSubParts, 'edit',storeIndex);
            form.insert(0, Form.Component.dataInventoryPerlengkapanSubSubPart(true,form));

            if (data !== null)
            {
                Ext.Object.each(data,function(key,value,myself){
                    if(data[key] == '0000-00-00')
                    {
                        data[key] = '';
                    }
                });
                 form.getForm().setValues(data);
            }
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();

}};
        
Pengadaan.removeSubSubParts = function()
{
    var grid = Ext.getCmp('grid_pengadaan_sub_sub_parts');
    var selected = grid.getSelectionModel().getSelection();
    if(selected.length > 0)
    {
        Ext.Msg.show({
            title: 'Konfirmasi',
            msg: 'Apakah Anda yakin untuk menghapus ?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.Msg.Question,
            fn: function(btn) {
                if (btn === 'yes')
                {
                    Ext.each(selected, function(obj){
                        var storeIndex = grid.store.indexOf(obj);
                        var record = grid.store.getAt(storeIndex);
                        grid.store.remove(record);
                    });
                }
            }
        });
    }
};

Pengadaan.Action.add = function (){
    var _form = Pengadaan.Form.create(null,false);
    Modal.processCreate.setTitle('Create Pengadaan');
    Modal.processCreate.add(_form);
    Pengadaan.dataStoreParts.changeParams({params:{open:'0'}});
    Pengadaan.dataStoreParts.removed = [];
    Pengadaan.dataStoreSubParts.changeParams({params:{open:'0'}});
    Pengadaan.dataStoreSubParts.removed = [];
    Pengadaan.dataStoreSubSubParts.changeParams({params:{open:'0'}});
    Pengadaan.dataStoreSubSubParts.removed = [];
    Modal.processCreate.show();

   
};

Pengadaan.Action.edit = function (){
    var selected = Pengadaan.Grid.grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {
        var data = selected[0].data;
        if (Modal.processEdit.items.length === 0)
        {
                Modal.processEdit.setTitle('Edit Perairan');
        }
        var _form = Pengadaan.Form.create(data,true);
        Modal.processEdit.add(_form);
        
        Pengadaan.dataStoreParts.changeParams({params:{open:'1',id_source:data.id}});
        Pengadaan.dataStoreParts.removed = [];
        Pengadaan.dataStoreSubParts.changeParams({params:{open:'1',id_source:data.id}});
        Pengadaan.dataStoreSubParts.removed = [];
        Pengadaan.dataStoreSubSubParts.changeParams({params:{open:'1',id_source:data.id}});
        Pengadaan.dataStoreSubSubParts.removed = [];
        Modal.processEdit.show();
    }
};

Pengadaan.Action.remove = function(){
    var selected = Pengadaan.Grid.grid.getSelectionModel().getSelection();
    var arrayDeleted = [];
    _.each(selected, function(obj){
            var data = {
                id : obj.data.id
            };
            arrayDeleted.push(data);
    });
    Modal.deleteAlert(arrayDeleted,Pengadaan.URL.remove,Pengadaan.Data);
};

Pengadaan.Action.print = function (){
    var selected = Pengadaan.Grid.grid.getSelectionModel().getSelection();
    var selectedData = "";
    if(selected.length >0)
    {
        for(var i=0; i<selected.length; i++)
        {
            selectedData += selected[i].data.id + ",";
        }
    }
    var gridHeader = Pengadaan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
    var gridHeaderList = "";
    //index starts at 2 to exclude the No. column
    for(var i=2; i<gridHeader.length; i++)
    {
        if(gridHeader[i].dataIndex == undefined || gridHeader[i].dataIndex == "" ) //filter the action columns in grid
        {
            //do nothing
        }
        else
        {
            gridHeaderList += gridHeader[i].text + "&&" + gridHeader[i].dataIndex + "^^";
        }
    }
    var serverSideModelName = "Pengadaan_Model";
    var title = "Pengadaan";
    var primaryKeys = "id";

    my_form=document.createElement('FORM');
    my_form.name='myForm';
    my_form.method='POST';
    my_form.action= BASE_URL + 'excel_management/exportToExcel/';

    my_tb=document.createElement('INPUT');
    my_tb.type='HIDDEN';
    my_tb.name='serverSideModelName';
    my_tb.value= serverSideModelName;
    my_form.appendChild(my_tb);

    my_tb=document.createElement('INPUT');
    my_tb.type='HIDDEN';
    my_tb.name='title';
    my_tb.value=title;
    my_form.appendChild(my_tb);
    document.body.appendChild(my_form);
    
    my_tb=document.createElement('INPUT');
    my_tb.type='HIDDEN';
    my_tb.name='primaryKeys';
    my_tb.value=primaryKeys;
    my_form.appendChild(my_tb);
    document.body.appendChild(my_form);
    
    my_tb=document.createElement('INPUT');
    my_tb.type='HIDDEN';
    my_tb.name='gridHeaderList';
    my_tb.value=gridHeaderList;
    my_form.appendChild(my_tb);
    document.body.appendChild(my_form);
    
    my_tb=document.createElement('INPUT');
    my_tb.type='HIDDEN';
    my_tb.name='selectedData';
    my_tb.value=selectedData;
    my_form.appendChild(my_tb);
    document.body.appendChild(my_form);
    
    my_form.submit();
};
    
var setting = {
        grid : {
            id : 'grid_Pengadaan',
            title : 'DAFTAR PENGADAAN',
            column : [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID',              dataIndex: 'id',                width: 50,  hidden:true,    groupable: false, filter:{type:'number'}},
                    {header: 'Unit Kerja',      dataIndex: 'nama_unker',        width: 150, hidden:true,    groupable : false,filter:{type:'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor',         width: 150, hidden:true,    groupable : false,filter:{type:'string'}},
                    {header: 'No Sppa',         dataIndex: 'no_sppa',           width: 120,  hidden:false,   groupable : false,filter:{type:'string'}},
                    {header: 'Kode Barang',     dataIndex: 'kd_brg',            width: 150, hidden:false,   groupable : false,filter:{type:'string'}},
                    {header: 'Nama',            dataIndex: 'nama',              width: 150, hidden:false,   groupable : false,filter:{type:'string'}},
                    {header: 'Vendor Name',     dataIndex: 'perolehan_bmn',     width: 120, hidden:false,   groupable : false,filter:{type:'string'}},
                    {header: 'Tahun Angaran',   dataIndex: 'tahun_angaran',     width: 100, hidden:false,   groupable: false,filter:{type:'string'}},
                    {header: 'Sumber',          dataIndex: 'perolehan_sumber',  width: 100, hidden:false,   groupable : false,filter:{type:'string'}},
                    {header: 'Asal Pengadaan',  dataIndex: 'asal_pengadaan',    width: 100, hidden:false,   groupable : false,filter:{type:'string'}},
                    {header: 'Harga Total',     dataIndex: 'harga_total',       width: 100, hidden:false,   groupable : false,filter:{type:'numeric'}},
                    {header: 'Deskripsi',       dataIndex: 'deskripsi',         width: 120, hidden:false,filter:{type:'string'}},
                    {header: 'Tgl Perolehan',   dataIndex: 'perolehan_tanggal', width: 90,  hidden:false,filter:{type:'string'}},
                    {header: 'Faktur No',       dataIndex: 'faktur_no',         width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Kuitansi Tgl',    dataIndex: 'kuitansi_tanggal',  width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'SP2D No',         dataIndex: 'sp2d_no',           width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'SP2D tgl',        dataIndex: 'sp2d_tanggal',      width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Mutasi No',       dataIndex: 'mutasi_no',         width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Mutasi Tgl',      dataIndex: 'mutasi_tanggal',    width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Grs Berlaku',     dataIndex: 'garansi_berlaku',   width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Grs Keterangan',  dataIndex: 'garansi_keterangan',width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Pelihara Tgl',    dataIndex: 'pelihara_berlaku',  width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Pelihara Ket',    dataIndex: 'pelihara_keterangan',width:90,  hidden:true,filter:{type:'string'}},
                    {header: 'Spk No',          dataIndex: 'spk_no',            width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Spk Jenis',       dataIndex: 'spk_jenis',         width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Spk berlaku',     dataIndex: 'spk_berlaku',       width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Spk keterangan',  dataIndex: 'spk_keterangan',    width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Terpelihara',     dataIndex: 'is_terpelihara',    width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Bergaransi ',     dataIndex: 'is_bergaransi',     width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'SPK',             dataIndex: 'is_spk',            width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Data Kontrak',    dataIndex: 'data_kontrak',      width: 90,  hidden:true,filter:{type:'string'}},
  
                    ]
        },
        search : {
            id : 'search_Pengadaan'
        },
        toolbar : {
            id : 'toolbar_Pengadaan',
            add : {
                id : 'button_add_Pengadaan',
                action : Pengadaan.Action.add,
                disabled:pengadaan_insert,
            },
            edit : {
                id : 'button_edit_Pengadaan',
                action : Pengadaan.Action.edit,
                disabled:pengadaan_update,
            },
            remove : {
                id : 'button_remove_Pengadaan',
                action : Pengadaan.Action.remove,
                disabled:pengadaan_delete,
            },
            print : {
                id : 'button_pring_Pengadaan',
                action : Pengadaan.Action.print,
                disabled:pengadaan_print,
            }
        }
};

Pengadaan.Grid.grid = Grid.processGrid(setting,Pengadaan.Data);

var new_tabpanel = {
    xtype:'panel',
    id: 'pengadaan_asset', title: 'Pengadaan', iconCls: 'icon-menu_impasing', border: false, closable: true, 
    layout: 'border', items: [Region.filterPanelPengadaan(Pengadaan.Data),Pengadaan.Grid.grid]
};
            
<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>