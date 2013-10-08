<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    /////////
        var Params_M_PemeliharaanLaut = null;

        Ext.namespace('PemeliharaanLaut', 'PemeliharaanLaut.reader', 'PemeliharaanLaut.proxy', 'PemeliharaanLaut.Data', 'PemeliharaanLaut.Grid', 'PemeliharaanLaut.Window', 'PemeliharaanLaut.Form', 'PemeliharaanLaut.Action', 'PemeliharaanLaut.URL');
        
        PemeliharaanLaut.dataStorePemeliharaanPart = new Ext.create('Ext.data.Store', {
            model: MPemeliharaanPart, autoLoad: false, noCache: false,
            proxy: new Ext.data.AjaxProxy({
                url: BASE_URL + 'pemeliharaan_part/getSpecificPemeliharaanPart', actionMethods: {read: 'POST'},
                reader: new Ext.data.JsonReader({
                    root: 'results', totalProperty: 'total', idProperty: 'id'})
            })
        });
        
        PemeliharaanLaut.URL = {
            read: BASE_URL + 'Pemeliharaan_Laut/getAllData',
            createUpdate: BASE_URL + 'Pemeliharaan_Laut/modifyPemeliharaanLaut',
            remove: BASE_URL + 'Pemeliharaan_Laut/deletePemeliharaanLaut',
            createUpdatePemeliharaanPart: BASE_URL + 'pemeliharaan_part/modifyPemeliharaanPart',
            removePemeliharaanPart: BASE_URL + 'pemeliharaan_part/deletePemeliharaanPart'
        };

        PemeliharaanLaut.reader = new Ext.create('Ext.data.JsonReader', {
            id: 'Reader.PemeliharaanLaut', root: 'results', totalProperty: 'total', idProperty: 'id'
        });

        PemeliharaanLaut.writer = new Ext.create('Ext.data.JsonWriter', {type: 'json',
            allowSingle: false});

        PemeliharaanLaut.proxy = new Ext.create('Ext.data.AjaxProxy', {
            id: 'Proxy_PemeliharaanLaut',
            url: PemeliharaanLaut.URL.read, actionMethods: {read: 'POST'}, extraParams: {id_open: '1'},
            reader: PemeliharaanLaut.reader,
            writer: PemeliharaanLaut.writer,
            afterRequest: function(request, success) {
                Params_M_PemeliharaanLaut = request.operation.params;
            }
        });

        PemeliharaanLaut.Data = new Ext.create('Ext.data.Store', {
            id: 'Data_PemeliharaanLaut', storeId: 'DataPemeliharaanLaut', model: 'MPemeliharaanLaut', pageSize: 20, noCache: false, autoLoad: true,
            proxy: PemeliharaanLaut.proxy, groupField: 'tipe'
        });

        PemeliharaanLaut.Form.create = function(data, edit) {
            var tipe_angkutan = 'laut';
            var setting = {
                tipe_angkutan:tipe_angkutan,
                url: PemeliharaanLaut.URL.createUpdate,
                data: PemeliharaanLaut.Data,
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
                id:'grid_pemeliharaan_laut_pemeliharaan_part',
                toolbar:{
                    add: PemeliharaanLaut.addPemeliharaanPart,
                    edit: PemeliharaanLaut.editPemeliharaanPart,
                    remove: PemeliharaanLaut.removePemeliharaanPart
                },
                dataStore:PemeliharaanLaut.dataStorePemeliharaanPart
            };

            var form = Form.pemeliharaan(setting,setting_grid_pemeliharaan_part);

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
                       data:{tipe_angkutan:'laut',id_ext_asset:data.id},
                       success:function(response, status){
                        if(response.status == 'success')
                        {
                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Jam';
                        }
                           
                       }
                    });
                
                form.getForm().setValues(data);
            }
            return form;
        };
        
        PemeliharaanLaut.addPemeliharaanPart = function(){
            var selected = PemeliharaanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                delete data.nama_unker;
                delete data.nama_unor;
                
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Tambah Part');
                }
                    var form = Form.pemeliharaanPart(PemeliharaanLaut.URL.createUpdatePemeliharaanPart, PemeliharaanLaut.dataStorePemeliharaanPart, false);
                    form.insert(0, Form.Component.dataPemeliharaanPart(data.id));
                    form.insert(1, Form.Component.dataInventoryPerlengkapan(true));
                    Modal.assetSecondaryWindow.add(form);
                    Modal.assetSecondaryWindow.show();
                
            }
        };
        
        PemeliharaanLaut.editPemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_pemeliharaan_laut_pemeliharaan_part').getSelectionModel().getSelection();
            if (selected.length === 1)
            {
               
                var data = selected[0].data;
                
                if (Modal.assetSecondaryWindow.items.length === 0)
                {
                    Modal.assetSecondaryWindow.setTitle('Edit Part');
                }
                    var form = Form.pemeliharaanPart(PemeliharaanLaut.URL.createUpdatePemeliharaanPart, PemeliharaanLaut.dataStorePemeliharaanPart, false);
                    form.insert(0, Form.Component.dataPemeliharaanPart(data.id_pemeliharaan,true));
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
        
        PemeliharaanLaut.removePemeliharaanPart = function(){
            var selected = Ext.getCmp('grid_pemeliharaan_laut_pemeliharaan_part').getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id,
                    id_penyimpanan: obj.data.id_penyimpanan,
                    qty_pemeliharaan:obj.data.qty_pemeliharaan,
                };
                arrayDeleted.push(data);
            });
            console.log(arrayDeleted);
            Modal.deleteAlert(arrayDeleted, PemeliharaanLaut.URL.removePemeliharaanPart, PemeliharaanLaut.dataStorePemeliharaanPart);
        };

        PemeliharaanLaut.Action.add = function() {
            var _form = PemeliharaanLaut.Form.create(null, false);
            Modal.processCreate.setTitle('Create PemeliharaanLaut');
            Modal.processCreate.add(_form);
            Modal.processCreate.show();
        };

        PemeliharaanLaut.Action.edit = function() {
            var selected = PemeliharaanLaut.Grid.grid.getSelectionModel().getSelection();
            if (selected.length === 1)
            {
                var data = selected[0].data;
                delete data.nama_unker;

                if (Modal.processEdit.items.length === 0)
                {
                    Modal.processEdit.setTitle('Edit PemeliharaanLaut');
                }
                var _form = PemeliharaanLaut.Form.create(data, true);
                Modal.processEdit.add(_form);
                Modal.processEdit.show();
                PemeliharaanLaut.dataStorePemeliharaanPart.changeParams({params:{id_pemeliharaan:data.id}});
            }
        };

        PemeliharaanLaut.Action.remove = function() {
            var selected = PemeliharaanLaut.Grid.grid.getSelectionModel().getSelection();
            var arrayDeleted = [];
            _.each(selected, function(obj) {
                var data = {
                    id: obj.data.id
                };
                arrayDeleted.push(data);
            });
            Modal.deleteAlert(arrayDeleted, PemeliharaanLaut.URL.remove, PemeliharaanLaut.Data);
        };

        PemeliharaanLaut.Action.print = function() {
            var selected = PemeliharaanLaut.Grid.grid.getSelectionModel().getSelection();
            var selectedData = "";
            if (selected.length > 0)
            {
                for (var i = 0; i < selected.length; i++)
                {
                    selectedData += selected[i].data.id + ",";
                }
            }
            var gridHeader = PemeliharaanLaut.Grid.grid.getView().getHeaderCt().getVisibleGridColumns();
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

            var serverSideModelName = "Pemeliharaan_Laut_Model";
            var title = "Pemeliharaan Laut";
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
                id: 'grid_PemeliharaanLaut',
                title: 'DAFTAR PEMELIHARAAN KENDARAAN LAUT',
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
                id: 'search_PemeliharaanLaut'
            },
            toolbar: {
                id: 'toolbar_PemeliharaanLaut',
                add: {
                    id: 'button_add_PemeliharaanLaut',
                    action: PemeliharaanLaut.Action.add
                },
                edit: {
                    id: 'button_edit_PemeliharaanLaut',
                    action: PemeliharaanLaut.Action.edit
                },
                remove: {
                    id: 'button_remove_PemeliharaanLaut',
                    action: PemeliharaanLaut.Action.remove
                },
                print: {
                    id: 'button_print_PemeliharaanLaut',
                    action: PemeliharaanLaut.Action.print
                }
            }
        };

        PemeliharaanLaut.Grid.grid = Grid.processGrid(setting, PemeliharaanLaut.Data);

        var new_tabpanel = {
            xtype: 'panel',
            id: 'pemeliharaan_asset_kendaraan_laut', title: 'Pemeliharaan Laut ', iconCls: 'icon-menu_impasing', border: false, closable: true,
            layout: 'border', items: [Region.filterPanelPemeliharaan(PemeliharaanLaut.Data,'pemeliharaan_kendaraan_laut'), PemeliharaanLaut.Grid.grid]
        };
     
<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>