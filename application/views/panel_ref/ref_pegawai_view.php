<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

// Catatan :
// VKEY = sPgwPilih
// VKEY1 = sDupeg
// VKEY2 = 

<?php
$title_plus = "";
if($this->session->userdata("sDupeg") == 13){
	$title_plus = "Pensiun";
}elseif($this->session->userdata("sDupeg") == 17){
	$title_plus = "CPNS";
}
?>

var title_plus = "<?php echo $title_plus; ?>";
var sPgwPilih = "<?php echo $this->input->post("VKEY"); ?>";
var sDupeg = "<?php echo $this->input->post("VKEY1"); ?>";
var skode_unor = "<?php echo $this->input->post("VKEY2"); ?>";
var skode_golru = "<?php echo $this->input->post("VKEY3"); ?>";

//var Str_Cur_Form_Caller_Pegawai = '';
//var Cur_Form_Caller_Pegawai = '', 
var fmode = '';
var veselon = 0;

// POPUP REFERENSI PEGAWAI ---------------------------------------------------- START
Ext.define('MSearch_RefPegawai', {extend: 'Ext.data.Model',
   fields: ['ID_Pegawai', 'NIP', 'f_namalengkap', 'gelar_d', 'gelar_b', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'usia', 'kode_dupeg', 'nama_dupeg', 'kode_jpeg', 'kode_golru', 'nama_pangkat', 'nama_golru', 'gapok_kpkt', 'kode_jab', 'kode_klp_jab', 'kode_eselon', 'nama_jab', 'TMT_jab', 'kode_unor', 'nama_unor', 'kode_unker', 'nama_unker']
});
var Reader_Search_RefPegawai = new Ext.create('Ext.data.JsonReader', {
 	id: 'Reader_Search_RefPegawai', root: 'results', totalProperty: 'total', idProperty: 'ID_Pegawai'  	
});
var Proxy_Search_RefPegawai = new Ext.create('Ext.data.AjaxProxy', {
   url: BASE_URL + 'browse_ref/ext_get_all_pegawai', actionMethods: {read:'POST'}, extraParams :{id_open: 1, eselon: veselon, sPgwPilih:sPgwPilih, sDupeg:sDupeg, skode_unor:skode_unor, skode_golru:skode_golru}, reader: Reader_Search_RefPegawai
});
var Data_Search_RefPegawai = new Ext.create('Ext.data.Store', {
	id: 'Data_Search_RefPegawai', model: 'MSearch_RefPegawai', pageSize: 10,	noCache: false, autoLoad: true,
  proxy: Proxy_Search_RefPegawai
});

var Search_RefPegawai = new Ext.create('Ext.ux.form.SearchField', {id: 'Search_RefPegawai', store: Data_Search_RefPegawai, emptyText: 'Pencarian NIP / Nama ...', width: 450});
var tbSearch_RefPegawai = new Ext.create('Ext.toolbar.Toolbar', { id: 'tbSearch_RefPegawai',
	items:[
    {xtype: 'checkbox', boxLabel: 'Eselon', id: 'cbeselon_pgw', checked:false, margins: '0 10px 5px 5px', width: 80,
   	 listeners: {
   	 	change : function(checkbox, checked) {
   	 		if(checked == true){
   	 			veselon = 1;
   	 		}else{
   	 			veselon = 0;
   	 		}
   	 		setParams_Data_Search_RefPegawai(veselon);
   	 	}
		 }
    },		
		Search_RefPegawai, '->', {text: 'PILIH', iconCls: 'icon-check', id: 'PILIH_pegawai', handler: function(){SetTo_Form_Caller_Pegawai();}}
  ]
});

