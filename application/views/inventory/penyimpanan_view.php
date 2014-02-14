<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_InventoryPenyimpanan = null;

        Ext.namespace('InventoryPenyimpanan', 'InventoryPenyimpanan.reader', 'InventoryPenyimpanan.proxy', 'InventoryPenyimpanan.Data', 'InventoryPenyimpanan.Grid', 'InventoryPenyimpanan.Window', 'InventoryPenyimpanan.Form', 'InventoryPenyimpanan.Action', 'InventoryPenyimpanan.URL');
        
        InventoryPenyimpanan.dataStoreParts = new Ext.create('Ext.data.Store', {
            model: MPartsPenyimpanan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'inventory_perlengkapan/getSpecificInventoryPenyimpananPerlengkapan',
                create: BASE_URL + 'inventory_perlengkapan/createInventoryPenyimpananPerlengkapan',
                update: BASE_URL + 'inventory_perlengkapan/updateInventoryPenyimpananPerlengkapan',
                destroy: BASE_URL + 'inventory_perlengkapan/destroyInventoryPenyimpananPerlengkapan'
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
        
        InventoryPenyimpanan.dataStoreSubParts = new Ext.create('Ext.data.Store', {
            model: MSubPartsPenyimpanan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'inventory_perlengkapan/getSpecificInventoryPenyimpananPerlengkapanSubPart',
                create: BASE_URL + 'inventory_perlengkapan/createInventoryPenyimpananPerlengkapanSubPart',
                update: BASE_URL + 'inventory_perlengkapan/updateInventoryPenyimpananPerlengkapanSubPart',
                destroy: BASE_URL + 'inventory_perlengkapan/destroyInventoryPenyimpananPerlengkapanSubPart'
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

        InventoryPenyimpanan.dataStoreSubSubParts = new Ext.create('Ext.data.Store', {
            model: MSubSubPartsPenyimpanan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'inventory_perlengkapan/getSpecificInventoryPenyimpananPerlengkapanSubSubPart',
                create: BASE_URL + 'inventory_perlengkapan/createInventoryPenyimpananPerlengkapanSubSubPart',
                update: BASE_URL + 'inventory_perlengkapan/updateInventoryPenyimpananPerlengkapanSubSubPart',
                destroy: BASE_URL + 'inventory_perlengkapan/destroyInventoryPenyimpananPerlengkapanSubSubPart'
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
        
        InventoryPenyimpanan.URL = {
            read: BASE_URL + 'inventory_penyimpanan/getAllData',
            createUpdate: BASE_URL + 'inventory_penyimpanan/modifyInventoryPenyimpanan',
            remove: BASE_URL + 'inventory_penyimpanan/deleteInventoryPenyimpanan'
        };

        InventoryPenyimpanan.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.InventoryPenyimpanan', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        InventoryPenyimpanan.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        InventoryPenyimpanan.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_InventoryPenyimpanan',
            url: InventoryPenyimpanan.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: InventoryPenyimpanan.reader,
            writer: InventoryPenyimpanan.writer,
            afterRequest: function(request, success) {
                Params_M_InventoryPenyimpanan = request.operation.params;
            }
        });

        InventoryPenyimpanan.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_InventoryPenyimpanan', storeId: 'DataInventoryPenyimpanan', model: 'MInventoryPenyimpanan', pageSize: 20, noCache: false, autoLoad: true,
            proxy: InventoryPenyimpanan.proxy, groupField: 'tipe'
        });

        InventoryPenyimpanan.Form.create = function(data, edit) {
            
            var setting_grid_parts = {
                id:'grid_inventory_penyimpanan_parts',
                toolbar:{
                    add: InventoryPenyimpanan.addParts,
                    edit: InventoryPenyimpanan.editParts,
                    remove: InventoryPenyimpanan.removeParts
                },
                dataStore:InventoryPenyimpanan.dataStoreParts,
            };
            
            var setting_grid_sub_parts = {
                id:'grid_inventory_penyimpanan_sub_parts',
                toolbar:{
                    add: InventoryPenyimpanan.addSubParts,
                    edit: InventoryPenyimpanan.editSubParts,
                    remove: InventoryPenyimpanan.removeSubParts
                },
                dataStore:InventoryPenyimpanan.dataStoreSubParts,
            };
    
            var setting_grid_sub_sub_parts = {
                id:'grid_inventory_penyimpanan_sub_sub_parts',
                toolbar:{
                    add: InventoryPenyimpanan.addSubSubParts,
                    edit: InventoryPenyimpanan.editSubSubParts,
                    remove: InventoryPenyimpanan.removeSubSubParts
                },
                dataStore:InventoryPenyimpanan.dataStoreSubSubParts,
            };
            
            var setting = {
                url: InventoryPenyimpanan.URL.createUpdate,
                data: InventoryPenyimpanan.Data,
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
                            console.error('There is existing grid in the popup selection - inventorypenyimpanan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

            var form = Form.inventoryPenyimpanan(setting,setting_grid_parts,setting_grid_sub_parts,setting_grid_sub_sub_parts);

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
        
        
        InventoryPenyimpanan.addParts = function()
        {
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.secondaryWindowAssetInventoryPenyimpanan(InventoryPenyimpanan.dataStoreParts,'add');
                    form.insert(0, Form.Component.dataInventoryPerlengkapanWithWarehouse());
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
        };

        InventoryPenyimpanan.editParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penyimpanan_parts');
            var selected = grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {

                var data = selected[0].data;
                var storeIndex = grid.store.indexOf(selected[0]);
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.secondaryWindowAssetInventoryPenyimpanan(InventoryPenyimpanan.dataStoreParts, 'edit',storeIndex);
                    form.insert(0, Form.Component.dataInventoryPerlengkapanWithWarehouse(true));

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

        InventoryPenyimpanan.removeParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penyimpanan_parts');
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
                            
                            
                            var gridStoreRecords = Ext.getCmp('grid_inventory_penyimpanan_parts').getStore().getRange();
                            var count_of_invalid_values = parseInt(0);
                            Ext.Array.each(gridStoreRecords,function(key,index,self)
                            {
                                if(gridStoreRecords[index].data.id_warehouse == '' || gridStoreRecords[index].data.id_warehouse_ruang == '')
                                {
                                    count_of_invalid_values++;
                                }
                            });
                            Ext.getCmp('inventory_penyimpanan_grid_invalid_data').setValue(count_of_invalid_values);
                        }
                    }
                });
            }
        };
        
        InventoryPenyimpanan.addSubParts = function()
        {
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Sub Part');
            }
                var form = Form.secondaryWindowAssetInventoryPenyimpananSubPart(InventoryPenyimpanan.dataStoreSubParts,'add');
                form.insert(0, Form.Component.dataInventoryPerlengkapanSubPartWithWarehouse(false,form));
                Modal.assetSecondaryWindow.add(form);
                Modal.assetSecondaryWindow.show();
        };
        
        InventoryPenyimpanan.editSubParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penyimpanan_sub_parts');
            var selected = grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {

                var data = selected[0].data;
                var storeIndex = grid.store.indexOf(selected[0]);

                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Sub Part');
                }
                    var form = Form.secondaryWindowAssetInventoryPenyimpananSubPart(InventoryPenyimpanan.dataStoreSubParts, 'edit',storeIndex);
                    form.insert(0, Form.Component.dataInventoryPerlengkapanSubPartWithWarehouse(true,form));

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

            }
        };

        InventoryPenyimpanan.removeSubParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penyimpanan_sub_parts');
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
                            
                            var gridStoreRecords = Ext.getCmp('grid_inventory_penyimpanan_sub_parts').getStore().getRange();
                                    var count_of_invalid_values = parseInt(0);
                                    Ext.Array.each(gridStoreRecords,function(key,index,self)
                                    {
                                        if(gridStoreRecords[index].data.id_warehouse == '' || gridStoreRecords[index].data.id_warehouse_ruang == '')
                                        {
                                            count_of_invalid_values++;
                                        }
                                    });
                                    Ext.getCmp('inventory_penyimpanan_grid_sub_parts_invalid_data').setValue(count_of_invalid_values);
                        }
                    }
                });
            }
        };

        InventoryPenyimpanan.addSubSubParts = function()
        {
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Sub Sub Part');
                }
                    var form = Form.secondaryWindowAssetInventoryPenyimpananSubSubPart(InventoryPenyimpanan.dataStoreSubSubParts,'add');
                    form.insert(0, Form.Component.dataInventoryPerlengkapanSubSubPartWithWarehouse(false,form));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
        };

        InventoryPenyimpanan.editSubSubParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penyimpanan_sub_sub_parts');
            var selected = grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {

                var data = selected[0].data;
                var storeIndex = grid.store.indexOf(selected[0]);

                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Sub Sub Part');
                }
                    var form = Form.secondaryWindowAssetInventoryPenyimpananSubSubPart(InventoryPenyimpanan.dataStoreSubSubParts, 'edit',storeIndex);
                    form.insert(0, Form.Component.dataInventoryPerlengkapanSubSubPartWithWarehouse(true,form));

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

         }
        };

        InventoryPenyimpanan.removeSubSubParts = function()
        {
            var grid = Ext.getCmp('grid_inventory_penyimpanan_sub_sub_parts');
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
                            
                            var gridStoreRecords = Ext.getCmp('grid_inventory_penyimpanan_sub_sub_parts').getStore().getRange();
                                    var count_of_invalid_values = parseInt(0);
                                    Ext.Array.each(gridStoreRecords,function(key,index,self)
                                    {
                                        if(gridStoreRecords[index].data.id_warehouse == '' || gridStoreRecords[index].data.id_warehouse_ruang == '')
                                        {
                                            count_of_invalid_values++;
                                        }
                                    });
                                    Ext.getCmp('inventory_penyimpanan_grid_sub_sub_parts_invalid_data').setValue(count_of_invalid_values);
                        }
                    }
                });
            }
        };

        InventoryPenyimpanan.Action.add = function() {
            var _form = InventoryPenyimpanan.Form.create(null, false);
            Modal.processCreate.setTitle('Create Inventory Penyimpanan');
            Modal.processCreate.add(_form);
            InventoryPenyimpanan.dataStoreParts.changeParams({params:{open:'0'}});
            InventoryPenyimpanan.dataStoreParts.removed = [];
            InventoryPenyimpanan.dataStoreSubParts.changeParams({params:{open:'0'}});
            InventoryPenyimpanan.dataStoreSubParts.removed = [];
            InventoryPenyimpanan.dataStoreSubSubParts.changeParams({params:{open:'0'}});
            InventoryPenyimpanan.dataStoreSubSubParts.removed = [];
            Modal.processCreate.show();
        };

        InventoryPenyimpanan.Action.edit = function() {
            var selected = InventoryPenyimpanan.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Inventory Penyimpanan');
                }
                var _form = InventoryPenyimpanan.Form.create(data, true);
                Modal.processEdit.add(_form);
                InventoryPenyimpanan.dataStoreParts.changeParams({params:{open:'1',id_source:data.id}});
                InventoryPenyimpanan.dataStoreParts.removed = [];
                InventoryPenyimpanan.dataStoreSubParts.changeParams({params:{open:'1',id_source:data.id}});
                InventoryPenyimpanan.dataStoreSubParts.removed = [];
                InventoryPenyimpanan.dataStoreSubSubParts.changeParams({params:{open:'1',id_source:data.id}});
                InventoryPenyimpanan.dataStoreSubSubParts.removed = [];
                Modal.processEdit.show();
            }
        };

        InventoryPenyimpanan.Action.remove = function() {
            var selected = InventoryPenyimpanan.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, InventoryPenyimpanan.URL.remove, InventoryPenyimpanan.Data);
        };

        InventoryPenyimpanan.Action.print = function() {
            var selected = InventoryPenyimpanan.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = InventoryPenyimpanan.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Inventory_Penyimpanan_Model";
            var title = "Inventory Penyimpanan";
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
                id: 'grid_InventoryPenyimpanan',
                title: 'DAFTAR INVENTORY PENYIMPANAN',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID', dataIndex: 'id', width: 50, hidden: true, groupable: false, filter: {type: 'number'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 180, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Tanggal Berita Acara', dataIndex: 'tgl_berita_acara', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Nomor Berita Acara', dataIndex: 'nomor_berita_acara', width: 90, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Date Created', dataIndex: 'date_created', width: 100, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Keterangan', dataIndex: 'keterangan', width: 120, hidden: false, filter: {type: 'string'}},
                    {header: 'Tanggal Penyimpanan', dataIndex: 'tgl_penyimpanan', width: 90, hidden: false, filter: {type: 'string'}},
                  
                ]
            },
            search: {
                id: 'search_InventoryPenyimpanan'
            },
            toolbar: {
                id: 'toolbar_InventoryPenyimpanan',
                add: {
                    id: 'button_add_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.add,
                    disabled:inventory_penyimpanan_insert
                },
                edit: {
                    id: 'button_edit_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.edit,
                    disabled:inventory_penyimpanan_update
                },
                remove: {
                    id: 'button_remove_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.remove,
                    disabled:inventory_penyimpanan_delete
                },
                print: {
                    id: 'button_print_InventoryPenyimpanan',
                    action: InventoryPenyimpanan.Action.print,
                    disabled:inventory_penyimpanan_print
                }
            }
        };

        InventoryPenyimpanan.Grid.grid = Grid.processGrid(setting, InventoryPenyimpanan.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'inventory_penyimpanan_panel', title: 'Inventory - Penyimpanan', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [InventoryPenyimpanan.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>