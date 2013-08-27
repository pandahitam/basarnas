<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
    
<script>
////// Model In View

Ext.define('MRiwayatPajakTanahDanBangunan', {extend: 'Ext.data.Model',
    fields: ['id','id_ext_asset','tahun_pajak','tanggal_pembayaran','jumlah_setoran',
        'file_setoran']
});

Ext.define('MInventoryPenerimaan', {extend: 'Ext.data.Model',
    fields: ['id','tgl_berita_acara','nomor_berita_acara','kd_brg','kd_lokasi',
        'no_aset', 'part_number','serial_number','date_created',
        'nama_unker','nama_unor', 'keterangan',
        'status_barang','qty','tgl_penerimaan','asal_barang','kode_unor']
});

Ext.define('MLuar', {extend: 'Ext.data.Model',
    fields: ['kd_lokasi','kd_brg','no_aset','lok_fisik',
        'id', 'kode_unor','image_url','document_url',
        'nama_unker','nama_unor', 'nama',
        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' // kode barang
        ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
        'kd_lvl1','kd_lvl2','kd_lvl3',]
});

Ext.define('MPerlengkapan', {extend: 'Ext.data.Model',
    fields: ['id','warehouse_id','ruang_id','rak_id',
        'serial_number', 'part_number','kd_brg','kd_lokasi',
        'no_aset','kondisi', 'kuantitas', 'dari',
        'tanggal_perolehan','no_dana','penggunaan_waktu',
        'penggunaan_freq','unit_waktu','unit_freq','disimpan', 
        'dihapus','image_url','document_url'
        ,'kd_klasifikasi_aset','nama_klasifikasi_aset','kode_unor']
});

Ext.define('MPemeliharaanBangunan', {extend: 'Ext.data.Model',
    fields: ['id','kd_brg', 'kd_lokasi', 'no_aset',
                            'kode_unor', 'jenis', 'subjenis', 'pelaksana_nama', 'pelaksana_startdate', 
							'pelaksana_endate', 'deskripsi', 'biaya', 'image_url', 'document_url','nama','kondisi']
});


Ext.define('MBangunan', {extend: 'Ext.data.Model',
  	fields: ['kd_lokasi', 'kd_brg', 'no_aset', // field from asset bangunan
            'kuantitas', 'no_kib', 'type', 
            'thn_sls', 'thn_pakai', 'no_imb', 'tgl_imb', 
            'kd_prov', 'kd_kab', 'kd_kec', 'kd_kel', 
            'alamat', 'kd_rtrw', 'no_kibtnh', 
            'dari', 'kondisi', 'unit_pmk', 
            'alm_pmk', 'catatan', 'rphwajar', 
            'rphnjop', 'status', 'luas_dsr', 
            'luas_bdg', 'jml_lt',
            'nop','njkp','waktu_pembayaran','setoran_pajak','keterangan',// Field from ext bangunan
            'id','nama_unker', 'nama_unor', 
            'nop','njkp','waktu_pembayaran','setoran_pajak','keterangan',
            'kode_unor','image_url','document_url',
            'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' // kode barang
            ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
            'kd_lvl1','kd_lvl2','kd_lvl3',
        ]
});

Ext.define('MAngkutan', {extend: 'Ext.data.Model',
    fields: ['id', 'kd_lokasi', 
        'kd_brg', 'no_aset', 
        'kuantitas', 'no_kib', 
        'merk', 'type', 
        'pabrik', 'thn_rakit', 
        'thn_buat', 'negara', 
        'muat', 'bobot', 
        'daya', 'msn_gerak', 
        'jml_msn', 'bhn_bakar', 
        'no_mesin', 'no_rangka', 
        'no_polisi', 'no_bpkb', 
        'lengkap1', 'lengkap2', 
        'lengkap3', 'jns_trn', 
        'dari', 'tgl_prl', 
        'rph_aset', 'dasar_hrg', 
        'sumber', 'no_dana', 
        'tgl_dana', 'unit_pmk', 
        'alm_pmk', 'catatan', 
        'kondisi', 'tgl_buku', 
        'rphwajar', 'status', 
        'id','nama_unker', 'nama_unor', // Field from ext bangunan
        'kode_unor','image_url','document_url',
        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' // kode barang
        ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
        'kd_lvl1','kd_lvl2','kd_lvl3',
    ]
});

