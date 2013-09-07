<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<script>
////PANEL MAP  -------------------------------------------- START

var baseUrl = '<?php echo base_url(); ?>';
var PixelsPerInch = 72; //defaults are for meters
var InchesPerMapUnit = 39.3701;
var	mapDefaultExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
var sLocationCode = '';

var mapQueryPoint = new Array(-1, -1);

var mapMode;
var mapExtent;
var mapWidth;
var mapHeight;
var mapCellsize;
var mapMinScale;
var mapMaxScale;
var mapZoomDir;
var mapZoomSize;
var mapPanSize;

var refExtent;
var refWidth;
var refHeight;
var refCellsize;

function Layer(name, longname, group, status) {
  this.name = name;
  this.longname = longname;
  this.group = group;
  this.status = status;
}

var mapLayers =  new Array();
mapLayers[mapLayers.length] = new Layer('Batas_Negara', 'Batas Negara', 'layers', false);
mapLayers[mapLayers.length] = new Layer('Batas_Provinsi', 'Batas Provinsi', 'layers', false);
mapLayers[mapLayers.length] = new Layer('Batas_Kabupaten', 'Batas Kabupaten', 'layers', true);
mapLayers[mapLayers.length] = new Layer('Batas_Kecamatan', 'Batas Kecamatan', 'layers', false);
mapLayers[mapLayers.length] = new Layer('Kantor_SAR', 'Kantor SAR', 'layers', true);
mapLayers[mapLayers.length] = new Layer('Pos_SAR', 'Pos SAR', 'layers', true);
mapLayers[mapLayers.length] = new Layer('Jalan_Lokal', 'Jalan Lokal', 'layers', true);

function buildLayer() {
	var s = '';
	for(var i=0;i<mapLayers.length;i++)
	{
		if(mapLayers[i].status)
		{
			if(s=='') s += mapLayers[i].name;
			else s += '+'+mapLayers[i].name;
		}
	}
	return s;
};

var startMapImg = '/cgi-bin/mapserv?mode=map&map=MAP_FILE&mapext='+mapDefaultExtent.join('+')+'&mapsize=768+480&layers='+buildLayer();
var startRefImg = '/cgi-bin/mapserv?mode=reference&map=MAP_FILE&mapext='+mapDefaultExtent.join('+')+'&mapsize=768+480';

function applyZoom(x,y) {
	var dx, dy, mx, my, x, y, zoom;
	if(mapZoomDir == 1 && mapZoomSize != 0) zoom = mapZoomSize;
	else if(mapZoomDir == -1 && mapZoomSize != 0) zoom = 1/mapZoomSize;
	else zoom = 1;
	// convert *click* to map coordinates
	dx = mapExtent[2] - mapExtent[0];
	dy = mapExtent[3] - mapExtent[1];
	mx = mapExtent[0] + mapCellsize*x; 
	my = mapExtent[3] - mapCellsize*y;
	mapExtent[0] = mx - .5*(dx/zoom);
	mapExtent[1] = my - .5*(dy/zoom);
	mapExtent[2] = mx + .5*(dx/zoom);
	mapExtent[3] = my + .5*(dy/zoom);
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	if(mapMinScale != -1 && getScale() < mapMinScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMinScale);
	}
	if(mapMaxScale != -1 && getScale() > mapMaxScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMaxScale);
	}
};

function applyReference(x,y) {
	var mx, my, dx, dy;
	dx = mapExtent[2] - mapExtent[0];
	dy = mapExtent[3] - mapExtent[1];
	mx = refExtent[0] + refCellsize*x;
	my = refExtent[3] - refCellsize*y;
	mapExtent[0] = mx - .5*dx;
	mapExtent[1] = my - .5*dy;
	mapExtent[2] = mx + .5*dx;
	mapExtent[3] = my + .5*dy;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
};

function getScale() {
	var gd, md;
	md = (mapWidth-1)/(PixelsPerInch*InchesPerMapUnit);
	gd = mapExtent[2] - mapExtent[0];
	return(gd/md);
};

