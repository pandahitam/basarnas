<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
header("Content-Type: application/x-javascript"); ?>
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>

var s_ak_menu = false;
var Txt_Form_Caller_Pegawai = '', Cur_Form_Caller_Pegawai = '', Cur_mode = '';
var sesi_user = 1, kode_jpeg_profil=1;

function Check_Sesi(){	
	Ext.Ajax.request({
  	url: BASE_URL + 'ext_check_sesi', method: 'POST', renderer: 'data',
    success: function(response){ sesi_user = response.responseText; },
    failure: function(response){ sesi_user = 0; }, scope : this
	});
	return sesi_user;
}

var Data_CB_Golru = new Ext.create('Ext.data.Store', {
	fields: ['kode_golru','nama_pangkat','nama_golru'], idProperty: 'ID_Golru',
	proxy: new Ext.data.AjaxProxy({
		url: BASE_URL + 'combo_ref/combo_golru', actionMethods: {read:'POST'}, extraParams :{id_open: 1, kode_jpeg: 1}
	}), autoLoad: true
});

function Set_Form_Biodata(p_NIP){
	Ext.Ajax.timeout = Time_Out;
	Ext.Ajax.request({
  	url: BASE_URL + 'profil_pns/biodata_data',
    method: 'POST', params: {id_open: 1, NIP:p_NIP}, renderer: 'data',
    success: function(response){
    	if(response.responseText != "GAGAL"){
  			obj = Ext.decode(response.responseText);
  			photo_pgw = obj.photo;
  			if(kode_jpeg_profil != obj.results.kode_jpeg){
  				Data_CB_Golru.changeParams({params :{id_open: 1, kode_jpeg: obj.results.kode_jpeg}});
  			}
  			kode_jpeg_profil = obj.results.kode_jpeg;
  			
    			var value_form_head = {
    				NIP_v: obj.results.NIP,
    				NIP_Lama_v: obj.results.NIP_Lama,
    				nama_lengkap_v: obj.results.f_namalengkap,
    				pangkat_golru_v: obj.results.nama_pangkat + ', ' + obj.results.nama_golru,
    				TMT_BUP_v: Ext.util.Format.date(obj.results.TMT_BUP,'d/m/Y'),
    				nama_jab_v: obj.results.nama_jab,
    				nama_unker_v: obj.results.nama_unker,
    				nama_unor_v: obj.results.nama_unor
    			};    			

  				var value_form = {
    				ID_Pegawai: obj.results.ID_Pegawai,
    				NIP: obj.results.NIP,
    				NIP_Lama: obj.results.NIP_Lama,
    				nama_lengkap: obj.results.nama_lengkap,
    				gelar_d: obj.results.gelar_d,
    				gelar_b: obj.results.gelar_b,
    				tempat_lahir: obj.results.tempat_lahir,
    				tanggal_lahir: obj.results.tanggal_lahir,
    				jenis_kelamin: obj.results.jenis_kelamin,
    				gol_darah: obj.results.gol_darah,
    				suku: obj.results.suku,
    				agama: obj.results.agama,
    				warga_negara: obj.results.warga_negara,
    				status_kawin: obj.results.status_kawin,
    				jenjang_pddk: obj.results.jenjang_pddk,
    				nama_pddk: obj.results.nama_pddk,
    				tahun_lulus: obj.results.tahun_lulus,
    				kode_jpeg: obj.results.kode_jpeg,
    				kode_dupeg: obj.results.kode_dupeg,
    				no_KTP: obj.results.no_KTP,
    				no_NPWP: obj.results.no_NPWP,
    				no_KARPEG: obj.results.no_KARPEG,
    				no_ASKES: obj.results.no_ASKES,
    				no_KARIS: obj.results.no_KARIS,
    				no_TASPEN: obj.results.no_TASPEN,
    				TMT_CPNS: Ext.util.Format.date(obj.results.TMT_CPNS,'d/m/Y'),
    				masa_kerja: obj.results.masa_kerja,
    				alamat: obj.results.alamat,
    				desa: obj.results.desa,
    				kode_prov: obj.results.kode_prov,
    				kode_kabkota: obj.results.kode_kabkota,
    				kode_kec: obj.results.kode_kec,
    				kodepos: obj.results.kodepos,
    				telp: obj.results.telp,
    				fax: obj.results.fax,
    				hp: obj.results.hp,
    				email: obj.results.email
    			};

    			var value_form_arsip = {NIP: obj.results.NIP};

	    		var value_form_posisi_d_jab = {
    				NIP: obj.results.NIP,
    				unker_induk: 'BADAN SAR NASIONAL',
    				unit_kerja: obj.results.nama_unker,
    				unit_org: obj.results.nama_unor,
    				lokasi_kerja: obj.results.lokasi_kerja,
    				asal_instansi: obj.results.asal_instansi,
    				jenis_jab: obj.results.jenis_jab,    				
    				jab: obj.results.nama_jab,
    				TMT_jab: obj.results.TMT_jab,
    				nama_pangkat: obj.results.nama_pangkat,
    				nama_golru: obj.results.nama_golru,
    				mk_th: obj.results.mk_th_kpkt,
    				mk_bl: obj.results.mk_bl_kpkt,
    				eselon: obj.results.nama_eselon,
    				no_SPMT: obj.results.no_SPMT,
    				tgl_SPMT: obj.results.tgl_SPMT,
    				no_KPKN: obj.results.no_KPKN,
    				no_KTUA: obj.results.no_KTUA,
    				jns_fung: obj.results.jns_fung,
    				nama_fung: obj.results.nama_fung,
    				nama_fung_tertentu: obj.results.nama_fung_tertentu,
    				nama_pangkat_terakhir: obj.results.nama_pangkat,
    				nama_golru_terakhir: obj.results.nama_golru,
    				TMT_kpkt_terakhir: obj.results.TMT_kpkt,
    				mk_th_kpkt_terakhir: obj.results.mk_th_kpkt,
    				mk_bl_kpkt_terakhir: obj.results.mk_bl_kpkt,
    				gapok_kpkt_terakhir: obj.results.gapok_kpkt,
    				TMT_CPNS: obj.results.TMT_CPNS,
    				nama_pangkat_cpns: obj.results.nama_pangkat_cpns,
    				nama_golru_cpns: obj.results.nama_golru_cpns,
    				mk_th_cpns: obj.results.mk_th_cpns,
    				mk_bl_cpns: obj.results.mk_bl_cpns,
    				TMT_pmkg: obj.results.TMT_pmkg,
    				mk_th_pmkg: obj.results.mk_th_pmkg,
    				mk_bl_pmkg: obj.results.mk_bl_pmkg
	    		};

	    		var value_form_data_lainnya = {
	    			NIP: obj.results.NIP,
	    			tinggi: obj.results.tinggi,
	    			berat: obj.results.berat,
	    			rambut: obj.results.rambut,
	    			bentuk_muka: obj.results.bentuk_muka,
	    			warna_kulit: obj.results.warna_kulit,
	    			ciri2_khas: obj.results.ciri2_khas,
	    			cacat_tubuh: obj.results.cacat_tubuh,
	    			hobby: obj.results.hobby,
	    			no_skd: obj.results.no_skd,
	    			pejabat_skd: obj.results.pejabat_skd,
	    			tgl_skd: obj.results.tgl_skd,
	    			no_sbn: obj.results.no_sbn,
	    			pejabat_sbn: obj.results.pejabat_sbn,
	    			tgl_sbn: obj.results.tgl_sbn,
	    			no_skck: obj.results.no_skck,
	    			pejabat_skck: obj.results.pejabat_skck,
	    			tgl_skck: obj.results.tgl_skck
	    		};					

    		Form_Head_PPNS.getForm().setValues(value_form_head);    			
    		Form_Biodata_PNS.getForm().setValues(value_form);
    		Form_Arsip_Bio.getForm().setValues(value_form_arsip);
    		Form_Posisi_d_Jab.getForm().setValues(value_form_posisi_d_jab);
    		Form_Data_Lainnya.getForm().setValues(value_form_data_lainnya);
    	}
   	},
    failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    scope : this
	});		
}