var filters_Search_RefPegawai = new Ext.create('Ext.ux.grid.filter.Filter', {
  	ftype: 'filters', autoReload: true, local: false, store: Data_Search_RefPegawai,
    filters: [
    	{type: 'string', dataIndex: 'NIP'},
    	{type: 'string', dataIndex: 'f_namalengkap'},
    	{type: 'list', dataIndex: 'nama_pangkat', options: ['Juru Muda', 'Juru Muda Tk.I', 'Juru', 'Juru Tk.I', 'Pengatur Muda', 'Pengatur Muda TK.I', 'Pengatur', 'Pengatur Tk.I', 'Penata Muda', 'Penata Muda Tk.I', 'Penata', 'Penata Tk.I', 'Pembina Muda', 'Pembina Tk.I', 'Pembina Utama Muda', 'Pembina Utama Madya', 'Pembina Utama'], phpMode: true},
    	{type: 'list', dataIndex: 'nama_golru', options: ['I/a', 'I/b', 'I/c', 'I/d', 'II/a', 'II/b', 'II/c', 'II/d', 'III/a', 'III/b', 'III/c', 'III/d', 'IV/a', 'IV/b', 'IV/c', 'IV/d', 'IV/e'], phpMode: true},
    	{type: 'string', dataIndex: 'nama_jab'},
    	{type: 'string', dataIndex: 'nama_unor'},
    	{type: 'string', dataIndex: 'nama_unker'}
    ]
});

var cbGrid_Search_RefPegawai = new Ext.create('Ext.selection.CheckboxModel');
var Grid_Search_RefPegawai = new Ext.create('Ext.grid.Panel', {
	id: 'Grid_Search_RefPegawai', store: Data_Search_RefPegawai, frame: true, border: true, loadMask: true, noCache: false, style: 'margin:0 auto;', height: '100%', width: '100%', selModel: cbGrid_Search_RefPegawai, columnLines: true,
	columns: [
 		{header: "NIP", dataIndex: 'NIP', width: 140}, 
 		{header: "Nama Lengkap", dataIndex: 'f_namalengkap', width: 150},
  	{header: "Pangkat", dataIndex: 'nama_pangkat', hidden: true, width: 100}, 
  	{header: "GolRu", dataIndex: 'nama_golru', width: 50}, 
 		{header: "Jabatan", dataIndex: 'nama_jab', width: 125},
 		{header: "Unit Organisasi", dataIndex: 'nama_unor', width: 150},
 		{header: "Unit Kerja", dataIndex: 'nama_unker', width: 150}
 	], 
  features: [filters_Search_RefPegawai],
 	bbar: tbSearch_RefPegawai,
 	dockedItems: [{xtype: 'pagingtoolbar', store: Data_Search_RefPegawai, dock: 'bottom', displayInfo: true}],
 	listeners: {
 		itemdblclick: function(dataview, record, item, index, e) {
 			Ext.getCmp('PILIH_pegawai').handler.call(Ext.getCmp("PILIH_pegawai").scope);
 		}
 	}
});
	
var win_popup_RefPegawai = new Ext.create('widget.window', {
 	id: 'win_popup_RefPegawai', title: 'Referensi Pegawai ' + title_plus, iconCls: 'icon-human',
 	modal:true, plain:true, closable: true, width: 650, height: 400, layout: 'fit', bodyStyle: 'padding: 5px;',
 	items: [Grid_Search_RefPegawai]
});

var new_popup_ref = win_popup_RefPegawai;

// POPUP REFERENSI PEGAWAI ---------------------------------------------------- END

// FUNCTION REF PEGAWAI ------------------------------------------------------- START 
function Funct_win_popup_RefPegawai(form_name, vfmode){
	//Str_Cur_Form_Caller_Pegawai = form_name;
	Cur_Form_Caller_Pegawai = window[form_name];
	fmode = vfmode;
	win_popup_RefPegawai.show();
}

