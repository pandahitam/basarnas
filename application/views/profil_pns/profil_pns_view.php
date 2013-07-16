<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-Type: application/x-javascript"); 

if(isset($jsscript) && $jsscript == TRUE){ 
?>

var Params_PPNS = null;

// TABEL PROFIL PNS  --------------------------------------------------------- START
Ext.define('MProfil_PNS', {extend: 'Ext.data.Model',
	fields: ['ID_Pegawai', 'NIP', 'NIP_Lama', 'f_namalengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'suku', 'agama', 'warga_negara', 'status_kawin', 'gol_darah', 
  'alamat','desa','kecamatan','kabupaten','provinsi','kodepos','negara','telp','hp','email',
  'kode_golru', 'nama_pangkat', 'nama_golru', 'kode_unor', 'nama_unor', 'nama_unker', 'kode_jab', 'nama_jab', 'nama_dupeg',
  'TMT_kpkt', 'mk_th_kpkt', 'mk_bl_kpkt', 'no_sk_kpkt', 'tgl_sk_kpkt',  'masa_kerja', 'usia', 'TMT_BUP',
  'kode_pddk', 'nama_pddk', 'jurusan', 'tahun_lulus']
});

var Reader_Profil_PNS = new Ext.create('Ext.data.JsonReader', {
  id: 'Reader_Profil_PNS', root: 'results', totalProperty: 'total', idProperty: 'ID_Pegawai'
});

var Proxy_Profil_PNS = new Ext.create('Ext.data.AjaxProxy', {
  url: BASE_URL + 'profil_pns/ext_get_all', actionMethods: {read:'POST'}, extraParams :{id_open: '1'},      
  reader: Reader_Profil_PNS,
  afterRequest: function(request, success) {Params_PPNS = request.operation.params;}
});

var Data_Profil_PNS = new Ext.create('Ext.data.Store', {
	id: 'Data_Profil_PNS', model: 'MProfil_PNS', pageSize: 20, noCache: false, autoLoad: true,
  proxy: Proxy_Profil_PNS
});

var search_Profil_PNS = new Ext.create('Ext.ux.form.SearchField', {
  id: 'search_Profil_PNS', store: Data_Profil_PNS, width: 180, emptyText: 'Pencarian NIP / Nama ...'
});

var tbProfil_PNS = new Ext.create('Ext.toolbar.Toolbar', { 
	items:[
		{text: 'Tambah', iconCls: 'icon-add', handler: add_Profil_PNS, disabled: ppns_insert},'-',	
		{text: 'Hapus', iconCls: 'icon-delete', handler: delete_Profil_PNS, disabled: ppns_delete},'-',	
		{text: 'Buka Profil', id: 'Buka_Profil', iconCls: 'icon-folder-open', handler: function () {Grid_Buka_Profil(Grid_Profil_PNS);}},'-',
		{text: 'Custom Filter', iconCls: 'icon-filter', handler: function(){Load_Popup('win_popup_Custom_Filter', BASE_URL + 'profil_pns/custom_filter')}},
		{text: 'Hapus Custom Filter', id: 'HCF_PPNS', iconCls: 'icon-filter_clear', handler: clear_Custom_Filter, disabled: true},'-',
		{text: 'Cetak Nominatif', iconCls: 'icon-printer', disabled: ppns_print, handler: function(){Load_Popup('win_print_pd', BASE_URL + 'profil_pns/print_dialog_dnp', 'Cetak Daftar Nominatif Pegawai');}},
		{text: 'Export', iconCls: 'icon-xls', disabled: ppns_print, handler: function(){Load_Popup('win_xls_pd', BASE_URL + 'profil_pns/xls_dialog_dnp', 'Export ke Excel');}, tooltip: {text: 'Export ke Excel'}},'-','->','-',
		{text: 'Hapus Kolom Filter', iconCls: 'icon-filter_clear', handler: function () {Grid_Profil_PNS.filters.clearFilters();}},'-',
		search_Profil_PNS
  ]
});

var filters_Profil_PNS = new Ext.create('Ext.ux.grid.filter.Filter', {
  ftype: 'filters', autoReload: true, local: false, store: Data_Profil_PNS,
  filters: [
   	{type: 'string', dataIndex: 'NIP'},
   	{type: 'string', dataIndex: 'NIP_Lama'},
   	{type: 'string', dataIndex: 'f_namalengkap'},
   	{type: 'string', dataIndex: 'tempat_lahir'},
   	{type: 'date', dataIndex: 'tanggal_lahir'},
   	{type: 'list', dataIndex: 'jenis_kelamin', options: ['L','P'], phpMode: true},
   	{type: 'string', dataIndex: 'suku'},
   	{type: 'list', dataIndex: 'agama', options: ['Islam','Katolik','Protestan','Hindu','Budha'], phpMode: true},
   	{type: 'list', dataIndex: 'warga_negara', options: ['WNI','WNA'], phpMode: true},
   	{type: 'list', dataIndex: 'status_kawin', options: ['Belum Kawin','Kawin','Janda','Duda'], phpMode: true},
   	{type: 'string', dataIndex: 'alamat'},
   	{type: 'string', dataIndex: 'desa'},
   	{type: 'string', dataIndex: 'kecamatan'},
   	{type: 'string', dataIndex: 'kabupaten'},
   	{type: 'string', dataIndex: 'provinsi'},
   	{type: 'string', dataIndex: 'kodepos'},
   	{type: 'string', dataIndex: 'negara'},
   	{type: 'string', dataIndex: 'telp'},
   	{type: 'string', dataIndex: 'hp'},
   	{type: 'string', dataIndex: 'email'},
   	{type: 'list', dataIndex: 'nama_pangkat', options: ['Juru Muda', 'Juru Muda Tk.I', 'Juru', 'Juru Tk.I', 'Pengatur Muda', 'Pengatur Muda TK.I', 'Pengatur', 'Pengatur Tk.I', 'Penata Muda', 'Penata Muda Tk.I', 'Penata', 'Penata Tk.I', 'Pembina Muda', 'Pembina Tk.I', 'Pembina Utama Muda', 'Pembina Utama Madya', 'Pembina Utama'], phpMode: true},
   	{type: 'list', dataIndex: 'nama_golru', options: ['I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'], phpMode: true},
   	{type: 'numeric', dataIndex: 'masa_kerja'},
   	{type: 'date', dataIndex: 'TMT_kpkt'},
   	{type: 'numeric', dataIndex: 'mk_th_kpkt'},
   	{type: 'numeric', dataIndex: 'mk_bl_kpkt'},
   	{type: 'string', dataIndex: 'no_sk_kpkt'},
   	{type: 'date', dataIndex: 'tgl_sk_kpkt'},
   	{type: 'string', dataIndex: 'nama_jab'},
   	{type: 'string', dataIndex: 'nama_unor'},
   	{type: 'string', dataIndex: 'nama_unker'},
   	{type: 'list', dataIndex: 'nama_dupeg', options: ['CPNS','PNS','Pensiun'], phpMode: true},
   	{type: 'string', dataIndex: 'nama_pddk'},
   	{type: 'string', dataIndex: 'jurusan'},
   	{type: 'numeric', dataIndex: 'tahun_lulus'}
  ]
});

var cbGrid_Profil_PNS = new Ext.create('Ext.selection.CheckboxModel');

var Grid_Profil_PNS = new Ext.create('Ext.grid.Panel', {
	id: 'Grid_Profil_PNS', store: Data_Profil_PNS, title: 'DAFTAR NOMINATIF PEGAWAI', 
  frame: true, border: true, loadMask: true, noCache: false,
  style: 'margin:0 auto;', autoHeight: true, columnLines: true, 
  selModel: cbGrid_Profil_PNS, 
	columns: [
  	{header:'No', xtype: 'rownumberer', width: 35, resizable: true, style: 'padding-top: .5px;'}, 
  	{header: "NIP / NIRP / NIK", dataIndex: 'NIP', width: 140}, 
  	{header: "NIP Lama", dataIndex: 'NIP_Lama', hidden: true, width: 80}, 
  	{header: "Nama Lengkap", dataIndex: 'f_namalengkap', width: 250},
  	{header: "Tempat Lahir", dataIndex: 'tempat_lahir', hidden: true, width: 100},
  	{header: "Tgl. Lahir", dataIndex: 'tanggal_lahir', hidden: true, width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "JK", dataIndex: 'jenis_kelamin', hidden: true, width: 30},
  	{header: "Suku", dataIndex: 'suku', hidden: true, width: 100},
  	{header: "Agama", dataIndex: 'agama', hidden: true, width: 100},
  	{header: "WN", dataIndex: 'warga_negara', hidden: true, width: 50},
  	{header: "Status Kawin", dataIndex: 'status_kawin', hidden: true, width: 100},
  	{header: "Gol. Darah", dataIndex: 'gol_darah', hidden: true, width: 70},
  	{header: "Alamat", dataIndex: 'alamat', hidden: true, width: 230},
  	{header: "Desa", dataIndex: 'desa', hidden: true, width: 100},
  	{header: "Kecamatan", dataIndex: 'kecamatan', hidden: true, width: 100},
  	{header: "Kabupaten", dataIndex: 'kabupaten', hidden: true, width: 100},
  	{header: "Provinsi", dataIndex: 'provinsi', hidden: true, width: 100},
  	{header: "Kodepos", dataIndex: 'kodepos', hidden: true, width: 80},
  	{header: "Negara", dataIndex: 'negara', hidden: true, width: 100},
  	{header: "Telp.", dataIndex: 'telp', hidden: true, width: 100},
  	{header: "HP", dataIndex: 'hp', hidden: true, width: 100},
  	{header: "E-Mail", dataIndex: 'email', hidden: true, width: 100},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', hidden: true, width: 150}, 
  	{header: "GolRu", dataIndex: 'nama_golru', width: 50},
  	{header: "M.K", dataIndex: 'masa_kerja', width: 70, renderer: function(val, meta, record) {return val + ' TH';}},
  	{header: "TMT Pangkat", dataIndex: 'TMT_kpkt', hidden: true, width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "MKG Th", dataIndex: 'mk_th_kpkt', hidden: true, width: 50},
  	{header: "MKG Bl", dataIndex: 'mk_bl_kpkt', hidden: true, width: 50},
  	{header: "No. SK Pangkat", dataIndex: 'no_sk_kpkt', hidden: true, width: 150}, 
  	{header: "Tgl. Pangkat", dataIndex: 'tgl_sk_kpkt', hidden: true, width: 75, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
  	{header: "Jabatan", dataIndex: 'nama_jab', width: 150}, 
  	{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 250}, 
  	{header: "Unit Kerja", dataIndex: 'nama_unker', width: 250}, 
  	{header: "Kedudukan", dataIndex: 'nama_dupeg', width: 80},
  	{header: "Pendidikan", dataIndex: 'nama_pddk', width: 150},
  	{header: "Jurusan", dataIndex: 'nama_pddk', hidden: true, width: 150},
  	{header: "Tahun Lulus", dataIndex: 'tahun_lulus', hidden: true, width: 80}
  ],
  features: [filters_Profil_PNS],
  tbar: tbProfil_PNS,
  dockedItems: [{xtype: 'pagingtoolbar', store: Data_Profil_PNS, dock: 'bottom', noCache: true, displayInfo: true}],
  listeners: {
  	itemdblclick: function(dataview, record, item, index, e) {
  		Ext.getCmp('Buka_Profil').handler.call(Ext.getCmp("Buka_Profil").scope);
  	}
  }
});

// TABEL PROFIL PNS  ------------------------------------------------- END

// FUNCTION PROFIL PNS ----------------------------------------------- START
function add_Profil_PNS(){
	Ext.MessageBox.prompt('NIP/NIRP/NIK', 'Masukkan NIP/NIRP/NIK:', function(btn, text){
  	if (btn == 'ok'){
			Ext.Ajax.request({
  			url: BASE_URL + 'profil_pns/check_nip',
    		method: 'POST', params: {id_open: 1, NIP_Cari:text}, scripts: true, renderer: 'data',
    		success: function(response){
    			if(response.responseText == 'ADA'){
    				Ext.MessageBox.show({title:'Peringatan !', msg:'NIP/NIRP/NIK yang Anda masukkan sudah terdaftar !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
    			}else{						
						Ext.MessageBox.prompt('NIP Lama', 'Masukkan NIP Lama:', function(btn, text_lama){
							var value_form = {NIP:text, NIP_Lama:text_lama, gol_darah:'-', kode_jpeg: 1, kode_dupeg:1}, value_form_head = {NIP_v:text, NIP_Lama_v:text_lama}, value_form_arsip = {NIP:text}, value_form_posisi_d_jab = {NIP:text}, value_form_data_lainnya = {NIP:text}; 
							Show_Form_Profil_PNS(value_form, value_form_head, value_form_arsip, value_form_posisi_d_jab, value_form_data_lainnya, 'tambah');							
						});
    			}
    		},
    		failure: function(response){Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});}, 
    		scope : this
			});
  	}
	});	
}

function delete_Profil_PNS(){
  var sm = Grid_Profil_PNS.getSelectionModel(), sel = sm.getSelection();
  if(sel.length > 0){
		Ext.Msg.show({
   		title: 'Konfirmasi', msg: 'Apakah Anda yakin untuk menghapus ?',
     	buttons: Ext.Msg.YESNO, icon: Ext.Msg.QUESTION,
     	fn: function(btn) {
     		if (btn == 'yes') {
     			var data = '';
     			for (i = 0; i < sel.length; i++) {
         		data = data + sel[i].get('ID_Pegawai') + '-';
					}
					Ext.Ajax.request({
         		url: BASE_URL + 'profil_pns/ext_delete_dnp', method: 'POST',
         		params: { postdata: data },
          	success: function(response){Data_Profil_PNS.load();},
    				failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg: obj.errors.reason, buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }
         	});
     		}
     	}
   	});
  }
}

function clear_Custom_Filter(){
	Ext.getCmp('HCF_PPNS').setDisabled(true);
	Data_Profil_PNS.changeParams({params :{id_open: 1}});
}

function cetak_DNP(){Load_Popup('win_print_dnp', BASE_URL + 'profil_pns/print_dialog_dnp', 'Cetak Daftar Nominatif Pegawai');}
// FUNCTION PROFIL PNS ----------------------------------------------- END

// PANEL PROFIL PNS  -------------------------------------------- START
var Center_Profil_PNS = {
  id: 'Center_Profil_PNS', region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '75%', border: false,
  items:[Grid_Profil_PNS]
};
var Container_Profil_PNS = {
 	id: 'box_border_Profil_PNS', layout: 'border', border: false, bodyBorder: false,
  defaults: {
   	collapsible: true, split: true, animFloat: false, autoHide: false,
    useSplitTips: true, bodyStyle: 'padding: 0px;'
  }, items:[Center_Profil_PNS]
};
var new_tabpanel = {
	id: 'profil_pns', title: 'Profil PNS', iconCls: 'icon-menu_profil',  border: false, closable: true,  
	layout: 'fit', items: [Container_Profil_PNS]
}
// PANEL PROFIL PNS  -------------------------------------------- END

<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>