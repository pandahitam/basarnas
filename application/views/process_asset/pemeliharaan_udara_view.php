<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_PemeliharaanUdara = null;

        Ext.namespace('PemeliharaanUdara', 'PemeliharaanUdara.reader', 'PemeliharaanUdara.proxy', 'PemeliharaanUdara.Data', 'PemeliharaanUdara.Grid', 'PemeliharaanUdara.Window', 'PemeliharaanUdara.Form', 'PemeliharaanUdara.Action', 'PemeliharaanUdara.URL');
        
        PemeliharaanUdara.dataStorePemeliharaanParts = new Ext.create('Ext.data.Store', {
            model: MAngkutanUdaraPerlengkapan, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPartsAngkutanUdara',
                create: BASE_URL + 'pemeliharaan_part/createPemeliharaanPartsAngkutanUdara',
                update: BASE_URL + 'pemeliharaan_part/updatePemeliharaanPartsAngkutanUdara',
                destroy: BASE_URL + 'pemeliharaan_part/destroyPemeliharaanPartsAngkutanUdara'
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
        
        PemeliharaanUdara.URL = {
            read: BASE_URL + 'Pemeliharaan_Udara/getAllData',
            createUpdate: BASE_URL + 'Pemeliharaan_Udara/modifyPemeliharaanUdara',
            remove: BASE_URL + 'Pemeliharaan_Udara/deletePemeliharaanUdara',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart'
        };

        PemeliharaanUdara.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.PemeliharaanUdara', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        PemeliharaanUdara.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        PemeliharaanUdara.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_PemeliharaanUdara',
            url: PemeliharaanUdara.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: PemeliharaanUdara.reader,
            writer: PemeliharaanUdara.writer,
            afterRequest: function(request, success) {
                Params_M_PemeliharaanUdara = request.operation.params;
            }
        });

        PemeliharaanUdara.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_PemeliharaanUdara', storeId: 'DataPemeliharaanUdara', model: 'MPemeliharaanUdara', pageSize: 20, noCache: false, autoLoad: true,
            proxy: PemeliharaanUdara.proxy, groupField: 'tipe'
        });

        PemeliharaanUdara.Form.create = function(data, edit) {
           var tipe_angkutan = 'udara';
           var setting = {
                tipe_angkutan:tipe_angkutan,
                url: PemeliharaanUdara.URL.createUpdate,
                data: PemeliharaanUdara.Data,
                isEditing: edit,
                addBtn: {
                    isHidden: edit,
                    text: 'Add Asset',
                    fn: function() {

                        if (Modal.assetSelection.items.length === 0)
                        {
                            Modal.assetSelection.add(Grid.selectionAssetAngkutan(tipe_angkutan, PemeliharaanUdara.dataStorePemeliharaanParts));
                            Modal.assetSelection.show();
                        }
                        else
                        {
                            console.error('There is existing grid in the popup selection - pemeliharaan');
                        }
                    }
                },
                selectionAsset: {
                    noAsetHidden: false
                }
            };

                var setting_grid_pemeliharaan_part = {
                id:'grid_pemeliharaan_parts',
                toolbar:{
                    add: PemeliharaanUdara.addPemeliharaanPart,
                    edit: PemeliharaanUdara.editPemeliharaanPart,
                    remove: PemeliharaanUdara.removePemeliharaanPart
                },
                dataStore:PemeliharaanUdara.dataStorePemeliharaanParts
            };

            var form = Form.pemeliharaanWithPartsAngkutan(setting,setting_grid_pemeliharaan_part);

            if (data !== null)
            {
                if(data.unit_waktu != 0)
                {
                    data.comboUnitWaktuOrUnitPenggunaan = 1;
                }
                if(data.unit_pengunaan != 0)
                {
                    data.comboUnitWaktuOrUnitPenggunaan = 2;
                }
                
                Ext.Object.each(data,function(key,value,myself){
                            if(data[key] == '0000-00-00')
                            {
                                data[key] = '';
                            }
                        });
                
//                $.ajax({
//                       url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
//                       type: "POST",
//                       dataType:'json',
//                       async:false,
//                       data:{tipe_angkutan:'udara',id_ext_asset:data.id},
//                       success:function(response, status){
//                        if(response.status == 'success')
//                        {
//                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Jam';
//                        }
//                           
//                       }
//                    });
                if(edit == true)
                {
                    form.getForm().findField('penambahan_umur').setReadOnly(true);
                }
                form.getForm().setValues(data);
            }
            return form;
        };
        
        PemeliharaanUdara.addPemeliharaanPart = function(){
            if (Modal.assetSecondaryWindow.items.length === 0)
            {
                Modal.assetSecondaryWindow.setTitle('Tambah Part');
            }
            var form = Form.secondaryWindowAsset(PemeliharaanUdara.dataStorePemeliharaanParts,'add');
//            form.insert(0, Form.Component.dataPemeliharaanParts());
//            form.insert(1, Form.Component.dataInventoryPerlengkapan(true));
            form.insert(0, Form.Component.dataPerlengkapanAngkutanUdara());
            Modal.assetSecondaryWindow.add(form);
            Modal.assetSecondaryWindow.show();
            Reference.Data.assetPerlengkapanPart.changeParams({params: {id_open: 1, jenis_asset:"udara"}});
            
        };
        
        PemeliharaanUdara.editPemeliharaanPart = function(){
            var grid = Ext.getCmp('grid_pemeliharaan_parts');
            var selected = grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {

                var data = selected[0].data;
                var storeIndex = grid.store.indexOf(selected[0]);
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.secondaryWindowAsset(PemeliharaanUdara.dataStorePemeliharaanParts, 'edit',storeIndex);
//                    form.insert(0, Form.Component.dataPemeliharaanParts(true));
//                    form.insert(1, Form.Component.dataInventoryPerlengkapan(true));
                    form.insert(0, Form.Component.dataPerlengkapanAngkutanUdara('',true));
                    
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
        
        PemeliharaanUdara.removePemeliharaanPart = function(){
            var grid = Ext.getCmp('grid_pemeliharaan_parts');
            var selected = grid.getSelectionModel().getSelection();
            if(selected.length > 0)
            {
//                Ext.Msg.show({
//                    title: 'Konfirmasi',
//                    msg: 'Apakah Anda yakin untuk menghapus ?',
//                    buttons: Ext.Msg.YESNO,
//                    icon: Ext.Msg.Question,
//                    fn: function(btn) {
//                        if (btn === 'yes')
//                        {
//                            Ext.each(selected, function(obj){
//                                var storeIndex = grid.store.indexOf(obj);
//                                var record = grid.store.getAt(storeIndex);
//                                grid.store.remove(record);
//                            });
//                        }
//                    }
//                });
                
                    var records=[];
                   _.each(selected, function(obj) {
                       records.push(grid.store.getAt(grid.store.indexOf(obj)));
                   });

                   var messageBox = Ext.create('Ext.window.MessageBox', {
                                                   width:350,
                                                   height: 100,
                                                   buttonText: {yes: "Hapus",no: "Simpan ke Warehouse"},

                                              });
                    messageBox.show({
                        title: 'Hapus',
                        msg: 'Pilih Tindakan',
                        buttons: Ext.Msg.YESNO,
                        icon: Ext.Msg.Question,
                        fn: function(btn) {
                            if (btn === 'yes')
                            {
                                Ext.each(records, function(obj){
        //                                var storeIndex = grid.store.indexOf(obj);
        //                                var record = grid.store.getAt(storeIndex);
                                        grid.store.remove(obj);
                                });
                            }
                            else if(btn === 'no')
                            {
        //                        var data = {id_collection:ids};
                                if (Modal.verySmallWindow.items.length === 0)
                                {
                                    Modal.verySmallWindow.setTitle('Simpan ke Warehouse');
                                }
                                var form = Form.panelVerySmall2(grid.store,records);                       
                                form.insert(3, Form.Component.warehousePerlengkapanSmall(false,form));
        //                        form.getForm().reset();
        //                        form.getForm().setValues(data);
                                Modal.verySmallWindow.add(form);
                                Modal.verySmallWindow.show();
                            }
                       }
                    });
            }
        };

        PemeliharaanUdara.Action.add = function() {
            var _form = PemeliharaanUdara.Form.create(null, false);
            Modal.processCreate.setTitle('Create PemeliharaanUdara');
            Modal.processCreate.add(_form);
            PemeliharaanUdara.dataStorePemeliharaanParts.changeParams({params:{open:'0'}});
            PemeliharaanUdara.dataStorePemeliharaanParts.removed = [];
            Modal.processCreate.show();
        };

        PemeliharaanUdara.Action.edit = function() {
            var selected = PemeliharaanUdara.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
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
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
                
                
            }
        };

        PemeliharaanUdara.Action.remove = function() {
            var selected = PemeliharaanUdara.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                    kd_lokasi:obj.data.kd_lokasi,
                    kd_brg:obj.data.kd_brg,
                    no_aset:obj.data.no_aset,
                    penambahan_umur:obj.data.penambahan_umur
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, PemeliharaanUdara.URL.remove, PemeliharaanUdara.Data);
        };

        PemeliharaanUdara.Action.print = function() {
            var selected = PemeliharaanUdara.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = PemeliharaanUdara.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Pemeliharaan_Udara_Model";
            var title = "Pemeliharaan Udara";
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
                id: 'grid_PemeliharaanUdara',
                title: 'DAFTAR PEMELIHARAAN KENDARAAN UDARA',
                column: [
                    {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                    {header: 'ID', dataIndex: 'id', width: 50, hidden: false, groupable: false, filter: {type: 'number'}},
                    {header: 'Unit Kerja', dataIndex: 'nama_unker', width: 180, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Unit Organisasi', dataIndex: 'nama_unor', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kode Barang', dataIndex: 'kd_brg', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'No Aset', dataIndex: 'no_aset', width: 130, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Nama', dataIndex: 'nama', width: 130, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Tahun Angaran', dataIndex: 'tahun_angaran', width: 90, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Pelaksanaan Tgl', dataIndex: 'pelaksana_tgl', width: 120, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Pelakasana', dataIndex: 'pelaksana_nama', width: 70, hidden: true, groupable: false, filter: {type: 'string'}},
                    {header: 'Kondisi', dataIndex: 'kondisi', width: 100, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'Deskripsi', dataIndex: 'deskripsi', width: 100, hidden: false, groupable: false, filter: {type: 'string'}},
                    {header: 'harga', dataIndex: 'harga', width: 120, hidden: false, filter: {type: 'string'}},
                    {header: 'kode_angaran', dataIndex: 'kode_angaran', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Freq Waktu', dataIndex: 'freq_waktu', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Freq Pengunaan', dataIndex: 'freq_pengunaan', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Status', dataIndex: 'status', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Durasi', dataIndex: 'durasi', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Rencana Waktu', dataIndex: 'rencana_waktu', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Rencana Pengunaan', dataIndex: 'rencana_pengunaan', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Rencana Deskripsi', dataIndex: 'rencana_deskripsi', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Alert', dataIndex: 'alert', width: 90, hidden: true, filter: {type: 'string'}},
                    {header: 'Jenis', dataIndex: 'jenis', width: 100, hidden: false, groupable: false, filter: {type: 'string'},
                        renderer: function(value) {
                            if (value === '1')
                            {
                                return "PREDICTIVE";
                            }
                            else if (value === '2')
                            {
                                return "PREVENTIVE";
                            }
                            else if (value === '3')
                            {
                                return "CORRECTIVE";
                            }
                            else
                            {
                                return "";
                            }
                        }
                    }
                ]
            },
            search: {
                id: 'search_PemeliharaanUdara'
            },
            toolbar: {
                id: 'toolbar_PemeliharaanUdara',
                add: {
                    id: 'button_add_PemeliharaanUdara',
                    action: PemeliharaanUdara.Action.add,
                    disabled:pemeliharaan_umum_kendaraan_udara_insert,
                },
                edit: {
                    id: 'button_edit_PemeliharaanUdara',
                    action: PemeliharaanUdara.Action.edit,
                    disabled:pemeliharaan_umum_kendaraan_udara_update,
                },
                remove: {
                    id: 'button_remove_PemeliharaanUdara',
                    action: PemeliharaanUdara.Action.remove,
                    disabled:pemeliharaan_umum_kendaraan_udara_delete,
                },
                print: {
                    id: 'button_print_PemeliharaanUdara',
                    action: PemeliharaanUdara.Action.print,
                    disabled:pemeliharaan_umum_kendaraan_udara_print,
                }
            }
        };

        PemeliharaanUdara.Grid.grid = Grid.processGrid(setting, PemeliharaanUdara.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'pemeliharaan_asset_kendaraan_udara', title: 'Pemeliharaan Udara ', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Region.filterPanelPemeliharaan(PemeliharaanUdara.Data,'pemeliharaan_kendaraan_udara'), PemeliharaanUdara.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>