function SetTo_Form_Caller_Pegawai(){
	var sm = Grid_Search_RefPegawai.getSelectionModel(), sel = sm.getSelection();
	if(sel.length == 1){
		var value_form = {
		 	NIP: sel[0].get('NIP'),
		 	f_namalengkap: sel[0].get('f_namalengkap'),
		 	gelar_d: sel[0].get('gelar_d'),
		 	gelar_b: sel[0].get('gelar_b'),
		 	tempat_lahir: sel[0].get('tempat_lahir'),
		 	tanggal_lahir: Ext.util.Format.date(sel[0].get('tanggal_lahir'),'d/m/Y'),
		 	jenis_kelamin: sel[0].get('jenis_kelamin'),
		 	usia: Ext.util.Format.number(sel[0].get('usia'), '1'),
		 	kode_jpeg: sel[0].get('kode_jpeg'),
		 	kode_dupeg: sel[0].get('kode_dupeg'),
		 	nama_dupeg: sel[0].get('nama_dupeg'),
		 	kode_golru: sel[0].get('kode_golru'),
		 	nama_pangkat: sel[0].get('nama_pangkat'),
		 	nama_golru: sel[0].get('nama_golru'),
		 	kode_jab: sel[0].get('kode_jab'),
		 	kode_klp_jab: sel[0].get('kode_klp_jab'),
		 	kode_eselon: sel[0].get('kode_eselon'),
		 	nama_jab: sel[0].get('nama_jab'),
		 	kode_unor: sel[0].get('kode_unor'),
		 	nama_unor: sel[0].get('nama_unor'),
		 	kode_unker: sel[0].get('kode_unker'),
		 	nama_unker: sel[0].get('nama_unker'),
		 	TMT_jab_lama: sel[0].get('TMT_jab')
		};

		switch(fmode){
			case 'atasan':
				// Pegawai Atasan
				var value_form = {
			  	NIP_atasan: sel[0].get('NIP'),
			  	nama_atasan: sel[0].get('f_namalengkap'),
			  	kode_jpeg_atasan: sel[0].get('kode_jpeg'),
			  	kode_golru_atasan: sel[0].get('kode_golru'),
			  	nama_pangkat_atasan: sel[0].get('nama_pangkat'),
			  	nama_golru_atasan: sel[0].get('nama_golru'),
			  	kode_jab_atasan: sel[0].get('kode_jab'),
			  	nama_jab_atasan: sel[0].get('nama_jab')
			  };
			  Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				break;
			case 'rcmd':
				// Pegawai yang merekomendasikan
				var value_form = {
			  	NIP_rcmdr: sel[0].get('NIP'),
			  	nama_rcmdr: sel[0].get('f_namalengkap'),
			  	kode_golru_rcmdr: sel[0].get('kode_golru'),
			  	kode_jpeg_rcmdr: sel[0].get('kode_jpeg'),
			  	nama_pangkat_rcmdr: sel[0].get('nama_pangkat'),
			  	nama_golru_rcmdr: sel[0].get('nama_golru'),
			  	kode_jab_rcmdr: sel[0].get('kode_jab'),
			  	nama_jab_rcmdr: sel[0].get('nama_jab'),
			  	kode_unor_rcmdr: sel[0].get('kode_unor'),
			  	nama_unor_rcmdr: sel[0].get('nama_unor'),
			  	nama_unker_rcmdr: sel[0].get('nama_unker')
			  };
			  Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				break;
			case 'penilai':
				// Penilai DP3
				var value_form = {
			  	NIP_penilai: sel[0].get('NIP'),
			  	nama_penilai: sel[0].get('f_namalengkap')
			  };
			  Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
			  break;
			case 'atasan_penilai':
				// Atasan Penilai DP3
				var value_form = {
			  	NIP_atasan_penilai: sel[0].get('NIP'),
			  	nama_atasan_penilai: sel[0].get('f_namalengkap')
			  };
			  Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
			  break;
			case 'disposisi':
				// Pegawai yang dipromosikan (Baperjakat) -> PPS
				T_PPS_Disposisi_Tambah(sel[0].get('NIP'), sel[0].get('kode_unor'), sel[0].get('kode_jab'), sel[0].get('kode_golru'));
				break;
			case 'pensiun':
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
			  Set_Data_Suami_Istri(sel[0].get('NIP'));
			  Set_Data_Alamat(sel[0].get('NIP'));
			  break;
			case 'ketua_penguji_rikes':
				// Ketua Tim Penguji Kesehatan
				var value_form = {
			  	NIP_ketua_penguji: sel[0].get('NIP'),
			  	nama_ketua_penguji: sel[0].get('f_namalengkap')
			  };
			  Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
			  break;
			case 'pngjwb_ib':
				// Pemberi Izin Belajar
				var value_form = {
			  	NIP_pngjwb: sel[0].get('NIP'),
			  	nama_pngjwb: sel[0].get('f_namalengkap'),
			  	kode_unor_pngjwb: sel[0].get('kode_unor'),
			  	kode_jab_pngjwb: sel[0].get('kode_jab')
			  };
			  Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
			  break;
  		case 'karissu':
    		// KARIS atau KARSU
    		Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				Set_Data_Suami_Istri(sel[0].get('NIP'));
			case 1:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				break;
			case 2:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				Set_Data_CPNS(sel[0].get('NIP'));
				break;
			case 3:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				Set_Data_CPNS(sel[0].get('NIP'));
				Set_Data_PMKG(sel[0].get('NIP'));
				break;
			case 4:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				Set_Data_CPNS(sel[0].get('NIP'));
				Set_Data_PMKG(sel[0].get('NIP'));
				Set_Data_KGB(sel[0].get('NIP'));
				Set_Data_KGB_Baru(sel[0].get('NIP'));
				break;
			case 5:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				Set_Data_Pddk(sel[0].get('NIP'));
				Set_Data_CPNS(sel[0].get('NIP'));
				Set_Data_PMKG(sel[0].get('NIP'));
				Set_Data_KPKT(sel[0].get('NIP'));
				Set_Data_AK(sel[0].get('NIP'));
				break;
			case 6:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
			  Set_Data_Suami_Istri(sel[0].get('NIP'));
			  Set_Data_Alamat(sel[0].get('NIP'));
			  break;
			case 7:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
			  Set_Data_Pensiun(sel[0].get('NIP'));
				break;
			case 8:
				// SK PNS
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				Set_Data_CPNS(sel[0].get('NIP'));
				Set_Data_Pddk(sel[0].get('NIP'));
				Set_Data_DP3(sel[0].get('NIP'));
				Set_Data_PraJab(sel[0].get('NIP'));
				Set_Data_RiKes(sel[0].get('NIP'));
				break;
			case 9:
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
				Set_Data_Pddk(sel[0].get('NIP'));
				Set_Data_KPKT(sel[0].get('NIP'));
				break;
			case 10:
				var value_form = {
				 	NIP: sel[0].get('NIP'),
				 	f_namalengkap: sel[0].get('f_namalengkap'),
				 	kode_jpeg: sel[0].get('kode_jpeg'),
				 	kode_golru: sel[0].get('kode_golru'),
				 	nama_pangkat: sel[0].get('nama_pangkat'),
				 	nama_golru: sel[0].get('nama_golru'),
				 	kode_jab: sel[0].get('kode_jab'),
				 	nama_jab: sel[0].get('nama_jab'),
				 	kode_unor: sel[0].get('kode_unor'),
				 	nama_unker: sel[0].get('nama_unker')
				};
				Cur_Form_Caller_Pegawai.getForm().setValues(value_form);				
				break;
			default:
	  }
	  
	  win_popup_RefPegawai.close();
	}else{
		Ext.MessageBox.show({title:'Peringatan !', msg: 'Silahkan pilih salah satu !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	}
}

function setParams_Data_Search_RefPegawai(p_eselon){
	Search_RefPegawai.onTrigger1Click();
	Data_Search_RefPegawai.changeParams({params :{id_open: 1, eselon: p_eselon, sPgwPilih:sPgwPilih, sDupeg:sDupeg, skode_unor:skode_unor, skode_golru:skode_golru}});
}

// FUNCTION REF PEGAWAI ------------------------------------------------------- END

<?php }else{ echo "var new_popup_ref = 'GAGAL';"; } ?>