function Get_Profil_PNS(ID_Pgw_z){	
  if(ID_Pgw_z){
  	Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'profil_pns/biodata_data',
    	method: 'POST', params: {id_open: 1,ID_Pgw:ID_Pgw_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				photo_pgw = obj.photo;
	  			if(kode_jpeg_profil != obj.results.kode_jpeg){
	  				Data_CB_Golru.changeParams({params :{id_open: 1, kode_jpeg: obj.results.kode_jpeg}});
	  			}
	  			kode_jpeg_profil = obj.results.kode_jpeg;

    			var value_form_head = {
    				NIP_v: obj.results.NIP,
    				NIP_Lama_v: obj.results.NIP_Lama,
    				nama_lengkap_v: obj.results.f_namalengkap,
    				pangkat_golru_v: obj.results.nama_pangkat + ', ' + obj.results.nama_golru,
    				TMT_BUP_v: Ext.util.Format.date(obj.results.TMT_BUP,'d/m/Y'),
    				nama_jab_v: obj.results.nama_jab,
    				nama_unker_v: obj.results.nama_unker,
    				nama_unor_v: obj.results.nama_unor
    			};    			

  				var value_form = {
    				ID_Pegawai: obj.results.ID_Pegawai,
    				NIP: obj.results.NIP,
    				NIP_Lama: obj.results.NIP_Lama,
    				nama_lengkap: obj.results.nama_lengkap,
    				gelar_d: obj.results.gelar_d,
    				gelar_b: obj.results.gelar_b,
    				tempat_lahir: obj.results.tempat_lahir,
    				tanggal_lahir: obj.results.tanggal_lahir,
    				jenis_kelamin: obj.results.jenis_kelamin,
    				gol_darah: obj.results.gol_darah,
    				suku: obj.results.suku,
    				agama: obj.results.agama,
    				warga_negara: obj.results.warga_negara,
    				status_kawin: obj.results.status_kawin,
    				jenjang_pddk: obj.results.jenjang_pddk,
    				nama_pddk: obj.results.nama_pddk,
    				tahun_lulus: obj.results.tahun_lulus,
    				kode_jpeg: obj.results.kode_jpeg,
    				kode_dupeg: obj.results.kode_dupeg,
    				no_KTP: obj.results.no_KTP,
    				no_NPWP: obj.results.no_NPWP,
    				no_KARPEG: obj.results.no_KARPEG,
    				no_ASKES: obj.results.no_ASKES,
    				no_KARIS: obj.results.no_KARIS,
    				no_TASPEN: obj.results.no_TASPEN,
    				TMT_CPNS: Ext.util.Format.date(obj.results.TMT_CPNS,'d/m/Y'),
    				masa_kerja: obj.results.masa_kerja,
    				alamat: obj.results.alamat,
    				desa: obj.results.desa,
    				kode_prov: obj.results.kode_prov,
    				kode_kabkota: obj.results.kode_kabkota,
    				kode_kec: obj.results.kode_kec,
    				kodepos: obj.results.kodepos,
    				telp: obj.results.telp,
    				fax: obj.results.fax,
    				hp: obj.results.hp,
    				email: obj.results.email
    			};

    			var value_form_arsip = {NIP: obj.results.NIP};

	    		var value_form_posisi_d_jab = {
    				NIP: obj.results.NIP,
    				unker_induk: 'BADAN SAR NASIONAL',
    				unit_kerja: obj.results.nama_unker,
    				unit_org: obj.results.nama_unor,
    				lokasi_kerja: obj.results.lokasi_kerja,
    				asal_instansi: obj.results.asal_instansi,
    				jenis_jab: obj.results.jenis_jab,    				
    				jab: obj.results.nama_jab,
    				TMT_jab: obj.results.TMT_jab,
    				nama_pangkat: obj.results.nama_pangkat,
    				nama_golru: obj.results.nama_golru,
    				eselon: obj.results.nama_eselon,
    				no_SPMT: obj.results.no_SPMT,
    				tgl_SPMT: obj.results.tgl_SPMT,
    				no_KPKN: obj.results.no_KPKN,
    				no_KTUA: obj.results.no_KTUA,
    				jns_fung: obj.results.jns_fung,
    				nama_fung: obj.results.nama_fung,
    				nama_fung_tertentu: obj.results.nama_fung_tertentu,
    				nama_pangkat_terakhir: obj.results.nama_pangkat,
    				nama_golru_terakhir: obj.results.nama_golru,
    				TMT_kpkt_terakhir: obj.results.TMT_kpkt,
    				mk_th_kpkt_terakhir: obj.results.mk_th_kpkt,
    				mk_bl_kpkt_terakhir: obj.results.mk_bl_kpkt,
    				gapok_kpkt_terakhir: obj.results.gapok_kpkt,
    				TMT_CPNS: obj.results.TMT_CPNS,
    				nama_pangkat_cpns: obj.results.nama_pangkat_cpns,
    				nama_golru_cpns: obj.results.nama_golru_cpns,
    				mk_th_cpns: obj.results.mk_th_cpns,
    				mk_bl_cpns: obj.results.mk_bl_cpns,
    				TMT_pmkg: obj.results.TMT_pmkg,
    				mk_th_pmkg: obj.results.mk_th_pmkg,
    				mk_bl_pmkg: obj.results.mk_bl_pmkg
	    		};

	    		var value_form_data_lainnya = {
	    			NIP: obj.results.NIP,
	    			tinggi: obj.results.tinggi,
	    			berat: obj.results.berat,
	    			rambut: obj.results.rambut,
	    			bentuk_muka: obj.results.bentuk_muka,
	    			warna_kulit: obj.results.warna_kulit,
	    			ciri2_khas: obj.results.ciri2_khas,
	    			cacat_tubuh: obj.results.cacat_tubuh,
	    			hobby: obj.results.hobby,
	    			no_skd: obj.results.no_skd,
	    			pejabat_skd: obj.results.pejabat_skd,
	    			tgl_skd: obj.results.tgl_skd,
	    			no_sbn: obj.results.no_sbn,
	    			pejabat_sbn: obj.results.pejabat_sbn,
	    			tgl_sbn: obj.results.tgl_sbn,
	    			no_skck: obj.results.no_skck,
	    			pejabat_skck: obj.results.pejabat_skck,
	    			tgl_skck: obj.results.tgl_skck
	    		};
					
    			if(obj.results.kode_klp_jab == 3){
    				s_ak_menu=true;
    			}else{
    				s_ak_menu=false;
    			}
					
    			Show_Form_Profil_PNS(value_form, value_form_head, value_form_arsip, value_form_posisi_d_jab, value_form_data_lainnya, 'edit');
    		}else{
    			Ext.MessageBox.show({title:'Peringatan !', msg:'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});    			
    		}
   		},
    	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    	scope : this
		});		
  }  
}