function setExtentFromScale(x, y, scale) {
	if((mapMinScale != -1) && (scale < mapMinScale)) scale = mapMinScale;
	if((mapMaxScale != -1) && (scale > mapMaxScale)) scale = mapMaxScale;
	mapCellsize = (scale/PixelsPerInch)/InchesPerMapUnit;
	mapExtent[0] = x - mapCellsize*mapWidth/2.0;
	mapExtent[1] = y - mapCellsize*mapHeight/2.0;
	mapExtent[2] = x + mapCellsize*mapWidth/2.0;
	mapExtent[3] = y + mapCellsize*mapHeight/2.0;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
};

function setExtent(minx, miny, maxx, maxy) {
	mapExtent[0] = minx;
	mapExtent[1] = miny;
	mapExtent[2] = maxx;
	mapExtent[3] = maxy;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	if(mapMinScale != -1 && getScale() < mapMinScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMinScale);    
	}
	if(mapMaxScale != -1 && getScale() > mapMaxScale) {
		x = (mapExtent[2] + mapExtent[0])/2;
		y = (mapExtent[3] + mapExtent[1])/2;
		setExtentFromScale(x, y, mapMaxScale);
	}
};

function adjustExtent(extent, width, height) {
	var cellsize = Math.max((extent[2] - extent[0])/(width-1), (extent[3] - extent[1])/(height-1));
	if(cellsize > 0) {
		var ox = Math.max(((width-1) - (extent[2] - extent[0])/cellsize)/2,0);
		var oy = Math.max(((height-1) - (extent[3] - extent[1])/cellsize)/2,0);
		extent[0] = extent[0] - ox*cellsize;
		extent[1] = extent[1] - oy*cellsize;
		extent[2] = extent[2] + ox*cellsize;
		extent[3] = extent[3] + oy*cellsize;
	}	
	return(cellsize);
};

function mapInit() {
	mapMode = 'map';
	mapExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	mapWidth = 768;
	mapHeight = 480;
	mapZoomDir = 0;
	mapZoomSize = 1.5;
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	mapMinScale = -1;
	mapMaxScale = -1;
	mapPanSize = .8;
	refExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	refWidth = 192;
	refHeight = 120;
	refCellsize = adjustExtent(refExtent, refWidth, refHeight);
};

function applyQuery() {
	var queryUrl = '/cgi-bin/mapserv?mode=query&map=MAP_FILE&imgext='+mapExtent.join('+')+'&imgxy='+mapQueryPoint.join('+')+'&imgsize='+mapWidth+'+'+mapHeight+'&layers='+buildLayer()+'&qlayer=Kantor_SAR';
	Ext.Ajax.timeout = Time_Out;
	Ext.Ajax.request({
		url: queryUrl, 
		method: 'GET',
		success: function(response){
			var rslt = new Ext.JSON.decode(response.responseText, true);
			var imageName = baseUrl+'assets/map/tmp/';
			imageName += 'basarnas'+rslt.kansar[0].imageId+'.png';
			document.mainImage.src = imageName;
			var kodeLoc = rslt.kansar[0].kodePse + rslt.kansar[0].kpb;
			var namaLoc = rslt.kansar[0].kantorSar;
			var dbUrl = baseUrl + 'global_map/req_all_asset/' + kodeLoc; 
			propsGrid.setTitle(namaLoc);
			Ext.Ajax.request({
				url: dbUrl, 
				method: 'GET',
				success: function(response)
				{
					var datas = new Ext.JSON.decode(response.responseText, true);
					sAssets.loadData(datas);
					Load_Popup('winmappopup', baseUrl + 'global_map/map_pop_up/' + sLocationCode);
				}
			});
			sLocationCode = kodeLoc;
		}
	});
};

