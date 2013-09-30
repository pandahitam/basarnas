<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>

<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL UTAMA MASTER DATA  -------------------------------------------- START

//$.ajax({
//    url : BASE_URL + 'services/assetByKode/3010110001/107010900414412000KP/2',
//    type : 'GET',
//    dataType : 'JSON',
//    success : function (data)
//    {
//        console.log(data);
//    }
//});

var Tab_PA = Ext.createWidget('tabpanel', {
	id: 'Tab_PA', layout: 'fit', resizeTabs: true, enableTabScroll: false, deferredRender: true, border: false,
  defaults: {autoScroll:true},
  items: [{
      id: 'default_Tab_MD', 
      bodyPadding: 10,
      closable: false
  }]
});

var Center_PA = {
  region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: true, autoScroll: true,
  items: [Tab_PA],
  tbar: Ext.create('Ext.toolbar.Toolbar', {
	  layout: {overflowHandler: 'Menu'},
		items: [
		{text: 'Tanah', iconCls: 'icon-tanah_bangunan',
				handler: function(){
					Load_TabPage_Asset('tanah_panel', BASE_URL + 'asset_tanah/tanah');
				}, 
				tooltip: {
					text: 'Inventaris Asset - Tanah'
				}
		},
		{text: 'Bangunan', iconCls: 'icon-tanah_bangunan',
				handler: function(){
					Load_TabPage_Asset('bangunan_panel', BASE_URL + 'asset_bangunan/bangunan');
				}, 
				tooltip: {
					text: 'Inventaris Asset - Bangunan'
				}
		},
	  	{text: 'Alat Besar', iconCls: 'icon-kendaraan', 
				handler: function(){
					Load_TabPage_Asset('alatbesar_panel', BASE_URL+'asset_alatbesar/alatbesar')
				}, 
				tooltip: {
					text: 'Inventaris Asset - Alat Besar'
				}
		},
	  	{text: 'Angkutan', iconCls: 'icon-book', 
                                menu:{
                                    items:[
                                        {
                                            text:"Angkutan Darat", iconCls: 'icon-book',
                                            handler: function(){
                                                Load_TabPage_Asset('angkutan_darat_panel',BASE_URL+'asset_angkutan_darat/angkutan_darat')
                                            },
                                        },
                                        {
                                            text:"Angkutan Laut", iconCls: 'icon-book',
                                            handler: function(){
                                                Load_TabPage_Asset('angkutan_laut_panel',BASE_URL+'asset_angkutan_laut/angkutan_laut')
                                            },
                                        },
                                        {
                                            text:"Angkutan Udara", iconCls: 'icon-book',
                                            handler: function(){
                                                Load_TabPage_Asset('angkutan_udara_panel',BASE_URL+'asset_angkutan_udara/angkutan_udara')
                                            },
                                        },
//                                        {
//                                            text:"Semua", iconCls: 'icon-book',
//                                            handler: function(){
//                                                Load_TabPage_Asset('angkutan_panel',BASE_URL+'asset_angkutan/angkutan')
//                                            },
//                                        },
                                    ]
                            
                                },
				tooltip: {
					text: 'Inventaris Asset - Angkutan'
				}
		},
		{text: 'Perairan', iconCls: 'icon-book', 
                                handler: function(){
                                    Load_TabPage_Asset('perairan_panel',BASE_URL+'asset_perairan/perairan')
                                }, 
                                tooltip: {
                                    text: 'Inventaris Asset - Perairan'
                                }
                },
                {text: 'Senjata', iconCls: 'icon-book', 
                                handler: function(){
                                    Load_TabPage_Asset('senjata_panel',BASE_URL+'asset_senjata/senjata')
                                }, 
                                tooltip: {
                                    text: 'Inventaris Asset - Senjata'
                                }
                },
                {text: 'Ruang', iconCls: 'icon-book', 
                                handler: function(){
                                    Load_TabPage_Asset('ruang_panel',BASE_URL+'asset_ruang/ruang')
                                }, 
                                tooltip: {
                                    text: 'Inventaris Asset - Ruang'
                                }
                },
                {text: 'Luar', iconCls: 'icon-book', 
                                handler: function(){
                                    Load_TabPage_Asset('luar_panel',BASE_URL+'asset_luar/luar')
                                }, 
                                tooltip: {
                                    text: 'Inventaris Asset - Luar'
                                }
                },
                {text: 'Perlengkapan', iconCls: 'icon-book', 
                                handler: function(){
                                    Load_TabPage_Asset('perlengkapan_panel',BASE_URL+'asset_perlengkapan/perlengkapan')
                                }, 
                                tooltip: {
                                    text: 'Inventaris Asset - Perlengkapan'
                                }
                },
	  ]
  })
};

var Container_PA = {
	xtype: 'container', region: 'center', layout: 'border', border: false,
  items: [Center_PA]
};

var new_tabpanel = {
	id: 'pengelolaan_asset', title: 'Inventaris Asset', iconCls: 'icon-menu_impasing', border: false, closable: true, 
	layout: 'fit', items: [Container_PA]
};
// PANEL UTAMA MASTER DATA  --------------------------------------------- END

function Load_TabPage_Asset(tab_id,tab_url){
	Ext.getCmp('layout-body').body.mask("Loading...", "x-mask-loading");
	var new_tab_id = Ext.getCmp(tab_id);
	if(new_tab_id){
		Ext.getCmp('Tab_PA').setActiveTab(tab_id);
		Ext.getCmp('layout-body').body.unmask(); 
	}else{
		Ext.Ajax.timeout = Time_Out;
		Ext.Ajax.request({
  		url: tab_url, method: 'POST', params: {id_open: 1}, scripts: true, 
    	success: function(response){
    		var jsonData = response.responseText.substring(13);   
			var aHeadNode = document.getElementsByTagName('head')[0]; 
			var aScript = document.createElement('script'); 
			aScript.text = jsonData; 
			aHeadNode.appendChild(aScript);
    		if(new_tabpanel_Asset != "GAGAL"){
    			Ext.getCmp('Tab_PA').add(new_tabpanel_Asset).show();
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