function Show_Form_Profil_PNS(value_form, value_form_head, value_form_arsip, value_form_posisi_d_jab, value_form_data_lainnya, mode){
  Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
	var new_page_id = Ext.getCmp('profil_pns_popup');
	if(new_page_id){
		Ext.getCmp('layout-body').body.unmask();
	}else{
		Ext.Ajax.request({
  		url: BASE_URL + 'profil_pns/profil_popup',
    	method: 'POST', params: {id_open: 1},
    	scripts: true, renderer: 'data',
    	success: function(response){    	
    		var jsonData = response.responseText; var aHeadNode = document.getElementsByTagName('head')[0]; var aScript = document.createElement('script'); aScript.text = jsonData; aHeadNode.appendChild(aScript);
    		if(win_popup_Profil_PNS != "GAGAL"){
    			win_popup_Profil_PNS.show();
    			if(mode == 'tambah'){    				
    				Profil_PNS_Reset_Biodata();
    			}
    			if(value_form_head && value_form){
		    		Form_Head_PPNS.getForm().setValues(value_form_head);    			
		    		Form_Biodata_PNS.getForm().setValues(value_form);
		    		Form_Arsip_Bio.getForm().setValues(value_form_arsip);
		    		Form_Posisi_d_Jab.getForm().setValues(value_form_posisi_d_jab);
		    		Form_Data_Lainnya.getForm().setValues(value_form_data_lainnya);
    			}
    			if(mode == 'tambah'){
    				Ext.getCmp('nama_lengkap').focus(false, 200);
    			}else{
    				Deactive_Form_Biodata_PNS();
    				Deactive_Form_Posisi_d_Jab();
    				Deactive_Form_Data_Lainnya();
    			}
    			if(s_ak_menu==false){Ext.getCmp('ak_menu').hide();}
    		}else{
    			Ext.MessageBox.show({title:'Peringatan !', msg:'Anda tidak dapat mengakses ke halaman ini !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});    			
    		}
   		},
    	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    	callback: function(response){ Ext.getCmp('layout-body').body.unmask(); },
    	scope : this
		});
	}
}

// CARI PEGAWAI -------------------------------------------------------------------- START
function Cari_Pegawai(form_name, fmode){
	Txt_Form_Caller_Pegawai = form_name;
	Cur_Form_Caller_Pegawai = window[form_name];
	Cur_mode = fmode;
	
	switch(fmode){
		case 'atasan':
			var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP_atasan').getValue(); break;
		case 'rcmd':
			var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP_rcmdr').getValue(); break;
		case 'penilai':
			var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP_penilai').getValue(); break;
		case 'atasan_penilai':
			var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP_atasan_penilai').getValue(); break;
		case 'ketua_penguji_rikes':
			var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP_ketua_penguji').getValue(); break;
		case 'pngjwb_ib':
			var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP_pngjwb').getValue(); break;
		default:
			var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP').getValue();
	}

	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_pegawai_browse',
    	method: 'POST', params: {id_open: 1, NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
	  			if(kode_jpeg_profil != obj.results.kode_jpeg){
	  				Data_CB_Golru.changeParams({params :{id_open: 1, kode_jpeg: obj.results.kode_jpeg}});
	  			}
	  			kode_jpeg_profil = obj.results.kode_jpeg;
  				
		  		var value_form = {
		    		NIP: obj.results.NIP,
		    		f_namalengkap: obj.results.f_namalengkap,
		    		gelar_d: obj.results.gelar_d,
		    		gelar_b: obj.results.gelar_b,
		    		tempat_lahir: obj.results.tempat_lahir,
		    		tanggal_lahir: obj.results.tanggal_lahir,
		    		jenis_kelamin: obj.results.jenis_kelamin,
		    		usia: Ext.util.Format.number(obj.results.usia, '1'),
		    		kode_dupeg: obj.results.kode_dupeg,
		    		nama_dupeg: obj.results.nama_dupeg,
		    		kode_golru: obj.results.kode_golru,
		    		nama_pangkat: obj.results.nama_pangkat,
		    		nama_golru: obj.results.nama_golru,
		    		kode_jab: obj.results.kode_jab,
		    		kode_klp_jab: obj.results.kode_klp_jab,
		    		nama_jab: obj.results.nama_jab,
		    		kode_unor: obj.results.kode_unor,
		    		nama_unor: obj.results.nama_unor,
		    		nama_unker: obj.results.nama_unker		    				
		    	};
					
  				switch(fmode){
  					case 'atasan':
		  				var value_form = {
		    				NIP_atasan: obj.results.NIP,
		    				nama_atasan: obj.results.f_namalengkap,
		    				kode_jpeg_atasan: obj.results.kode_jpeg,
		    				kode_golru_atasan: obj.results.kode_golru,
		    				nama_pangkat_atasan: obj.results.nama_pangkat,
		    				nama_golru_atasan: obj.results.nama_golru,
		    				kode_jab_atasan: obj.results.kode_jab,
		    				nama_jab_atasan: obj.results.nama_jab
		    			};
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
  						break;
  					case 'rcmd':
		  				var value_form = {
		    				NIP_rcmdr: obj.results.NIP,
		    				nama_rcmdr: obj.results.f_namalengkap,
		    				kode_golru_rcmdr: obj.results.kode_golru,
		    				kode_jpeg_rcmdr: obj.results.kode_jpeg,
		    				nama_pangkat_rcmdr: obj.results.nama_pangkat,
		    				nama_golru_rcmdr: obj.results.nama_golru,
		    				kode_jab_rcmdr: obj.results.kode_jab,
		    				nama_jab_rcmdr: obj.results.nama_jab,
		    				kode_unor_rcmdr: obj.results.kode_unor,
		    				nama_unor_rcmdr: obj.results.nama_unor,
		    				nama_unker_rcmdr: obj.results.nama_unker
		    			};
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
  						break;
  					case 'penilai':
		  				// Penilai DP3
		  				var value_form = {
		    				NIP_penilai: obj.results.NIP,
		    				nama_penilai: obj.results.f_namalengkap
		    			};
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
  						break;
  					case 'atasan_penilai':
		  				// Atasan Penilai DP3
		  				var value_form = {
		    				NIP_atasan_penilai: obj.results.NIP,
		    				nama_atasan_penilai: obj.results.f_namalengkap
		    			};
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
  						break;
  					case 'pensiun':
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    					Set_Data_CPNS(NIP_z);
							Set_Data_Suami_Istri(NIP_z);
							Set_Data_Alamat(NIP_z);
  						break;
  					case 'ketua_penguji_rikes':
		  				var value_form = {
		    				NIP_ketua_penguji: obj.results.NIP,
		    				nama_ketua_penguji: obj.results.f_namalengkap
		    			};
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
  						break;
						case 'pngjwb_ib':
							// Pemberi Izin Belajar
							var value_form = {
						  	NIP_pngjwb: obj.results.NIP,
						  	nama_pngjwb: obj.results.f_namalengkap,
						  	kode_unor_pngjwb: obj.results.kode_unor,
						  	kode_jab_pngjwb: obj.results.kode_jab
						  };
						  Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
						  break;
  					case 'karissu':
    					// KARIS atau KARSU
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_Suami_Istri(NIP_z);
  						break;
  					case 1:
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
  						break;
  					case 2:
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_CPNS(NIP_z);
  						break;
  					case 3:
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_CPNS(NIP_z);
							Set_Data_PMKG(NIP_z);
  						break;
  					case 4:
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_CPNS(NIP_z);
							Set_Data_PMKG(NIP_z);
							Set_Data_KGB(NIP_z);
							Set_Data_KGB_Baru(NIP_z);
  						break;
  					case 5:
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_Pddk(NIP_z);
							Set_Data_CPNS(NIP_z);
							Set_Data_PMKG(NIP_z);
							Set_Data_KPKT(NIP_z);
							Set_Data_AK(NIP_z);
							break;
  					case 6:
    					// Taperum
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_Suami_Istri(NIP_z);
							Set_Data_Alamat(NIP_z);
  						break;
  					case 7:
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_Pensiun(NIP_z);
  						break;
  					case 8:
    					// SK PNS
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_CPNS(NIP_z);
							Set_Data_Pddk(NIP_z);
							Set_Data_DP3(NIP_z);
							Set_Data_PraJab(NIP_z);
							Set_Data_RiKes(NIP_z);
							break;
						case 9:
							Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
							Set_Data_Pddk(NIP_z);
							Set_Data_KPKT(NIP_z);
							break;
						case 10:
							var value_form = {
							 	NIP: obj.results.NIP,
							 	f_namalengkap: obj.results.f_namalengkap,
							 	kode_jpeg: obj.results.kode_jpeg,
							 	kode_golru: obj.results.kode_golru,
							 	nama_pangkat: obj.results.nama_pangkat,
							 	nama_golru: obj.results.nama_golru,
							 	kode_jab: obj.results.kode_jab,
							 	nama_jab: obj.results.nama_jab,
							 	kode_unor: obj.results.kode_unor,
							 	nama_unker: obj.results.nama_unker
							};
							Cur_Form_Caller_Pegawai.getForm().setValues(value_form);				
							break;
  					default:
    					Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
  				}
  				
    		}else{
    			Ext.Msg.show({title:'Peringatan !', msg:'NIP tidak terdaftar !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR,
    				fn: function(btn) {
    					Cur_Form_Caller_Pegawai.getForm().reset(); 
    					Cur_Form_Caller_Pegawai.getForm().findField('NIP').focus(false, 200);
    				}
    			});
    		}
   		},
    	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    	scope : this
		});
	}
}
// CARI PEGAWAI -------------------------------------------------------------------- END

