<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_InventoryPenerimaanPemeriksaan = null;

        Ext.namespace('InventoryPenerimaanPemeriksaan', 'InventoryPenerimaanPemeriksaan.reader', 'InventoryPenerimaanPemeriksaan.proxy', 'InventoryPenerimaanPemeriksaan.Data', 'InventoryPenerimaanPemeriksaan.Grid', 'InventoryPenerimaanPemeriksaan.Window', 'InventoryPenerimaanPemeriksaan.Form', 'InventoryPenerimaanPemeriksaan.Action', 'InventoryPenerimaanPemeriksaan.URL');
        
        InventoryPenerimaanPemeriksaan.dataStoreParts = new Ext.create('Ext.data.Store', {
            model: MParts, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'inventory_perlengkapan/getSpecificInventoryPenerimaanPemeriksaanPerlengkapan',
                create: BASE_URL + 'inventory_perlengkapan/createInventoryPenerimaanPemeriksaanPerlengkapan',
                update: BASE_URL + 'inventory_perlengkapan/updateInventoryPenerimaanPemeriksaanPerlengkapan',
                destroy: BASE_URL + 'inventory_perlengkapan/destroyInventoryPenerimaanPemeriksaanPerlengkapan'
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
    
        InventoryPenerimaanPemeriksaan.URL = {
            read: BASE_URL + 'inventory_penerimaan_pemeriksaan/getAllData',
            createUpdate: BASE_URL + 'inventory_penerimaan_pemeriksaan/modifyInventoryPenerimaanPemeriksaan',
            remove: BASE_URL + 'inventory_penerimaan_pemeriksaan/deleteInventoryPenerimaanPemeriksaan'
        };

        InventoryPenerimaanPemeriksaan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.InventoryPenerimaanPemeriksaan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        InventoryPenerimaanPemeriksaan.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        InventoryPenerimaanPemeriksaan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_InventoryPenerimaanPemeriksaan',
            url: InventoryPenerimaanPemeriksaan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: InventoryPenerimaanPemeriksaan.reader,
            writer: InventoryPenerimaanPemeriksaan.writer,
            afterRequest: function(request, success) {
                Params_M_InventoryPenerimaanPemeriksaan = request.operation.params;
            }
        });

        InventoryPenerimaanPemeriksaan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_InventoryPenerimaanPemeriksaan', storeId: 'DataInventoryPenerimaanPemeriksaan', model: 'MInventoryPenerimaanPemeriksaan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: InventoryPenerimaanPemeriksaan.proxy, groupField: 'tipe'
        });

        InventoryPenerimaanPemeriksaan.Form.create = function(data, edit) {
            
            var setting_grid_parts = {
                id:'grid_inventory_penerimaan_pemeriksaan_parts',
                toolbar:{
                    add: InventoryPenerimaanPemeriksaan.addParts,
                    edit: InventoryPenerimaanPemeriksaan.editParts,
                    remove: InventoryPenerimaanPemeriksaan.removeParts
                },
                dataStore:InventoryPenerimaanPemeriksaan.dataStoreParts,
            };
    
            var setting = {
                url: InventoryPenerimaanPemeriksaan.URL.createUpdate,
                data: InventoryPenerimaanPemeriksaan.Data,
                isEditing: edit,
                addBtn: {
                    isHidden: true,
                    text: 'Add Asset',
                    fn: function() {

                        if (Modal.assetSelection.items.length === 0)
                        {
                            Modal.assetSelection.add(Grid.selectionAsset());
                            Modal.assetSelection.show();
                        }
                        else
                        {
                            console.error('There is existing grid in the popup selection - inventorypenerimaan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

            var form = Form.inventoryPenerimaanPemeriksaan(setting,setting_grid_parts);

            if (data !== null)
            {
                Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
                if(data.id_pengadaan == 0)
                {
                    data.id_pengadaan = '';
                }
                form.getForm().setValues(data);
            }
            return form;
        };
        
        InventoryPenerimaanPemeriksaan.addParts = function()
        {
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.secondaryWindowAsset(InventoryPenerimaanPemeriksaan.dataStoreParts,'add');
                    form.insert(0, Form.Component.dataInventoryPerlengkapan());
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
        };

        InventoryPenerimaanPemeriksaan.editParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penerimaan_pemeriksaan_parts');
            var selected = grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {

                var data = selected[0].data;
                var storeIndex = grid.store.indexOf(selected[0]);

                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.secondaryWindowAsset(InventoryPenerimaanPemeriksaan.dataStoreParts, 'edit',storeIndex);
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

        InventoryPenerimaanPemeriksaan.removeParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penerimaan_pemeriksaaan_parts');
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

        InventoryPenerimaanPemeriksaan.Action.add = function() {
            var _form = InventoryPenerimaanPemeriksaan.Form.create(null, false);
            Modal.processCreate.setTitle('Create Inventory Penerimaan/Pemeriksaan');
            Modal.processCreate.add(_form);
            InventoryPenerimaanPemeriksaan.dataStoreParts.changeParams({params:{open:'0'}});
            InventoryPenerimaanPemeriksaan.dataStoreParts.removed = [];
            Modal.processCreate.show();
            
        };

        InventoryPenerimaanPemeriksaan.Action.edit = function() {
            var selected = InventoryPenerimaanPemeriksaan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Inventory Penerimaan/Pemeriksaan');
                }
                var _form = InventoryPenerimaanPemeriksaan.Form.create(data, true);
                Modal.processEdit.add(_form);
                InventoryPenerimaanPemeriksaan.dataStoreParts.changeParams({params:{open:'1',id_source:data.id}});
                InventoryPenerimaanPemeriksaan.dataStoreParts.removed = [];
                Modal.processEdit.show();
            }
        };

        InventoryPenerimaanPemeriksaan.Action.remove = function() {
            var selected = InventoryPenerimaanPemeriksaan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, InventoryPenerimaanPemeriksaan.URL.remove, InventoryPenerimaanPemeriksaan.Data);
        };

        InventoryPenerimaanPemeriksaan.Action.print = function() {
            var selected = InventoryPenerimaanPemeriksaan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = InventoryPenerimaanPemeriksaan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
            var gridHeaderList = "";
            //index starts at 2 to exclude the No. column
            for (var i = 2; i < gridHeader.length; i++)
            {
                if (gridHeader[i].dataIndex == undefined || gridHeader[i].dataIndex == "") //filter the action columns in grid
                {
                    //do nothing
                }
                else
                {
                    gridHeaderList += gridHeader[i].text + "&&" + gridHeader[i].dataIndex + "^^";
                }
            }

            var serverSideModelName = "Inventory_Penerimaan_Model";
            var title = "Inventory Penerimaan";
            var primaryKeys = "id";

            my_form = document.createElement('FORM');
            my_form.name = 'myForm';
            my_form.method = 'POST';
            my_form.action = BASE_URL + 'excel_management/exportToExcel/';

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'serverSideModelName';
            my_tb.value = serverSideModelName;
            my_form.appendChild(my_tb);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'title';
            my_tb.value = title;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'primaryKeys';
            my_tb.value = primaryKeys;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'gridHeaderList';
            my_tb.value = gridHeaderList;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_tb = document.createElement('INPUT');
            my_tb.type = 'HIDDEN';
            my_tb.name = 'selectedData';
            my_tb.value = selectedData;
            my_form.appendChild(my_tb);
            document.body.appendChild(my_form);

            my_form.submit();
        };

        var setting = {
            grid: {
                id: 'grid_InventoryPenerimaanPemeriksaan',
                title: 'DAFTAR INVENTORY PENERIMAAN/PEMERIKSAAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID', dataIndex: 'id', width: 50, hidden: true, groupable: false, filter: {type: 'number'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 180, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'No Aset', dataIndex: 'no_aset', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Tanggal Berita Acara', dataIndex: 'tgl_berita_acara', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nomor Berita Acara', dataIndex: 'nomor_berita_acara', width: 90, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Date Created', dataIndex: 'date_created', width: 100, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Keterangan', dataIndex: 'keterangan', width: 120, hidden: false, filter: {type: 'string'}},
                    {header: 'Tanggal Penerimaan', dataIndex: 'tgl_penerimaan', width: 90, hidden: false, filter: {type: 'string'}},
                    {header: 'Nama Penerima/Pemeriksa', dataIndex: 'nama_org', width: 90, hidden: false, filter: {type: 'string'}},
                ]
            },
            search: {
                id: 'search_InventoryPenerimaanPemeriksaan'
            },
            toolbar: {
                id: 'toolbar_InventoryPenerimaanPemeriksaan',
                add: {
                    id: 'button_add_InventoryPenerimaanPemeriksaan',
                    action: InventoryPenerimaanPemeriksaan.Action.add,
                    disabled:inventory_penerimaan_pemeriksaan_insert,
                },
                edit: {
                    id: 'button_edit_InventoryPenerimaanPemeriksaan',
                    action: InventoryPenerimaanPemeriksaan.Action.edit,
                    disabled:inventory_penerimaan_pemeriksaan_update,
                },
                remove: {
                    id: 'button_remove_InventoryPenerimaanPemeriksaan',
                    action: InventoryPenerimaanPemeriksaan.Action.remove,
                    disabled:inventory_penerimaan_pemeriksaan_delete,
                },
                print: {
                    id: 'button_print_InventoryPenerimaanPemeriksaan',
                    action: InventoryPenerimaanPemeriksaan.Action.print,
                    disabled:inventory_penerimaan_pemeriksaan_print,
                }
            }
        };

        InventoryPenerimaanPemeriksaan.Grid.grid = Grid.processGrid(setting, InventoryPenerimaanPemeriksaan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'inventory_penerimaan_pemeriksaan_panel', title: 'Inventory - Penerimaan/Pemeriksaan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [InventoryPenerimaanPemeriksaan.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>