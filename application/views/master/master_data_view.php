<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START

var West_MD = {
	title: 'PETUNJUK',
  region: 'west', collapsible: true,
  width: '25%', minSize: 100, maxSize: 350,
  split: true, iconCls: 'icon-help',
  items:[{
  	xtype : 'miframe', frame: false, height: '100%',
    src : BASE_URL + 'master_data/petunjuk'
  }]
};

var Tab_MD = Ext.createWidget('tabpanel', {
	id: 'Tab_MD', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [{
      id: 'default_Tab_MD', 
      bodyPadding: 10,
      closable: false
  }]
});

var Center_MD = {
  region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: true, autoScroll: true,
  items: [Tab_MD],
  tbar: Ext.create('Ext.toolbar.Toolbar', {
	  layout: {overflowHandler: 'Menu'},
		items: [
	  	{text: 'Unit Kerja', iconCls: 'icon-course', disabled: false, handler: function(){Load_TabPage_MD('master_unit_kerja', BASE_URL + 'master_data/unit_kerja');}, tooltip: {text: 'Referensi Unit Kerja'}},
	  	{text: 'Unit Organisasi', iconCls: 'icon-spell', disabled: false, handler: function(){Load_TabPage_MD('master_unit_organisasi', BASE_URL + 'master_data/unit_organisasi');}, tooltip: {text: 'Referensi Unit Organisasi'}},
                {text: 'Part', iconCls: 'icon-templates', disabled: false, menu:{
                        items:[
                            {text: 'Kelompok Part', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_kelompok_part', BASE_URL + 'master_data/kelompok_part');}, tooltip: {text: 'Referensi Kelompok Part'}},
                            {text: 'Part Number', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_partnumber', BASE_URL + 'master_data/part_number');}, tooltip: {text: 'Referensi Part Number'}},
                            {text: 'Sub Part', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_subpart', BASE_URL + 'master_data/sub_part');}, tooltip: {text: 'Referensi Sub Part'}},
                            {text: 'Sub Sub Part', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_subsubpart', BASE_URL + 'master_data/sub_sub_part');}, tooltip: {text: 'Referensi Sub Sub Part'}},
                        ]
                }},
                {text: 'Kode Barang', iconCls: 'icon-templates', disabled: false, menu:{
                        items:[
                            {text: 'Golongan', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_kd_brg_golongan', BASE_URL + 'master_data/kd_brg_golongan');}, tooltip: {text: 'Referensi Kode Barang Golongan'}},
                            {text: 'Bidang', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_kd_brg_bidang', BASE_URL + 'master_data/kd_brg_bidang');}, tooltip: {text: 'Referensi Kode Barang Bidang'}},
                            {text: 'Kelompok', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_kd_brg_kelompok', BASE_URL + 'master_data/kd_brg_kelompok');}, tooltip: {text: 'Referensi Kode Barang Kelompok'}},
                            {text: 'Sub Kelompok', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_kd_brg_subkelompok', BASE_URL + 'master_data/kd_brg_subkelompok');}, tooltip: {text: 'Referensi Kode Barang Sub Kelompok'}},
                            {text: 'Sub Sub Kelompok', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_kd_brg_subsubkelompok', BASE_URL + 'master_data/kd_brg_subsubkelompok');}, tooltip: {text: 'Referensi Kode Barang Sub Sub Kelompok'}},
                        ]
                }},
                {text: 'Klasifikasi Aset', iconCls: 'icon-templates', disabled: false, menu:{
                        items:[
                            {text: 'Klasifikasi Aset Lvl 1', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_klasifikasi_aset_lvl1', BASE_URL + 'master_data/klasifikasi_aset_lvl1');}, tooltip: {text: 'Referensi Klasifikasi Aset Lvl1'}},
                            {text: 'Klasifikasi Aset Lvl 2', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_klasifikasi_aset_lvl2', BASE_URL + 'master_data/klasifikasi_aset_lvl2');}, tooltip: {text: 'Referensi Klasifikasi Aset Lvl2'}},
                            {text: 'Klasifikasi Aset Lvl 3', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_klasifikasi_aset_lvl3', BASE_URL + 'master_data/klasifikasi_aset_lvl3');}, tooltip: {text: 'Referensi Klasifikasi Aset Lvl3'}},
                        ]
                }},
                {text: 'Penyimpanan', iconCls: 'icon-templates', disabled: false, menu:{
                        items:[
                            {text: 'Warehouse', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_warehouse', BASE_URL + 'master_data/warehouse');}, tooltip: {text: 'Referensi Warehouse'}},
                            {text: 'Ruang', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_ruang', BASE_URL + 'master_data/ruang');}, tooltip: {text: 'Referensi Ruang'}},
                            {text: 'Rak', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_rak', BASE_URL + 'master_data/rak');}, tooltip: {text: 'Referensi Rak'}},
                        ]
                    }},
                {text: 'Wilayah', iconCls: 'icon-templates', disabled: false, menu:{
                        items:[
                            {text: 'Provinsi', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_provinsi', BASE_URL + 'master_data/provinsi');}, tooltip: {text: 'Referensi Provinsi'}},
                            {text: 'Kota/Kabupaten', iconCls: 'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_kabkota', BASE_URL + 'master_data/kabkota');}, tooltip: {text: 'Referensi Kota/Kabupaten'}},
                        ]
                    }},
                {text:'Ruang', iconCls:'icon-templates', disabled: false, handler: function(){Load_TabPage_MD('master_referensi_ruang', BASE_URL + 'master_data/referensi_ruang');}}
               
	  ]
  })
};

var Container_MD = {
	xtype: 'container', region: 'center', layout: 'border', border: false,
  items: [Center_MD]
};

var new_tabpanel = {
	id: 'master_data', title: 'Referensi', iconCls: 'icon-gears', border: false, closable: true, 
	layout: 'fit', items: [Container_MD]
};
// PANEL UTAMA MASTER DATA  --------------------------------------------- END

function Load_TabPage_MD(tab_id,tab_url){
	Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
	var new_tab_id = Ext.getCmp(tab_id);
	if(new_tab_id){
		Ext.getCmp('Tab_MD').setActiveTab(tab_id);
		Ext.getCmp('layout-body').body.unmask(); 
	}else{
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true, 
    	success: function(response){    	
    		var jsonData = response.responseText.substring(14); var aHeadNode = document.getElementsByTagName('head')[0]; var aScript = document.createElement('script'); aScript.text = jsonData; aHeadNode.appendChild(aScript);
    		if(new_tabpanel_MD != "GAGAL"){
    			Ext.getCmp('Tab_MD').add(new_tabpanel_MD).show();
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
<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>