// POPUP PROFIL PEGAWAI BY FORM ---------------------------------------------------- START
function Show_Popup_Profil(form_name){
	if(Check_Sesi() == 0){
		window.location = BASE_URL + 'user/index'; return false;
	}else{
		Txt_Form_Caller_Pegawai = form_name;
		Cur_Form_Caller_Pegawai = window[form_name];
		var NIP_z = Cur_Form_Caller_Pegawai.getForm().findField('NIP').getValue();
		if(NIP_z){
			Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
			Ext.Ajax.timeout = Time_Out;
			Ext.Ajax.request({
		  	url: BASE_URL + 'browse_ref/ext_get_id_pegawai',
		    method: 'POST', params: {id_open:1, NIP:NIP_z}, renderer: 'data',
		    success: function(response){
		    	if(response.responseText != "GAGAL"){
		    		Get_Profil_PNS(response.responseText);
		    	}else{
		    		Ext.MessageBox.show({title:'Peringatan !', msg:'NIP tidak ditemukan di dalam profil !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
		    	}
		   	},
		    failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
		    callback: function(response){ Ext.getCmp('layout-body').body.unmask(); },
		    scope : this
			});
		}
	}
}
// POPUP PROFIL PEGAWAI BY FORM ---------------------------------------------------- END

// POPUP PROFIL PEGAWAI BY NIP ---------------------------------------------------- START
function Show_Popup_Profil_byNIP(NIP_z){
	if(NIP_z){
		Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
	  	url: BASE_URL + 'browse_ref/ext_get_id_pegawai', method: 'POST', params: {id_open:1, NIP:NIP_z}, renderer: 'data',
	    success: function(response){
	    	if(response.responseText != "GAGAL"){
	    		Get_Profil_PNS(response.responseText);
	    	}else{
	    		Ext.MessageBox.show({title:'Peringatan !', msg:'NIP tidak ditemukan di dalam profil !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR});
	    	}
	   	},
	    failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
	    callback: function(response){ Ext.getCmp('layout-body').body.unmask(); },
	    scope : this
		});
	}
}
// POPUP PROFIL PEGAWAI BY NIP ---------------------------------------------------- END

// SET SPECIAL DATA --------------------------------------------------------------- START
// SET SUAMI/ISTRI
function Set_Data_Suami_Istri(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_si_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				nama_si: obj.results.nama_si,
    				tmpt_lahir_si: obj.results.tmpt_lahir_si,
    				tgl_lahir_si: obj.results.tgl_lahir_si,
    				tgl_menikah: obj.results.tgl_menikah
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Gagal memuat dokumen !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, 
    	scope : this
		});
	}	
}

