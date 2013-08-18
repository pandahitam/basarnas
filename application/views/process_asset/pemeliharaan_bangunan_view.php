<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START
var Params_M_PemeliharaanBangunan = null;

Ext.namespace('PemeliharaanBangunan','PemeliharaanBangunan.reader', 'PemeliharaanBangunan.proxy', 'PemeliharaanBangunan.Data','PemeliharaanBangunan.Grid','PemeliharaanBangunan.Window','PemeliharaanBangunan.Form','PemeliharaanBangunan.Action','PemeliharaanBangunan.URL');

PemeliharaanBangunan.URL = {
    read : BASE_URL + 'Pemeliharaan_Bangunan/getAllData',
    createUpdate : BASE_URL + 'Pemeliharaan_Bangunan/modifyPemeliharaanBangunan',
    remove : BASE_URL + 'Pemeliharaan_Bangunan/deletePemeliharaanBangunan'
};


PemeliharaanBangunan.reader = new Ext.create('Ext.data.JsonReader', {
    id: 'Reader.PemeliharaanBangunan', root: 'results', totalProperty: 'total', idProperty: 'id'    
});

PemeliharaanBangunan.proxy = new Ext.create('Ext.data.AjaxProxy', {
    id: 'Proxy_PemeliharaanBangunan', 
    url: PemeliharaanBangunan.URL.read, actionMethods: {read:'POST'},  extraParams :{id_open: '1'},
    reader: PemeliharaanBangunan.reader,
    afterRequest: function(request, success) {
        Params_M_PemeliharaanBangunan = request.operation.params;
    }
});

PemeliharaanBangunan.Data = new Ext.create('Ext.data.Store', {
    id: 'Data_PemeliharaanBangunan', storeId: 'DataPemeliharaanBangunan', model: 'MPemeliharaanBangunan', pageSize: 20,noCache: false, autoLoad: true,
    proxy: PemeliharaanBangunan.proxy, groupField: 'tipe'
});

PemeliharaanBangunan.Form.create = function(data,edit){
        var setting = {
            url : PemeliharaanBangunan.URL.createUpdate,
            data : PemeliharaanBangunan.Data,
            isEditing : edit,
            isBangunan: true,
            isPemeliharaanAssetInventaris : false,
            addBtn : {
                isHidden : edit,
                text : 'Add Asset',
                fn : function() {
                    
                    if(Modal.assetSelection.items.length === 0)
                    {
                        Modal.assetSelection.add(Grid.selectionAsset());
                        Modal.assetSelection.show();
                    }
                    else
                    {
                        console.error('There is existing grid in the popup selection - pemeliharaan');
                    }
                }
            },
            selectionAsset: {
                noAsetHidden : false
            }
        };
        debugger;
	var form = Form.pemeliharaan(setting);
        
	if (data !== null)
	{
		form.getForm().setValues(data);
	}
	return form;
};

PemeliharaanBangunan.Action.add = function (){
    var _form = PemeliharaanBangunan.Form.create(null,false);
    Modal.processCreate.setTitle('Create Pemeliharaan Bangunan');
    Modal.processCreate.add(_form);
    Modal.processCreate.show();
};

PemeliharaanBangunan.Action.edit = function (){
    var selected = PemeliharaanBangunan.Grid.grid.getSelectionModel().getSelection();
    if (selected.length === 1)
    {
        var data = selected[0].data;
        delete data.nama_unker;
        debugger;
        if (Modal.processEdit.items.length === 0)
        {
                Modal.processEdit.setTitle('Edit Pemeliharaan Bangunan');
        }
        var _form = PemeliharaanBangunan.Form.create(data,true);
        Modal.processEdit.add(_form);
        Modal.processEdit.show();
    }
};

PemeliharaanBangunan.Action.remove = function(){
    var selected = PemeliharaanBangunan.Grid.grid.getSelectionModel().getSelection();
    var arrayDeleted = [];
    _.each(selected, function(obj){
            var data = {
                id : obj.data.id
            };
            arrayDeleted.push(data);
    });
    Modal.deleteAlert(arrayDeleted,PemeliharaanBangunan.URL.remove,PemeliharaanBangunan.Data);
};