function mapDraw() {
	if(mapMode=='map')
	{
		Ext.getDom('mainImage').src = "/cgi-bin/mapserv?mode=map&map=MAP_FILE&mapext="+mapExtent.join("+")+"&mapsize="+mapWidth+"+"+mapHeight+"&layers="+buildLayer();
	} else if(mapMode=='query') applyQuery();
	Ext.getDom('referenceImage').src = "/cgi-bin/mapserv?mode=reference&map=MAP_FILE&mapext="+mapExtent.join("+")+"&mapsize="+mapWidth+"+"+mapHeight;
};

function imgClick(event) {
	var offPos = Ext.getCmp('center_map_navigator').getPosition();
	var pos_x = event.clientX - offPos[0] - 6; //6: paddingX
	var pos_y = event.clientY - offPos[1] - 6; //6: paddingY
	if(mapMode=='map')
	{
		applyZoom(pos_x, pos_y);
	} else if(mapMode=='query')
	{
		mapQueryPoint[0] = pos_x;
		mapQueryPoint[1] = pos_y;
	}
	mapDraw();
};

function refClick(event) {
	var oldMode = mapMode;
	mapMode = 'map';
	pos_x = event.offsetX;
	pos_y = event.offsetY;
	applyReference(pos_x, pos_y);
	mapDraw();
	mapMode = oldMode;
};

function calculateExtent(arrExtents)
{
	var xMin = 360;
	var xMax = -360;
	var yMin = 90;
	var yMax = -90;
	var i;
	for(i=0; i<arrExtents.length; i++)
	{
		if(xMin>arrExtents[i][0]) xMin = arrExtents[i][0];
		if(xMax<arrExtents[i][0]) xMax = arrExtents[i][0];
		if(yMin>arrExtents[i][1]) yMin = arrExtents[i][1];
		if(yMax<arrExtents[i][1]) yMax = arrExtents[i][1];
	}
	var xy = new Array( xMin+((xMax-xMin)/2), yMin+((yMax-yMin)/2) );
	return xy;
}

function applyItemQuery(kodeWilayah) {
	//alert(kodeWilayah);
	if(kodeWilayah!=null)
	{
		kodeWilayah +='';
		if(kodeWilayah.length==4)
		{
			var kode = '';
			var queryUrl = '';
			queryUrl = '/cgi-bin/mapserv?mode=itemnquery&map=MAP_FILE&qstring='+kodeWilayah+'&qitem=KODEPSE&qlayer=Kantor_SAR'+'&layers='+buildLayer();
			Ext.Ajax.timeout = Time_Out;
			Ext.Ajax.request({
				url: queryUrl, 
				method: 'GET',
				success: function(response) {
					var rslt = new Ext.JSON.decode(response.responseText, true);
					var eLength = rslt.kansar.length; 
					if(eLength)
					{
						/* 
						// Alternate 01 -> Show query result : Zoom Center, No Highlight
						var x = 0;
						var y = 0;
						var extTmp = new Array();
						if(eLength==1)
						{
							extTmp = rslt.kansar[0].extent.split(' ');
							x = parseFloat(extTmp[0]);
							y = parseFloat(extTmp[1]);
						} else
						{
							var i = 0;
							for(i=0; i<eLength; i++) 
							{
								var aTmp = new Array(parseFloat(rslt.kansar[i].easting), parseFloat(rslt.kansar[i].northing));
								extTmp[i] = aTmp; 
							}
							var xy = calculateExtent(extTmp);
							x = xy[0];
							y = xy[1];
						}
						setExtentFromScale(x, y, getScale());
						*/
						var oldMode = mapMode;
						mapMode = 'map';
						mapDraw();
						mapMode = oldMode;
						var kodeLoc = rslt.kansar[0].kodePse + rslt.kansar[0].kpb;
						var namaLoc = rslt.kansar[0].kantorSar;
						var dbUrl = baseUrl + 'global_map/req_all_asset/' + kodeLoc; 
						propsGrid.setTitle(namaLoc);
						Ext.Ajax.request({
							url: dbUrl, 
							method: 'GET',
							success: function(response)
							{
								var datas = new Ext.JSON.decode(response.responseText, true);
								sAssets.loadData(datas);
								Load_Popup('winmappopup', baseUrl + 'global_map/map_pop_up/' + sLocationCode);
								// Alternate 02 -> Show query result : Zoom Extent, Highlight
								Ext.getDom('mainImage').src = baseUrl + 'assets/map/tmp/basarnas' + rslt.kansar[0].imageId + '.png';
								Ext.getDom('referenceImage').src = baseUrl + 'assets/map/tmp/basarnasref' + rslt.kansar[0].imageId + '.png';
								applyZoomAll();
							}
						});
						sLocationCode = kodeLoc;
					}
				}
			});
		}
	}
};