// SET ALAMAT
function Set_Data_Alamat(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_alamat_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				alamat_penerima: obj.results.alamat,
    				desa_penerima: obj.results.desa,
    				kec_penerima: obj.results.kecamatan,
    				kab_penerima: obj.results.kabupaten,
    				prov_penerima: obj.results.provinsi
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET PENDIDIKAN
function Set_Data_Pddk(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_pddk_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				IDP_Pddk: obj.results.IDP_Pddk,
    				kode_pddk: obj.results.kode_pddk,
    				nama_pddk: obj.results.nama_pddk,
    				jurusan: obj.results.jurusan,
    				tahun_lulus: obj.results.tahun_lulus
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET DATA CPNS
function Set_Data_CPNS(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_cpns_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				kode_golru_cpns: obj.results.kode_golru,
    				nama_pangkat_cpns: obj.results.nama_pangkat,
    				nama_golru_cpns: obj.results.nama_golru,
    				no_sk_cpns: obj.results.no_sk_kpkt,
    				TMT_CPNS: obj.results.TMT_kpkt,
    				mk_th_cpns: obj.results.mk_th_kpkt,
    				mk_bl_cpns: obj.results.mk_bl_kpkt
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET DATA PENYESUAIAN MASA KERJA / GOLONGAN
function Set_Data_PMKG(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_pmkg_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				TMT_pmkg: obj.results.TMT_pmkg,
    				mk_th_pmkg: obj.results.mk_th_terhitung,
    				mk_bl_pmkg: obj.results.mk_bl_terhitung
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET DATA KEPANGKATAN
function Set_Data_KPKT(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_kpkt_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				no_sk_lama: obj.results.no_sk_kpkt,
    				tgl_sk_lama: obj.results.tgl_sk_kpkt,
    				TMT_kpkt_lama: obj.results.TMT_kpkt,
    				mk_th_lama: obj.results.mk_th_kpkt,
    				mk_bl_lama: obj.results.mk_bl_kpkt
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET DATA ANGKA KREDIT
function Set_Data_AK(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_ak_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				ak_lama: obj.results.total_ak_lb
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET DATA KGB TERAKHIR
function Set_Data_KGB(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_kgb_pegawai', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				no_sk_lama: obj.results.no_sk_kgb,
    				tgl_sk_lama: obj.results.tgl_sk_kgb,
    				TMT_lama: obj.results.TMT_kgb,
    				mk_th_lama: obj.results.mk_th_kgb,
    				mk_bl_lama: obj.results.mk_bl_kgb,
    				gapok_lama: obj.results.gapok_baru
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET DATA KGB BARU
function Set_Data_KGB_Baru(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'layanan/kgb/get_data_kgb_baru', method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				TMT_kgb: obj.results._TMT_kgb,
    				TMT_yad: obj.results._TMT_yad,
    				mk_th_baru: obj.results._mk_th_kgb,
    				mk_bl_baru: obj.results._mk_bl_kgb
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    			KGB_Kontrol_Usul(obj.results._kurang_mk_bl, obj.results._bl_th_kgb, obj.results._mk_th_kgb);
    		}
   		},
    	scope : this
		});
	}	
}
// SET DP3
function Set_Data_DP3(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_dp3_pegawai',
    	method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				IDP_DP3: obj.results.IDP_DP3,
    				nilai_dp3: obj.results.nilai_dp3,
    				penilai_dp3: obj.results.penilai_dp3,
    				tgl_dp3: obj.results.tgl_dp3
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET PRA JABATAN
function Set_Data_PraJab(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_prajab_pegawai',
    	method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				no_sttpp: obj.results.no_sttpp,
    				tgl_sttpp: obj.results.tgl_sttpp
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET RIWAYAT KESEHATAN
function Set_Data_RiKes(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_rikes_pegawai',
    	method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				no_sk_rikes: obj.results.no_sk_rikes,
    				tgl_sk_rikes: obj.results.tgl_sk_rikes
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		},
    	scope : this
		});
	}	
}

