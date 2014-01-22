<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if (isset($jsscript) && $jsscript == TRUE) { ?>
    <script>
    ///////////
        Ext.namespace('Grid', 'ToolbarGrid');

        Grid.baseGrid = function(setting, data, feature_list) {
            var grid = new Ext.create('Ext.grid.Panel', {
                id: setting.grid.id,
                store: data,
                title: setting.grid.title,
                frame: true,
                region: 'center',
                border: true,
                loadMask: true,
                autoScroll:true,
                style: 'margin:0 auto;',
                height: '100%',
                selModel: feature_list.selmode,
                columns: setting.grid.column,
                columnLines: true,
                features: feature_list.filter,
                tbar: feature_list.toolbar,
                dockedItems: [{xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true}],
                listeners: {
                    itemdblclick: function(dataview, record, item, index, e) {
                        Ext.getCmp(setting.toolbar.edit.id).handler.call(Ext.getCmp(setting.toolbar.edit.id).scope);
                    }
                }
            });

            return grid;
        };
        
        Grid.baseGridAngkutanPerlengkapan = function(setting, data, feature_list) {
            var grid = new Ext.create('Ext.grid.Panel', {
                id: setting.grid.id,
                store: data,
                title: setting.grid.title,
                frame: true,
                region: 'center',
                border: true,
                loadMask: true,
                autoScroll:true,
                style: 'margin:0 auto;',
                height: '100%',
                selModel: feature_list.selmode,
                columns: setting.grid.column,
                columnLines: true,
                features: feature_list.filter,
                tbar: feature_list.toolbar,
                dockedItems: [{xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true}],
                listeners: {
                    itemdblclick: function(dataview, record, item, index, e) {
                        var id = record.data.id_asset_perlengkapan;
                        if(id == 0 || id == '')
                        {
                            Ext.MessageBox.alert('Tidak Terdapat Data','Pilihan yang dipilih tidak memiliki data dari asset perlengkapan');
                        }
                        else
                        {
                               $.ajax({
                                url:BASE_URL + 'asset_perlengkapan/getSpecificPerlengkapan',
                                type: "POST",
                                dataType:'json',
                                async:false,
                                data:{id:id},
                                success:function(response, status){
                                    if(status == "success")
                                    {
                                        if (Modal.assetSecondaryWindow.items.length === 0)
                                        {
                                            Modal.assetSecondaryWindow.setTitle('Edit Part');
                                        }
                                        var form = Ext.create('Ext.form.Panel', {
                                            frame: true,
                                            bodyStyle: 'padding:5px',
                                            width: '100%',
                                            height: '100%',
                                            autoScroll:true,
                                            fieldDefaults: {
                                                msgTarget: 'side'
                                            },
                                        });
                                        
                                        
                                        form.insert(0, Form.Component.unit(true,form));
                                        form.insert(1, Form.Component.klasifikasiAset(true))
                                        form.insert(2, Form.Component.perlengkapan(true));
                                        form.insert(3, Form.Component.fileUpload(true));
                                        
                                        
                                        form.getForm().setValues(response);
                                        Modal.assetSecondaryWindow.add(form);
                                        Modal.assetSecondaryWindow.show();
                                    }
                                }
                             });
                        }
//                        Ext.getCmp(setting.toolbar.edit.id).handler.call(Ext.getCmp(setting.toolbar.edit.id).scope);
                    }
                }
            });

            return grid;
        };
        
        Grid.baseGridWithTotalAsset= function(setting, data, feature_list) {
            var grid = new Ext.create('Ext.grid.Panel', {
                id: setting.grid.id,
                store: data,
//                tools:[{xtype:'displayfield', readOnly:true,fieldLabel:'Total Nilai Asset', id:'total_'+setting.grid.id, height:10}],
                title: setting.grid.title,
                frame: true,
                region: 'center',
                border: true,
                loadMask: true,
                autoScroll:true,
                style: 'margin:0 auto;',
                height: '100%',
                selModel: feature_list.selmode,
                columns: setting.grid.column,
                columnLines: true,
                features: feature_list.filter,
                tbar: feature_list.toolbar,
                bbar:['->',{xtype:'textfield', labelWidth:110, readOnly:true,fieldLabel:'Total Nilai Asset(Rp.)', id:'total_'+setting.grid.id}],
                dockedItems: [{xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true}],
                listeners: {
                    itemdblclick: function(dataview, record, item, index, e) {
                        Ext.getCmp(setting.toolbar.edit.id).handler.call(Ext.getCmp(setting.toolbar.edit.id).scope);
                    }
                }
            });

            return grid;
        };
        
        
        Grid.inventoryPerlengkapan = function(setting)
        {
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_inventory', dataIndex: 'id_inventory', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'no_aset', dataIndex: 'no_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Status Barang', dataIndex: 'status_barang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Qty', dataIndex: 'qty', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Asal Barang', dataIndex: 'asal_barang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            
                        ]
                    },
                    search: {
                        id: 'search_inventory_perlengkapan'
                    },
                    toolbar: {
                        id: 'toolbar_inventory_perlengkapan',
                        add: {
                            id: 'button_add_inventory_perlengkapan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_inventory_perlengkapan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_inventory_perlengkapan',
                            action: setting.toolbar.remove
                        }
                    }
                };

              var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
        
        Grid.detailPenggunaanAngkutanUdara = function(setting,edit)
        {
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_ext_angkutan', dataIndex: 'id_ext_asset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Tanggal', dataIndex: 'tanggal', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Jumlah Penggunaan', dataIndex: 'jumlah_penggunaan', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Satuan Penggunaan', dataIndex: 'satuan_penggunaan', width: 150, hidden: false, groupable: false, filter: {type: 'string'},
                            renderer: function(value) {
                            if (value === '1')
                            {
                                return "Meter";
                            }
                            else if (value === '2')
                            {
                                return "Kilometer";
                            }
                            else if (value === '3')
                            {
                                return "Mil";
                            }
                            else if (value === '4')
                            {
                                return "Jam Layar";
                            }
                            else if (value === '5')
                            {
                                return "Jam Terbang";
                            }
                            else
                            {
                                return "";
                            }
                            
                        }},
                            {header: 'Jumlah Cycle', dataIndex: 'jumlah_cycle', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            
                        ]
                    },
                    search: {
                        id: 'search_angkutan_detail_penggunaan'+setting.id
                    },
                    toolbar: {
                        id: 'toolbar_angkutan_detail_penggunaan'+setting.id,
                        add: {
                            id: 'button_add_angkutan_detail_penggunaan'+setting.id,
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_angkutan_detail_penggunaan'+setting.id,
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_angkutan_detail_penggunaan'+setting.id,
                            action: setting.toolbar.remove
                        }
                    },
                    
                };
                
                var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        }
        
        
        Grid.detailPenggunaanAngkutan = function(setting,edit)
        {
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_ext_angkutan', dataIndex: 'id_ext_asset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Tanggal', dataIndex: 'tanggal', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Jumlah Penggunaan', dataIndex: 'jumlah_penggunaan', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Satuan Penggunaan', dataIndex: 'satuan_penggunaan', width: 150, hidden: false, groupable: false, filter: {type: 'string'},
                            renderer: function(value) {
                            if (value === '1')
                            {
                                return "Meter";
                            }
                            else if (value === '2')
                            {
                                return "Kilometer";
                            }
                            else if (value === '3')
                            {
                                return "Mil";
                            }
                            else if (value === '4')
                            {
                                return "Jam Layar";
                            }
                            else if (value === '5')
                            {
                                return "Jam Terbang";
                            }
                            else
                            {
                                return "";
                            }
                            
                        }},
                            {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            
                        ]
                    },
                    search: {
                        id: 'search_angkutan_detail_penggunaan'+setting.id
                    },
                    toolbar: {
                        id: 'toolbar_angkutan_detail_penggunaan'+setting.id,
                        add: {
                            id: 'button_add_angkutan_detail_penggunaan'+setting.id,
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_angkutan_detail_penggunaan'+setting.id,
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_angkutan_detail_penggunaan'+setting.id,
                            action: setting.toolbar.remove
                        }
                    },
                    
                };
                
                var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        }
        
        
        
        
        Grid.angkutanDaratPerlengkapan = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_ext_asset', dataIndex: 'id_ext_asset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Jenis Perlengkapan', dataIndex: 'jenis_perlengkapan', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'No', dataIndex: 'no', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                           
                        ]
                    },
                    search: {
                        id: 'search_angkutanDarat_perlengkapan'
                    },
                    toolbar: {
                        id: 'toolbar_angkutanDarat_perlengkapan',
                        add: {
                            id: 'button_add_angkutanDarat_perlengkapan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_angkutanDarat_perlengkapan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_angkutanDarat_perlengkapan',
                            action: setting.toolbar.remove
                        }
                    }
                };
                
