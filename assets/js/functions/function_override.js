// Ref : http://www.sencha.com/learn/grid-faq/

// Override FieldContainer
Ext.override(Ext.form.FieldContainer, {
  setFieldLabel : function(text) {
  	if (this.rendered) Ext.get(this.labelEl.id).update(text);
    this.fieldLabel = text;
  }
}); 

// Override Field
Ext.override(Ext.form.Field, {
  setFieldLabel : function(text) {
  	if (this.rendered) Ext.get(this.labelEl.id).update(text);
    this.fieldLabel = text;
  }
}); 

// Override Checkbox
Ext.override(Ext.form.Checkbox, {
	setBoxLabel: function(boxLabel){
		if(this.rendered) Ext.get(this.boxLabelEl.id).update(boxLabel);
		this.boxLabel = boxLabel;
	}
});

// Override DateField
Ext.override(Ext.form.DateField, {
	format: 'd/m/Y', emptyText: 'dd/mm/yyyy', maskRe: /[\d\/\;]/, altFormats: 'dmY|Y-m-d|jny'
});

// Override Combobox
Ext.override(Ext.form.ComboBox, {
  getSelectedIndex: function() {
    var v = this.getValue();
    var r = this.findRecord(this.valueField || this.displayField, v);
    return(this.store.indexOf(r));
  },
	assertValue  : function(){
  	var val = this.getRawValue(), rec;
    if(this.valueField && Ext.isDefined(this.value)){
    	rec = this.findRecord(this.valueField, this.value);
		}
    if(!rec || rec.get(this.displayField) != val){
    	rec = this.findRecord(this.displayField, val);
		}
    if(!rec && this.forceSelection){
    	if(val.length > 0 && val != this.emptyText){
      	this.el.dom.value = Ext.value(this.lastSelectionText, '');
        this.applyEmptyText();
      }else{
      	this.clearValue();
      }
    }else{
    	if(rec && this.valueField){
      	val = rec.get(this.valueField);
        if (this.value == val){
        	return;
        }
      }
      this.setValue(val);
    }
	}
});

Ext.override(Ext.LoadMask, {
	onHide: function() {this.callParent();}
});

// Override CheckboxGroup
Ext.override(Ext.form.CheckboxGroup, {
  getNames: function() {
		var n = [];
    this.items.each(function(item) {
      if (item.getValue()) {
        n.push(item.getName());
      }
    });
    return n;
  },
  getValues: function() {
    var v = [];
    this.items.each(function(item) {
      if (item.getValue()) {
        v.push(item.getRawValue());
      }
    });
    return v;
  },
  setValues: function(v) {
    var r = new RegExp('(' + v.join('|') + ')');

    this.items.each(function(item) {
      item.setValue(r.test(item.getRawValue()));
    });
  }
});

// Override RadioGroup
Ext.override(Ext.form.RadioGroup, {
  getName: function() {
    return this.items.first().getName();
  },
  getValue: function() {
    var v;
    this.items.each(function(item) {
      v = item.getRawValue();
      return !item.getValue();
    });
    return v;
  },
  setValue: function(v) {
    this.items.each(function(item) {
      item.setValue(item.getRawValue() == v);
    });
  }
});


// Override Data Store
Ext.override(Ext.data.Store, {
	// startAutoRefresh : function(interval, params, callback, refreshNow){
  startAutoRefresh: function(c){
  	if (c.refreshNow) {
    	this.load({params: c.params, callback: c.callback});
    }
    if (this.autoRefreshProcId) {
    	clearInterval(this.autoRefreshProcId);
    }
    //use reload for subsequent refreshes
    //pass empty arguments so lastOptions is maintained
    this.autoRefreshProcId = setInterval(this.reload.createDelegate(this, []), c.interval * 1000);
  },
  stopAutoRefresh: function(){
  	if (this.autoRefreshProcId) {
    	clearInterval(this.autoRefreshProcId);
    }
  },
  changeParams: function(c){
  	//this.proxy.noCache = false;
  	this.proxy.extraParams = c.params;
  	this.proxy.applyEncoding(this.proxy.extraParams);
  	this.loadPage(1);
  }
}); 

// Override Data Operation
Ext.override(Ext.data.Operation, {
	getRecords: function() {
		var resultSet = this.getResultSet();
		return this.records || (resultSet ? resultSet.records : null);
	}
});

// Override Grid Panel
Ext.override(Ext.grid.Panel, {
	viewConfig: {layout: 'fit'}	
});

Ext.override(Ext.grid.column.Column, {
	initResizable: Ext.emptyFn
});

// Override Grid Scroller
Ext.override(Ext.grid.Scroller, {
	onAdded: function() {
  	this.callParent(arguments);
    var me = this;
    if (me.scrollEl) {
    	me.mun(me.scrollEl, 'scroll', me.onElScroll, me);
      me.mon(me.scrollEl, 'scroll', me.onElScroll, me);
    }
  }
});

//Takes any number of objects and returns one merged object
var objectMerge = function(){
	var out = {};
  if(!arguments.length)
  	return out;
	for(var i=0; i < arguments.length; i++) {
  	for(var key in arguments[i]){
    	out[key] = arguments[i][key];
    }
  }
  return out;
}

// CHECK Is Integer, Float, Number, Numeric
function isset(varname){return(typeof(varname)!='undefined');}
function IsInteger(n){return ((typeof n==='number')&&(n%1===0));}
function IsFloat(n){return ((typeof n==='number')&&(n%1!==0));}
function IsNumber(n){return (typeof n==='number');}