// SET DATA PENSIUN
function Set_Data_Pensiun(NIP_z){
	if(NIP_z){
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: BASE_URL + 'browse_ref/ext_search_pensiun_pegawai',
    	method: 'POST', params: {id_open: 1,NIP:NIP_z}, renderer: 'data',
    	success: function(response){
    		if(response.responseText != "GAGAL"){
  				obj = Ext.decode(response.responseText);
  				var value_form = {
    				jns_pensiun: obj.results.jns_pensiun,
    				no_sk_pensiun: obj.results.no_sk_pensiun,
    				tgl_sk_pensiun: obj.results.tgl_sk_pensiun,
    				TMT_pensiun: obj.results.TMT_pensiun
    			};
    			Cur_Form_Caller_Pegawai.getForm().setValues(value_form);
    		}
   		}, scope : this
		});
	}	
}

function Set_Gaji_Pokok(form_name, p_kode_jpeg, field_golru, field_mk_th, field_gapok, vstatus_data){
	if(!vstatus_data){vstatus_data='baru';}
	var Cur_Form_Caller = window[form_name], vkode_golru = Cur_Form_Caller.getForm().findField(field_golru).getValue(), vmk_th = Cur_Form_Caller.getForm().findField(field_mk_th).getValue();
	if (vkode_golru){
		Ext.Ajax.request({
	  	url: BASE_URL + 'master_data/ext_search_gapok', params: {id_open: 1, kode_jpeg:p_kode_jpeg, kode_golru:vkode_golru, masa_kerja: vmk_th, status_data: vstatus_data}, method: 'POST', renderer: 'data',
	    success: function(response){
	    	Cur_Form_Caller.getForm().findField(field_gapok).setValue(response.responseText);
	   	},
	    failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Sesi Telah Berakhir !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, scope : this
		});
	}else{ Cur_Form_Caller.getForm().findField(field_gapok).setValue(0); }
}