//                 var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//                });
              var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
//                var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                id: settingGrid.toolbar.id,
//                items: [{
//                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', action:settingGrid.toolbar.add.action
//                        }, '-', {
//                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', action:settingGrid.toolbar.edit.action
//                    }, '-', {
//                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', action:settingGrid.toolbar.remove.action
//                        
//                    }, '->', {
//                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, search
//                ]
//            });
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->', 
//                            search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGridAngkutanPerlengkapan(settingGrid, setting.dataStore, feature_list);
        };
        
        Grid.angkutanLautPerlengkapan = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_ext_asset', dataIndex: 'id_ext_asset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Jenis Perlengkapan', dataIndex: 'jenis_perlengkapan', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'No', dataIndex: 'no', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_angkutanLaut_perlengkapan'
                    },
                    toolbar: {
                        id: 'toolbar_angkutanLaut_perlengkapan',
                        add: {
                            id: 'button_add_angkutanLaut_perlengkapan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_angkutanLaut_perlengkapan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_angkutanLaut_perlengkapan',
                            action: setting.toolbar.remove
                        }
                    }
                };
                
//                 var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//                });
                var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
//                var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                id: settingGrid.toolbar.id,
//                items: [{
//                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', action:settingGrid.toolbar.add.action
//                        }, '-', {
//                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', action:settingGrid.toolbar.edit.action
//                    }, '-', {
//                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', action:settingGrid.toolbar.remove.action
//                        
//                    }, '->', {
//                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, search
//                ]
//            });
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGridAngkutanPerlengkapan(settingGrid, setting.dataStore, feature_list);
        };
        
        
        Grid.angkutanUdaraPerlengkapan = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_ext_asset', dataIndex: 'id_ext_asset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Jenis Perlengkapan', dataIndex: 'jenis_perlengkapan', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'No', dataIndex: 'no', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                                
                        ]
                    },
                    search: {
                        id: 'search_angkutanUdara_perlengkapan'
                    },
                    toolbar: {
                        id: 'toolbar_angkutanUdara_perlengkapan',
                        add: {
                            id: 'button_add_angkutanUdara_perlengkapan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_angkutanUdara_perlengkapan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_angkutanUdara_perlengkapan',
                            action: setting.toolbar.remove
                        }
                    }
                };
                
//                 var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//                });

            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
                
//                var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                id: settingGrid.toolbar.id,
//                items: [{
//                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', action:settingGrid.toolbar.add.action
//                        }, '-', {
//                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', action:settingGrid.toolbar.edit.action
//                    }, '-', {
//                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', action:settingGrid.toolbar.remove.action
//                        
//                    }, '->', {
//                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, search
//                ]
//            });
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGridAngkutanPerlengkapan(settingGrid, setting.dataStore, feature_list);
        }
        
        Grid.angkutanPerlengkapan = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_ext_asset', dataIndex: 'id_ext_asset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Jenis Perlengkapan', dataIndex: 'jenis_perlengkapan', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'No', dataIndex: 'no', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                                
                        ]
                    },
                    search: {
                        id: 'search_angkutan_perlengkapan'
                    },
                    toolbar: {
                        id: 'toolbar_angkutan_perlengkapan',
                        add: {
                            id: 'button_add_angkutan_perlengkapan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_angkutan_perlengkapan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_angkutan_perlengkapan',
                            action: setting.toolbar.remove
                        }
                    }
                };
                
//                 var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//                });

            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
                
//                var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                id: settingGrid.toolbar.id,
//                items: [{
//                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', action:settingGrid.toolbar.add.action
//                        }, '-', {
//                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', action:settingGrid.toolbar.edit.action
//                    }, '-', {
//                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', action:settingGrid.toolbar.remove.action
//                        
//                    }, '->', {
//                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, search
//                ]
//            });
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGridAngkutanPerlengkapan(settingGrid, setting.dataStore, feature_list);
        }
        
        Grid.parts = function(setting,isInventoryPenyimpanan, isInventoryPengeluaran)
        {
            if(isInventoryPenyimpanan == true)
            {
                 var settingGrid = {
                    grid: {
                        id: setting.id,
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_source', dataIndex: 'id_source', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_warehouse', dataIndex: 'id_warehouse', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_warehouse_ruang', dataIndex: 'id_warehouse_ruang', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_warehouse_rak', dataIndex: 'id_warehouse_rak', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Warehouse', dataIndex: 'nama_warehouse', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Ruang', dataIndex: 'nama_ruang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Rak', dataIndex: 'nama_rak', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Status Barang', dataIndex: 'status_barang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Qty', dataIndex: 'qty', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Asal Barang', dataIndex: 'asal_barang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_parts'
                    },
                    toolbar: {
                        id: 'toolbar_parts',
                        add: {
                            id: 'button_add_parts',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_parts',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_parts',
                            action: setting.toolbar.remove
                        }
                    }
                };
            }
            else if(isInventoryPengeluaran == true)
            {
                var settingGrid = {
                    grid: {
                        id: setting.id,
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_penyimpanan', dataIndex: 'id_penyimpanan', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_penyimpanan_data_perlengkapan', dataIndex: 'id_penyimpanan_data_perlengkapan', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'ID Warehouse', dataIndex: 'id_warehouse', width: 180, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Warehouse', dataIndex: 'nama_warehouse', width: 180, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Qty Keluar', dataIndex: 'qty_keluar', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_parts'
                    },
                    toolbar: {
                        id: 'toolbar_parts',
                        add: {
                            id: 'button_add_parts',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_parts',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_parts',
                            action: setting.toolbar.remove
                        }
                    }
                };
            }
            else
            {
                var settingGrid = {
                    grid: {
                        id: setting.id,
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_source', dataIndex: 'id_source', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Status Barang', dataIndex: 'status_barang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Qty', dataIndex: 'qty', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Asal Barang', dataIndex: 'asal_barang', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_parts'
                    },
                    toolbar: {
                        id: 'toolbar_parts',
                        add: {
                            id: 'button_add_parts',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_parts',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_parts',
                            action: setting.toolbar.remove
                        }
                    }
                };
            }
            
            

                    var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
                
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        }
        
        Grid.perlengkapanSubPart = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_part', dataIndex: 'id_part', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                                
                        ]
                    },
                    search: {
                        id: 'search_perlengkapan_sub_part'
                    },
                    toolbar: {
                        id: 'toolbar_perlengkapan_sub_part',
                        add: {
                            id: 'button_add_perlengkapan_sub_part',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_perlengkapan_sub_part',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_perlengkapan_sub_part',
                            action: setting.toolbar.remove
                        }
                    }
                };
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    },'->'
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGridAngkutanPerlengkapan(settingGrid, setting.dataStore, feature_list);
        }
        
        
        Grid.perlengkapanSubSubPart = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_sub_part', dataIndex: 'id_sub_part', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                                
                        ]
                    },
                    search: {
                        id: 'search_perlengkapan_sub_sub_part'
                    },
                    toolbar: {
                        id: 'toolbar_perlengkapan_sub_sub_part',
                        add: {
                            id: 'button_add_perlengkapan_sub_sub_part',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_perlengkapan_sub_sub_part',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_perlengkapan_sub_sub_part',
                            action: setting.toolbar.remove
                        }
                    }
                };
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    },'->'
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGridAngkutanPerlengkapan(settingGrid, setting.dataStore, feature_list);
        }
        
        
        Grid.pemeliharaanPart = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_pemeliharaan', dataIndex: 'id_pemeliharaan', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'id_penyimpanan', dataIndex: 'id_penyimpanan', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Qty', dataIndex: 'qty_pemeliharaan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pemeliharaan_part'
                    },
                    toolbar: {
                        id: 'toolbar_pemeliharaan_part',
                        add: {
                            id: 'button_add_pemeliharaan_part',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pemeliharaan_part',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pemeliharaan_part',
                            action: setting.toolbar.remove
                        }
                    }
                };
                
