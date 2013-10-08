<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START
var Params_M_Perencanaan = null;

Ext.namespace('Perencanaan','Perencanaan.reader', 'Perencanaan.proxy', 'Perencanaan.Data','Perencanaan.Grid','Perencanaan.Window','Perencanaan.Form','Perencanaan.Action','Perencanaan.URL');

Perencanaan.URL = {
    read : BASE_URL + 'Perencanaan/getAllData',
    createUpdate : BASE_URL + 'Perencanaan/modifyPerencanaan',
    remove : BASE_URL + 'Perencanaan/deletePerencanaan',

}

Perencanaan.reader = new Ext.create('Ext.data.JsonReader', {
    id: 'Reader.Perencanaan', root: 'results', totalProperty: 'total', idProperty: 'id'    
});

Perencanaan.proxy = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_Perencanaan', 
    url: Perencanaan.URL.read, actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
    reader: Perencanaan.reader,
    afterRequest: function(request, success) {
        Params_M_Perencanaan = request.operation.params;
    }
});

Perencanaan.Data = new Ext.create('Ext.data.Store', {
    id: 'Data_Perencanaan', storeId: 'DataPerencanaan', model: 'MPerencanaan', pageSize: 20,noCache: false, autoLoad: true,
    proxy: Perencanaan.proxy, groupField: 'tipe'
});

Perencanaan.Form.create = function(data,edit){
        var setting = {
            url : Perencanaan.URL.createUpdate,
            data : Perencanaan.Data,
            isEditing : edit,
            addBtn : {
                isHidden : edit,
                text : 'Add Reference',
                fn : function() {
                    if(Modal.assetSelection.items.length === 0)
                    {
                        //Modal.assetSelection.add(Grid.selectionReference());
                        Modal.assetSelection.add(Grid.selectionAsset());
                        Modal.assetSelection.show();
                    }
                    else
                    {
                        console.error('There is existing grid in the popup');
                    }
                }
            },
            selectionAsset: {
                noAsetHidden : false
            }
        };
        
        var form = Form.perencanaan(setting);

	if (data !== null)
	{
            
            Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
            form.getForm().setValues(data);
//	    var task = Ext.TaskManager.start({
//		run: function () {
//		    form.getForm().setValues(data)
//		},
//		interval: 1000,
//		repeat:2
//	    });
	}
        
	return form;
};

Perencanaan.Action.add = function (){
    var _form = Perencanaan.Form.create(null,false)
    Modal.processCreate.setTitle('Create Perencanaan');
    Modal.processCreate.add(_form);
    Modal.processCreate.show();
};

Perencanaan.Action.edit = function (){
    var selected = Perencanaan.Grid.grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {
        var data = selected[0].data;
        if (Modal.processEdit.items.length === 0)
        {
                Modal.processEdit.setTitle('Edit Perencanaan');
        }
        var _form = Perencanaan.Form.create(data,true);
        Modal.processEdit.add(_form);
        Modal.processEdit.show();
    }
};

Perencanaan.Action.remove = function(){
    var selected = Perencanaan.Grid.grid.getSelectionModel().getSelection();
    var arrayDeleted = [];
    _.each(selected, function(obj){
            var data = {
                id : obj.data.id
            };
            arrayDeleted.push(data);
    });
    Modal.deleteAlert(arrayDeleted,Perencanaan.URL.remove,Perencanaan.Data);
};

Perencanaan.Action.print = function (){
    
    var selected = Perencanaan.Grid.grid.getSelectionModel().getSelection();
    var selectedData = "";
    if(selected.length >0)
    {
        for(var i=0; i<selected.length; i++)
        {
            selectedData += selected[i].data.id + ",";
        }
    }
    var gridHeader = Perencanaan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
    var serverSideModelName = "Perencanaan_Model";
    var title = "Perencanaan";
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
            id : 'grid_Perencanaan',
            title : 'DAFTAR PERENCANAAN',
            column : [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID',              dataIndex: 'id',                width: 50, groupable: false, filter:{type:'number'}},
                    {header: 'Unit Kerja',      dataIndex: 'nama_unker',        width: 150,groupable : false,filter:{type:'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor',         width: 150,groupable : false,filter:{type:'string'}},
                    {header: 'Kode Lokasi',     dataIndex: 'kode_lokasi',       width: 130,hidden:true,groupable : false,filter:{type:'string'}},
                    {header: 'Kode Barang',     dataIndex: 'kd_brg',            width: 100,hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'No Aset',         dataIndex: 'no_aset',        width: 100,groupable: false,filter:{type:'string'}},
                    {header: 'Nama',            dataIndex: 'nama',              width: 250,groupable: false,filter:{type:'string'}},
                    {header: 'Tahun Angaran',   dataIndex: 'tahun_angaran',     width: 100,groupable : false,filter:{type:'string'}},
                    {header: 'Kebutuhan',       dataIndex: 'kebutuhan',         width: 120,groupable : false,filter:{type:'string'}},
                    {header: 'Keterangan',      dataIndex: 'keterangan',        width: 70,  hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'Satuan',          dataIndex: 'satuan',            width: 100, hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'Quantity',        dataIndex: 'quantity',          width: 90, hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'Harga Satuan',    dataIndex: 'harga_satuan',      width: 90, hidden:false,filter:{type:'string'}},
                    {header: 'Harga Total',     dataIndex: 'harga_toal',        width: 90,  hidden:true,filter:{type:'string'}},
                    {header: 'Realisasi',       dataIndex: 'is_realisasi',      width: 90,hidden : true,filter:{type:'string'}},
                    ]
        },
        search : {
            id : 'search_Perencanaan'
        },
        toolbar : {
            id : 'toolbar_Perencanaan',
            add : {
                id : 'button_add_Perencanaan',
                action : Perencanaan.Action.add
            },
            edit : {
                id : 'button_edit_Perencanaan',
                action : Perencanaan.Action.edit
            },
            remove : {
                id : 'button_remove_Perencanaan',
                action : Perencanaan.Action.remove
            },
            print : {
                id : 'button_pring_Perencanaan',
                action : Perencanaan.Action.print
            }
        }
};

Perencanaan.Grid.grid = Grid.processGrid(setting,Perencanaan.Data);

var new_tabpanel = {
    id: 'perencanaan_asset', title: 'Perencanaan', iconCls: 'icon-menu_impasing', border: false, closable: true, 
    layout: 'border', items: [Region.filterPanelPerencanaan(Perencanaan.Data),Perencanaan.Grid.grid]
};
            
<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>