PemeliharaanBangunan.Action.print = function (){
    var selected = PemeliharaanBangunan.Grid.grid.getSelectionModel().getSelection();
    var selectedData = "";
    if(selected.length >0)
    {
        for(var i=0; i<selected.length; i++)
        {
            selectedData += selected[i].data.id + ",";
        }
    }
    var gridHeader = PemeliharaanBangunan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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
    var serverSideModelName = "Pemeliharaan_Bangunan_Model";
    var title = "Pemeliharaan Bangunan";
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
            id : 'grid_PemeliharaanBangunan',
            title : 'DAFTAR PEMELIHARAAN BANGUNAN',
            column : [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID',              dataIndex: 'id',                width: 50, groupable: false, filter:{type:'number'}},
                    {header: 'Unit Kerja',      dataIndex: 'nama_unker',        width: 180,groupable : false,filter:{type:'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor',         width: 130,groupable : false,filter:{type:'string'}},
                    {header: 'Kode Lokasi',     dataIndex: 'kd_lokasi',       width: 130,hidden:true,groupable : false,filter:{type:'string'}},
                    {header: 'Kode Barang',     dataIndex: 'kd_brg',       width: 130,hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'No Aset',         dataIndex: 'no_aset',           width: 130, hidden:true,    groupable: false,filter:{type:'string'}}, 
                    {header: 'Pelaksana',      dataIndex: 'pelaksana_nama',    width: 70,  hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'Pelaksanaan Tgl Start', dataIndex: 'pelaksana_startdate',     width: 120,groupable : false,filter:{type:'string'}},
                    {header: 'Pelaksanaan Tgl End', dataIndex: 'pelaksana_endate',     width: 120,groupable : false,filter:{type:'string'}},
                    {header: 'Deskripsi',       dataIndex: 'deskripsi',         width: 100, hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'Biaya',         dataIndex: 'biaya',           width: 100, hidden:false,groupable : false,filter:{type:'string'}},
                    {header: 'Jenis',           dataIndex: 'jenis',             width: 100,hidden:false, groupable: false,filter:{type:'string'},
                        renderer:function(value){
                            if (value === '1')
                            {
                                return "PEMELIHARAAN";
                            }
                            else if (value === '2')
                            {
                                return "PERAWATAN";
                            }
                            else
                            {
                                return "";
                            }
                        }
                    },
					{header: ' SubJenis',           dataIndex: 'subjenis',             width: 100,hidden:false, groupable: false,filter:{type:'string'},
                        renderer:function(value){
                            if (value === '1')
                            {
                                return "ARSITEKTURAL";
                            }
                            else if (value === '2')
                            {
                                return "STRUKTURAL";
                            }
                            else if (value === '3')
                            {
                                return "MEKANIKAL";
                            }
                            else if (value === '4')
                            {
                                return "ELEKTRIKAL";
                            }
                            else if (value === '5')
                            {
                                return "TATA RUANG LUAR";
                            }
                            else if (value === '6')
                            {
                                return "TATA GRAHA (HOUSE KEEPING)";
                            }
                            else if (value === '11')
                            {
                                return "REHABILITASI";
                            }
                            else if (value === '12')
                            {
                                return "RENOVASI";
                            }
                            else if (value === '13')
                            {
                                return "RESTORASI";
                            }
                            else if (value === '14')
                            {
                                return "PERAWATAN KERUSAKAN";
                            }
                            else
                            {
                                return "";
                            }
                        }
                    },
                      {header: 'Image Url', dataIndex: 'image_url',     width: 120,groupable : false,filter:{type:'string'}},
                      {header: 'Document Url', dataIndex: 'document_url',     width: 120,groupable : false,filter:{type:'string'}},
                    ]
        },
        search : {
            id : 'search_PemeliharaanBangunan'
        },
        toolbar : {
            id : 'toolbar_PemeliharaanBangunan',
            add : {
                id : 'button_add_PemeliharaanBangunan',
                action : PemeliharaanBangunan.Action.add
            },
            edit : {
                id : 'button_edit_PemeliharaanBangunan',
                action : PemeliharaanBangunan.Action.edit
            },
            remove : {
                id : 'button_remove_PemeliharaanBangunan',
                action : PemeliharaanBangunan.Action.remove
            },
            print : {
                id : 'button_pring_PemeliharaanBangunan',
                action : PemeliharaanBangunan.Action.print
            }
        }
};
PemeliharaanBangunan.Grid.grid = Grid.processGrid(setting,PemeliharaanBangunan.Data);
/*PemeliharaanBangunan.Grid.grid = Grid.inventarisGrid(setting,'');*/

var new_tabpanel = {
    xtype:'panel',
    id: 'pemeliharaan_asset_bangunan', title: 'Pemeliharaan Bangunan', iconCls: 'icon-menu_impasing', border: false, closable: true, 
    layout: 'border', items: [Region.filterPanelPemeliharaanBangunan(PemeliharaanBangunan.Data),PemeliharaanBangunan.Grid.grid]
};

/*var new_tabpanel = {
    id: 'pemeliharaan_asset_bangunan', title: 'Pemeliharaan Bangunan', iconCls: 'icon-menu_impasing', closable: true, border: false,
    items: [PemeliharaanBangunan.Grid.grid]
}*/
            
<?php }else{ echo "var new_tabpanel_MD = 'GAGAL';"; } ?>