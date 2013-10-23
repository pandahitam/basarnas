<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_PemeliharaanDarat = null;

        Ext.namespace('PemeliharaanDarat', 'PemeliharaanDarat.reader', 'PemeliharaanDarat.proxy', 'PemeliharaanDarat.Data', 'PemeliharaanDarat.Grid', 'PemeliharaanDarat.Window', 'PemeliharaanDarat.Form', 'PemeliharaanDarat.Action', 'PemeliharaanDarat.URL');
        
        PemeliharaanDarat.dataStorePemeliharaanParts = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPart, autoLoad: false, noCache: false, clearRemovedOnLoad: true,
            proxy: new Ext.data.AjaxProxy({
                actionMethods: {read: 'POST'},
                api: {
                read: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanParts',
                create: BASE_URL + 'pemeliharaan_part/createPemeliharaanParts',
                update: BASE_URL + 'pemeliharaan_part/updatePemeliharaanParts',
                destroy: BASE_URL + 'pemeliharaan_part/destroyPemeliharaanParts'
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
        
        PemeliharaanDarat.URL = {
            read: BASE_URL + 'Pemeliharaan_Darat/getAllData',
            createUpdate: BASE_URL + 'Pemeliharaan_Darat/modifyPemeliharaanDarat',
            remove: BASE_URL + 'Pemeliharaan_Darat/deletePemeliharaanDarat',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart'
        };

        PemeliharaanDarat.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.PemeliharaanDarat', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        PemeliharaanDarat.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        PemeliharaanDarat.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_PemeliharaanDarat',
            url: PemeliharaanDarat.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: PemeliharaanDarat.reader,
            writer: PemeliharaanDarat.writer,
            afterRequest: function(request, success) {
                Params_M_PemeliharaanDarat = request.operation.params;
            }
        });

        PemeliharaanDarat.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_PemeliharaanDarat', storeId: 'DataPemeliharaanDarat', model: 'MPemeliharaanDarat', pageSize: 20, noCache: false, autoLoad: true,
            proxy: PemeliharaanDarat.proxy, groupField: 'tipe'
        });
        

        PemeliharaanDarat.Form.create = function(data, edit) {
            var tipe_angkutan = 'darat';
            var setting = {
                tipe_angkutan:tipe_angkutan,
                url: PemeliharaanDarat.URL.createUpdate,
                data: PemeliharaanDarat.Data,
                isEditing: edit,
                addBtn: {
                    isHidden: edit,
                    text: 'Add Asset',
                    fn: function() {

                        if (Modal.assetSelection.items.length === 0)
                        {
                            Modal.assetSelection.add(Grid.selectionAsset(tipe_angkutan));
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
                    add: PemeliharaanDarat.addPemeliharaanPart,
                    edit: PemeliharaanDarat.editPemeliharaanPart,
                    remove: PemeliharaanDarat.removePemeliharaanPart
                },
                dataStore:PemeliharaanDarat.dataStorePemeliharaanParts
            };

            var form = Form.pemeliharaanWithParts(setting,setting_grid_pemeliharaan_part);
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
                
                $.ajax({
                       url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaan',
                       type: "POST",
                       dataType:'json',
                       async:false,
                       data:{tipe_angkutan:'darat',id_ext_asset:data.id},
                       success:function(response, status){
                        if(response.status == 'success')
                        {
                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Km';
                        }
                           
                       }
                    });
                
                form.getForm().setValues(data);
            }
            return form;
        };
        
        PemeliharaanDarat.addPemeliharaanPart = function(){
         if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.secondaryWindowAsset(PemeliharaanDarat.dataStorePemeliharaanParts,'add');
                    form.insert(0, Form.Component.dataPemeliharaanParts());
                    form.insert(1, Form.Component.dataInventoryPerlengkapan(true));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
        };
        
        PemeliharaanDarat.editPemeliharaanPart = function(){
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
                    var form = Form.secondaryWindowAsset(PemeliharaanDarat.dataStorePemeliharaanParts, 'edit',storeIndex);
                    form.insert(0, Form.Component.dataPemeliharaanParts(true));
                    form.insert(1, Form.Component.dataInventoryPerlengkapan(true));

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
        
        PemeliharaanDarat.removePemeliharaanPart = function(){
            var grid = Ext.getCmp('grid_pemeliharaan_parts');
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

        PemeliharaanDarat.Action.add = function() {
            var _form = PemeliharaanDarat.Form.create(null, false);
            Modal.processCreate.setTitle('Create Pemeliharaan Darat');
            Modal.processCreate.add(_form);
              PemeliharaanDarat.dataStorePemeliharaanParts.changeParams({params:{open:'0'}});
            PemeliharaanDarat.dataStorePemeliharaanParts.removed = [];
            Modal.processCreate.show();
        };

        PemeliharaanDarat.Action.edit = function() {
            var selected = PemeliharaanDarat.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit Pemeliharaan Darat');
                }
                var _form = PemeliharaanDarat.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
                PemeliharaanDarat.dataStorePemeliharaanParts.changeParams({params:{id_pemeliharaan:data.id}});
                PemeliharaanDarat.dataStorePemeliharaanParts.removed = [];
            }
        };

        PemeliharaanDarat.Action.remove = function() {
            var selected = PemeliharaanDarat.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, PemeliharaanDarat.URL.remove, PemeliharaanDarat.Data);
        };

        PemeliharaanDarat.Action.print = function() {
            var selected = PemeliharaanDarat.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = PemeliharaanDarat.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Pemeliharaan_Darat_Model";
            var title = "Pemeliharaan Darat";
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
                id: 'grid_PemeliharaanDarat',
                title: 'DAFTAR PEMELIHARAAN KENDARAAN DARAT',
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
                id: 'search_PemeliharaanDarat'
            },
            toolbar: {
                id: 'toolbar_PemeliharaanDarat',
                add: {
                    id: 'button_add_PemeliharaanDarat',
                    action: PemeliharaanDarat.Action.add
                },
                edit: {
                    id: 'button_edit_PemeliharaanDarat',
                    action: PemeliharaanDarat.Action.edit
                },
                remove: {
                    id: 'button_remove_PemeliharaanDarat',
                    action: PemeliharaanDarat.Action.remove
                },
                print: {
                    id: 'button_print_PemeliharaanDarat',
                    action: PemeliharaanDarat.Action.print
                }
            }
        };

        PemeliharaanDarat.Grid.grid = Grid.processGrid(setting, PemeliharaanDarat.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'pemeliharaan_asset_kendaraan_darat', title: 'Pemeliharaan Darat ', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Region.filterPanelPemeliharaan(PemeliharaanDarat.Data,'pemeliharaan_kendaraan_darat'), PemeliharaanDarat.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>