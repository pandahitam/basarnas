<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php header("Content-Type: application/x-javascript"); ?>
	
<?php if(isset($jsscript) && $jsscript == TRUE){ ?>
<?php
function change_bool($val){
	if($val == 0){
		return 'true';
	}else{
		return 'false';
	}
}

if(isset($var_menu) && count($var_menu)){
	foreach($var_menu as $key => $list){
		$ID_Menu = $list['ID_Menu'];
		switch($ID_Menu){
			case 1: $m_utama = change_bool($list['u_access']); break;
			case 2: 
				$m_pengguna_login = change_bool($list['u_access']); 
				$pl_insert = change_bool($list['u_insert']); 
				$pl_update = change_bool($list['u_update']); 
				$pl_delete = change_bool($list['u_delete']); 
				$pl_print = change_bool($list['u_print']); 
				break;
			// REFERENSI ---------------------------------------- START
			case 3: $m_referensi = change_bool($list['u_access']); 
				break;
			case 4: 
				$m_unit_kerja = change_bool($list['u_access']); 
				$uk_insert = change_bool($list['u_insert']); 
				$uk_update = change_bool($list['u_update']); 
				$uk_delete = change_bool($list['u_delete']); 
				$uk_print = change_bool($list['u_print']); 
				break;
			case 5: 
				$m_jabatan = change_bool($list['u_access']); 
				$jab_insert = change_bool($list['u_insert']); 
				$jab_update = change_bool($list['u_update']); 
				$jab_delete = change_bool($list['u_delete']); 
				$jab_print = change_bool($list['u_print']); 
				break;
			case 6: 
				$m_unor = change_bool($list['u_access']); 
				$unor_insert = change_bool($list['u_insert']); 
				$unor_update = change_bool($list['u_update']); 
				$unor_delete = change_bool($list['u_delete']); 
				$unor_print = change_bool($list['u_print']); 
				break;
			case 7: 
				$m_diklat = change_bool($list['u_access']); 
				$diklat_insert = change_bool($list['u_insert']); 
				$diklat_update = change_bool($list['u_update']); 
				$diklat_delete = change_bool($list['u_delete']); 
				$diklat_print = change_bool($list['u_print']); 
				break;
			case 8: 
				$m_reward = change_bool($list['u_access']); 
				$reward_insert = change_bool($list['u_insert']); 
				$reward_update = change_bool($list['u_update']); 
				$reward_delete = change_bool($list['u_delete']); 
				$reward_print = change_bool($list['u_print']); 
				break;
			case 9: 
				$m_hukdis = change_bool($list['u_access']); 
				$hukdis_insert = change_bool($list['u_insert']); 
				$hukdis_update = change_bool($list['u_update']); 
				$hukdis_delete = change_bool($list['u_delete']); 
				$hukdis_print = change_bool($list['u_print']); 
				break;
			case 10: 
				$m_pddk = change_bool($list['u_access']); 
				$pddk_insert = change_bool($list['u_insert']); 
				$pddk_update = change_bool($list['u_update']); 
				$pddk_delete = change_bool($list['u_delete']); 
				$pddk_print = change_bool($list['u_print']); 
				break;
			case 11: 
				$m_pekerjaan = change_bool($list['u_access']); 
				$pkrjn_insert = change_bool($list['u_insert']); 
				$pkrjn_update = change_bool($list['u_update']); 
				$pkrjn_delete = change_bool($list['u_delete']); 
				$pkrjn_print = change_bool($list['u_print']); 
				break;
			case 12: 
				$m_gapok_pp = change_bool($list['u_access']); 
				$g_pp_insert = change_bool($list['u_insert']); 
				$g_pp_update = change_bool($list['u_update']); 
				$g_pp_delete = change_bool($list['u_delete']); 
				$g_pp_print = change_bool($list['u_print']); 
				break;
			case 13: 
				$m_gapok = change_bool($list['u_access']); 
				$gapok_insert = change_bool($list['u_insert']); 
				$gapok_update = change_bool($list['u_update']); 
				$gapok_delete = change_bool($list['u_delete']); 
				$gapok_print = change_bool($list['u_print']); 
				break;
			case 14: 
				$m_fung = change_bool($list['u_access']); 
				$fung_insert = change_bool($list['u_insert']); 
				$fung_update = change_bool($list['u_update']); 
				$fung_delete = change_bool($list['u_delete']); 
				$fung_print = change_bool($list['u_print']); 
				break;
			case 15: 
				$m_fung_t = change_bool($list['u_access']); 
				$fung_t_insert = change_bool($list['u_insert']); 
				$fung_t_update = change_bool($list['u_update']); 
				$fung_t_delete = change_bool($list['u_delete']); 
				$fung_t_print = change_bool($list['u_print']); 
				break;
			case 16: 
				$m_ttd = change_bool($list['u_access']); 
				$ttd_insert = change_bool($list['u_insert']); 
				$ttd_update = change_bool($list['u_update']); 
				$ttd_delete = change_bool($list['u_delete']); 
				$ttd_print = change_bool($list['u_print']); 
				break;
			case 17: 
				$m_prov = change_bool($list['u_access']); 
				$prov_insert = change_bool($list['u_insert']); 
				$prov_update = change_bool($list['u_update']); 
				$prov_delete = change_bool($list['u_delete']); 
				$prov_print = change_bool($list['u_print']); 
				break;
			case 18: 
				$m_kabkota = change_bool($list['u_access']); 
				$kabkota_insert = change_bool($list['u_insert']); 
				$kabkota_update = change_bool($list['u_update']); 
				$kabkota_delete = change_bool($list['u_delete']); 
				$kabkota_print = change_bool($list['u_print']); 
				break;
			case 19: 
				$m_kec = change_bool($list['u_access']); 
				$kec_insert = change_bool($list['u_insert']); 
				$kec_update = change_bool($list['u_update']); 
				$kec_delete = change_bool($list['u_delete']); 
				$kec_print = change_bool($list['u_print']); 
				break;
			// REFERENSI ---------------------------------------- END
			
			case 20: 
				$m_ppns = change_bool($list['u_access']); 
				$ppns_insert = change_bool($list['u_insert']); 
				$ppns_update = change_bool($list['u_update']); 
				$ppns_delete = change_bool($list['u_delete']); 
				$ppns_proses = change_bool($list['u_proses']); 
				$ppns_print = change_bool($list['u_print']); 
				$ppns_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 21: $m_log = change_bool($list['u_access']); break;
			case 22: $m_db_tool = change_bool($list['u_access']); break;
			
			// LAYANAN ---------------------------------------- START
			case 23: $m_layanan = change_bool($list['u_access']); break;
			case 24: 
				$m_inpsg = change_bool($list['u_access']); 
				$inpsg_insert = change_bool($list['u_insert']); 
				$inpsg_update = change_bool($list['u_update']); 
				$inpsg_delete = change_bool($list['u_delete']); 
				$inpsg_proses = change_bool($list['u_proses']); 
				$inpsg_print = change_bool($list['u_print']); 
				$inpsg_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 25: 
				$m_kgb = change_bool($list['u_access']); 
				$kgb_insert = change_bool($list['u_insert']); 
				$kgb_update = change_bool($list['u_update']); 
				$kgb_delete = change_bool($list['u_delete']); 
				$kgb_proses = change_bool($list['u_proses']); 
				$kgb_print = change_bool($list['u_print']); 
				$kgb_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 26: 
				$m_kp = change_bool($list['u_access']); 
				$kp_insert = change_bool($list['u_insert']); 
				$kp_update = change_bool($list['u_update']); 
				$kp_delete = change_bool($list['u_delete']); 
				$kp_proses = change_bool($list['u_proses']); 
				$kp_print = change_bool($list['u_print']); 
				$kp_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 27: 
				$m_pensiun = change_bool($list['u_access']); 
				$pensiun_insert = change_bool($list['u_insert']); 
				$pensiun_update = change_bool($list['u_update']); 
				$pensiun_delete = change_bool($list['u_delete']); 
				$pensiun_proses = change_bool($list['u_proses']); 
				$pensiun_print = change_bool($list['u_print']); 
				$pensiun_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 28: 
				$m_ib = change_bool($list['u_access']); 
				$ib_insert = change_bool($list['u_insert']); 
				$ib_update = change_bool($list['u_update']); 
				$ib_delete = change_bool($list['u_delete']); 
				$ib_proses = change_bool($list['u_proses']); 
				$ib_print = change_bool($list['u_print']); 
				$ib_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 29: 
				$m_ud = change_bool($list['u_access']); 
				$ud_insert = change_bool($list['u_insert']); 
				$ud_update = change_bool($list['u_update']); 
				$ud_delete = change_bool($list['u_delete']); 
				$ud_proses = change_bool($list['u_proses']); 
				$ud_print = change_bool($list['u_print']); 
				$ud_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 30: 
				$m_sl = change_bool($list['u_access']); 
				$sl_insert = change_bool($list['u_insert']); 
				$sl_update = change_bool($list['u_update']); 
				$sl_delete = change_bool($list['u_delete']); 
				$sl_proses = change_bool($list['u_proses']); 
				$sl_print = change_bool($list['u_print']); 
				$sl_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 31: 
				$m_cuti = change_bool($list['u_access']); 
				$cuti_insert = change_bool($list['u_insert']); 
				$cuti_update = change_bool($list['u_update']); 
				$cuti_delete = change_bool($list['u_delete']); 
				$cuti_proses = change_bool($list['u_proses']); 
				$cuti_print = change_bool($list['u_print']); 
				$cuti_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 32: 
				$m_taperum = change_bool($list['u_access']); 
				$taperum_insert = change_bool($list['u_insert']); 
				$taperum_update = change_bool($list['u_update']); 
				$taperum_delete = change_bool($list['u_delete']); 
				$taperum_proses = change_bool($list['u_proses']); 
				$taperum_print = change_bool($list['u_print']); 
				$taperum_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 33: 
				$m_sk_rikes = change_bool($list['u_access']); 
				$sk_rikes_insert = change_bool($list['u_insert']); 
				$sk_rikes_update = change_bool($list['u_update']); 
				$sk_rikes_delete = change_bool($list['u_delete']); 
				$sk_rikes_proses = change_bool($list['u_proses']); 
				$sk_rikes_print = change_bool($list['u_print']); 
				$sk_rikes_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 34: 
				$m_sk_mngl = change_bool($list['u_access']); 
				$sk_mngl_insert = change_bool($list['u_insert']); 
				$sk_mngl_update = change_bool($list['u_update']); 
				$sk_mngl_delete = change_bool($list['u_delete']); 
				$sk_mngl_proses = change_bool($list['u_proses']); 
				$sk_mngl_print = change_bool($list['u_print']); 
				$sk_mngl_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 35: 
				$m_karpeg = change_bool($list['u_access']); 
				$karpeg_insert = change_bool($list['u_insert']); 
				$karpeg_update = change_bool($list['u_update']); 
				$karpeg_delete = change_bool($list['u_delete']); 
				$karpeg_proses = change_bool($list['u_proses']); 
				$karpeg_print = change_bool($list['u_print']); 
				$karpeg_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 36: 
				$m_karissu = change_bool($list['u_access']); 
				$karissu_insert = change_bool($list['u_insert']); 
				$karissu_update = change_bool($list['u_update']); 
				$karissu_delete = change_bool($list['u_delete']); 
				$karissu_proses = change_bool($list['u_proses']); 
				$karissu_print = change_bool($list['u_print']); 
				$karissu_print_sk = change_bool($list['u_print_sk']); 
				break;
			// LAYANAN ---------------------------------------- END
			// KEPEGAWAIAN ---------------------------------------- START
			case 37: $m_kepegawaian = change_bool($list['u_access']); break;
			case 38: 
				$m_sk_cpns = change_bool($list['u_access']); 
				$sk_cpns_insert = change_bool($list['u_insert']); 
				$sk_cpns_update = change_bool($list['u_update']); 
				$sk_cpns_delete = change_bool($list['u_delete']); 
				$sk_cpns_proses = change_bool($list['u_proses']); 
				$sk_cpns_print = change_bool($list['u_print']); 
				$sk_cpns_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 39: 
				$m_sk_pns = change_bool($list['u_access']); 
				$sk_pns_insert = change_bool($list['u_insert']); 
				$sk_pns_update = change_bool($list['u_update']); 
				$sk_pns_delete = change_bool($list['u_delete']); 
				$sk_pns_proses = change_bool($list['u_proses']); 
				$sk_pns_print = change_bool($list['u_print']); 
				$sk_pns_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 40: 
				$m_sk_pmk = change_bool($list['u_access']); 
				$sk_pmk_insert = change_bool($list['u_insert']); 
				$sk_pmk_update = change_bool($list['u_update']); 
				$sk_pmk_delete = change_bool($list['u_delete']); 
				$sk_pmk_proses = change_bool($list['u_proses']); 
				$sk_pmk_print = change_bool($list['u_print']); 
				$sk_pmk_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 41: 
				$m_sk_mpp = change_bool($list['u_access']); 
				$sk_mpp_insert = change_bool($list['u_insert']); 
				$sk_mpp_update = change_bool($list['u_update']); 
				$sk_mpp_delete = change_bool($list['u_delete']); 
				$sk_mpp_proses = change_bool($list['u_proses']); 
				$sk_mpp_print = change_bool($list['u_print']); 
				$sk_mpp_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 42: 
				// Mutasi Masuk
				$m_mm = change_bool($list['u_access']); 
				$mm_insert = change_bool($list['u_insert']); 
				$mm_update = change_bool($list['u_update']); 
				$mm_delete = change_bool($list['u_delete']); 
				$mm_proses = change_bool($list['u_proses']); 
				$mm_print = change_bool($list['u_print']); 
				$mm_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 43: 
				// Mutasi Keluar
				$m_mk = change_bool($list['u_access']); 
				$mk_insert = change_bool($list['u_insert']); 
				$mk_update = change_bool($list['u_update']); 
				$mk_delete = change_bool($list['u_delete']); 
				$mk_proses = change_bool($list['u_proses']); 
				$mk_print = change_bool($list['u_print']); 
				$mk_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 44: 
				// Surat Tugas
				$m_st = change_bool($list['u_access']); 
				$st_insert = change_bool($list['u_insert']); 
				$st_update = change_bool($list['u_update']); 
				$st_delete = change_bool($list['u_delete']); 
				$st_proses = change_bool($list['u_proses']); 
				$st_print = change_bool($list['u_print']); 
				$st_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 45: 
				// Pelantikan Pejabat Fungsional
				$m_ppf = change_bool($list['u_access']); 
				$ppf_insert = change_bool($list['u_insert']); 
				$ppf_update = change_bool($list['u_update']); 
				$ppf_delete = change_bool($list['u_delete']); 
				$ppf_proses = change_bool($list['u_proses']); 
				$ppf_print = change_bool($list['u_print']); 
				$ppf_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 46: 
				// Pelantikan Pejabat Struktural
				$m_pps = change_bool($list['u_access']); 
				$pps_insert = change_bool($list['u_insert']); 
				$pps_update = change_bool($list['u_update']); 
				$pps_delete = change_bool($list['u_delete']); 
				$pps_proses = change_bool($list['u_proses']); 
				$pps_print = change_bool($list['u_print']); 
				$pps_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 47: 
				// Struktur Organisasi Tata Kerja
				$m_sotk = change_bool($list['u_access']); 
				$sotk_insert = change_bool($list['u_insert']); 
				$sotk_update = change_bool($list['u_update']); 
				$sotk_delete = change_bool($list['u_delete']); 
				$sotk_proses = change_bool($list['u_proses']); 
				$sotk_print = change_bool($list['u_print']); 
				$sotk_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 48: 
				// Disiplin Pegawai
				$m_dp = change_bool($list['u_access']); 
				$dp_insert = change_bool($list['u_insert']); 
				$dp_update = change_bool($list['u_update']); 
				$dp_delete = change_bool($list['u_delete']); 
				$dp_proses = change_bool($list['u_proses']); 
				$dp_print = change_bool($list['u_print']); 
				$dp_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 49: 
				// DP3 (Daftar Penilaian Pelaksanaan Pekerjaan)
				$m_dp3 = change_bool($list['u_access']); 
				$dp3_insert = change_bool($list['u_insert']); 
				$dp3_update = change_bool($list['u_update']); 
				$dp3_delete = change_bool($list['u_delete']); 
				$dp3_proses = change_bool($list['u_proses']); 
				$dp3_print = change_bool($list['u_print']); 
				$dp3_print_sk = change_bool($list['u_print_sk']); 
				break;
			// KEPEGAWAIAN ---------------------------------------- END
			// DIKLAT --------------------------------------------- START
			case 50: $m_tdiklat = change_bool($list['u_access']); break;
			case 51:
				// Pra Jabatan
				$m_prajab = change_bool($list['u_access']); 
				$prajab_insert = change_bool($list['u_insert']); 
				$prajab_update = change_bool($list['u_update']); 
				$prajab_delete = change_bool($list['u_delete']); 
				$prajab_proses = change_bool($list['u_proses']); 
				$prajab_print = change_bool($list['u_print']); 
				$prajab_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 52:
				$m_diklat_pim = change_bool($list['u_access']); 
				$diklat_pim_insert = change_bool($list['u_insert']); 
				$diklat_pim_update = change_bool($list['u_update']); 
				$diklat_pim_delete = change_bool($list['u_delete']); 
				$diklat_pim_proses = change_bool($list['u_proses']); 
				$diklat_pim_print = change_bool($list['u_print']); 
				$diklat_pim_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 53:
				// Tugas Belajar
				$m_tb = change_bool($list['u_access']); 
				$tb_insert = change_bool($list['u_insert']); 
				$tb_update = change_bool($list['u_update']); 
				$tb_delete = change_bool($list['u_delete']); 
				$tb_proses = change_bool($list['u_proses']); 
				$tb_print = change_bool($list['u_print']); 
				$tb_print_sk = change_bool($list['u_print_sk']); 
				break;
			case 54:
				// Riwayat Pendidikan
				$m_r_pddk = change_bool($list['u_access']); 
				$r_pddk_insert = change_bool($list['u_insert']); 
				$r_pddk_update = change_bool($list['u_update']); 
				$r_pddk_delete = change_bool($list['u_delete']); 
				$r_pddk_proses = change_bool($list['u_proses']); 
				$r_pddk_print = change_bool($list['u_print']); 
				$r_pddk_print_sk = change_bool($list['u_print_sk']); 
				break;
			// DIKLAT --------------------------------------------- END
			// LAPORAN --------------------------------------------- START
			case 55: $m_laporan = change_bool($list['u_access']); break;
			case 56:
				// Daftar Urut Kepangkatan
				$m_duk = change_bool($list['u_access']); 
				$rpt_duk_print = change_bool($list['u_print']); 
				break;
			case 57:
				// Pejabat Aktif
				$m_pjbt_aktif = change_bool($list['u_access']); 
				$rpt_pjbt_aktif_print = change_bool($list['u_print']); 
				break;
			case 58:
				// Fungsional Tertentu
				$m_pns_ft = change_bool($list['u_access']); 
				$rpt_pns_ft_print = change_bool($list['u_print']); 
				break;
			case 59:
				// Rekap Golongan
				$m_rekap_gol = change_bool($list['u_access']); 
				$rpt_rekap_gol_print = change_bool($list['u_print']); 
				break;
			case 60:
				$m_rekap_eselon = change_bool($list['u_access']); 
				$rpt_rekap_eselon_print = change_bool($list['u_print']); 
				break;
			case 61:
				$m_rekap_pddk = change_bool($list['u_access']); 
				$rpt_rekap_pddk_print = change_bool($list['u_print']); 
				break;
			case 62:
				// Rekap Usia dan Agama
				$m_rekap_u_a = change_bool($list['u_access']); 
				$rpt_rekap_u_a_print = change_bool($list['u_print']); 
				break;
			case 63:
				$m_rekap_p_p = change_bool($list['u_access']);
				$rpt_rekap_p_p_print = change_bool($list['u_print']); 
				break;
			case 64:
				$m_hist_nmtf = change_bool($list['u_access']); 
				$rpt_hist_nmtf_print = change_bool($list['u_print']); 
				break;
			case 65:
				$m_hist_rekap = change_bool($list['u_access']); 
				$rpt_hist_rekap_print = change_bool($list['u_print']); 
				break;
			// LAPORAN --------------------------------------------- END
			default:
		}
	}
}
?>

var photo_default = BASE_URL + 'assets/photo/anonymous.jpg';
var photo_pgw = '';
var sesi_type = '<?php echo $this->session->userdata("type_zs_simpeg");?>';

Ext.getCmp('m_utama').setDisabled(<?php echo $m_utama;?>);
Ext.getCmp('m_pengguna_login').setDisabled(<?php echo $m_pengguna_login;?>);
var pl_insert = <?php echo $pl_insert;?>;
var pl_update = <?php echo $pl_update;?>;
var pl_delete = <?php echo $pl_delete;?>;
var pl_print = <?php echo $pl_print;?>;

// REFERENSI ------------------------------------------------------ START
Ext.getCmp('m_referensi').setDisabled(<?php echo $m_referensi;?>);
var m_unit_kerja = <?php echo $m_unit_kerja;?>;
var uk_insert = <?php echo $uk_insert;?>;
var uk_update = <?php echo $uk_update;?>;
var uk_delete = <?php echo $uk_delete;?>;
var uk_print = <?php echo $uk_print;?>;
var m_jabatan = <?php echo $m_jabatan;?>;
var jab_insert = <?php echo $jab_insert;?>;
var jab_update = <?php echo $jab_update;?>;
var jab_delete = <?php echo $jab_delete;?>;
var jab_print = <?php echo $jab_print;?>;
var m_unor = <?php echo $m_unor;?>;
var unor_insert = <?php echo $unor_insert;?>;
var unor_update = <?php echo $unor_update;?>;
var unor_delete = <?php echo $unor_delete;?>;
var unor_print = <?php echo $unor_print;?>;
var m_diklat = <?php echo $m_diklat;?>;
var diklat_insert = <?php echo $diklat_insert;?>;
var diklat_update = <?php echo $diklat_update;?>;
var diklat_delete = <?php echo $diklat_delete;?>;
var diklat_print = <?php echo $diklat_print;?>;
var m_reward = <?php echo $m_reward;?>;
var reward_insert = <?php echo $reward_insert;?>;
var reward_update = <?php echo $reward_update;?>;
var reward_delete = <?php echo $reward_delete;?>;
var reward_print = <?php echo $reward_print;?>;
var m_hukdis = <?php echo $m_hukdis;?>;
var hukdis_insert = <?php echo $hukdis_insert;?>;
var hukdis_update = <?php echo $hukdis_update;?>;
var hukdis_delete = <?php echo $hukdis_delete;?>;
var hukdis_print = <?php echo $hukdis_print;?>;
var m_pddk = <?php echo $m_pddk;?>;
var pddk_insert = <?php echo $pddk_insert;?>;
var pddk_update = <?php echo $pddk_update;?>;
var pddk_delete = <?php echo $pddk_delete;?>;
var pddk_print = <?php echo $pddk_print;?>;
var m_pekerjaan = <?php echo $m_pekerjaan;?>;
var pkrjn_insert = <?php echo $pkrjn_insert;?>;
var pkrjn_update = <?php echo $pkrjn_update;?>;
var pkrjn_delete = <?php echo $pkrjn_delete;?>;
var pkrjn_print = <?php echo $pkrjn_print;?>;
var m_gapok_pp = <?php echo $m_gapok_pp;?>;
var g_pp_insert = <?php echo $g_pp_insert;?>;
var g_pp_update = <?php echo $g_pp_update;?>;
var g_pp_delete = <?php echo $g_pp_delete;?>;
var g_pp_print = <?php echo $g_pp_print;?>;
var m_gapok = <?php echo $m_gapok;?>;
var gapok_insert = <?php echo $gapok_insert;?>;
var gapok_update = <?php echo $gapok_update;?>;
var gapok_delete = <?php echo $gapok_delete;?>;
var gapok_print = <?php echo $gapok_print;?>;
var m_fung = <?php echo $m_fung;?>;
var fung_insert = <?php echo $fung_insert;?>;
var fung_update = <?php echo $fung_update;?>;
var fung_delete = <?php echo $fung_delete;?>;
var fung_print = <?php echo $fung_print;?>;
var m_fung_t = <?php echo $m_fung_t;?>;
var fung_t_insert = <?php echo $fung_t_insert;?>;
var fung_t_update = <?php echo $fung_t_update;?>;
var fung_t_delete = <?php echo $fung_t_delete;?>;
var fung_t_print = <?php echo $fung_t_print;?>;
var m_ttd = <?php echo $m_ttd;?>;
var ttd_insert = <?php echo $ttd_insert;?>;
var ttd_update = <?php echo $ttd_update;?>;
var ttd_delete = <?php echo $ttd_delete;?>;
var ttd_print = <?php echo $ttd_print;?>;
var m_prov = <?php echo $m_prov;?>;
var prov_insert = <?php echo $prov_insert;?>;
var prov_update = <?php echo $prov_update;?>;
var prov_delete = <?php echo $prov_delete;?>;
var prov_print = <?php echo $prov_print;?>;
var m_kabkota = <?php echo $m_kabkota;?>;
var kabkota_insert = <?php echo $kabkota_insert;?>;
var kabkota_update = <?php echo $kabkota_update;?>;
var kabkota_delete = <?php echo $kabkota_delete;?>;
var kabkota_print = <?php echo $kabkota_print;?>;
var m_kec = <?php echo $m_kec;?>;
var kec_insert = <?php echo $kec_insert;?>;
var kec_update = <?php echo $kec_update;?>;
var kec_delete = <?php echo $kec_delete;?>;
var kec_print = <?php echo $kec_print;?>;
// REFERENSI ------------------------------------------------------ END

Ext.getCmp('m_ppns').setDisabled(<?php echo $m_ppns;?>);
var ppns_insert = <?php echo $ppns_insert;?>;
var ppns_update = <?php echo $ppns_update;?>;
var ppns_delete = <?php echo $ppns_delete;?>;
var ppns_print = <?php echo $ppns_print;?>;

Ext.getCmp('m_log').setDisabled(<?php echo $m_log;?>);
Ext.getCmp('m_db_tool').setDisabled(<?php echo $m_db_tool;?>);

// LAYANAN ------------------------------------------------------ START
Ext.getCmp('m_layanan').setDisabled(<?php echo $m_layanan;?>);

Ext.getCmp('m_inpsg').setDisabled(<?php echo $m_inpsg;?>);
var inpsg_insert = <?php echo $inpsg_insert;?>;
var inpsg_update = <?php echo $inpsg_update;?>;
var inpsg_delete = <?php echo $inpsg_delete;?>;
var inpsg_proses = <?php echo $inpsg_proses;?>;
var inpsg_print = <?php echo $inpsg_print;?>;
var inpsg_print_sk = <?php echo $inpsg_print_sk;?>;

Ext.getCmp('m_kgb').setDisabled(<?php echo $m_kgb;?>);
var kgb_insert = <?php echo $kgb_insert;?>;
var kgb_update = <?php echo $kgb_update;?>;
var kgb_delete = <?php echo $kgb_delete;?>;
var kgb_proses = <?php echo $kgb_proses;?>;
var kgb_print = <?php echo $kgb_print;?>;
var kgb_print_sk = <?php echo $kgb_print_sk;?>;

Ext.getCmp('m_kp').setDisabled(<?php echo $m_kp;?>);
var kp_insert = <?php echo $kp_insert;?>;
var kp_update = <?php echo $kp_update;?>;
var kp_delete = <?php echo $kp_delete;?>;
var kp_proses = <?php echo $kp_proses;?>;
var kp_print = <?php echo $kp_print;?>;
var kp_print_sk = <?php echo $kp_print_sk;?>;

Ext.getCmp('m_pensiun').setDisabled(<?php echo $m_pensiun;?>);
var pensiun_insert = <?php echo $pensiun_insert;?>;
var pensiun_update = <?php echo $pensiun_update;?>;
var pensiun_delete = <?php echo $pensiun_delete;?>;
var pensiun_proses = <?php echo $pensiun_proses;?>;
var pensiun_print = <?php echo $pensiun_print;?>;
var pensiun_print_sk = <?php echo $pensiun_print_sk;?>;

Ext.getCmp('m_ib').setDisabled(<?php echo $m_ib;?>);
var ib_insert = <?php echo $ib_insert;?>;
var ib_update = <?php echo $ib_update;?>;
var ib_delete = <?php echo $ib_delete;?>;
var ib_proses = <?php echo $ib_proses;?>;
var ib_print = <?php echo $ib_print;?>;
var ib_print_sk = <?php echo $ib_print_sk;?>;

Ext.getCmp('m_ud').setDisabled(<?php echo $m_ud;?>);
var ud_insert = <?php echo $ud_insert;?>;
var ud_update = <?php echo $ud_update;?>;
var ud_delete = <?php echo $ud_delete;?>;
var ud_proses = <?php echo $ud_proses;?>;
var ud_print = <?php echo $ud_print;?>;
var ud_print_sk = <?php echo $ud_print_sk;?>;

Ext.getCmp('m_sl').setDisabled(<?php echo $m_sl;?>);
var sl_insert = <?php echo $sl_insert;?>;
var sl_update = <?php echo $sl_update;?>;
var sl_delete = <?php echo $sl_delete;?>;
var sl_proses = <?php echo $sl_proses;?>;
var sl_print = <?php echo $sl_print;?>;
var sl_print_sk = <?php echo $sl_print_sk;?>;

Ext.getCmp('m_cuti').setDisabled(<?php echo $m_cuti;?>);
var cuti_insert = <?php echo $cuti_insert;?>;
var cuti_update = <?php echo $cuti_update;?>;
var cuti_delete = <?php echo $cuti_delete;?>;
var cuti_proses = <?php echo $cuti_proses;?>;
var cuti_print = <?php echo $cuti_print;?>;
var cuti_print_sk = <?php echo $cuti_print_sk;?>;

Ext.getCmp('m_taperum').setDisabled(<?php echo $m_taperum;?>);
var taperum_insert = <?php echo $taperum_insert;?>;
var taperum_update = <?php echo $taperum_update;?>;
var taperum_delete = <?php echo $taperum_delete;?>;
var taperum_proses = <?php echo $taperum_proses;?>;
var taperum_print = <?php echo $taperum_print;?>;
var taperum_print_sk = <?php echo $taperum_print_sk;?>;

Ext.getCmp('m_sk_rikes').setDisabled(<?php echo $m_sk_rikes;?>);
var sk_rikes_insert = <?php echo $sk_rikes_insert;?>;
var sk_rikes_update = <?php echo $sk_rikes_update;?>;
var sk_rikes_delete = <?php echo $sk_rikes_delete;?>;
var sk_rikes_proses = <?php echo $sk_rikes_proses;?>;
var sk_rikes_print = <?php echo $sk_rikes_print;?>;
var sk_rikes_print_sk = <?php echo $sk_rikes_print_sk;?>;

Ext.getCmp('m_sk_mngl').setDisabled(<?php echo $m_sk_mngl;?>);
var sk_mngl_insert = <?php echo $sk_mngl_insert;?>;
var sk_mngl_update = <?php echo $sk_mngl_update;?>;
var sk_mngl_delete = <?php echo $sk_mngl_delete;?>;
var sk_mngl_proses = <?php echo $sk_mngl_proses;?>;
var sk_mngl_print = <?php echo $sk_mngl_print;?>;
var sk_mngl_print_sk = <?php echo $sk_mngl_print_sk;?>;

Ext.getCmp('m_karpeg').setDisabled(<?php echo $m_karpeg;?>);
var karpeg_insert = <?php echo $karpeg_insert;?>;
var karpeg_update = <?php echo $karpeg_update;?>;
var karpeg_delete = <?php echo $karpeg_delete;?>;
var karpeg_proses = <?php echo $karpeg_proses;?>;
var karpeg_print = <?php echo $karpeg_print;?>;
var karpeg_print_sk = <?php echo $karpeg_print_sk;?>;

Ext.getCmp('m_karissu').setDisabled(<?php echo $m_karissu;?>);
var karissu_insert = <?php echo $karissu_insert;?>;
var karissu_update = <?php echo $karissu_update;?>;
var karissu_delete = <?php echo $karissu_delete;?>;
var karissu_proses = <?php echo $karissu_proses;?>;
var karissu_print = <?php echo $karissu_print;?>;
var karissu_print_sk = <?php echo $karissu_print_sk;?>;

// LAYANAN ------------------------------------------------------ END

// KEPEGAWAIAN ------------------------------------------------------ START
Ext.getCmp('m_kepegawaian').setDisabled(<?php echo $m_kepegawaian;?>);

Ext.getCmp('m_sk_cpns').setDisabled(<?php echo $m_sk_cpns;?>);
var sk_cpns_insert = <?php echo $sk_cpns_insert;?>;
var sk_cpns_update = <?php echo $sk_cpns_update;?>;
var sk_cpns_delete = <?php echo $sk_cpns_delete;?>;
var sk_cpns_proses = <?php echo $sk_cpns_proses;?>;
var sk_cpns_print = <?php echo $sk_cpns_print;?>;
var sk_cpns_print_sk = <?php echo $sk_cpns_print_sk;?>;

Ext.getCmp('m_sk_pns').setDisabled(<?php echo $m_sk_pns;?>);
var sk_pns_insert = <?php echo $sk_pns_insert;?>;
var sk_pns_update = <?php echo $sk_pns_update;?>;
var sk_pns_delete = <?php echo $sk_pns_delete;?>;
var sk_pns_proses = <?php echo $sk_pns_proses;?>;
var sk_pns_print = <?php echo $sk_pns_print;?>;
var sk_pns_print_sk = <?php echo $sk_pns_print_sk;?>;

Ext.getCmp('m_sk_pmk').setDisabled(<?php echo $m_sk_pmk;?>);
var sk_pmk_insert = <?php echo $sk_pmk_insert;?>;
var sk_pmk_update = <?php echo $sk_pmk_update;?>;
var sk_pmk_delete = <?php echo $sk_pmk_delete;?>;
var sk_pmk_proses = <?php echo $sk_pmk_proses;?>;
var sk_pmk_print = <?php echo $sk_pmk_print;?>;
var sk_pmk_print_sk = <?php echo $sk_pmk_print_sk;?>;

Ext.getCmp('m_sk_mpp').setDisabled(<?php echo $m_sk_mpp;?>);
var sk_mpp_insert = <?php echo $sk_mpp_insert;?>;
var sk_mpp_update = <?php echo $sk_mpp_update;?>;
var sk_mpp_delete = <?php echo $sk_mpp_delete;?>;
var sk_mpp_proses = <?php echo $sk_mpp_proses;?>;
var sk_mpp_print = <?php echo $sk_mpp_print;?>;
var sk_mpp_print_sk = <?php echo $sk_mpp_print_sk;?>;

Ext.getCmp('m_mm').setDisabled(<?php echo $m_mm;?>);
var mm_insert = <?php echo $mm_insert;?>;
var mm_update = <?php echo $mm_update;?>;
var mm_delete = <?php echo $mm_delete;?>;
var mm_proses = <?php echo $mm_proses;?>;
var mm_print = <?php echo $mm_print;?>;
var mm_print_sk = <?php echo $mm_print_sk;?>;

Ext.getCmp('m_mk').setDisabled(<?php echo $m_mk;?>);
var mk_insert = <?php echo $mk_insert;?>;
var mk_update = <?php echo $mk_update;?>;
var mk_delete = <?php echo $mk_delete;?>;
var mk_proses = <?php echo $mk_proses;?>;
var mk_print = <?php echo $mk_print;?>;
var mk_print_sk = <?php echo $mk_print_sk;?>;

Ext.getCmp('m_st').setDisabled(<?php echo $m_st;?>);
var st_insert = <?php echo $st_insert;?>;
var st_update = <?php echo $st_update;?>;
var st_delete = <?php echo $st_delete;?>;
var st_proses = <?php echo $st_proses;?>;
var st_print = <?php echo $st_print;?>;
var st_print_sk = <?php echo $st_print_sk;?>;

Ext.getCmp('m_ppf').setDisabled(<?php echo $m_ppf;?>);
var ppf_insert = <?php echo $ppf_insert;?>;
var ppf_update = <?php echo $ppf_update;?>;
var ppf_delete = <?php echo $ppf_delete;?>;
var ppf_proses = <?php echo $ppf_proses;?>;
var ppf_print = <?php echo $ppf_print;?>;
var ppf_print_sk = <?php echo $ppf_print_sk;?>;

Ext.getCmp('m_pps').setDisabled(<?php echo $m_pps;?>);
var pps_insert = <?php echo $pps_insert;?>;
var pps_update = <?php echo $pps_update;?>;
var pps_delete = <?php echo $pps_delete;?>;
var pps_proses = <?php echo $pps_proses;?>;
var pps_print = <?php echo $pps_print;?>;
var pps_print_sk = <?php echo $pps_print_sk;?>;

Ext.getCmp('m_sotk').setDisabled(<?php echo $m_sotk;?>);
var sotk_insert = <?php echo $sotk_insert;?>;
var sotk_update = <?php echo $sotk_update;?>;
var sotk_delete = <?php echo $sotk_delete;?>;
var sotk_proses = <?php echo $sotk_proses;?>;
var sotk_print = <?php echo $sotk_print;?>;
var sotk_print_sk = <?php echo $sotk_print_sk;?>;

Ext.getCmp('m_dp').setDisabled(<?php echo $m_dp;?>);
var dp_insert = <?php echo $dp_insert;?>;
var dp_update = <?php echo $dp_update;?>;
var dp_delete = <?php echo $dp_delete;?>;
var dp_proses = <?php echo $dp_proses;?>;
var dp_print = <?php echo $dp_print;?>;
var dp_print_sk = <?php echo $dp_print_sk;?>;

Ext.getCmp('m_dp3').setDisabled(<?php echo $m_dp3;?>);
var dp3_insert = <?php echo $dp3_insert;?>;
var dp3_update = <?php echo $dp3_update;?>;
var dp3_delete = <?php echo $dp3_delete;?>;
var dp3_proses = <?php echo $dp3_proses;?>;
var dp3_print = <?php echo $dp3_print;?>;
var dp3_print_sk = <?php echo $dp3_print_sk;?>;

// KEPEGAWAIAN ------------------------------------------------------ END

// DIKLAT --------------------------------------------------------- START
Ext.getCmp('m_tdiklat').setDisabled(<?php echo $m_tdiklat;?>);

Ext.getCmp('m_prajab').setDisabled(<?php echo $m_prajab;?>);
var prajab_insert = <?php echo $prajab_insert;?>;
var prajab_update = <?php echo $prajab_update;?>;
var prajab_delete = <?php echo $prajab_delete;?>;
var prajab_proses = <?php echo $prajab_proses;?>;
var prajab_print = <?php echo $prajab_print;?>;
var prajab_print_sk = <?php echo $prajab_print_sk;?>;

Ext.getCmp('m_diklat_pim').setDisabled(<?php echo $m_diklat_pim;?>);
var diklat_pim_insert = <?php echo $diklat_pim_insert;?>;
var diklat_pim_update = <?php echo $diklat_pim_update;?>;
var diklat_pim_delete = <?php echo $diklat_pim_delete;?>;
var diklat_pim_proses = <?php echo $diklat_pim_proses;?>;
var diklat_pim_print = <?php echo $diklat_pim_print;?>;
var diklat_pim_print_sk = <?php echo $diklat_pim_print_sk;?>;

Ext.getCmp('m_tb').setDisabled(<?php echo $m_tb;?>);
var tb_insert = <?php echo $tb_insert;?>;
var tb_update = <?php echo $tb_update;?>;
var tb_delete = <?php echo $tb_delete;?>;
var tb_proses = <?php echo $tb_proses;?>;
var tb_print = <?php echo $tb_print;?>;
var tb_print_sk = <?php echo $tb_print_sk;?>;

Ext.getCmp('m_r_pddk').setDisabled(<?php echo $m_r_pddk;?>);
var r_pddk_insert = <?php echo $r_pddk_insert;?>;
var r_pddk_update = <?php echo $r_pddk_update;?>;
var r_pddk_delete = <?php echo $r_pddk_delete;?>;
var r_pddk_proses = <?php echo $r_pddk_proses;?>;
var r_pddk_print = <?php echo $r_pddk_print;?>;
var r_pddk_print_sk = <?php echo $r_pddk_print_sk;?>;

// DIKLAT --------------------------------------------------------- END

// LAPORAN --------------------------------------------------------- START
Ext.getCmp('m_laporan').setDisabled(<?php echo $m_laporan;?>);
Ext.getCmp('m_duk').setDisabled(<?php echo $m_duk;?>);
var rpt_duk_print = <?php echo $rpt_duk_print;?>;
Ext.getCmp('m_pjbt_aktif').setDisabled(<?php echo $m_pjbt_aktif;?>);
var rpt_pjbt_aktif_print = <?php echo $rpt_pjbt_aktif_print;?>;
Ext.getCmp('m_pns_ft').setDisabled(<?php echo $m_pns_ft;?>);
var rpt_pns_ft_print = <?php echo $rpt_pns_ft_print;?>;
Ext.getCmp('m_rekap_gol').setDisabled(<?php echo $m_rekap_gol;?>);
var rpt_rekap_gol_print = <?php echo $rpt_rekap_gol_print;?>;
Ext.getCmp('m_rekap_eselon').setDisabled(<?php echo $m_rekap_eselon;?>);
var rpt_rekap_eselon_print = <?php echo $rpt_rekap_eselon_print;?>;
Ext.getCmp('m_rekap_pddk').setDisabled(<?php echo $m_rekap_pddk;?>);
var rpt_rekap_pddk_print = <?php echo $rpt_rekap_pddk_print;?>;
Ext.getCmp('m_rekap_u_a').setDisabled(<?php echo $m_rekap_u_a;?>);
var rpt_rekap_u_a_print = <?php echo $rpt_rekap_u_a_print;?>;
Ext.getCmp('m_rekap_p_p').setDisabled(<?php echo $m_rekap_p_p;?>);
var rpt_rekap_p_p_print = <?php echo $rpt_rekap_p_p_print;?>;
Ext.getCmp('m_hist_nmtf').setDisabled(<?php echo $m_hist_nmtf;?>);
var rpt_hist_nmtf_print = <?php echo $rpt_hist_nmtf_print;?>;
Ext.getCmp('m_hist_rekap').setDisabled(<?php echo $m_hist_rekap;?>);
var rpt_hist_rekap_print = <?php echo $rpt_hist_rekap_print;?>;
// LAPORAN --------------------------------------------------------- END

var var_akses_menu = 'SUKSES';

<?php }else{ echo "var var_akses_menu = 'GAGAL';"; } ?>