function applyZoomIn() {
	applyZoom(parseInt(mapWidth/2),parseInt(mapHeight/2));  
	mapDraw();
};

function applyZoomOut() {
	applyZoom(parseInt(mapWidth/2),parseInt(mapHeight/2));  
	mapDraw();
};

function applyZoomAll() {
	mapExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	mapCellsize = adjustExtent(mapExtent, mapWidth, mapHeight);
	refExtent = new Array(94.973492, -11.007750, 141.066985 ,7.033773);
	refCellsize = adjustExtent(refExtent, refWidth, refHeight);
};

//-------------------------------------------------------------------------------------------------------------------------------
    Ext.define('mAsset', {
        extend: 'Ext.data.Model',
        fields: ['asset', 'criteria', 'count']
    });

   var sAssets = Ext.create('Ext.data.Store', {
        storeId: 'sAssets',
        model: 'mAsset',
        //groupField: 'asset',
        sorters: ['asset','criteria'],
        data: []
		/*
		,
        listeners: {
            groupchange: function(store, groupers) {
                var grouped = restaurants.isGrouped(),
                    groupBy = groupers.items[0] ? groupers.items[0].property : '',
                    toggleMenuItems, len, i = 0;

                // Clear grouping button only valid if the store is grouped
                grid.down('[text=Clear Grouping]').setDisabled(!grouped);
                
                // Sync state of group toggle checkboxes
                if (grouped && groupBy === 'cuisine') {
                    toggleMenuItems = grid.down('button[text=Toggle groups...]').menu.items.items;
                    for (len = toggleMenuItems.length; i < len; i++) {
                        toggleMenuItems[i].setChecked(groupingFeature.isExpanded(toggleMenuItems[i].text));
                    }
                    grid.down('[text=Toggle groups...]').enable();
                } else {
                    grid.down('[text=Toggle groups...]').disable();
                }
            }
        }
		*/
    });

    var propsGrid = Ext.create('Ext.grid.Panel', {
        renderTo: Ext.getBody(),
        //collapsible: true,
        //iconCls: 'icon-grid',
        //frame: true,
        store: sAssets,
		width: '100%',
		height: 225,
        title: '-',
        //resizable: true,
        //features: [groupingFeature],
        /*
		tbar: ['->', {
            text: 'Toggle groups...',
            menu: toggleMenu
        }],
		*/
        columns: [{
            text: 'Asset',
            flex: 1,
			dataIndex: 'asset'
        },{
            text: 'Criteria',
            flex: 2,
			width: 250,
            dataIndex: 'criteria'
        },{
            text: 'Count',
			width: 50,
            dataIndex: 'count'
        }]
    });

var scale_slider = new Ext.create('Ext.slider.Single', {
	width: 130,
	value: 1.5,
	increment: 0.25,
	minValue: 1,
	maxValue: 4,
	decimalPrecision: 2,
	renderTo: Ext.getBody(),
	listeners: {
		change : function(ctl, newValue, oldValue, options) {
			mapZoomSize = parseFloat(newValue);
		}
	}			

});