//                 var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//                });

                    var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
                
//                var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                id: settingGrid.toolbar.id,
//                items: [{
//                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', action:settingGrid.toolbar.add.action
//                        }, '-', {
//                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', action:settingGrid.toolbar.edit.action
//                    }, '-', {
//                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', action:settingGrid.toolbar.remove.action
//                        
//                    }, '->', {
//                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, search
//                ]
//            });
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        }
        
        Grid.riwayatPajak = function(setting)
        {
 
            var settingGrid = {
                    grid: {
                        id: setting.id,
                        
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'id', dataIndex: 'id', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Tahun Pajak', dataIndex: 'tahun_pajak', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Tanggal Pembayaran', dataIndex: 'tanggal_pembayaran', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Jumlah Setoran', dataIndex: 'jumlah_setoran', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'File Setoran', dataIndex: 'file_setoran', width: 150, groupable: false, filter: {type: 'string'}},
                            {header: 'Keterangan', dataIndex: 'keterangan', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'id_ext_asset', dataIndex: 'id_ext_asset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_riwayat_pajak'
                    },
                    toolbar: {
                        id: 'toolbar_riwayat_pajak',
                        add: {
                            id: 'button_add_riwayat_pajak',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_riwayat_pajak',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_riwayat_pajak',
                            action: setting.toolbar.remove
                        }
                    }
                };
                
//                 var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//                });
                    var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
//                var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                id: settingGrid.toolbar.id,
//                items: [{
//                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', action:settingGrid.toolbar.add.action
//                        }, '-', {
//                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', action:settingGrid.toolbar.edit.action
//                    }, '-', {
//                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', action:settingGrid.toolbar.remove.action
//                        
//                    }, '->', {
//                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, search
//                ]
//            });
            
            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });
           
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');



            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        }
        
        Grid.mutasiGrid = function(setting) {
                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'Pemindahan',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'NO SPPA', dataIndex: 'no_sppa', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'KD BARANG', dataIndex: 'kd_brg', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'NAMA BARANG', dataIndex: 'ur_baru', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'No Awal', dataIndex: 'no_awal', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'No Akhir', dataIndex: 'no_akhir', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
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
                            {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'No Aset', dataIndex: 'no_aset', width: 150, hidden: true, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pemindahan'
                    },
                    toolbar: {
                        id: 'toolbar_pemindahan',
                        add: {
                            id: 'button_add_pemindahan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pemindahan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pemindahan',
                            action: setting.toolbar.remove
                        }
                    }
                };
            



            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

//            var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//            });
var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];

            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Lihat', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',search
                ]
            });


            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
        Grid.pendayagunaanGrid = function(setting) {
                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'PENDAYAGUNAAN',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'ID', dataIndex: 'id', flex:0.5, hidden: true, groupable: false, filter: {type: 'number'}},
//                            {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset',flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
//                            {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
//                            {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
//                            {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
//                            {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Unit Kerja', dataIndex: 'nama_unker', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Unit Organisasi', dataIndex: 'nama_unor', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'No Aset', dataIndex: 'no_aset', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
//                            {header: 'Part Number', dataIndex: 'part_number', flex:1, groupable: false, filter: {type: 'string'}},
//                            {header: 'Serial Number', dataIndex: 'serial_number', flex:1, groupable: false, filter: {type: 'string'}},
                            {header: 'Mode Pendayagunaan', dataIndex: 'mode_pendayagunaan', flex:1.5, groupable: false, filter: {type: 'string'}},
                            {header: 'Pihak Ke-Tiga', dataIndex: 'pihak_ketiga', flex:1, hidden: false, groupable: false},
                            {header: 'Tanggal Mulai', dataIndex: 'tanggal_start', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Tanggal Selesai', dataIndex: 'tanggal_end', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Deskripsi', dataIndex: 'description', flex:1, hidden: false, groupable: false},
                            {header: 'Document', dataIndex: 'document', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama Aset', dataIndex: 'nama', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pendayagunaan'
                    },
                    toolbar: {
                        id: 'toolbar_pendayagunaan',
                        add: {
                            id: 'button_add_pendayagunaan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pendayagunaan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pendayagunaan',
                            action: setting.toolbar.remove
                        }
                    }
                };
            



            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

//            var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//            });
            
            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];

            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });


            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
        
        Grid.pengelolaanGrid = function(setting) {
                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'PENGELOLAAN',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'ID', dataIndex: 'id', flex:0.5, groupable: false, hidden:true, filter: {type: 'number'}},
                            {header: 'Nama Operasi SAR', dataIndex: 'nama_operasi', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'PIC', dataIndex: 'pic', flex: 1, groupable: false, filter: {type: 'string'}},
                            {header: 'Tanggal Mulai', dataIndex: 'tanggal_mulai', flex: 1, groupable: false, filter: {type: 'string'}},
                            {header: 'Tanggal Mulai', dataIndex: 'tanggal_selesai', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Deskripsi', dataIndex: 'deskripsi', flex: 1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'No Aset', dataIndex: 'no_aset', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Nama Barang', dataIndex: 'nama', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Image Url', dataIndex: 'image_url', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Document Url', dataIndex: 'document_url', flex: 1, hidden: true, groupable: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pengelolaan'
                    },
                    toolbar: {
                        id: 'toolbar_pengelolaan',
                        add: {
                            id: 'button_add_pengelolaan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pengelolaan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pengelolaan',
                            action: setting.toolbar.remove
                        }
                    }
                };
            



            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

//            var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//            });
            
            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];

            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });


            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
        Grid.alertPerlengkapanListRequiredPemeliharaan = function(setting) {
                var settingGrid = {
                    grid: {
                        id: "alert_perlengkapan_grid_list_required_pemeliharaan",
                        title: 'Daftar Part Yang Membutuhkan Pemeliharaan',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'Tipe', dataIndex: 'tipe', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Nama', dataIndex: 'nama', width: 150, groupable: false, hidden: false, filter: {type: 'date'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Perbedaan Umur', dataIndex: 'perbedaan_umur', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Perbedaan Cycle', dataIndex: 'perbedaan_cycle', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                        ]
                    },
                };
            


            var feature_list = {
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };


        Grid.pemeliharaanPerlengkapanGrid = function(setting) {
                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'Pemeliharaan',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'Jenis', dataIndex: 'jenis', width: 120, groupable: false, hidden: false, filter: {type: 'string'},
                                renderer: function(value){
                                    if (value === '1')
                                    {
                                        return "Predictive";
                                    }
                                    else if (value === '2')
                                    {
                                        return "Preventive";
                                    }
                                    else if (value === '3')
                                    {
                                        return "Corrective";
                                    }
                                }
                            },
                            {header: 'Tahun Anggaran', dataIndex: 'tahun_angaran', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Pelaksana Tanggal', dataIndex: 'pelaksana_tgl', width: 150, groupable: false, hidden: false, filter: {type: 'date'}},
                            {header: 'Pelaksana Nama', dataIndex: 'pelaksana_nama', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Kondisi', dataIndex: 'kondisi', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Deskripsi', dataIndex: 'deskripsi', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Harga', dataIndex: 'harga', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Kode Anggaran', dataIndex: 'kode_anggaran', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Frekuensi Waktu', dataIndex: 'freq_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Frekuensi Penggunaan', dataIndex: 'freq_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Status', dataIndex: 'status', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Durasi', dataIndex: 'durasi', width: 90, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Rencana Waktu', dataIndex: 'rencana_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'date'}},
//                            {header: 'Rencana Penggunaan', dataIndex: 'rencana_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Rencana Keterangan', dataIndex: 'rencana_keterangan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Penambahan Umur', dataIndex: 'umur', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Penambahan Cycle', dataIndex: 'cycle', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pemeliharaan'
                    },
                    toolbar: {
                        id: 'toolbar_pemeliharaan',
                        add: {
                            id: 'button_add_pemeliharaan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pemeliharaan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pemeliharaan',
                            action: setting.toolbar.remove
                        }
                    }
                };
            



            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