Ext.define('MAlatbesar', {extend: 'Ext.data.Model',
    fields: ['kd_lokasi', // Field from asset alatbesar
        'kd_brg', 'no_aset', 
        'kuantitas', 'no_kib', 
        'merk', 'type', 
        'pabrik', 'thn_rakit', 
        'thn_buat', 'negara', 
        'kapasitas', 'sis_opr', 
        'sis_dingin', 'sis_bakar', 
        'duk_alat', 'pwr_train', 
        'no_mesin', 'no_rangka', 
        'lengkap1', 'lengkap2', 
        'lengkap3', 'jns_trn', 
        'dari', 'tgl_prl', 
        'rph_aset', 'dasar_hrg', 
        'sumber', 'no_dana', 
        'tgl_dana', 'unit_pmk', 
        'alm_pmk', 'catatan', 
        'kondisi', 'tgl_buku', 
        'rphwajar', 'status', 
        'cad1',
        'id','nama_unker', 'nama_unor', // Field from ext alatbesar
        'kode_unor','image_url','document_url',
        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' // kode barang
        ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
        'kd_lvl1','kd_lvl2','kd_lvl3',
     ]
});


Ext.define('MSenjata', {extend: 'Ext.data.Model',
    fields: ['id', 'kd_lokasi', 
        'kd_brg', 'no_aset', 
        'rph_aset', 'no_kib', 
        'kuantitas', 'nama', 
        'merk', 'type', 
        'kaliber', 'no_pabrik', 
        'thn_buat', 'surat', 
        'tgl_surat', 'lengkap1', 
        'lengkap2', 'lengkap3', 
        'jns_trn', 'dari', 
        'tgl_prl', 'kondisi', 
        'dasar_hrg', 'sumber', 
        'no_dana', 'tgl_dana', 
        'unit_pmk', 'alm_pmk', 
        'catatan', 'tgl_buku', 
        'rphwajar', 'status',
        'id','nama_unker', 'nama_unor', // Field from ext bangunan
        'kode_unor','image_url','document_url',
        'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' // kode barang
        ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
        'kd_lvl1','kd_lvl2','kd_lvl3',
    ]
});

Ext.define('MTanah', {extend: 'Ext.data.Model',
  	fields: ['kd_lokasi', 'kd_brg', 'no_aset', // Field from asset tanah
            'kuantitas', 'rph_aset', 'no_kib', 'luas_tnhs', 
            'luas_tnhb', 'luas_tnhl', 'luas_tnhk', 'kd_prov', 
            'kd_kab', 'kd_kec', 'kd_kel', 'kd_rtrw', 
            'alamat', 'batas_u', 'batas_s', 'batas_t', 
            'batas_b', 'jns_trn', 'sumber', 'dari', 
            'dasar_hrg', 'no_dana', 'tgl_dana', 'surat1', 
            'surat2', 'surat3', 'rph_m2', 'unit_pmk', 
            'alm_pmk', 'catatan', 'tgl_prl', 'tgl_buku', 
            'rphwajar', 'rphnjop', 'status', 'smilik',
            'id_ext_asset','nama_unker', 'nama_unor', // Field from ext tanah
            'kode_unor','image_url','document_url',
            'nop','njkp','waktu_pembayaran','setoran_pajak','keterangan',
            'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' // kode barang
            ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
            'kd_lvl1','kd_lvl2','kd_lvl3',
        ]
});