var map_option_control = new Ext.create('Ext.form.Panel', {
    title: 'Control',
    bodyPadding: 10,
	padding: '5 0 0 0',
    width: '100%',
    height: 210,
    renderTo: Ext.getBody(),
    items:[
		{
			xtype: 'radiogroup',
			columns: 1,
			vertical: true,
			items: [
				{
					boxLabel: ' Query feature', 
					name: 'mapOption',
					handler: function(ctl, val) {
					  if(val) mapMode = 'query';
					}			
				},
				{
					boxLabel: ' Pan', 
					name: 'mapOption',
					checked: true,
					handler: function(ctl, val) {
						if(val) 
						{
							mapZoomDir = 0;
							mapMode = 'map';
						}
					}			
				}
			]
		},
		{
			xtype: 'label',
			text: 'Zoom Size'
		}, scale_slider,
		{
			xtype: 'button', 
			text: 'Zoom In',
			width: 130,
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					mapZoomDir = 1;
					applyZoomIn();
					mapZoomDir = 0;
					mapMode = oldMode;
				}
			}
		},
		{
			xtype: 'button', 
			text: 'Zoom Out',
			width: 130,
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					mapZoomDir = -1;
					applyZoomOut();
					mapZoomDir = 0;
					mapMode = oldMode;
				}
			}
		},
		{
			xtype: 'button', 
			text: 'Zoom All',
			width: 130,
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					applyZoomAll();
					mapDraw();
					mapMode = oldMode;
				}
			}
		}
	]
});

var map_option_layer = new Ext.create('Ext.form.Panel', {
    title: 'Layers',
    bodyPadding: 10,
    padding: '5 0 0 0',
    width: '100%',
    height: '100%',
    renderTo: Ext.getBody(),
    items: [
        {
            xtype: 'fieldcontainer',
            defaultType: 'checkboxfield',
            items: [
                {
                    boxLabel  : mapLayers[0].longname,
                    name      : mapLayers[0].group,
                    checked   : mapLayers[0].status,
					handler: function(ctl, val) {
						mapLayers[0].status = val;
					}
                }, {
                    boxLabel  : mapLayers[1].longname,
                    name      : mapLayers[1].group,
                    checked   : mapLayers[1].status,
					handler: function(ctl, val) {
						mapLayers[1].status = val;
					}
                }, {
                    boxLabel  : mapLayers[2].longname,
                    name      : mapLayers[2].group,
                    checked   : mapLayers[2].status,
					handler: function(ctl, val) {
						mapLayers[2].status = val;
					}
                },
                {
                    boxLabel  : mapLayers[3].longname,
                    name      : mapLayers[3].group,
                    checked   : mapLayers[3].status,
					handler: function(ctl, val) {
						mapLayers[3].status = val;
					}
                }, {
                    boxLabel  : mapLayers[4].longname,
                    name      : mapLayers[4].group,
                    checked   : mapLayers[4].status,
					handler: function(ctl, val) {
						mapLayers[4].status = val;
					}
                }, {
                    boxLabel  : mapLayers[5].longname,
                    name      : mapLayers[5].group,
                    checked   : mapLayers[5].status,
					handler: function(ctl, val) {
						mapLayers[5].status = val;
					}
                }, {
                    boxLabel  : mapLayers[6].longname,
                    name      : mapLayers[6].group,
                    checked   : mapLayers[6].status,
					handler: function(ctl, val) {
						mapLayers[6].status = val;
					}
				}
            ]			
        },
		{
			xtype: 'button', 
			name: 'map_layer_btn', 
			id: 'map_layer_btn', 
			text: 'Apply Layer(s)',
			listeners: {
				click : function(){
					var oldMode = mapMode;
					mapMode = 'map';
					mapDraw();
					mapMode = oldMode;
				}
			}
		}
    ]
});

var map_reference = new Ext.create('Ext.form.Panel', {
    title: 'Map Reference',
    bodyPadding: 10,
    padding: '5 0 0 0',
    width: '100%',
    renderTo: Ext.getBody(),
    items: [
		{ html: '<img id="referenceImage" onClick="refClick(event)" name="referenceImage" width="192" height="120" src="'+startRefImg+'" />' }
	]
});