//            var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//            });

            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    },
//                        '-', {
//                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, 
                    '->',
//                            search
                ]
            });


            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
        
        Grid.pemeliharaanPerlengkapanSubPartGrid = function(setting) {
            
                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'Pemeliharaan Sub Part',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'Nama Sub Part', dataIndex: 'nama', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Jenis', dataIndex: 'jenis', width: 120, groupable: false, hidden: false, filter: {type: 'string'},
                                renderer: function(value){
                                    if (value === '1')
                                    {
                                        return "Predictive";
                                    }
                                    else if (value === '2')
                                    {
                                        return "Preventive";
                                    }
                                    else if (value === '3')
                                    {
                                        return "Corrective";
                                    }
                                }
                            },
                            {header: 'Tahun Anggaran', dataIndex: 'tahun_angaran', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Pelaksana Tanggal', dataIndex: 'pelaksana_tgl', width: 150, groupable: false, hidden: false, filter: {type: 'date'}},
                            {header: 'Pelaksana Nama', dataIndex: 'pelaksana_nama', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Kondisi', dataIndex: 'kondisi', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Deskripsi', dataIndex: 'deskripsi', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Harga', dataIndex: 'harga', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Kode Anggaran', dataIndex: 'kode_anggaran', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Frekuensi Waktu', dataIndex: 'freq_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Frekuensi Penggunaan', dataIndex: 'freq_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Status', dataIndex: 'status', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Durasi', dataIndex: 'durasi', width: 90, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Rencana Waktu', dataIndex: 'rencana_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'date'}},
//                            {header: 'Rencana Penggunaan', dataIndex: 'rencana_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Rencana Keterangan', dataIndex: 'rencana_keterangan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Penambahan Umur', dataIndex: 'umur', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Penambahan Cycle', dataIndex: 'cycle', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pemeliharaan_sub_part'
                    },
                    toolbar: {
                        id: 'toolbar_pemeliharaan_sub_part',
                        add: {
                            id: 'button_add_pemeliharaan_sub_part',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pemeliharaan_sub_part',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pemeliharaan_sub_part',
                            action: setting.toolbar.remove
                        }
                    }
                };
            



            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

//            var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//            });

            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    },
//                        '-', {
//                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, 
                    '->',
//                            search
                ]
            });


            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
        Grid.pemeliharaanPerlengkapanSubSubPartGrid = function(setting) {
                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'Pemeliharaan Sub Sub Part',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'Nama Sub Sub Part', dataIndex: 'nama', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Jenis', dataIndex: 'jenis', width: 120, groupable: false, hidden: false, filter: {type: 'string'},
                                renderer: function(value){
                                    if (value === '1')
                                    {
                                        return "Predictive";
                                    }
                                    else if (value === '2')
                                    {
                                        return "Preventive";
                                    }
                                    else if (value === '3')
                                    {
                                        return "Corrective";
                                    }
                                }
                            },
                            {header: 'Tahun Anggaran', dataIndex: 'tahun_angaran', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Pelaksana Tanggal', dataIndex: 'pelaksana_tgl', width: 150, groupable: false, hidden: false, filter: {type: 'date'}},
                            {header: 'Pelaksana Nama', dataIndex: 'pelaksana_nama', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Kondisi', dataIndex: 'kondisi', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Deskripsi', dataIndex: 'deskripsi', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Harga', dataIndex: 'harga', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Kode Anggaran', dataIndex: 'kode_anggaran', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Frekuensi Waktu', dataIndex: 'freq_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Frekuensi Penggunaan', dataIndex: 'freq_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Status', dataIndex: 'status', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Durasi', dataIndex: 'durasi', width: 90, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Rencana Waktu', dataIndex: 'rencana_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'date'}},
//                            {header: 'Rencana Penggunaan', dataIndex: 'rencana_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
//                            {header: 'Rencana Keterangan', dataIndex: 'rencana_keterangan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Penambahan Umur', dataIndex: 'umur', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Penambahan Cycle', dataIndex: 'cycle', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pemeliharaan_sub_sub_part'
                    },
                    toolbar: {
                        id: 'toolbar_pemeliharaan_sub_sub_part',
                        add: {
                            id: 'button_add_pemeliharaan_sub_sub_part',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pemeliharaan_sub_sub_part',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pemeliharaan_sub_sub_part',
                            action: setting.toolbar.remove
                        }
                    }
                };
            



            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

//            var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//            });

            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    },
//                        '-', {
//                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
//                        handler: function() {
//                            _grid.filters.clearFilters();
//                        }
//                    }, 
                    '->',