function Set_Nama_Golru(form_name, field_golru, field_nama_golru, p_kode_jpeg){
	if(!p_kode_jpeg){p_kode_jpeg=1;}
	var Cur_Form_Caller = window[form_name], vkode_golru = Cur_Form_Caller.getForm().findField(field_golru).getValue();
	if (vkode_golru && p_kode_jpeg){
		Ext.Ajax.request({
	  	url: BASE_URL + 'combo_ref/get_nama_golru', params: {id_open: 1, kode_golru: vkode_golru, kode_jpeg: p_kode_jpeg}, method: 'POST', renderer: 'data',
	    success: function(response){
	    	Cur_Form_Caller.getForm().findField(field_nama_golru).setValue(response.responseText);	    	
	   	},
	    failure: function(response){ Ext.MessageBox.show({title:'Peringatan !', msg:'Sesi Telah Berakhir !', buttons: Ext.MessageBox.OK, icon: Ext.MessageBox.ERROR}); }, scope : this
		});
	}else{ Cur_Form_Caller.getForm().findField(field_nama_golru).setValue('-'); }
}
// SET SPECIAL DATA --------------------------------------------------------------- END

function Grid_Buka_Profil(Grid_Name){
	if(Check_Sesi() == 0){
		window.location = BASE_URL + 'user/index'; return false;
	}else{
		var sm = Grid_Name.getSelectionModel(), sel = sm.getSelection();
	  if(sel.length == 1){
	  	var NIP = sel[0].get('NIP');
	  	Show_Popup_Profil_byNIP(NIP);
	  }
	}
}