function IsNumeric(sText,decimals,negatives) {
	var isNumber=true;
	var numDecimals = 0;
	var validChars = "0123456789";
	if (decimals)  validChars += ".";
	if (negatives) validChars += "-";
	var thisChar;
	for (i = 0; i < sText.length && isNumber == true; i++) {  
		thisChar = sText.charAt(i); 
		if (negatives && thisChar == "-" && i > 0) isNumber = false;
		if (decimals && thisChar == "."){
			numDecimals = numDecimals + 1;
			if (i==0 || i == sText.length-1) isNumber = false;
			if (numDecimals > 1) isNumber = false;
		}
		if (validChars.indexOf(thisChar) == -1) isNumber = false;
	}
	return isNumber;
}

function IsDate(sDate) {
	var scratch = new Date(sDate);
	if (scratch.toString() == "NaN" || scratch.toString() == "Invalid Date") {
		return false;
	} else {
		return true;
	}
}

function isURL(str){
	var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	return regexp.test(str);
}

function toFixed(value, precision) {
	var newvalue = parseFloat(value);
	var power = Math.pow(10, precision || 0);
  return String(Math.round(newvalue * power) / power);
}

// Function Left, Right, Mid
function Left(str, n){
	if (n <= 0)
		return "";
	else if (n > String(str).length)
		return str;
	else
	return String(str).substring(0,n);
}
function Right(str, n){
	if (n <= 0)
		return "";
	else if (n > String(str).length)
		return str;
	else {
		var iLen = String(str).length;
		return String(str).substring(iLen, iLen - n);
	}
}
function Mid(str, s, n){
	if (s <= 0)
		return "";
	else if (n <= 0)
		return "";
	else if (String(str).length <= 0)
		return "";
	else if (s > String(str).length)
		return str;
	else {
		return str.substring(s - 1, s + n - 1);
	}
}

function Trim(str){
	var	str = str.replace(/^\s\s*/, ''), ws = /\s/, i = str.length;
	while (ws.test(str.charAt(--i)));
	return str.slice(0, i + 1);
}

// Function ReplaceAll
function replaceAll(str, n, r){
	var mystr = new String(), myRegExp = new RegExp(n, "g");
  mystr = str;
  if (myRegExp == "/./g"){
  	return mystr.replace(/\./g, r); 	
  }else{
  	return mystr.replace(myRegExp, r); 	
  }
}

Array.prototype.Average = function() {
	var av = 0, cnt = 0, len = this.length;
	for (var i = 0; i < len; i++) {
		var e = +this[i];
		if(!e && this[i] !== 0 && this[i] !== '0') e--;
		if (this[i] == e) {av += e; cnt++;}
	}
	return av/cnt;
}

// START - CALCULATION DATE
function add_years(Str_Date, p_add) {
	var currentTime = new Date(Str_Date);
	var month = currentTime.getMonth() + 1;
	var day = currentTime.getDate();
	var year = currentTime.getFullYear() + p_add;
	return new Date(month + "/" + day + "/" + year);
}

function diff_years(Str_D_From, Str_D_Now) {
  var now = new Date(Str_D_Now); 
  var yearNow = now.getYear(), monthNow = now.getMonth(), dateNow = now.getDate();

  var dob = new Date(Str_D_From); 
  var yearDob = dob.getYear(), monthDob = dob.getMonth(), dateDob = dob.getDate();

  var yearAge = yearNow - yearDob;

  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow - monthDob;
  }

  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }
	return yearAge;
}

function diff_months(Str_D_From, Str_D_Now) {
  var now = new Date(Str_D_Now); 
  var yearNow = now.getYear(), monthNow = now.getMonth(), dateNow = now.getDate();

  var dob = new Date(Str_D_From); 
  var yearDob = dob.getYear(), monthDob = dob.getMonth(), dateDob = dob.getDate();

  var yearAge = yearNow - yearDob;

  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow - monthDob;
  }

  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }
	return monthAge;
}
// END - CALCULATION DATE

// START - TERBILANG
function terbilang(bilangan) { 
	bilangan    = String(bilangan);
	var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
	var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
	var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');
 
 	var panjang_bilangan = bilangan.length;
 
 	/* pengujian panjang bilangan */
 	if (panjang_bilangan > 15) {
   	kaLimat = "Diluar Batas";
   	return kaLimat;
 	}
 
 	/* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 	for (i = 1; i <= panjang_bilangan; i++) {
   	angka[i] = bilangan.substr(-(i),1);
 	}
 
 	i = 1;
 	j = 0;
 	kaLimat = "";
 
 
 	/* mulai proses iterasi terhadap array angka */
 	while (i <= panjang_bilangan) {
 
   	subkaLimat = "";
   	kata1 = "";
   	kata2 = "";
   	kata3 = "";
 
   	/* untuk Ratusan */
   	if (angka[i+2] != "0") {
     	if (angka[i+2] == "1") {
       	kata1 = "Seratus";
     	} else {
       	kata1 = kata[angka[i+2]] + " Ratus";
     	}
   	}
 
   	/* untuk Puluhan atau Belasan */
   	if (angka[i+1] != "0") {
     	if (angka[i+1] == "1") {
       	if (angka[i] == "0") {
         	kata2 = "Sepuluh";
       	} else if (angka[i] == "1") {
         	kata2 = "Sebelas";
       	} else {
         	kata2 = kata[angka[i]] + " Belas";
       	}
     	} else {
       	kata2 = kata[angka[i+1]] + " Puluh";
     	}
   	}
 
   	/* untuk Satuan */
   	if (angka[i] != "0") {
     	if (angka[i+1] != "1") {
       	kata3 = kata[angka[i]];
     	}
   	}
 
   	/* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   	if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     	subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   	}
 
   	/* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   	kaLimat = subkaLimat + kaLimat;
   	i = i + 3;
   	j = j + 1; 
 }
 
 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }
  
 //return kaLimat + "Rupiah";
 return kaLimat;
}
// END - TERBILANG