//                            search
                ]
            });


            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
    // use in inventaris asset, 
        Grid.pemeliharaanGrid = function(setting) {
            if (setting.isBangunan)
            {
                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'Pemeliharaan',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'Jenis', dataIndex: 'jenis', width: 100, hidden: false, groupable: false, filter: {type: 'string'},
                                renderer: function(value) {
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
                            {header: ' SubJenis', dataIndex: 'subjenis', width: 100, hidden: false, groupable: false, filter: {type: 'string'},
                                renderer: function(value) {
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
                                        return "NOT YET IMPLEMENTED";
                                    }
                                }
                            },
                            {header: 'Pelaksana', dataIndex: 'pelaksana_nama', width: 120, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Pelaksanaan Tgl Start', dataIndex: 'pelaksana_startdate', width: 120, groupable: false, filter: {type: 'string'}},
                            {header: 'Pelaksanaan Tgl End', dataIndex: 'pelaksana_endate', width: 120, groupable: false, filter: {type: 'string'}},
                            {header: 'Deskripsi', dataIndex: 'deskripsi', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Biaya', dataIndex: 'biaya', width: 100, hidden: false, groupable: false, filter: {type: 'string'}}
                        ]
                    },
                    search: {
                        id: 'search_pemeliharaan'
                    },
                    toolbar: {
                        id: 'toolbar_pemeliharaan',
                        add: {
                            id: 'button_add_pemeliharaan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pemeliharaan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pemeliharaan',
                            action: setting.toolbar.remove
                        }
                    }
                };
            }
            else
            {

                var settingGrid = {
                    grid: {
                        id: setting.toolbar.idGrid,
                        title: 'Pemeliharaan',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'Jenis', dataIndex: 'jenis', width: 120, groupable: false, hidden: false, filter: {type: 'string'},
                                renderer: function(value){
                                    if (value === '1')
                                    {
                                        return "Predictive";
                                    }
                                    else if (value === '2')
                                    {
                                        return "Preventive";
                                    }
                                    else if (value === '3')
                                    {
                                        return "Corrective";
                                    }
                                }
                            },
                            {header: 'Tahun Anggaran', dataIndex: 'tahun_angaran', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Pelaksana Tanggal', dataIndex: 'pelaksana_tgl', width: 150, groupable: false, hidden: false, filter: {type: 'date'}},
                            {header: 'Pelaksana Nama', dataIndex: 'pelaksana_nama', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Kondisi', dataIndex: 'kondisi', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Deskripsi', dataIndex: 'deskripsi', width: 150, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Harga', dataIndex: 'harga', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Kode Anggaran', dataIndex: 'kode_anggaran', width: 100, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Frekuensi Waktu', dataIndex: 'freq_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Frekuensi Penggunaan', dataIndex: 'freq_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Status', dataIndex: 'status', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Durasi', dataIndex: 'durasi', width: 90, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Rencana Waktu', dataIndex: 'rencana_waktu', width: 120, groupable: false, hidden: false, filter: {type: 'date'}},
                            {header: 'Rencana Penggunaan', dataIndex: 'rencana_penggunaan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                            {header: 'Rencana Keterangan', dataIndex: 'rencana_keterangan', width: 120, groupable: false, hidden: false, filter: {type: 'string'}},
                        ]
                    },
                    search: {
                        id: 'search_pemeliharaan'
                    },
                    toolbar: {
                        id: 'toolbar_pemeliharaan',
                        add: {
                            id: 'button_add_pemeliharaan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_pemeliharaan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_pemeliharaan',
                            action: setting.toolbar.remove
                        }
                    }
                };
            }



            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

//            var search = new Ext.create('Ext.ux.form.SearchField', {
//                id: settingGrid.search.id, store: setting.dataStore, width: 180
//            });

            var search = [{
                    xtype:'searchfield',
                    id:settingGrid.search.id,
                    store:setting.dataStore,
                    width:180
            }];
            
            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: settingGrid.toolbar.id,
                items: [{
                        text: 'Tambah', id: settingGrid.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            settingGrid.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: settingGrid.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            settingGrid.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: settingGrid.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            settingGrid.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',
//                            search
                ]
            });


            var feature_list = {
                filter: filter,
                search: search,
                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(settingGrid, setting.dataStore, feature_list);
        };
        
        
        Grid.inventarisGrid = function(setting, data, noTotalNilaiAssetField) {
          

            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: false, encode: true, paramPrefix:'gridFilter',
                id:'inventaris_grid_filter',
                updateBuffer: 2000,
            });

            var searchCode = [{
                    xtype:'searchfield',
                    id:setting.search.id + 'code',
                    store:data,
                    width:180,
                    emptyText:'Scan Barcode/RFID',
                    paramName:'query'
            }];
        
            var searchField = [{
                    xtype:'searchfield',
                    id:setting.search.id + 'field',
                    store:data,
                    width:180,
                    emptyText:'Cari',
                    paramName:'search'
            }];

            var selMode = new Ext.create('Ext.selection.CheckboxModel');
            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: setting.toolbar.id,
                items: [{
                        text: 'Tambah', id: setting.toolbar.add.id, disabled:fnCheckControlButton(setting, 'insert'), iconCls: 'icon-add', handler: function() {
                            setting.toolbar.add.action();
                        },
						 
                    }, '-', {
                        text: 'Ubah', id: setting.toolbar.edit.id, disabled:fnCheckControlButton(setting, 'update'), iconCls: 'icon-edit', handler: function() {
                            setting.toolbar.edit.action();
                        },
						 
                    }, '-', {
                        text: 'Hapus', id: setting.toolbar.remove.id, disabled:fnCheckControlButton(setting, 'delete'), iconCls: 'icon-delete', handler: function() {
                            setting.toolbar.remove.action();
                        },
						 
                    }, '-', {
                        text: 'Cetak', id: setting.toolbar.print.id, disabled:fnCheckControlButton(setting, 'print'), iconCls: 'icon-printer', handler: function() {
                            setting.toolbar.print.action();
                        },
						
                    }, '-', 
                            {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            Ext.getCmp(setting.grid.id).filters.clearFilters();
//                              var dataProxy = data.getProxy();
//                              delete data.getProxy().extraParams.gridFilter;
//                              data.load()
                        }
                    }, '->',searchField,searchCode
                ]
            });

            var feature_list = {
                filter: filter,
                selmode: selMode,
                toolbar: toolbar
            };
            
            if(noTotalNilaiAssetField == true)
            {
                return Grid.baseGrid(setting, data, feature_list);
            }
            else
            {
                return Grid.baseGridWithTotalAsset(setting, data, feature_list);
            }
            
        };
        
        Grid.mutasiPenghapusanGridNoCRUD = function(setting, data) {
            if (setting === null)
            {
                console.log('setting is null');
                return;
            }

            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: false, encode: true, paramPrefix:'gridFilter',
                updateBuffer: 2000,
            });

            var searchCode = [{
                    xtype:'searchfield',
                    id:setting.search.id + 'code',
                    store:data,
                    width:180,
                    emptyText:'Scan Barcode/RFID',
                    paramName:'query'
            }];
        
            var searchField = [{
                    xtype:'searchfield',
                    id:setting.search.id + 'field',
                    store:data,
                    width:180,
                    emptyText:'Cari',
                    paramName:'search'
            }];

            var selMode = new Ext.create('Ext.selection.CheckboxModel');
            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: setting.toolbar.id,
                items: [ {
                        text: 'Lihat', id: setting.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            setting.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Cetak', id: setting.toolbar.print.id, iconCls: 'icon-printer', handler: function() {
                            setting.toolbar.print.action();
                        }
                    }, '-', 
                            {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            Ext.getCmp(setting.grid.id).filters.clearFilters();
                        }
                    }, '->',
                            searchField,searchCode
                ]
            });

            var feature_list = {
                filter: filter,

                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGridWithTotalAsset(setting, data, feature_list);
        };
        
        Grid.referensiGrid = function(setting, data) {
//            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
//                ftype: 'filters', autoReload: true, local: true, encode: true
//            });

            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: false, encode: true, paramPrefix:'gridFilter',
                id:'referensi_grid_filter',
                updateBuffer: 2000,
            });

