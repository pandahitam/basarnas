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
                        id: 'search_angkutan_detail_penggunaan'
                    },
                    toolbar: {
                        id: 'toolbar_angkutan_detail_penggunaan',
                        add: {
                            id: 'button_add_angkutan_detail_penggunaan',
                            action: setting.toolbar.add
                        },
                        edit: {
                            id: 'button_edit_angkutan_detail_penggunaan',
                            action: setting.toolbar.edit
                        },
                        remove: {
                            id: 'button_remove_angkutan_detail_penggunaan',
                            action: setting.toolbar.remove
                        }
                    },
                    
                };
                
                 var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
                });
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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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
                
                 var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
                });
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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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
                
                 var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
                });
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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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
                            {header: 'Part Number', dataIndex: 'part_number', width: 150, hidden: false, groupable: false, filter: {type: 'string'}},
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
                
                 var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
                });
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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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
                
                 var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
                });
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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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
                
                 var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
                });
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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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

            var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
            });

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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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
                        title: 'Pendayagunaan',
                        column: [
                            {header: 'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'},
                            {header: 'ID', dataIndex: 'id', flex:0.5, hidden: true, groupable: false, filter: {type: 'number'}},
                            {header: 'Klasifikasi Aset', dataIndex: 'nama_klasifikasi_aset',flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Klasifikasi Aset Level 1', dataIndex: 'kd_lvl1', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Klasifikasi Aset Level 2', dataIndex: 'kd_lvl2', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Klasifikasi Aset Level 3', dataIndex: 'kd_lvl3', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Klasifikasi Aset', dataIndex: 'kd_klasifikasi_aset', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Unit Kerja', dataIndex: 'nama_unker', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Unit Organisasi', dataIndex: 'nama_unor', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Lokasi', dataIndex: 'kd_lokasi', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Kode Barang', dataIndex: 'kd_brg', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'No Aset', dataIndex: 'no_aset', flex:1, hidden: true, groupable: false, filter: {type: 'string'}},
                            {header: 'Part Number', dataIndex: 'part_number', flex:1, groupable: false, filter: {type: 'string'}},
                            {header: 'Serial Number', dataIndex: 'serial_number', flex:1, groupable: false, filter: {type: 'string'}},
                            {header: 'Mode Pendayagunaan', dataIndex: 'mode_pendayagunaan', flex:1.5, groupable: false, filter: {type: 'string'}},
                            {header: 'Pihak Ke-Tiga', dataIndex: 'pihak_ketiga', flex:1, hidden: false, groupable: false},
                            {header: 'Tanggal Mulai', dataIndex: 'tanggal_start', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Tanggal Selesai', dataIndex: 'tanggal_end', flex:1, hidden: false, groupable: false, filter: {type: 'string'}},
                            {header: 'Deksiprisi', dataIndex: 'description', flex:1, hidden: false, groupable: false},
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

            var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
            });

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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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

            var search = new Ext.create('Ext.ux.form.SearchField', {
                id: settingGrid.search.id, store: setting.dataStore, width: 180
            });

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
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
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
        
        
        Grid.inventarisGrid = function(setting, data) {
            if (setting === null)
            {
                console.log('setting is null');
                return;
            }

            var filter = new Ext.create('Ext.ux.grid.filter.Filter', {
                ftype: 'filters', autoReload: true, local: false, encode: true
            });

            var search = new Ext.create('Ext.ux.form.SearchField', {
                id: setting.search.id, store: data, width: 180
            });

            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: setting.toolbar.id,
                items: [{
                        text: 'Tambah', id: setting.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            setting.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: setting.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            setting.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: setting.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            setting.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Cetak', id: setting.toolbar.print.id, iconCls: 'icon-printer', handler: function() {
                            setting.toolbar.print.action();
                        }
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
                ]
            });

            var feature_list = {
                filter: filter,
                search: search,
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

            var search = new Ext.create('Ext.ux.form.SearchField', {
                id: setting.search.id, store: data, width: 180
            });

            var selMode = new Ext.create('Ext.selection.CheckboxModel');

            var toolbar = new Ext.create('Ext.toolbar.Toolbar', {
                id: setting.toolbar.id,
                items: [{
                        text: 'Tambah', id: setting.toolbar.add.id, iconCls: 'icon-add', handler: function() {
                            setting.toolbar.add.action();
                        }
                    }, '-', {
                        text: 'Ubah', id: setting.toolbar.edit.id, iconCls: 'icon-edit', handler: function() {
                            setting.toolbar.edit.action();
                        }
                    }, '-', {
                        text: 'Hapus', id: setting.toolbar.remove.id, iconCls: 'icon-delete', handler: function() {
                            setting.toolbar.remove.action();
                        }
                    }, '-', {
                        text: 'Cetak', id: setting.toolbar.print.id, iconCls: 'icon-printer', handler: function() {
                            setting.toolbar.print.action();
                        }
                    }, '->', {
                        text: 'Clear Filter', iconCls: 'icon-filter_clear',
                        handler: function() {
                            _grid.filters.clearFilters();
                        }
                    }, search
                ]
            });

            var feature_list = {
                filter: filter,
                search: search,
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
                dockedItems: [
                    {xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true},
                ],
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
                                        else if(tipe_angkutan == "udara" || tipe_angkutan == "laut")
                                        {
                                            data.pemeliharaan_status_penggunaan_angkutan_sampai_saat_ini = response.total + ' Jam';
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
                dockedItems: [
                    {xtype: 'pagingtoolbar', store: data, dock: 'bottom', displayInfo: true},
                ],
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
        
        ToolbarGrid.gridSelectionAsset = function(WithLokasi, data) {
            var cmp_selection = ToolbarGrid.component(WithLokasi, data);
            var cmp_write = ToolbarGrid.componentWrite(WithLokasi, data);

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