function Set_Label_NIP(p_id_NIP, p_kode_jpeg){
	switch(p_kode_jpeg){
		case '1': case '6':
			Ext.getCmp(p_id_NIP).setFieldLabel('N I P'); break;
		case '2': case '3': case '4': case '5':
			Ext.getCmp(p_id_NIP).setFieldLabel('N I R P'); break;
		case '7':
			Ext.getCmp(p_id_NIP).setFieldLabel('N I P'); break;
		case '8':
			Ext.getCmp(p_id_NIP).setFieldLabel('N I K'); break;
		default:
			Ext.getCmp(p_id_NIP).setFieldLabel('N I P');
	}
}

function Masking_NIP(form_name, p_NIP){
	// 19581103 197803 2 003
	var new_NIP = "", Len_NIP = String(Trim(p_NIP)).length;
	switch(Len_NIP){
		case 8 : new_NIP = Trim(p_NIP) + " "; break;
		case 15 : new_NIP = Trim(p_NIP) + " "; break;
		case 17 : new_NIP = Trim(p_NIP) + " "; break;
		default:
	}
	if(Len_NIP > 21) {new_NIP = Left(Trim(p_NIP), 21);}
	if(new_NIP){
		var Cur_Form_Masking = window[form_name];
		Cur_Form_Masking.getForm().findField('NIP').setValue(new_NIP);
	}
}

<?php }else{ echo "var Funct_PPNS = 'GAGAL';"; } ?>