//            var searchCode = [{
//                    xtype:'searchfield',
//                    id:setting.search.id + 'code',
//                    store:data,
//                    width:180,
//                    emptyText:'Scan Barcode/RFID',
//                    paramName:'query'
//            }];
//        
            var searchField = [{
                    xtype:'searchfield',
                    id:setting.search.id + 'field',
                    store:data,
                    width:180,
                    emptyText:'Cari',
                    paramName:'search'
            }];

            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: setting.toolbar.id,
                items: [{
                        text: 'Tambah', id: setting.toolbar.add.id, disabled:(setting.toolbar.add.disabled == true)?true:false, iconCls: 'icon-add', handler: function() {
                            setting.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: setting.toolbar.edit.id, disabled:(setting.toolbar.edit.disabled == true)?true:false, iconCls: 'icon-edit', handler: function() {
                            setting.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: setting.toolbar.remove.id, disabled:(setting.toolbar.remove.disabled == true)?true:false, iconCls: 'icon-delete', handler: function() {
                            setting.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            Ext.getCmp(setting.grid.id).filters.clearFilters();
                        }
                    }, '->'
                    ,searchField
                ]
            });

            var feature_list = {
                filter: filter,

                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(setting, data, feature_list);

        };

        Grid.processGrid = function(setting, data) {
            if (setting === null)
            {
                console.log('setting is null');
                return;
            }

            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: true, encode: true
            });

            var searchCode = [{
                    xtype:'searchfield',
                    id:setting.search.id + 'code',
                    store:data,
                    width:180,
                    emptyText:'Scan Barcode/RFID',
                    paramName:'query'
            }];
        
            var searchField = [{
                    xtype:'searchfield',
                    id:setting.search.id + 'field',
                    store:data,
                    width:180,
                    emptyText:'Cari',
                    paramName:'search'
            }];

            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: setting.toolbar.id,
                items: [{
                        text: 'Tambah', id: setting.toolbar.add.id, disabled:(setting.toolbar.add.disabled == true)?true:false, iconCls: 'icon-add', handler: function() {
                            setting.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: setting.toolbar.edit.id, disabled:(setting.toolbar.edit.disabled == true)?true:false, iconCls: 'icon-edit', handler: function() {
                            setting.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: setting.toolbar.remove.id, disabled:(setting.toolbar.remove.disabled == true)?true:false, iconCls: 'icon-delete', handler: function() {
                            setting.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Cetak', id: setting.toolbar.print.id, disabled:(setting.toolbar.print.disabled == true)?true:false, iconCls: 'icon-printer', handler: function() {
                            setting.toolbar.print.action();
                        }
                    }, '-', {
                        text: 'Clear Column Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, '->',searchField,searchCode
                ]
            });

            var feature_list = {
                filter: filter,

                selmode: selMode,
                toolbar: toolbar
            };

            return Grid.baseGrid(setting, data, feature_list);

        };

        Grid.selectionAsset = function(tipe_angkutan) {

            var data = new Ext.create('Ext.data.Store', {
                fields: ['nama', 'unker', 'kd_lokasi', 'kd_brg', 'no_aset', 'kd_gol', 'kd_bid', 'kd_kel', 'kd_skel', 'kd_sskel'], autoLoad: false,
                proxy: new Ext.data.AjaxProxy({
                    url: BASE_URL + 'asset_master/allAsset', actionMethods: {read: 'POST'},
                    extraParams: {id_open: 1, kd_lokasi: 0, kd_gol: 0, kd_bid: 0, kd_kel: 0, kd_skel: 0, kd_sskel: 0}
                })
            });
            
           
                

            var toolbar = ToolbarGrid.gridSelectionAsset(true, data);
            
            
            if(tipe_angkutan == 'darat' || tipe_angkutan =='laut')
            {
                Ext.getCmp('select_gol').setValue('3');
                Ext.getCmp('select_bidang').setValue('02');
                data.changeParams({params:{id_open: 1, kd_lokasi: 0, kd_gol: 3, kd_bid: 02, kd_kel: 0, kd_skel: 0, kd_sskel: 0}})
            }
            else if(tipe_angkutan == 'udara')
            {
                Ext.getCmp('select_gol').setValue('3');
                Ext.getCmp('select_bidang').setValue('02');
                Ext.getCmp('select_kel').setValue('05');
                data.changeParams({params:{id_open: 1, kd_lokasi: 0, kd_gol: 3, kd_bid: 02, kd_kel: 05, kd_skel: 0, kd_sskel: 0}})
            }
            
            var _grid = Ext.create('Ext.grid.Panel', {
                store: data,
                title: 'SELECT ASSET',
                frame: true,
                border: true,
                loadMask: true,
                style: 'margin:0 auto;',
                height: '100%',
                width: '100%',
                columnLines: true,
                tbar: toolbar,
//                dockedItems: [
//                    {xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true},
//                ],
                listeners: {
                    itemdblclick: function(dataview, record, item, index, e) {
                        var data = record.data;
                        if (data !== null)
                        {
                            
                            if(tipe_angkutan != null && tipe_angkutan != undefined)
                            {
                                 $.ajax({
                                    url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaanWithoudIdExtAsset',
                                    type: "POST",
                                    dataType:'json',
                                    async:false,
                                    data:{tipe_angkutan:tipe_angkutan,kd_brg:data.kd_brg,kd_lokasi:data.kd_lokasi,no_aset:data.no_aset},
                                    success:function(response, status){
                                     if(response.status == 'success')
                                     {
                                        if(tipe_angkutan == "darat")
                                        {
                                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Km';
                                        }
                                        else if(tipe_angkutan == "laut")
                                        {
                                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Jam';
                                        }
                                        else if(tipe_angkutan == 'udara')
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

                                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = 'Mesin 1: ' + total_penggunaan_mesin1  +'<br />' + 'Mesin 2: ' + total_penggunaan_mesin2;
                                        }
                                            
                                         
                                     }

                                    }
                                 });
                            }
                            var temp = Ext.getCmp('form-process');
                            if (temp !== null && temp != undefined)
                            {
                                
                                var form = temp.getForm();
                                form.setValues(data);
                            }
                            Modal.assetSelection.close();
                        }
                    },
                },
                columns: [
                    {
                        text: 'Nama',
                        width: 200,
                        sortable: true,
                        dataIndex: 'nama',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'Unit Kerja',
                        width: 200,
                        sortable: true,
                        dataIndex: 'unker',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'Kode Lokasi',
                        width: 150,
                        sortable: true,
                        dataIndex: 'kd_lokasi',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'Kode Barang',
                        width: 110,
                        sortable: true,
                        dataIndex: 'kd_brg',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'No Asset',
                        width: 70,
                        sortable: true,
                        dataIndex: 'no_aset',
                        filter: {type: 'string'}
                    },
                ]
            });

            return _grid;
        };
        
         Grid.selectionAssetAngkutan = function(tipe_angkutan,store) {

            var data = new Ext.create('Ext.data.Store', {
                fields: ['nama', 'unker', 'kd_lokasi', 'kd_brg', 'no_aset', 'kd_gol', 'kd_bid', 'kd_kel', 'kd_skel', 'kd_sskel'], autoLoad: false,
                proxy: new Ext.data.AjaxProxy({
                    url: BASE_URL + 'asset_master/allAsset', actionMethods: {read: 'POST'},
                    extraParams: {id_open: 1, kd_lokasi: 0, kd_gol: 0, kd_bid: 0, kd_kel: 0, kd_skel: 0, kd_sskel: 0}
                })
            });
            var specific_data = null;
            
            if(tipe_angkutan == 'udara')
            {
                specific_data = new Ext.create('Ext.data.Store', {
                fields: ['nama', 'unker', 'kd_lokasi', 'kd_brg', 'no_aset', 'kd_gol', 'kd_bid', 'kd_kel', 'kd_skel', 'kd_sskel'], autoLoad: false,
                proxy: new Ext.data.AjaxProxy({
                    url: BASE_URL + 'asset_master/assetAngkutan/udara', actionMethods: {read: 'POST'},
                    extraParams: {id_open: 1, kd_lokasi: 0, kd_gol: 0, kd_bid: 0, kd_kel: 0, kd_skel: 0, kd_sskel: 0}
                })
                });
            }
            else if(tipe_angkutan == 'darat')
            {
                specific_data = new Ext.create('Ext.data.Store', {
                fields: ['nama', 'unker', 'kd_lokasi', 'kd_brg', 'no_aset', 'kd_gol', 'kd_bid', 'kd_kel', 'kd_skel', 'kd_sskel'], autoLoad: false,
                proxy: new Ext.data.AjaxProxy({
                    url: BASE_URL + 'asset_master/assetAngkutan/darat', actionMethods: {read: 'POST'},
                    extraParams: {id_open: 1, kd_lokasi: 0, kd_gol: 0, kd_bid: 0, kd_kel: 0, kd_skel: 0, kd_sskel: 0}
                })
                });
            }
            else if(tipe_angkutan == 'laut')
            {
                specific_data = new Ext.create('Ext.data.Store', {
                fields: ['nama', 'unker', 'kd_lokasi', 'kd_brg', 'no_aset', 'kd_gol', 'kd_bid', 'kd_kel', 'kd_skel', 'kd_sskel'], autoLoad: false,
                proxy: new Ext.data.AjaxProxy({
                    url: BASE_URL + 'asset_master/assetAngkutan/laut', actionMethods: {read: 'POST'},
                    extraParams: {id_open: 1, kd_lokasi: 0, kd_gol: 0, kd_bid: 0, kd_kel: 0, kd_skel: 0, kd_sskel: 0}
                })
                });
            }
            
           
            var toolbar = ToolbarGrid.gridSelectionAsset(true, data, specific_data);

            
            
            
            if(tipe_angkutan == 'darat' || tipe_angkutan =='laut')
            {
                Ext.getCmp('select_gol').setValue('3');
                Ext.getCmp('select_bidang').setValue('02');
                Ext.getCmp('select_gol').setReadOnly(true);
                Ext.getCmp('select_bidang').setReadOnly(true);
                specific_data.changeParams({params:{id_open: 1, kd_lokasi: 0, kd_gol: '3', kd_bid: '02', kd_kel: '0', kd_skel: '0', kd_sskel: '0'}})
            }
            else if(tipe_angkutan == 'udara')
            {
                Ext.getCmp('select_gol').setValue('3');
                Ext.getCmp('select_bidang').setValue('02');
                Ext.getCmp('select_kel').setValue('05');
                Ext.getCmp('select_gol').setReadOnly(true);
                Ext.getCmp('select_bidang').setReadOnly(true);
                Ext.getCmp('select_kel').setReadOnly(true);
                specific_data.changeParams({params:{id_open: 1, kd_lokasi: 0, kd_gol: '3', kd_bid: '02', kd_kel: '05', kd_skel: 0, kd_sskel: 0}})
            }
            
            
            
            var _grid = Ext.create('Ext.grid.Panel', {
                store: (specific_data == undefined || specific_data == null)?data:specific_data,
                title: 'SELECT ASSET',
                frame: true,
                border: true,
                loadMask: true,
                style: 'margin:0 auto;',
                height: '100%',
                width: '100%',
                columnLines: true,
                tbar: toolbar,
//                dockedItems: [
//                    {xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true},
//                ],
                listeners: {
                    itemdblclick: function(dataview, record, item, index, e) {
                        var data = record.data;
                        if (data !== null)
                        {
                            
                            if(tipe_angkutan != null && tipe_angkutan != undefined)
                            {
                                 $.ajax({
                                    url:BASE_URL + 'asset_angkutan_detail_penggunaan/getTotalPenggunaanWithoudIdExtAsset',
                                    type: "POST",
                                    dataType:'json',
                                    async:false,
                                    data:{tipe_angkutan:tipe_angkutan,kd_brg:data.kd_brg,kd_lokasi:data.kd_lokasi,no_aset:data.no_aset},
                                    success:function(response, status){
                                     if(response.status == 'success')
                                     {
                                        if(tipe_angkutan == 'udara')
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

                                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = 'Mesin 1: ' + total_penggunaan_mesin1  +'<br />' + 'Mesin 2: ' + total_penggunaan_mesin2;
                                        }
                                        
                                        else if(tipe_angkutan == "darat")
                                        {
                                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Km';
                                        }
                                        else if(tipe_angkutan == "laut")
                                        {
                                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Jam';
                                        }
                                            
                                         
                                     }

                                    }
                                 });
                                if(tipe_angkutan == "udara")
                                {
                                    $.ajax({
                                    url:BASE_URL + 'asset_angkutan_udara/getSpecificPerlengkapanAngkutanUdaraWithoutIdExtAsset',
                                    type: "POST",
                                    dataType:'json',
                                    async:false,
                                    data:{kd_brg:data.kd_brg,kd_lokasi:data.kd_lokasi,no_aset:data.no_aset},
                                    success:function(response, status){
                                     
                                        if(status == "success")
                                        {
                                            var data = response.results;
                                            if(data.length > 0)
                                            {
                                                var id_ext_asset = data[0].id_ext_asset;
                                                store.changeParams({params:{id_ext_asset:id_ext_asset}});
//                                                Ext.each(data,function(value,index){
//                                                    var partsData = {};
//                                                    partsData.id = value.id;
//                                                    partsData.id_asset_perlengkapan = value.id_asset_perlengkapan;
//                                                    partsData.id_ext_asset = value.id_ext_asset;
//                                                    partsData.jenis_perlengkapan = value.jenis_perlengkapan;
//                                                    partsData.keterangan = value.keterangan;
//                                                    partsData.nama = value.nama;
//                                                    partsData.no = value.no;
//                                                    store.add(partsData);
//                                                })
                                            }
                                            
                                        }

                                    }
                                 });
                                }
                                
                                else if(tipe_angkutan == "darat")
                                {
                                    $.ajax({
                                    url:BASE_URL + 'asset_angkutan_darat/getSpecificPerlengkapanAngkutanDaratWithoutIdExtAsset',
                                    type: "POST",
                                    dataType:'json',
                                    async:false,
                                    data:{kd_brg:data.kd_brg,kd_lokasi:data.kd_lokasi,no_aset:data.no_aset},
                                    success:function(response, status){
                                     
                                        if(status == "success")
                                        {
                                            var data = response.results;
                                            if(data.length > 0)
                                            {
                                                var id_ext_asset = data[0].id_ext_asset;
                                                store.changeParams({params:{id_ext_asset:id_ext_asset}});
//                                                Ext.each(data,function(value,index){
//                                                    var partsData = {};
//                                                    partsData.id = value.id;
//                                                    partsData.id_asset_perlengkapan = value.id_asset_perlengkapan;
//                                                    partsData.id_ext_asset = value.id_ext_asset;
//                                                    partsData.jenis_perlengkapan = value.jenis_perlengkapan;
//                                                    partsData.keterangan = value.keterangan;
//                                                    partsData.nama = value.nama;
//                                                    partsData.no = value.no;
//                                                    store.add(partsData);
//                                                })
                                            }
                                            
                                           
                                        }

                                    }
                                 });
                                }
                                
                                else if(tipe_angkutan == "laut")
                                {
                                    $.ajax({
                                    url:BASE_URL + 'asset_angkutan_laut/getSpecificPerlengkapanAngkutanLautWithoutIdExtAsset',
                                    type: "POST",
                                    dataType:'json',
                                    async:false,
                                    data:{kd_brg:data.kd_brg,kd_lokasi:data.kd_lokasi,no_aset:data.no_aset},
                                    success:function(response, status){
                                     
                                        if(status == "success")
                                        {
                                            var data = response.results;
                                            if(data.length > 0)
                                            {
                                                var id_ext_asset = data[0].id_ext_asset;
                                                store.changeParams({params:{id_ext_asset:id_ext_asset}});
//                                                Ext.each(data,function(value,index){
//                                                    var partsData = {};
//                                                    partsData.id = value.id;
//                                                    partsData.id_asset_perlengkapan = value.id_asset_perlengkapan;
//                                                    partsData.id_ext_asset = value.id_ext_asset;
//                                                    partsData.jenis_perlengkapan = value.jenis_perlengkapan;
//                                                    partsData.keterangan = value.keterangan;
//                                                    partsData.nama = value.nama;
//                                                    partsData.no = value.no;
//                                                    store.add(partsData);
//                                                })
                                            }
                                            
                                           
                                        }

                                    }
                                 });
                                }
                                 
                                
                                  Ext.getCmp('grid_pemeliharaan_perlengkapan_angkutan').setDisabled(false); 
                            }
                            var temp = Ext.getCmp('form-process');
                            if (temp !== null && temp != undefined)
                            {
                                
                                var form = temp.getForm();
                                form.setValues(data);
                            }
                            Modal.assetSelection.close();
                        }
                    },
                },
                columns: [
                    {
                        text: 'Nama',
                        width: 200,
                        sortable: true,
                        dataIndex: 'nama',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'Unit Kerja',
                        width: 200,
                        sortable: true,
                        dataIndex: 'unker',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'Kode Lokasi',
                        width: 150,
                        sortable: true,
                        dataIndex: 'kd_lokasi',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'Kode Barang',
                        width: 110,
                        sortable: true,
                        dataIndex: 'kd_brg',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'No Asset',
                        width: 70,
                        sortable: true,
                        dataIndex: 'no_aset',
                        filter: {type: 'string'}
                    },
                ]
            });

            return _grid;
        };

        Grid.selectionReference = function() {

            var data = new Ext.create('Ext.data.Store', {
                fields: ['nama', 'kd_brg', 'kd_gol', 'kd_bid', 'kd_kel', 'kd_skel', 'kd_sskel'], autoLoad: false,
                proxy: new Ext.data.AjaxProxy({
                    url: BASE_URL + 'asset_master/allReference', actionMethods: {read: 'POST'},
                    extraParams: {id_open: 1, kd_gol: 0, kd_bid: 0, kd_kel: 0, kd_skel: 0, kd_sskel: 0}
                })
            });

            var toolbar = ToolbarGrid.selection(false, data);

            var _grid = Ext.create('Ext.grid.Panel', {
                store: data,
                title: 'SELECT RERENCE BARANG',
                frame: true,
                border: true,
                loadMask: true,
                style: 'margin:0 auto;',
                height: '100%',
                width: '100%',
                columnLines: true,
                tbar: toolbar,
//                dockedItems: [
//                    {xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true},
//                ],
                listeners: {
                    itemdblclick: function(dataview, record, item, index, e) {
                        var data = record.data;
                        if (data !== null)
                        {
                            //var temp = Ext.getCmp('form-create');
                            var temp = Ext.getCmp('form-process');
                            if (temp !== null)
                            {
                                var form = temp.getForm();
                                form.setValues(data);
                            }
                            Modal.assetSelection.close();
                        }
                    },
                },
                columns: [
                    {
                        text: 'Nama',
                        width: 200,
                        sortable: true,
                        dataIndex: 'nama',
                        filter: {type: 'string'}
                    },
                    {
                        text: 'Kode Barang',
                        width: 220,
                        sortable: true,
                        dataIndex: 'kd_brg',
                        filter: {type: 'string'}
                    },
                ]
            });

            return _grid;
        }