Ext.define('MPerairan', {extend: 'Ext.data.Model',
  	fields: [
            'id',
            'kd_lokasi', 'kd_brg', 
            'no_aset', 'kuantitas', 
            'rph_aset', 'no_kib', 
            'luas_bdg', 'luas_dsr', 
            'kapasitas', 'thn_sls', 
            'thn_pakai', 'no_imb', 
            'tgl_imb', 'kd_prov', 
            'kd_kab', 'kd_kec', 
            'kd_kel', 'alamat', 
            'kd_rtrw', 'no_kibtnh', 
            'jns_trn', 'dari', 
            'tgl_prl', 'kondisi', 
            'rph_wajar', 'dasar_hrg', 
            'sumber', 'no_dana', 
            'tgl_dana', 'unit_pmk', 
            'alm_pmk', 'catatan', 
            'tgl_buku', 'kons_sist', 
            'rphwajar', 'status',
            'id','nama_unker', 'nama_unor', // Field from ext bangunan
            'kode_unor','image_url','document_url',
            'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' // kode barang
            ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
            'kd_lvl1','kd_lvl2','kd_lvl3',
        ]
});

Ext.define('MRuang', {extend: 'Ext.data.Model',
  	fields: [
            'id',
            'kd_lokasi', 'kd_brg', 
            'no_aset', 'kd_ruang',
            'kd_pemilik', 'kd_unor',
            'document_url', 'image_url',
            'ruang', 'pejabat_ruang',
            'nip_pjrug', 'ur_sskel',
            'lok_fisik','nama_unker',
            'nama_unor',
            'kd_gol','kd_bid','kd_kelompok','kd_skel','kd_sskel' 
            ,'kd_klasifikasi_aset','nama_klasifikasi_aset',
            'kd_lvl1','kd_lvl2','kd_lvl3',
        ]
});

Ext.define('MPemeliharaan', {extend: 'Ext.data.Model',
    fields: ['id', 'kd_brg', 'kd_lokasi', 'no_aset',
        'kode_unor', 'nama_unker', 'nama_unor','jenis', 'nama', 
        'tahun_angaran', 'pelaksana_tgl', 'pelaksana_nama', 'kondisi', 
        'deskripsi', 'harga', 'kode_angaran', 'unit_waktu', 'unit_pengunaan', 'freq_waktu', 
        'freq_pengunaan', 'status', 'durasi', 'rencana_waktu', 
        'rencana_pengunaan', 'rencana_keterangan', 'alert','image_url','document_url']
});

Ext.define('MPemeliharaanBangunan', {extend: 'Ext.data.Model',
    fields: ['id','kd_brg', 'kd_lokasi', 'no_aset', 'kode_unor', 'nama_unker', 'nama_unor', 
            'jenis', 'subjenis', 'pelaksana_nama', 'pelaksana_startdate', 
            'pelaksana_endate', 'deskripsi', 'biaya', 'image_url', 'document_url','nama','kondisi']
});

Ext.define('MPengadaan', {extend: 'Ext.data.Model',
    fields: ['id', 'kode_unor', 'nama_unker', 'nama_unor','id_vendor', 'kd_lokasi','kd_brg','no_aset','part_no','merek','model',
                'tahun_angaran', 'perolehan_sumber', 'perolehan_bmn', 'perolehan_tanggal', 
                'no_sppa', 'asal_pengadaan', 'harga_total', 'deskripsi', 
                'faktur_no', 'faktur_tanggal', 'kuitansi_no', 'kuitansi_tanggal', 
                'sp2d_no', 'sp2d_tanggal', 'mutasi_no', 'mutasi_tanggal', 
                'garansi_berlaku', 'garansi_keterangan', 'pelihara_berlaku', 'pelihara_keterangan', 
                'spk_no', 'spk_jenis', 'spk_berlaku', 'spk_keterangan', 'is_terpelihara', 
                'is_garansi', 'is_spk', 'data_kontrak','image_url','document_url']
});

Ext.define('MPerencanaan', {extend: 'Ext.data.Model',
    fields: ['id', 'kode_unor','nama_unker','nama_unor','kd_lokasi',
                'kd_brg', 'tahun_angaran', 'nama', 
                'kebutuhan', 'keterangan', 'satuan', 'quantity', 
                'harga_satuan', 'harga_total', 'is_realisasi','image_url','document_url']
});

Ext.define('MPenghapusan', {extend: 'Ext.data.Model',
    fields: ['id']
});

Ext.define('MPengelolaan', {extend: 'Ext.data.Model',
    fields: ['id','nama','no_document','tanggal_document','pembuat','perihal','date_upload','image_url', 'document_url']
});