var map_item_query = new Ext.create('Ext.form.Panel', {
    title: 'Kansar Info',
    bodyPadding: 10,
    padding: '5 0 0 0',
    width: '100%',
	height: '100%',
    renderTo: Ext.getBody(),
    items: [
		{
			xtype: 'button', 
			name: 'map_show_tanah', 
			id: 'map_show_tanah', 
			text: 'Tanah',
			listeners: {
				click : function(){
					Load_MapSearch('tanah_panel', BASE_URL + 'asset_tanah/tanah','DataTanah', sLocationCode);
				}
			}
		},
		{
			xtype: 'button', 
			name: 'map_show_bangunan', 
			id: 'map_show_bangunan', 
			text: 'Bangunan',
			listeners: {
				click : function(){
					Load_MapSearch('bangunan_panel', BASE_URL + 'asset_bangunan/bangunan','DataBangunan', sLocationCode);
				}
			}
		},
		{
			xtype: 'button', 
			name: 'map_show_alatbesar', 
			id: 'map_show_alatbesar', 
			text: 'Alat Besar',
			listeners: {
				click : function(){
					Load_MapSearch('alatbesar_panel', BASE_URL + 'asset_alatbesar/alatbesar','DataAlatbesar', sLocationCode);
				}
			}
		},
		{
			xtype: 'button', 
			name: 'map_show_angkutan', 
			id: 'map_show_angkutan', 
			text: 'Angkutan',
			listeners: {
				click : function(){
					Load_MapSearch('angkutan_panel', BASE_URL + 'asset_angkutan/angkutan','DataAngkutan', sLocationCode);
				}
			}
		},
		{
			xtype: 'button', 
			name: 'map_show_perairan', 
			id: 'map_show_perairan', 
			text: 'Perairan',
			listeners: {
				click : function(){
					Load_MapSearch('perairan_panel', BASE_URL + 'asset_perairan/perairan','DataPerairan', sLocationCode);
				}
			}
		},
		propsGrid
    ]
});

var map_navigator_layout = new Ext.create('Ext.panel.Panel', {
   id: 'map_navigator_layout', layout: 'border', width: '100%', height: '100%', bodyStyle: 'padding: 0px;', border: false,
   items: [
		{id: 'West_map_navigator', title:'Option', region: 'west', width: 200, minWidth: 200, split: true, collapsible: true, collapseMode: 'mini', bodyStyle: 'padding: 5px',
		 items: [map_option_control, map_option_layer]
		},
		{id: 'center_map_navigator', region: 'center', split: true, bodyStyle: 'padding: 6px; background : #35537e;', width: '100%', height: '100%',
		 html: '<img id="mainImage" onClick="imgClick(event)" name="mainImage" width="768" height="480" src="'+startMapImg+'"/>'
		},
		{id: 'East_map_navigator', title: 'Map Reference and Kansar Info', region: 'east', width: 360, minWidth: 360, split: true, collapsible: true, collapseMode: 'mini', bodyStyle: 'padding: 5px',
		 items: [map_reference, map_item_query]
		}
   ],
	listeners: {
			render: function(){
			mapInit();
		}
	}
   });

var map_navigator = new Ext.create('Ext.panel.Panel', {
   id: 'boxborder_map_navigator', title: 'Navigator', layout: 'border',
   width: '100%', height: '100%', bodyStyle: 'padding: 0px;',
   items: [
		{region: 'center', layout: 'card', collapsible: false, margins: '0 0 0 0', width: '100%', border: false,
	   items: [map_navigator_layout]
		}
   ]
});

var new_tabpanel = {
	id: 'map_asset', title: 'Global MAP', iconCls: 'icon-star',  border: true, closable: true,  
	layout: 'fit', items: [map_navigator]
}

<?php }else{ echo "var new_tabpanel = 'GAGAL';"; } ?>