//        ToolbarGrid.selection = function(WithLokasi, data) {
//            var cmp = ToolbarGrid.component(WithLokasi, data);
//
//            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                items: cmp
//            });
//
//
//            return toolbar;
//        };
//        
//        ToolbarGrid.selectionWrite = function(WithLokasi, data) {
//            var cmp = ToolbarGrid.componentWrite(WithLokasi, data);
//
//            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
//                items: cmp
//            });
//
//
//            return toolbar;
//        };
        
        ToolbarGrid.gridSelectionAsset = function(WithLokasi, data, specific_data) {
            if(specific_data == undefined || specific_data == null)
            {
                specific_data = data;
            }
            var cmp_selection = ToolbarGrid.component(WithLokasi, specific_data);
            var cmp_write = ToolbarGrid.componentWrite(WithLokasi, specific_data);

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                layout:'column',
                items: [cmp_selection,cmp_write]
            });


            return toolbar;
        };


        ToolbarGrid.component = function(WithLokasi, data)
        {
            var selectionParams = {};

            var component = [{
                    xtype: 'combo',
                    id: 'select_gol',
                    valueField: 'kd_gol',
                    displayField: 'ur_gol',
                    emptyText: 'Golongan',
                    valueNotFoundText: 'Golongan',
                    typeAhead: true,
                    width: 130,
                    store: Reference.Data.golongan,
                    editable:false,
                    listeners: {
                        change: function(obj, value) {
                            if (value !== null)
                            {
                                selectionParams['kd_gol'] = value;
                                var bidangField = Ext.getCmp('select_bidang');
                                if (bidangField !== null) {
                                    bidangField.enable();
                                    Reference.Data.bidang.changeParams({params: {
                                            id_open: 1,
                                            kd_gol: value}});
                                }
                                else {
                                    console.error('error couldnt find field or value');
                                }

                            }
                        }
                    }
                }, {
                    xtype: 'combo',
                    id: 'select_bidang',
                    valueField: 'kd_bid',
                    displayField: 'ur_bid',
                    emptyText: 'Bidang',
                    valueNotFoundText: 'Bidang',
                    typeAhead: true,
                    disabled: true,
                    width: 120,
                    store: Reference.Data.bidang,
                    editable:false,
                    listeners: {
                        change: function(obj, value) {
                            if (value !== null)
                            {
                                selectionParams['kd_bid'] = value;
                                var kelompokField = Ext.getCmp('select_kel');
                                var golonganField = Ext.getCmp('select_gol').getValue();
                                if (kelompokField !== null && golonganField !== null) {
                                    kelompokField.enable();
                                    Reference.Data.kelompok.changeParams({params: {
                                            id_open: 1,
                                            kd_gol: golonganField,
                                            kd_bid: value}});
                                }
                                else {
                                    console.error('error couldnt find field or value');
                                }
                            }
                        }
                    }
                }, {
                    xtype: 'combo',
                    id: 'select_kel',
                    valueField: 'kd_kel',
                    displayField: 'ur_kel',
                    emptyText: 'Kelompok',
                    valueNotFoundText: 'Kelompok',
                    typeAhead: true,
                    disabled: true,
                    width: 110,
                    store: Reference.Data.kelompok,
                    editable:false,
                    listeners: {
                        change: function(obj, value) {
                            if (value !== null)
                            {
                                selectionParams['kd_kel'] = value;
                                var golonganValue = Ext.getCmp('select_gol').getValue();
                                var bidangValue = Ext.getCmp('select_bidang').getValue();
                                var skelompokField = Ext.getCmp('select_skel');
                                if (skelompokField !== null && bidangValue !== null && golonganValue !== null) {
                                    skelompokField.enable();
                                    Reference.Data.subKelompok.changeParams({params: {
                                            id_open: 1,
                                            kd_gol: golonganValue,
                                            kd_bid: bidangValue,
                                            kd_kel: value}});
                                }
                                else {
                                    console.error('error couldnt find field or value');
                                }
                            }
                        }
                    }
                }, {
                    xtype: 'combo',
                    id: 'select_skel',
                    valueField: 'kd_skel',
                    displayField: 'ur_skel',
                    emptyText: 'SubKelompok',
                    valueNotFoundText: 'SubKelompok',
                    typeAhead: true,
                    disabled: true,
                    width: 110,
                    store: Reference.Data.subKelompok,
                    editable:false,
                    listeners: {
                        change: function(obj, value) {
                            if (value !== null)
                            {
                                selectionParams['kd_skel'] = value;
                                var golonganValue = Ext.getCmp('select_gol').getValue();
                                var bidangValue = Ext.getCmp('select_bidang').getValue();
                                var kelompokValue = Ext.getCmp('select_kel').getValue();
                                var sskelompokField = Ext.getCmp('select_sskel');
                                if (sskelompokField !== null && kelompokValue !== null && bidangValue !== null && golonganValue !== null) {
                                    sskelompokField.enable();
                                    Reference.Data.subSubKelompok.changeParams({params: {
                                            id_open: 1,
                                            kd_gol: golonganValue,
                                            kd_bid: bidangValue,
                                            kd_kel: kelompokValue,
                                            kd_skel: value
                                        }});
                                }
                                else {
                                    console.error('error couldnt find field or value');
                                }
                            }
                        }
                    }
                }, {
                    xtype: 'combo',
                    id: 'select_sskel',
                    valueField: 'kd_sskel',
                    displayField: 'ur_sskel',
                    emptyText: 'SSubKelompok',
                    valueNotFoundText: 'SSubKelompok',
                    typeAhead: true,
                    disabled: true,
                    width: 110,
                    store: Reference.Data.subSubKelompok,
                    editable:false,
                    listeners: {
                        change: function(obj, value) {
                            if (value !== null)
                            {
                                selectionParams['kd_sskel'] = value;
                            }
                        }
                    }
                }, '->', {
                    xtype: 'button',
                    text: 'search',
                    frame: true,
                    border: 1,
                    handler: function() {
                        if (WithLokasi)
                        {
                            data.changeParams({params: {
                                    kd_lokasi: selectionParams.kd_lokasi,
                                    kd_gol: selectionParams.kd_gol,
                                    kd_bid: selectionParams.kd_bid,
                                    kd_kel: selectionParams.kd_kel,
                                    kd_skel: selectionParams.kd_skel,
                                    kd_sskel: selectionParams.kd_sskel
                                }});
                        }
                        else
                        {
                            data.changeParams({params: {
                                    kd_gol: selectionParams.kd_gol,
                                    kd_bid: selectionParams.kd_bid,
                                    kd_kel: selectionParams.kd_kel,
                                    kd_skel: selectionParams.kd_skel,
                                    kd_sskel: selectionParams.kd_sskel
                                }});
                        }

                    }
                }];

            if (WithLokasi)
            {
                var lokasi = {
                    xtype: 'combo',
                    valueField: 'kdlok',
                    displayField: 'ur_upb',
                    emptyText: 'Unit Kerja',
                    valueNotFoundText: 'Unit Kerja',
                    typeAhead: true,
                    width: 190,
                    store: Reference.Data.unker,
                    listeners: {
                        change: function(obj, value) {
                            if (value !== null)
                            {
                                selectionParams['kd_lokasi'] = value;
                            }
                        }
                    }
                };

                component.splice(0, 0, lokasi);
            }

            return component;
        };
        
        
        ToolbarGrid.componentWrite = function(WithLokasi, data)
        {
            
            var component = [ 
                    {
                        xtype:'textfield',
                        fieldLabel: 'Kode Lokasi',
                        id:'grid_selection_asset_component_write_kd_lokasi',
                        name:'kd_lokasi',
                        
                    },
                    {
                        xtype:'textfield',
                        fieldLabel: 'Kode Barang',
                        id:'grid_selection_asset_component_write_kd_brg',
                        name:'kd_brg',
                        
                    },
                    {
                        xtype:'numberfield',
                        fieldLabel: 'No Aset',
                        id:'grid_selection_asset_component_write_no_aset',
                        name:'kd_lokasi',
                        minValue:0,
                        
                    }, '->',{
                    xtype: 'button',
                    text: 'search',
                    frame: true,
                    border: 1,
                    handler: function() {
                            data.changeParams({params: {
                                    write_filter: 1,
                                    kd_lokasi: Ext.getCmp('grid_selection_asset_component_write_kd_lokasi').value,
                                    kd_brg: Ext.getCmp('grid_selection_asset_component_write_kd_brg').value,
                                    no_aset: Ext.getCmp('grid_selection_asset_component_write_no_aset').value,
                                }});
                    }
                }];


            return component;
        };

<?php } else {
    echo "var new_tabpanel_MD = 'GAGAL';";
} ?>