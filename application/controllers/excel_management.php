<?php
ini_set('MAX_EXECUTION_TIME', -1);

class Excel_Management extends CI_Controller{
  public function __construct(){
  	parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
                 $this->load->library('PHPExcel');
    }
  
	
  public function index()
  {
      
  }
  
  /*
   * Params:
   * $modelName= the name of the model that the data will be loaded from
   * $title = the filename, and the title of the excel file
   * $columnString = the list of column with its data index that will be displayed on the report
   * $selectedKeys = the list of primary keys of the data that will be displayed, if false or not set then all data from the model will be displayed 
   * $columnKeys = the name of the primary keys/column name of the data that will be displayed .
   */
  public function exportToExcel()
  {
      
      $modelName = $_POST["serverSideModelName"];
      $title = $_POST["title"];
      $columnString = $_POST["gridHeaderList"];
      $selectedKeys = $_POST["selectedData"];
      $columnKeys = $_POST["primaryKeys"];
      
      $this->load->model($modelName);
      $queryResult = $this->$modelName->get_AllData();
      $data = $queryResult['data'];
      $excel = new PHPExcel();
      $header = array();
      $header_temp = array();
      $content = array();
      $content_array = array();
      $columnToInclude = array();
      
      $getColumnString = array_filter(explode('^^',$columnString));
      foreach($getColumnString as $value)
      {
          $y=explode('&&',$value);
          $header_temp[$y[1]]=$y[0];
          $columnToInclude[$y[1]] = $y[0];
//          array_push($header_temp,$y[0]);
//          array_push($columnToInclude,$y[1]);
      }
      
      if($selectedKeys != '')
      {
         $selectedData = array_filter(explode(',',$selectedKeys));
      }
      if($columnKeys!='')
      {
          $selectedColumn = array_filter(explode(',',$columnKeys));
      }
      /* get the data to array*/
      for( $i=0; $i<count($data); $i++)
      {
          if($selectedKeys == '' || $columnKeys == '') //if selected Keys = '' then print all data
          {
            foreach ($data[$i] as $key=>$value) {
              if(isset($columnToInclude[strtolower($key)]))
              {
                   if($value == "")
                   {
                      //Set a value for cell(s) that has no value, to prevent cell overlapping
                      $content[$key] = " "; 
                   }
                   else if(strtolower($key) == "jenis" || strtolower($key)== "subjenis")
                   {
                      $content[$key] = $this->valueParser($modelName, $key, $value);
                   }
                   else
                   {
                       $content[$key] = $value; 
                   }
                   if($i === 0)
                   {
//                      $x = array_search($key, $columnToInclude);
//                       array_push($header,$header_temp[$x]);
                      $header[]=$header_temp[$key];
                   }
              }
            }
            array_push($content_array, $content);
            
          }
          else //if selected keys != '', print selected data
          {
            $flag=0;
            
            foreach($selectedData as $value)
            {
                $temp = explode('||',$value);
                
                foreach($temp as $value2)
                {
                    foreach($selectedColumn as $value3)
                    {
                        $u= $data[$i]->$value3;
                        $ux = strcasecmp($data[$i]->$value3,$value2);
                        if(strcasecmp($data[$i]->$value3,$value2) === 0)
                        {
                           $flag+=1; 
                        }
                    }
                }

                if($flag == count($selectedColumn))
                {
                    break 1;
                }
                else
                {
                    $flag=0;
                }
            }
            
                foreach ($data[$i] as $key=>$value) {
                    if($flag == count($selectedColumn))
                    {
                        if(isset($columnToInclude[strtolower($key)]) )
                        {
                          if($value == "")
                           {
                              //Set a value for cell(s) that has no value, to prevent cell overlapping
                              $content[$key] = " "; 
                           }
                           else if(strtolower($key) == "jenis" || strtolower($key)== "subjenis")
                           {
                              $content[$key] = $this->valueParser($modelName, $key, $value);
                           }
                           else
                           {
                               $content[$key] = $value; 
                           }
                        }
                    }
                    if($i == 0)
                    {
                        if(isset($columnToInclude[strtolower($key)]))
                        {
         
//                               $x = array_search($key, $columnToInclude);
//                               array_push($header,$header_temp[$x]);
                               $header[]=$header_temp[$key];
                        }
                    }
                }
                if($flag == count($selectedColumn))
                {
                    array_push($content_array, $content);
//                    var_dump(array($content_array,$header));
//                    die;
                }
          }
         
      }
      
      $totalColumnCount = count($header);
      $activeSheet = $excel->getActiveSheet();
      /*Set title column, its style, and merge its row */
      $activeSheet->setCellValue('A1',urldecode($title));
      $activeSheet->mergeCells("A1:".PHPExcel_Cell::stringFromColumnIndex($totalColumnCount - 1)."1");
      $activeSheet->getStyle('A1')->getFont()->setSize(20);
      
      
      /*fill data to excel */
      $activeSheet->fromArray($header,NULL,'A3');
      $activeSheet->fromArray($content_array,NULL,'A4');
      
      
      /*Set column width to autosize and set the header's cells to bold */
      for($i=0; $i<$totalColumnCount; $i++)
      {
          $activeSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);
          $activeSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($i)."3")->getFont()->setBold(true);
      }
      
      /*before excel download settings */
      $today = date("Y-m-d");  
      $filename= $title."(".$today.")"; 
//      header('Content-Type: application/vnd.ms-excel'); 
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
      header('Content-Disposition: attachment;filename="'.$filename.'"'); 
      header('Cache-Control: max-age=0');
//      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); 
      $objWriter = new PHPExcel_Writer_Excel2007($excel); 
      $objWriter->save('php://output');
  }
  
  private function valueParser($modelName, $key, $value)
  {
      if($modelName =="Pemeliharaan_Model")
      {
            if(strtolower($key) == "jenis")
            {
                if ($value == '1')
                {
                    return "PREDICTIVE";
                }
                else if ($value == '2')
                {
                    return "PREVENTIVE";
                }
                else if ($value == '3')
                {
                    return "CORRECTIVE";
                }
                else
                {
                    return " ";
                }
            }
      }
      else if($modelName =="Pemeliharaan_Bangunan_Model")
      {
            if(strtolower($key) == "jenis")
            {
                    if ($value == '1')
                    {
                        return "PEMELIHARAAN";
                    }
                    else if ($value == '2')
                    {
                        return "PERAWATAN";
                    }
                    else
                    {
                        return " ";
                    }
            }
            else if(strtolower($key) == "subjenis")
            {
                   if($value == '1')
                   {
                       return "ARSITEKTURAL";
                   }
                   else if ($value == '2')
                   {
                       return "STRUKTURAL";
                   }
                   else if ($value == '3')
                   {
                       return "MEKANIKAL";
                   }
                   else if ($value == '4')
                   {
                       return "ELEKTRIKAL";
                   }
                   else if ($value == '5')
                   {
                       return "TATA RUANG LUAR";
                   }
                   else if ($value == '6')
                   {
                       return "TATA GRAHA (HOUSE KEEPING)";
                   }
                   else if ($value == '11')
                   {
                       return "REHABILITASI";
                   }
                   else if ($value == '12')
                   {
                       return "RENOVASI";
                   }
                   else if ($value == '13')
                   {
                       return "RESTORASI";
                   }
                   else if ($value == '14')
                   {
                       return "PERAWATAN KERUSAKAN";
                   }
                   else
                   {
                       return " ";
                   }
            }
     }
  }
  
    public function exportLaporanUnkerTotalAset($unitkerja,$kd_lokasi,$tahun,$kd_unor=null,$golongan="",$bidang="",$kelompok="",$sub_kelompok="")
    {
      $excel = new PHPExcel();
      $active_sheet = $excel->getActiveSheet();
      $unitkerja = urldecode($unitkerja);
     
      $query_barang = $this->getQueryBarang($golongan, $bidang, $kelompok, $sub_kelompok);
      
      /* HEADER */
      
      $active_sheet->setCellValue('A2',"LAPORAN ASET/UNIT KERJA");
      $active_sheet->mergeCells('A2:I2');
      $active_sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  
      $active_sheet->setCellValue('A3',"$unitkerja");
      $active_sheet->mergeCells('A3:I3');
      $active_sheet->getStyle('A3:I3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $active_sheet->setCellValue('A4',"TAHUN $tahun");
      $active_sheet->mergeCells('A4:I4');
      $active_sheet->getStyle('A4:I4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $active_sheet->setCellValue('A6',"NO");
      $active_sheet->setCellValue('A8',"1");
      $active_sheet->mergeCells('A6:A7');
      $active_sheet->getStyle('A6:A8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $active_sheet->setCellValue('B6',"URAIAN");
      $active_sheet->setCellValue('B7',"JENIS ASSET");
      $active_sheet->setCellValue('B8',"2");
      $active_sheet->getStyle('B6:B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $active_sheet->setCellValue('C6',"MERK");
      $active_sheet->setCellValue('C8',"3");
      $active_sheet->mergeCells('C6:C7');
      $active_sheet->getStyle('C6:C8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $active_sheet->setCellValue('D6',"TYPE");
      $active_sheet->setCellValue('D8',"4");
      $active_sheet->mergeCells('D6:D7');
      $active_sheet->getStyle('D6:D8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $active_sheet->setCellValue('E6',"JUMLAH");
      $active_sheet->setCellValue('E8',"5");
      $active_sheet->mergeCells('E6:E7');
      $active_sheet->getStyle('E6:E8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
//      $active_sheet->setCellValue('F6',"SATUAN");
//      $active_sheet->setCellValue('F8',"6");
//      $active_sheet->mergeCells('F6:F7');
//      $active_sheet->getStyle('F6:F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $active_sheet->setCellValue('F6',"TAHUN");
      $active_sheet->setCellValue('F7',"PEROLEHAN");
      $active_sheet->setCellValue('F8',"6");
      $active_sheet->getStyle('F6:F8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $active_sheet->setCellValue('G6',"NILAI");
      $active_sheet->setCellValue('G7',"RUPIAH");
      $active_sheet->setCellValue('G8',"7");
      $active_sheet->getStyle('G6:G8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      
      $active_sheet->setCellValue('H6',"KONDISI");
      $active_sheet->setCellValue('H8',"8");
      $active_sheet->mergeCells('H6:H7');
      $active_sheet->getStyle('H6:H8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      $active_sheet->setCellValue('I6',"KETERANGAN");
      $active_sheet->setCellValue('I8',"9");
      $active_sheet->mergeCells('I6:I7');
      $active_sheet->getStyle('I6:I8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      
      
      
      /* Data Row */
      if($kd_unor == null || $kd_unor == 0)
      {
          $query = "select ur_sskel,kd_lokasi,no_aset,kd_brg,type,merk,kondisi,kategori_aset,rph_aset,kuantitas,tgl_prl from
                (
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Peralatan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_alatbesar as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Angkutan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_angkutan as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,'-','-','Bangunan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_bangunan as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi,'Senjata' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_senjata as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','DIL' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from ext_asset_dil as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Perairan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_perairan as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Ruang' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from ext_asset_ruang as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Tanah' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_tanah as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' $query_barang
                ) as result


                ";
      }
      else
      {
          $query = "select kode_unor,kd_lokasi,no_aset,kd_brg,type,merk,kondisi,kategori_aset,rph_aset from
                          (
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Peralatan' as kategori_aset,t.rph_aset from asset_alatbesar as t
                          LEFT JOIN ext_asset_alatbesar AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."' $query_barang
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Angkutan' as kategori_aset,t.rph_aset from asset_angkutan as t
                          LEFT JOIN ext_asset_angkutan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."' $query_barang
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,'-','-','Bangunan' as kategori_aset,t.rph_aset from asset_bangunan as t
                          LEFT JOIN ext_asset_angkutan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."' $query_barang
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi,'Senjata' as kategori_aset,t.rph_aset from asset_senjata as t
                          LEFT JOIN ext_asset_senjata AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."' $query_barang
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','DIL' as kategori_aset,t.rph_aset from ext_asset_dil as t
                          LEFT JOIN ext_asset_dil AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and b.kode_unor = '".$kd_unor."' $query_barang
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Perairan' as kategori_aset,t.rph_aset from asset_perairan as t
                          LEFT JOIN ext_asset_perairan AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."' $query_barang
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Ruang' as kategori_aset,t.rph_aset from ext_asset_ruang as t
                          LEFT JOIN ext_asset_ruang AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and b.kode_unor = '".$kd_unor."' $query_barang
                          UNION
                          select b.kode_unor,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Tanah' as kategori_aset,t.rph_aset from asset_tanah as t
                          LEFT JOIN ext_asset_tanah AS b ON t.kd_lokasi = b.kd_lokasi AND t.kd_brg = b.kd_brg AND t.no_aset = b.no_aset
                          where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."' and b.kode_unor = '".$kd_unor."' $query_barang
                          ) as result
                          

                          ";
      }
       
       $r = $this->db->query($query);
       $data = array();
       $totalRows = $r->num_rows(); 
       if ($totalRows > 0)
       {
            foreach ($r->result() as $obj)
            {
                $data[] = $obj;
            }  
       }
       
//       var_dump($data);
//       die;
//      $active_sheet->fromArray($data,NULL,'A10');
       $i=1;
       $cellIndex = 0;
      foreach($data as $result)
      {
        $cellIndex = $i+9;
        $active_sheet->setCellValue('A'.$cellIndex,$i); //NO
        $active_sheet->setCellValue('B'.$cellIndex,$result->ur_sskel); //JENIS ASSET
        $active_sheet->setCellValue('C'.$cellIndex,$result->merk); //MERK
        $active_sheet->setCellValue('D'.$cellIndex,$result->type); //TYPE
        $active_sheet->setCellValue('E'.$cellIndex,$result->kuantitas); //JUMLAH
        $active_sheet->setCellValue('F'.$cellIndex,$result->tgl_prl); //TAHUN
        $active_sheet->setCellValue('G'.$cellIndex,number_format($result->rph_aset)); //RPH ASET
        if($result->kondisi == '1')
        {
            $kondisi = "BAIK";
        }
        else if($result->kondisi == '2')
        {
            $kondisi = "RUSAK RINGAN";
        }
        else if($result->kondisi == '3')
        {
            $kondisi = "RUSAK BERAT";
        }
        else if($result->kondisi == '4')
        {
            $kondisi = "HILANG";
        }
        else
        {
            $kondisi = "-";
        }
        $active_sheet->setCellValue('H'.$cellIndex,$kondisi); //KONDISI
        $i++;
      }
      
      
      /* STYLING */

      
      $styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
                        ),
                'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THICK,
			'color' => array('argb' => '000000'),
                        ),
                ),
        );
      
      $styleArray2 = array(
	'borders' => array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			'color' => array('argb' => '000000'),
                        ),
                ),
        );
    $cellIndex++;
    $active_sheet->getStyle('A6:I'.$cellIndex)->applyFromArray($styleArray);
    $active_sheet->getStyle('A8:I8')->applyFromArray($styleArray2);  
    $active_sheet->getStyle('A6:I'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $active_sheet->getStyle('B10:B'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    $active_sheet->getColumnDimension('A')->setWidth(8); //NO
    $active_sheet->getColumnDimension('B')->setWidth(40); //JENIS ASSET
    $active_sheet->getColumnDimension('C')->setWidth(25); //MERK
    $active_sheet->getColumnDimension('D')->setWidth(25); //TYPE
    $active_sheet->getColumnDimension('E')->setWidth(8); //JUMLAH
    $active_sheet->getColumnDimension('F')->setWidth(8); //TAHUN
    $active_sheet->getColumnDimension('G')->setWidth(25); //RPH ASET
    $active_sheet->getColumnDimension('H')->setWidth(15); //KONDISI
    $active_sheet->getColumnDimension('I')->setWidth(25); //KETERANGAN
      
      
        /*before excel download settings */
      $today = date("Y-m-d");  
      $filename= "Laporan Aset/Unit Kerja"."(".$today.")"; 
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
      header('Content-Disposition: attachment;filename="'.$filename.'"'); 
      header('Cache-Control: max-age=0');
      $objWriter = new PHPExcel_Writer_Excel2007($excel); 
      $objWriter->save('php://output');
    }
    
  public function exportToExcelMutasiPenghapusan()
  {
      
      $modelName = $_POST["serverSideModelName"];
      $title = $_POST["title"];
      $columnString = $_POST["gridHeaderList"];
      $selectedKeys = $_POST["selectedData"];
      $columnKeys = $_POST["primaryKeys"];
     
      $this->load->model($modelName);
      $queryResult = $this->$modelName->get_AllData();
      $data = $queryResult['data'];
      $excel = new PHPExcel();
      $header = array();
      $header_temp = array();
      $content = array();
      $content_array = array();
      $columnToInclude = array();
      
      $getColumnString = array_filter(explode('^^',$columnString));
      foreach($getColumnString as $value)
      {
          $y=explode('&&',$value);
          $header_temp[$y[1]]=$y[0];
          $columnToInclude[$y[1]] = $y[0];
//          array_push($header_temp,$y[0]);
//          array_push($columnToInclude,$y[1]);
      }
      
      
      
      if($selectedKeys != '')
      {
         $selectedData = json_decode($selectedKeys);
      }
      if($columnKeys!='')
      {
          $selectedColumn = array_filter(explode(',',$columnKeys));
      }
      /* get the data to array*/
      for( $i=0; $i<count($data); $i++)
      {
          if($selectedKeys == '' || $columnKeys == '') //if selected Keys = '' then print all data
          {
            foreach ($data[$i] as $key=>$value) {
              if(isset($columnToInclude[strtolower($key)]))
              {
                   if($value == "")
                   {
                      //Set a value for cell(s) that has no value, to prevent cell overlapping
                      $content[$key] = " "; 
                   }
                   else if(strtolower($key) == "jenis" || strtolower($key)== "subjenis")
                   {
                      $content[$key] = $this->valueParser($modelName, $key, $value);
                   }
                   else
                   {
                       $content[$key] = $value; 
                   }
                   if($i === 0)
                   {
//                      $x = array_search($key, $columnToInclude);
//                       array_push($header,$header_temp[$x]);
                      $header[]=$header_temp[$key];
                   }
              }
            }
            array_push($content_array, $content);
            
          }
          else //if selected keys != '', print selected data
          {
              $dataTemp = array();
//            var_dump(array($selectedData,$columnToInclude));
//            die;
                foreach($selectedData[$i] as $key=>$value)
                {
                    if(isset($columnToInclude[$key]))
                    {
                        $dataTemp[$key] = $value;
                        if($i == 0)
                        {
                             $header[]=$header_temp[$key];
                        }
                    }
                }
                array_push($content_array, $dataTemp);
                if($i+1 == count($selectedData))
                {
                    break 1;
                }
          }
         
      }
      
      $totalColumnCount = count($header);
      $activeSheet = $excel->getActiveSheet();
      /*Set title column, its style, and merge its row */
      $activeSheet->setCellValue('A1',urldecode($title));
      $activeSheet->mergeCells("A1:".PHPExcel_Cell::stringFromColumnIndex($totalColumnCount - 1)."1");
      $activeSheet->getStyle('A1')->getFont()->setSize(20);
      
      
      /*fill data to excel */
      $activeSheet->fromArray($header,NULL,'A3');
      $activeSheet->fromArray($content_array,NULL,'A4');
      
      
      /*Set column width to autosize and set the header's cells to bold */
      for($i=0; $i<$totalColumnCount; $i++)
      {
          $activeSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->setAutoSize(true);
          $activeSheet->getStyle(PHPExcel_Cell::stringFromColumnIndex($i)."3")->getFont()->setBold(true);
      }
      
      /*before excel download settings */
      $today = date("Y-m-d");  
      $filename= $title."(".$today.")"; 
//      header('Content-Type: application/vnd.ms-excel'); 
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
      header('Content-Disposition: attachment;filename="'.$filename.'"'); 
      header('Cache-Control: max-age=0');
//      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5'); 
      $objWriter = new PHPExcel_Writer_Excel2007($excel); 
      $objWriter->save('php://output');
  }
  
  public function getColumnSize()
  {
//      $inputFileName = './a.xls';
//
//     /** Load $inputFileName to a PHPExcel Object  **/
//     $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
//     
//     $active_sheet = $objPHPExcel->getActiveSheet();
//     
//     for($i=0; $i<30; $i++)
//     {
//         echo PHPExcel_Cell::stringFromColumnIndex($i)." ". $active_sheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($i))->getWidth()."<br />";
//     }
      die;
      
  }
  
  public function exportLaporanUdara($no_induk_asset)
  {
      //new page setiap 33 atau 32 baris
      $page_index = array();
      $excel = new PHPExcel();
      $excel->setActiveSheetIndex(0);
      $active_sheet = $excel->getActiveSheet();
      
      
      //      $active_sheet->setBreak('A50', PHPExcel_Worksheet::BREAK_ROW);
      $active_sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      $active_sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
      $active_sheet->getPageSetup()->setScale(74);
//      $active_sheet->getPageSetup()->setFitToWidth(1);
      $active_sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 9);
      $active_sheet->getDefaultStyle()->getFont()->setName('Arial');
//      $active_sheet->getDefaultStyle()->getFont()->setSize(8);
      $active_sheet->freezePane('A9');
      
      
//      $no_induk_asset = "3020501005107010199414370000KP1";
      $query_detail_angkutan = "select * from view_asset_angkutan_udara where CONCAT(kd_brg,kd_lokasi,no_aset) = '$no_induk_asset'";
      $r = $this->db->query($query_detail_angkutan);
      $data_detail = $r->row();
      $ac_type = ":"."$data_detail->merk"; //merek
      $ac_reg = ":"."$data_detail->no_polisi"; //no polisi
      $ac_sn = ":"."$data_detail->no_rangka"; //no rangka
      $ac_owner = ":"."BASARNAS";
      $date = ":".date("d-F-Y");
      
      $active_sheet->setTitle("$data_detail->merk");
      
      $query_usage = "SELECT CONCAT(kd_brg,kd_lokasi,no_aset) AS no_induk, IFNULL(SUM(jumlah_penggunaan),0) AS jumlah, IFNULL(SUM(jumlah_cycle),0) AS cycle  FROM ext_asset_angkutan_udara_detail_penggunaan AS t
                      LEFT JOIN ext_asset_angkutan AS a ON a.id = t.id_ext_asset
                      WHERE CONCAT(kd_brg,kd_lokasi,no_aset) = '$no_induk_asset'";
      $r = $this->db->query($query_usage);
      $data_usage = $r->row();
      $ac_tt =":".$data_usage->jumlah." Hrs";
      $ac_cyl = ":".$data_usage->cycle." Cyl";
      
      $data_ac = array();
      $data_ac["reg"] = $data_detail->no_polisi;
      $data_ac["tt"] = $data_usage->jumlah;
      
      
      $query_414 = "SELECT
                b.id AS id_kelompok,
                b.nama_kelompok,
                a.nama,
                t.id,
                t.is_oc,
                t.part_number,
                t.serial_number, 
                t.is_engine,
                t.eng_type,
                t.eng_tso,
                t.umur,
                t.cycle,
                t.cycle_maks,
                (SELECT DATE_FORMAT(pelaksana_tgl,'%d-%m-%Y') FROM pemeliharaan_perlengkapan WHERE CONCAT(kd_brg,kd_lokasi,no_aset) = 
                (SELECT CONCAT(kd_brg,kd_lokasi,no_aset) FROM asset_perlengkapan AS X WHERE  x.part_number = t.part_number AND x.serial_number = t.serial_number)ORDER BY pelaksana_tgl LIMIT 1) AS date_of_mnf_specific, 
                (SELECT DATE_FORMAT(pelaksana_tgl,'%d-%m-%Y') FROM view_pemeliharaan_udara
                WHERE CONCAT(kd_brg,kd_lokasi,no_aset) = '$no_induk_asset' ORDER BY pelaksana_tgl LIMIT 1) AS date_of_mnf_general, 
                DATE_FORMAT(t.installation_date,'%d-%m-%Y') AS installation_date,
                t.installation_ac_tsn,
                t.installation_comp_tsn,
                t.umur_maks AS operating_time_limit,
                t.task,
                (t.umur_maks + t.installation_ac_tsn - t.installation_comp_tsn) AS remove_due,
                CASE WHEN (t.umur_maks - $data_usage->jumlah) < t.umur_maks
                THEN  
                (t.umur_maks - $data_usage->jumlah)
                ELSE
                'Expired'
                END AS tsn_tso_current,
                (t.umur_maks - $data_usage->jumlah) AS time_available
                FROM asset_perlengkapan AS t
                INNER JOIN ref_perlengkapan AS a ON t.part_number = a.part_number
                LEFT JOIN ref_kelompok_part AS b ON a.id_kelompok_part  = b.id
                WHERE no_induk_asset = '$no_induk_asset'
                ";
      
       $r = $this->db->query($query_414);
       $data_engine = array();
       $data_414 = array();
       $data_414_no_kelompok = array();
       $totalRows = $r->num_rows(); 
       if ($totalRows > 0)
       {
//           for($i=0; $i<15; $i++)
//           {
            foreach ($r->result() as $obj)
            {
                if(strtotime($obj->date_of_mnf_specific) == false && strtotime($obj->date_of_mnf_general) == false)
                {
                    $obj->date_of_mnf_last_insp = null;
                }
                else if(strtotime($obj->date_of_mnf_specific) != false && strtotime($obj->date_of_mnf_general)!= false)
                {
                    if(strtotime($obj->date_of_mnf_specific) > strtotime($obj->date_of_mnf_general))
                    {
                        $obj->date_of_mnf_last_insp = $obj->date_of_mnf_specific;
                    }
                    else
                    {
                        $obj->date_of_mnf_last_insp = $obj->date_of_mnf_general;
                    }
                }
                else if(strtotime($obj->date_of_mnf_specific) == false && strtotime($obj->date_of_mnf_general)!= false)
                {
                    $obj->date_of_mnf_last_insp = $obj->date_of_mnf_general;
                }
                else if(strtotime($obj->date_of_mnf_specific) != false && strtotime($obj->date_of_mnf_general)== false)
                {
                    $obj->date_of_mnf_last_insp = $obj->date_of_mnf_specific;
                }
                else
                {
                    $obj->date_of_mnf_last_insp = null;
                }
                
                if($obj->is_engine == "1")
                {
                    $data_engine[] = $obj;
                }
                
                if($obj->id_kelompok == null)
                {
                    $data_414_no_kelompok[] = $obj;
                }
                else
                {
                    $data_414[] = $obj;
                }
            }
//           }
       }
       
       $query_kelompok_414 = "select id,nama_kelompok from ref_kelompok_part 
                        where id in 
                        (
                                SELECT DISTINCT id_kelompok_part FROM ref_perlengkapan AS t
                                INNER JOIN asset_perlengkapan AS a ON a.part_number = t.part_number
                                WHERE id_kelompok_part != 0 and no_induk_asset = '$no_induk_asset'
                        )";
      
       $r = $this->db->query($query_kelompok_414);
       $data_kelompok_414 = array();
       $totalRows = $r->num_rows(); 
       if ($totalRows > 0)
       {
            foreach ($r->result() as $obj)
            {
                $data_kelompok_414[] = $obj;
            }  
       }
       
       $cellIndex = 10;
       $rowCount = 1;
       
       foreach($data_kelompok_414 as $kelompok)
       {
           $active_sheet->setCellValue('B'.$cellIndex,$kelompok->nama_kelompok.":");
           $active_sheet->getStyle('B'.$cellIndex)->getFont()->setBold(true);
           $active_sheet->getStyle('B'.$cellIndex)->getFont()->setSize(8);
           
//           $this->getBorderLaporanUdara($active_sheet,$cellIndex);
           $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
           
           $no = 1;
           foreach($data_414 as $value)
           {
               if($value->id_kelompok == $kelompok->id)
               {
//                   $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
//                   $active_sheet->getStyle('A'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                   $active_sheet->getStyle('C'.$cellIndex.':N'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                   $active_sheet->getStyle('Q'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                   $active_sheet->getStyle('S'.$cellIndex.':T'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                   $active_sheet->getStyle('V'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                   $active_sheet->getStyle('X'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//                   $active_sheet->getStyle('Z'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                   $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex,false);
                   
                   $active_sheet->setCellValue('A'.$cellIndex,$no);
                   $active_sheet->setCellValue('B'.$cellIndex,$value->nama);
                   $active_sheet->setCellValue('C'.$cellIndex,$value->part_number);
                   $active_sheet->setCellValue('D'.$cellIndex,$value->serial_number);
                   if($value->date_of_mnf_last_insp != "00-00-0000" && strtotime($value->date_of_mnf_last_insp) != false)
                    {
                        $date_of_mnf_last_insp = explode('-', $value->date_of_mnf_last_insp);
                        $active_sheet->setCellValue('E'.$cellIndex,$date_of_mnf_last_insp[0]);
                        $active_sheet->setCellValue('F'.$cellIndex,"-");
                        $active_sheet->setCellValue('G'.$cellIndex,$date_of_mnf_last_insp[1]);
                        $active_sheet->setCellValue('H'.$cellIndex,"-");
                        $active_sheet->setCellValue('I'.$cellIndex,$date_of_mnf_last_insp[2]);
                    }
                    else
                    {
                        $active_sheet->setCellValue('G'.$cellIndex,"-");
                    }
                   if($value->installation_date != "00-00-0000")
                    {
                        $installation_date = explode('-', $value->installation_date);
                        $active_sheet->setCellValue('J'.$cellIndex,$installation_date[0]);
                        $active_sheet->setCellValue('K'.$cellIndex,"-");
                        $active_sheet->setCellValue('L'.$cellIndex,$installation_date[1]);
                        $active_sheet->setCellValue('M'.$cellIndex,"-");
                        $active_sheet->setCellValue('N'.$cellIndex,$installation_date[2]);
                    }
                    else
                    {
                        $active_sheet->setCellValue('L'.$cellIndex,"-");
                    }
                   $active_sheet->setCellValue('O'.$cellIndex,$value->installation_ac_tsn);
                   $active_sheet->setCellValue('P'.$cellIndex,$value->installation_comp_tsn);
                   $active_sheet->setCellValue('Q'.$cellIndex,"Hrs");
                   if($value->task == "0")
                    {
                        $active_sheet->setCellValue('T'.$cellIndex,"");

                    }
                    else
                    {
                        $active_sheet->setCellValue('T'.$cellIndex,$value->task);
                    }
                   
                   if($value->is_oc == "0")
                   {
                       $active_sheet->setCellValue('R'.$cellIndex,$value->operating_time_limit);
                       $active_sheet->setCellValue('S'.$cellIndex,"Hrs");
                       $active_sheet->setCellValue('U'.$cellIndex,$value->remove_due);
                       $active_sheet->setCellValue('V'.$cellIndex,"Hrs");
                       $active_sheet->setCellValue('W'.$cellIndex,$value->tsn_tso_current);
                       $active_sheet->setCellValue('X'.$cellIndex,"Hrs");
                       $active_sheet->setCellValue('Y'.$cellIndex,$value->time_available);
                       $active_sheet->setCellValue('Z'.$cellIndex,"Hrs");
                   }
                   else
                   {
                       $active_sheet->setCellValue('R'.$cellIndex,"");
                       $active_sheet->setCellValue('S'.$cellIndex,"OC");
                       $active_sheet->setCellValue('U'.$cellIndex,"");
                       $active_sheet->setCellValue('V'.$cellIndex,"OC");
                       $active_sheet->setCellValue('W'.$cellIndex,"");
                       $active_sheet->setCellValue('X'.$cellIndex,"OC");
                       $active_sheet->setCellValue('Y'.$cellIndex,"");
                       $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                   }
                   
                   $no++;
//                   $this->getBorderLaporanUdara($active_sheet,$cellIndex);
                   $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
               }
           }
//           $this->getBorderLaporanUdara($active_sheet,$cellIndex);
           $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
       }
       
       /*print data that has no kelompok */
       
       foreach($data_414_no_kelompok as $value)
       {
//           $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
//           $active_sheet->setCellValue('B'.$cellIndex,$value->nama);
//           $active_sheet->getStyle('B'.$cellIndex)->getFont()->setBold(true);
//           $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
//           $active_sheet->getStyle('A'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//           $active_sheet->getStyle('C'.$cellIndex.':N'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//           $active_sheet->getStyle('Q'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//           $active_sheet->getStyle('S'.$cellIndex.':T'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//           $active_sheet->getStyle('V'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//           $active_sheet->getStyle('X'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//           $active_sheet->getStyle('Z'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex);
                   
            $active_sheet->setCellValue('B'.$cellIndex,$value->nama);
            $active_sheet->setCellValue('C'.$cellIndex,$value->part_number);
            $active_sheet->setCellValue('D'.$cellIndex,$value->serial_number);
            if($value->date_of_mnf_last_insp != "00-00-0000" && strtotime($value->date_of_mnf_last_insp) != false)
            {
                $date_of_mnf_last_insp = explode('-', $value->date_of_mnf_last_insp);
                $active_sheet->setCellValue('E'.$cellIndex,$date_of_mnf_last_insp[0]);
                $active_sheet->setCellValue('F'.$cellIndex,"-");
                $active_sheet->setCellValue('G'.$cellIndex,$date_of_mnf_last_insp[1]);
                $active_sheet->setCellValue('H'.$cellIndex,"-");
                $active_sheet->setCellValue('I'.$cellIndex,$date_of_mnf_last_insp[2]);
            }
            else
            {
                $active_sheet->setCellValue('G'.$cellIndex,"-");
            }
            if($value->installation_date != "00-00-0000")
            {
                $installation_date = explode('-', $value->installation_date);
                $active_sheet->setCellValue('J'.$cellIndex,$installation_date[0]);
                $active_sheet->setCellValue('K'.$cellIndex,"-");
                $active_sheet->setCellValue('L'.$cellIndex,$installation_date[1]);
                $active_sheet->setCellValue('M'.$cellIndex,"-");
                $active_sheet->setCellValue('N'.$cellIndex,$installation_date[2]);
            }
            else
            {
                $active_sheet->setCellValue('L'.$cellIndex,"-");
            }
            $active_sheet->setCellValue('O'.$cellIndex,$value->installation_ac_tsn);
            $active_sheet->setCellValue('P'.$cellIndex,$value->installation_comp_tsn);
            $active_sheet->setCellValue('Q'.$cellIndex,"Hrs");
            if($value->task == "0")
            {
                $active_sheet->setCellValue('T'.$cellIndex,"");
                
            }
            else
            {
                $active_sheet->setCellValue('T'.$cellIndex,$value->task);
            }
            if($value->is_oc == "0")
            {
                $active_sheet->setCellValue('R'.$cellIndex,$value->operating_time_limit);
                $active_sheet->setCellValue('S'.$cellIndex,"Hrs");
                $active_sheet->setCellValue('U'.$cellIndex,$value->remove_due);
                $active_sheet->setCellValue('V'.$cellIndex,"Hrs");
                $active_sheet->setCellValue('W'.$cellIndex,$value->tsn_tso_current);
                $active_sheet->setCellValue('X'.$cellIndex,"Hrs");
                $active_sheet->setCellValue('Y'.$cellIndex,$value->time_available);
                $active_sheet->setCellValue('Z'.$cellIndex,"Hrs");
            }
            else
            {
                $active_sheet->setCellValue('R'.$cellIndex,"");
                $active_sheet->setCellValue('S'.$cellIndex,"OC");
                $active_sheet->setCellValue('U'.$cellIndex,"");
                $active_sheet->setCellValue('V'.$cellIndex,"OC");
                $active_sheet->setCellValue('W'.$cellIndex,"");
                $active_sheet->setCellValue('X'.$cellIndex,"OC");
                $active_sheet->setCellValue('Y'.$cellIndex,"");
                $active_sheet->setCellValue('Z'.$cellIndex,"OC");
            }
//           $this->getBorderLaporanUdara($active_sheet,$cellIndex);
           $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
//           $this->getBorderLaporanUdara($active_sheet,$cellIndex);
           $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
       }
//       $this->getBorderLaporanUdara($active_sheet,$cellIndex);
       $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount,true);

       
      
      /* SET COLUMN WIDTH */
      $active_sheet->getColumnDimension('A')->setWidth(3.140625);
      $active_sheet->getColumnDimension('B')->setWidth(19.85546875);
      $active_sheet->getColumnDimension('C')->setWidth(12.42578125);
      $active_sheet->getColumnDimension('D')->setWidth(10.140625);
      $active_sheet->getColumnDimension('E')->setWidth(3.28515625);
      $active_sheet->getColumnDimension('F')->setWidth(0.85546875);
      $active_sheet->getColumnDimension('G')->setWidth(3.140625);
      $active_sheet->getColumnDimension('H')->setWidth(1);
      $active_sheet->getColumnDimension('I')->setWidth(4.28515625);
      $active_sheet->getColumnDimension('J')->setWidth(2.42578125);
      $active_sheet->getColumnDimension('K')->setWidth(1.28515625);
      $active_sheet->getColumnDimension('L')->setWidth(2.42578125);
      $active_sheet->getColumnDimension('M')->setWidth(0.85546875);
      $active_sheet->getColumnDimension('N')->setWidth(4.85546875);
      $active_sheet->getColumnDimension('O')->setWidth(7);
      $active_sheet->getColumnDimension('P')->setWidth(6.85546875);
      $active_sheet->getColumnDimension('Q')->setWidth(3);
      $active_sheet->getColumnDimension('R')->setWidth(5.28515625);
      $active_sheet->getColumnDimension('S')->setWidth(4.28515625);
      $active_sheet->getColumnDimension('T')->setWidth(3.85546875);
      $active_sheet->getColumnDimension('U')->setWidth(14.5703125);
      $active_sheet->getColumnDimension('V')->setWidth(3.42578125);
      $active_sheet->getColumnDimension('W')->setWidth(7.5703125);
      $active_sheet->getColumnDimension('X')->setWidth(3.5703125);
      $active_sheet->getColumnDimension('Y')->setWidth(7.5703125);
      $active_sheet->getColumnDimension('Z')->setWidth(3);
      $active_sheet->getColumnDimension('AA')->setWidth(7);
      $active_sheet->getColumnDimension('AB')->setWidth(6);
      $active_sheet->getColumnDimension('AC')->setWidth(6.140625);
      
      
      
      
      /* HEADER */
      
       $active_sheet->getStyle('A1:B6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A1:B6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A1:AC1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      
      $active_sheet->getStyle('A2:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('A2:B4')->getFont()->setSize(10);
      $active_sheet->getStyle('A2:B4')->getFont()->setName('Arial Black');
      $active_sheet->getStyle('A2:B4')->getFont()->setBold(true);
      
      $active_sheet->setCellValue('A2',"KOARMATIM");
      $active_sheet->mergeCells('A2:B2');
      
      $active_sheet->setCellValue('A3',"WING UDARA");
      $active_sheet->mergeCells('A3:B3');
      
      $active_sheet->setCellValue('A4',"SUSDALITAS");
      $active_sheet->mergeCells('A4:B4');
      
      
      
      
      
      $active_sheet->setCellValue('C3',"AIRCRAFT MAJOR COMPONENT STATUS");
      $active_sheet->mergeCells('C3:U4');
      $active_sheet->getStyle('C3:U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('C3:U3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      $active_sheet->getStyle('C3:U3')->getFont()->setBold(true);
      $active_sheet->getStyle('C3:U3')->getFont()->setSize(18);
      $active_sheet->getStyle('C3:U3')->getFont()->setName('Bookman Old Style');
      
      
      
      
      
      $active_sheet->getStyle('V1:Y6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('V1:Y6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('Z1:AC6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('Z1:AC6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('V1:W4')->getFont()->setBold(true);
      $active_sheet->getStyle('V1:W4')->getFont()->setSize(8);
      $active_sheet->getStyle('V1:W4')->getFont()->setName('Arial');
      $active_sheet->getStyle('Z1:AA4')->getFont()->setBold(true);
      $active_sheet->getStyle('Z1:AA4')->getFont()->setSize(8);
      $active_sheet->getStyle('Z1:AA4')->getFont()->setName('Arial');
      $active_sheet->getStyle('X1:Y4')->getFont()->setSize(8);
      $active_sheet->getStyle('X1:Y4')->getFont()->setName('Arial');
      $active_sheet->getStyle('AB1:AC4')->getFont()->setSize(8);
      $active_sheet->getStyle('AB1:AC4')->getFont()->setName('Arial');
      
      $active_sheet->setCellValue('V1',"A/C. Type");
      $active_sheet->mergeCells('V1:W1');
      $active_sheet->setCellValue('X1',$ac_type);
      $active_sheet->mergeCells('X1:Y1'); 
      
      $active_sheet->setCellValue('Z1',"Date");
      $active_sheet->mergeCells('Z1:AA1');
      $active_sheet->setCellValue('AB1',$date);
      $active_sheet->mergeCells('AB1:AC1');
     
      $active_sheet->setCellValue('V2',"A/C. REG");
      $active_sheet->mergeCells('V2:W2');
      $active_sheet->setCellValue('X2',$ac_reg);
      $active_sheet->mergeCells('X2:Y2');
      
      $active_sheet->setCellValue('Z2',"A/C T.T");
      $active_sheet->mergeCells('Z2:AA2');
      $active_sheet->setCellValue('AB2',$ac_tt);
      $active_sheet->mergeCells('AB2:AC2');
      
      $active_sheet->setCellValue('V3',"A/C. S/N");
      $active_sheet->mergeCells('V3:W3');
      $active_sheet->setCellValue('X3',$ac_sn);
      $active_sheet->mergeCells('X3:Y3');
      
      $active_sheet->setCellValue('Z3',"A/C CYL");
      $active_sheet->mergeCells('Z3:AA3');
      $active_sheet->setCellValue('AB3',$ac_cyl);
      $active_sheet->mergeCells('AB3:AC3');
      
      $active_sheet->setCellValue('V4',"A/C. OWNER");
      $active_sheet->mergeCells('V4:W4');
      $active_sheet->setCellValue('X4',$ac_owner);
      $active_sheet->mergeCells('X4:Y4');
      
     
      
      
      
      
     $headerColumnStyle = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 8,
            'name'  => 'Arial'
        ),
        'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
                        ),
                'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			'color' => array('argb' => '000000'),
                        ),
                
        ),
        'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'C0C0C0')
        )
       );
      
      $active_sheet->getStyle('A7:AC8')->applyFromArray($headerColumnStyle);
      
      $active_sheet->setCellValue('A7',"NO");
      $active_sheet->mergeCells('A7:A8');
      
      $active_sheet->setCellValue('B7',"DESIGNATION");
      $active_sheet->mergeCells('B7:B8');
      
      $active_sheet->setCellValue('C7',"PART NUMBER");
      $active_sheet->mergeCells('C7:C8');
      
      $active_sheet->setCellValue('D7',"SERIAL NO");
      $active_sheet->mergeCells('D7:D8');
      
      $active_sheet->setCellValue('E7',"DATE OF\nMNF./LAST INSP");
      $active_sheet->mergeCells('E7:I8');
      $active_sheet->getStyle('E7:I8')->getAlignment()->setWrapText(true);
      
      
      $active_sheet->setCellValue('J7',"INSTALLATION ON/AT");
      $active_sheet->mergeCells('J7:Q7');
      $active_sheet->setCellValue('J8',"DATE");
      $active_sheet->mergeCells('J8:N8');
      $active_sheet->setCellValue('O8',"A/C TSN");
      $active_sheet->setCellValue('P8',"COMP TSN");
      $active_sheet->mergeCells('P8:Q8');
      
      $active_sheet->setCellValue('R7',"OPERATING\nTIME LIMIT");
      $active_sheet->mergeCells('R7:S8');
      $active_sheet->getStyle('R7:S8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('T7',"TASK");
      $active_sheet->mergeCells('T7:T8');
      
      $active_sheet->setCellValue('U7',"REMOVE DUE\nA/C. T.T");
      $active_sheet->mergeCells('U7:V8');
      $active_sheet->getStyle('U7:U8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('W7',"TSN/TSO\nCurrent");
      $active_sheet->mergeCells('W7:X8');
      $active_sheet->getStyle('W7:X8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('Y7',"TIME\nAVAILABLE");
      $active_sheet->mergeCells('Y7:Z8');
      $active_sheet->getStyle('Y7:Z8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('AA7',"REMARKS");
      $active_sheet->mergeCells('AA7:AC8');
      
      $active_sheet->getStyle('A9:AC9')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A9:AC9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A9:D9')->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('E9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('I9')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('N9')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('P9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('R9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('T9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('U9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('W9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('Y9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('AA9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      
      //SET PAGE OF
      $totalPage = count($page_index);
      $i=1;
      foreach($page_index as $page)
      {
          $active_sheet->setCellValue('AB'.$page,"Page $i of $totalPage");
          $i++;
      }


      

      
      //LAPORAN ENGINE
//      var_dump($data_engine);
//      die;
      $sheet_index = 1;
      foreach($data_engine as $dt)
      {
          $this->getLaporanEngine($excel, $sheet_index,$dt,$data_ac);
          $sheet_index++;
      }
      
      
      
      
//      $active_sheet->setCellValue('AB43','&RPage &P of &N');
      /*before excel download settings */
      $excel->setActiveSheetIndex(0);
      $today = date("Y-m-d");  
      $filename= "Laporan Udara $data_detail->merk"."(".$today.")"; 
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); 
      header('Content-Disposition: attachment;filename="'.$filename.'"'); 
      header('Cache-Control: max-age=0');
      $objWriter = new PHPExcel_Writer_Excel2007($excel); 
      $objWriter->save('php://output');
  }
  
  private function getLaporanEngine($excel,$sheet_index,$data_engine,$data_ac)
  {
//      var_dump($data_engine);
//      die;
      $page_index = array();
      $excel->createSheet();
      $excel->setActiveSheetIndex($sheet_index);
      $active_sheet = $excel->getActiveSheet();
      $active_sheet->setTitle("$data_engine->nama");
      
      $active_sheet->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
      $active_sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
      $active_sheet->getPageSetup()->setScale(74);
//      $active_sheet->getPageSetup()->setFitToWidth(1);
      $active_sheet->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 9);
      $active_sheet->getDefaultStyle()->getFont()->setName('Arial');
      $active_sheet->freezePane('A9');
      $eng_type = ":".$data_engine->eng_type;
      $eng_sn = ":".$data_engine->serial_number;
      $eng_tt = ":".$data_engine->umur." Hrs";
      $eng_cyl = ":".$data_engine->cycle." Cyl";
      $eng_tso = ":".$data_engine->eng_tso;
      $ac_owner = ":"."BASARNAS";
      $date = ":".date("d-F-Y");
      $ac_reg= ":".$data_ac["reg"];
      $ac_tt= ":".$data_ac["tt"]." Hrs";
      
      $query_sub_part = "SELECT 
                        t.is_kelompok,
                        t.is_oc,
                        t.id,
                        t.id_part,
                        t.nama,
                        t.part_number,
                        t.serial_number,
                        (SELECT DATE_FORMAT(pelaksana_tgl,'%d-%m-%Y') FROM pemeliharaan_perlengkapan_sub_part WHERE id_sub_part = 
			(SELECT id FROM asset_perlengkapan_sub_part AS X WHERE  x.id = t.id)ORDER BY pelaksana_tgl LIMIT 1) 
			AS date_of_mnf_sub_part,  
                        DATE_FORMAT(t.installation_date,'%d-%m-%Y') AS installation_date,
                        t.installation_ac_tsn,
                        t.installation_comp_tsn,
                        t.umur_maks AS operating_time_limit_hrs,
                        t.cycle_maks AS operating_time_limit_cyc,
                        t.task,
                        t.cycle,
                        t.cycle_maks,
                        (t.umur_maks + t.installation_ac_tsn - t.installation_comp_tsn) AS remove_due_hrs,
                        (t.cycle_maks) AS remove_due_cyc,
                        (t.umur_maks - (t.umur_maks - (SELECT umur FROM asset_perlengkapan WHERE id = $data_engine->id))) AS tsn_tso_current_hrs,
                        (t.cycle_maks - (t.cycle_maks - (SELECT cycle FROM asset_perlengkapan WHERE id = $data_engine->id))) AS tsn_tso_current_cyc,
                        (t.umur_maks - (SELECT umur FROM asset_perlengkapan WHERE id = $data_engine->id)) AS time_available_hrs,
                        (t.cycle_maks - (SELECT cycle FROM asset_perlengkapan WHERE id = $data_engine->id)) AS time_available_cyc
                        FROM asset_perlengkapan_sub_part AS t
                        WHERE t.id_part = $data_engine->id";
      
       $r = $this->db->query($query_sub_part);
       $data_sub_part = array();
       $totalRows = $r->num_rows(); 
       if ($totalRows > 0)
       {
            foreach ($r->result() as $obj)
            {
                if(strtotime($obj->date_of_mnf_sub_part) == false && strtotime($data_engine->date_of_mnf_last_insp) == false)
                {
                    $obj->date_of_mnf_last_insp = null;
                }
                else if(strtotime($obj->date_of_mnf_sub_part) != false && strtotime($data_engine->date_of_mnf_last_insp)!= false)
                {
                    if(strtotime($obj->date_of_mnf_sub_part) > strtotime($data_engine->date_of_mnf_last_insp))
                    {
                        $obj->date_of_mnf_last_insp = $obj->date_of_mnf_sub_part;
                    }
                    else
                    {
                        $obj->date_of_mnf_last_insp = $data_engine->date_of_mnf_last_insp;
                    }
                }
                else if(strtotime($obj->date_of_mnf_sub_part) == false && strtotime($data_engine->date_of_mnf_last_insp)!= false)
                {
                    $obj->date_of_mnf_last_insp = $data_engine->date_of_mnf_last_insp;
                }
                else if(strtotime($obj->date_of_mnf_sub_part) != false && strtotime($data_engine->date_of_mnf_last_insp)== false)
                {
                    $obj->date_of_mnf_last_insp = $obj->date_of_mnf_sub_part;
                }
                else
                {
                    $obj->date_of_mnf_last_insp = null;
                }
                $data_sub_part[] = $obj;
            }  
       }
       
       $query_sub_sub_part ="SELECT 
                            t.is_oc,
                            t.id_sub_part,
                            t.nama,
                            t.part_number,
                            t.serial_number,
                           (SELECT DATE_FORMAT(pelaksana_tgl,'%d-%m-%Y') FROM pemeliharaan_perlengkapan_sub_sub_part WHERE id_sub_sub_part = 
			   (SELECT id FROM asset_perlengkapan_sub_sub_part AS X WHERE  x.id = t.id)ORDER BY pelaksana_tgl LIMIT 1) AS date_of_mnf_sub_sub_part,  
                            DATE_FORMAT(t.installation_date,'%d-%m-%Y') AS installation_date,
                            t.installation_ac_tsn,
                            t.installation_comp_tsn,
                            t.umur_maks AS operating_time_limit_hrs,
                            t.cycle_maks AS operating_time_limit_cyc,
                            t.task,
                            t.cycle,
                            t.cycle_maks,
                            (t.umur_maks + t.installation_ac_tsn - t.installation_comp_tsn) AS remove_due_hrs,
                            (t.cycle_maks) AS remove_due_cyc,
                            (t.umur_maks - (t.umur_maks - (SELECT umur FROM asset_perlengkapan WHERE id = $data_engine->id))) AS tsn_tso_current_hrs,
                            (t.cycle_maks - (t.cycle_maks - (SELECT cycle FROM asset_perlengkapan WHERE id = $data_engine->id))) AS tsn_tso_current_cyc,
                            (t.umur_maks - (SELECT umur FROM asset_perlengkapan WHERE id = $data_engine->id)) AS time_available_hrs,
                            (t.cycle_maks - (SELECT cycle FROM asset_perlengkapan WHERE id = $data_engine->id)) AS time_available_cyc
                            FROM asset_perlengkapan_sub_sub_part AS t
                            WHERE t.id_sub_part IN (SELECT id FROM asset_perlengkapan_sub_part WHERE id_part = $data_engine->id)
                            ";
       $r = $this->db->query($query_sub_sub_part);
       $data_sub_sub_part = array();
       $totalRows = $r->num_rows(); 
       if ($totalRows > 0)
       {
            foreach ($r->result() as $obj)
            {
                $data_sub_sub_part[] = $obj;
            }  
       }
           
       
      
           $rowCount = 1;
           $cellIndex = 10;
           
           $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex);

            $active_sheet->setCellValue('B'.$cellIndex,$data_engine->nama);
            $active_sheet->setCellValue('C'.$cellIndex,$data_engine->part_number);
            $active_sheet->setCellValue('D'.$cellIndex,$data_engine->serial_number);
            if($data_engine->date_of_mnf_last_insp != "00-00-0000" && strtotime($data_engine->date_of_mnf_last_insp) != false)
            {
                $date_of_mnf_last_insp = explode('-', $data_engine->date_of_mnf_last_insp);
                $active_sheet->setCellValue('E'.$cellIndex,$date_of_mnf_last_insp[0]);
                $active_sheet->setCellValue('F'.$cellIndex,"-");
                $active_sheet->setCellValue('G'.$cellIndex,$date_of_mnf_last_insp[1]);
                $active_sheet->setCellValue('H'.$cellIndex,"-");
                $active_sheet->setCellValue('I'.$cellIndex,$date_of_mnf_last_insp[2]);
            }
            else
            {
                $active_sheet->setCellValue('G'.$cellIndex,"-");
            }
            if($data_engine->installation_date != "00-00-0000")
            {
                $installation_date = explode('-', $data_engine->installation_date);
                $active_sheet->setCellValue('J'.$cellIndex,$installation_date[0]);
                $active_sheet->setCellValue('K'.$cellIndex,"-");
                $active_sheet->setCellValue('L'.$cellIndex,$installation_date[1]);
                $active_sheet->setCellValue('M'.$cellIndex,"-");
                $active_sheet->setCellValue('N'.$cellIndex,$installation_date[2]);
            }
            else
            {
                $active_sheet->setCellValue('L'.$cellIndex,"-");
            }
            $active_sheet->setCellValue('O'.$cellIndex,$data_engine->installation_ac_tsn);
            $active_sheet->setCellValue('P'.$cellIndex,$data_engine->installation_comp_tsn);
            $active_sheet->setCellValue('Q'.$cellIndex,"Hrs");
            if($data_engine->task == "0")
            {
                $active_sheet->setCellValue('T'.$cellIndex,"");
                
            }
            else
            {
                $active_sheet->setCellValue('T'.$cellIndex,$data_engine->task);
            }
            if($data_engine->is_oc == "0")
            {
                $active_sheet->setCellValue('R'.$cellIndex,$data_engine->operating_time_limit);
                $active_sheet->setCellValue('S'.$cellIndex,"Hrs");
                $active_sheet->setCellValue('U'.$cellIndex,$data_engine->remove_due);
                $active_sheet->setCellValue('V'.$cellIndex,"Hrs");
                $active_sheet->setCellValue('W'.$cellIndex,$data_engine->tsn_tso_current);
                $active_sheet->setCellValue('X'.$cellIndex,"Hrs");
                $active_sheet->setCellValue('Y'.$cellIndex,$data_engine->time_available);
                $active_sheet->setCellValue('Z'.$cellIndex,"Hrs");
            }
            else
            {
                $active_sheet->setCellValue('R'.$cellIndex,"");
                $active_sheet->setCellValue('S'.$cellIndex,"OC");
                $active_sheet->setCellValue('U'.$cellIndex,"");
                $active_sheet->setCellValue('V'.$cellIndex,"OC");
                $active_sheet->setCellValue('W'.$cellIndex,"");
                $active_sheet->setCellValue('X'.$cellIndex,"OC");
                $active_sheet->setCellValue('Y'.$cellIndex,"");
                $active_sheet->setCellValue('Z'.$cellIndex,"OC");
            }
            
             $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
               
               //cycle AREA
               $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex);

               if($data_engine->is_oc == "0")
                {
                    $active_sheet->setCellValue('R'.$cellIndex,$data_engine->cycle_maks);
                    $active_sheet->setCellValue('S'.$cellIndex,"Cyc");
                    $active_sheet->setCellValue('U'.$cellIndex,$data_engine->cycle_maks);
                    $active_sheet->setCellValue('V'.$cellIndex,"Cyc");
                    $active_sheet->setCellValue('W'.$cellIndex,$data_engine->cycle);
                    $active_sheet->setCellValue('X'.$cellIndex,"Cyc");
                    $active_sheet->setCellValue('Y'.$cellIndex,$data_engine->cycle_maks - $data_engine->cycle);
                    $active_sheet->setCellValue('Z'.$cellIndex,"Cyc");
                }
                else
                {
                    $active_sheet->setCellValue('R'.$cellIndex,"");
                    $active_sheet->setCellValue('S'.$cellIndex,"OC");
                    $active_sheet->setCellValue('U'.$cellIndex,"");
                    $active_sheet->setCellValue('V'.$cellIndex,"OC");
                    $active_sheet->setCellValue('W'.$cellIndex,"");
                    $active_sheet->setCellValue('X'.$cellIndex,"OC");
                    $active_sheet->setCellValue('Y'.$cellIndex,"");
                    $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                }
//           $this->getBorderLaporanUdara($active_sheet,$cellIndex);
           $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
//           $this->getBorderLaporanUdara($active_sheet,$cellIndex);
           $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
           
           $active_sheet->mergeCells('J'.$cellIndex.':N'.$cellIndex);
           $active_sheet->mergeCells('P'.$cellIndex.':Q'.$cellIndex);
           $active_sheet->getStyle('J'.$cellIndex.':Q'.$cellIndex)->getFont()->setSize(8);
           $active_sheet->getStyle('J'.$cellIndex.':Q'.$cellIndex)->getFont()->setBold(true);
           $active_sheet->getStyle('J'.$cellIndex.':Q'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $active_sheet->getStyle('J'.$cellIndex.':Q'.$cellIndex)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
           $active_sheet->getStyle('J'.$cellIndex.':Q'.$cellIndex)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
           $active_sheet->setCellValue('J'.$cellIndex,"DATE");
           $active_sheet->setCellValue('O'.$cellIndex,"ENG HRS");
           $active_sheet->setCellValue('P'.$cellIndex,"COMP HRS");
           $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
//       $this->getBorderLaporanUdara($active_sheet,$cellIndex);
      
      
      foreach($data_sub_part as $value)
      {
          $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex);
           
            $active_sheet->setCellValue('B'.$cellIndex,$value->nama);
           if($value->is_kelompok == "0")
           {
                $active_sheet->setCellValue('C'.$cellIndex,$value->part_number);
                $active_sheet->setCellValue('D'.$cellIndex,$value->serial_number);
                if($value->date_of_mnf_last_insp != "00-00-0000" && strtotime($value->date_of_mnf_last_insp) != false)
                {
                    $date_of_mnf_last_insp = explode('-', $value->date_of_mnf_last_insp);
                    $active_sheet->setCellValue('E'.$cellIndex,$date_of_mnf_last_insp[0]);
                    $active_sheet->setCellValue('F'.$cellIndex,"-");
                    $active_sheet->setCellValue('G'.$cellIndex,$date_of_mnf_last_insp[1]);
                    $active_sheet->setCellValue('H'.$cellIndex,"-");
                    $active_sheet->setCellValue('I'.$cellIndex,$date_of_mnf_last_insp[2]);
                }
                else
                {
                    $active_sheet->setCellValue('G'.$cellIndex,"-");
                }
                if($value->installation_date != "00-00-0000")
                {
                    $installation_date = explode('-', $value->installation_date);
                    $active_sheet->setCellValue('J'.$cellIndex,$installation_date[0]);
                    $active_sheet->setCellValue('K'.$cellIndex,"-");
                    $active_sheet->setCellValue('L'.$cellIndex,$installation_date[1]);
                    $active_sheet->setCellValue('M'.$cellIndex,"-");
                    $active_sheet->setCellValue('N'.$cellIndex,$installation_date[2]);
                }
                else
                {
                    $active_sheet->setCellValue('L'.$cellIndex,"-");
                }
                $active_sheet->setCellValue('O'.$cellIndex,$value->installation_ac_tsn);
                $active_sheet->setCellValue('P'.$cellIndex,$value->installation_comp_tsn);
                $active_sheet->setCellValue('Q'.$cellIndex,"Hrs");
                if($value->task == "0")
                {
                    $active_sheet->setCellValue('T'.$cellIndex,"");

                }
                else
                {
                    $active_sheet->setCellValue('T'.$cellIndex,$value->task);
                }
                if($value->is_oc == "0")
                {
                    $active_sheet->setCellValue('R'.$cellIndex,$value->operating_time_limit_hrs);
                    $active_sheet->setCellValue('S'.$cellIndex,"Hrs");
                    $active_sheet->setCellValue('U'.$cellIndex,$value->remove_due_hrs);
                    $active_sheet->setCellValue('V'.$cellIndex,"Hrs");
                    $active_sheet->setCellValue('W'.$cellIndex,$value->tsn_tso_current_hrs);
                    $active_sheet->setCellValue('X'.$cellIndex,"Hrs");
                    $active_sheet->setCellValue('Y'.$cellIndex,$value->time_available_hrs);
                    $active_sheet->setCellValue('Z'.$cellIndex,"Hrs");
                }
                else
                {
                    $active_sheet->setCellValue('R'.$cellIndex,"");
                    $active_sheet->setCellValue('S'.$cellIndex,"OC");
                    $active_sheet->setCellValue('U'.$cellIndex,"");
                    $active_sheet->setCellValue('V'.$cellIndex,"OC");
                    $active_sheet->setCellValue('W'.$cellIndex,"");
                    $active_sheet->setCellValue('X'.$cellIndex,"OC");
                    $active_sheet->setCellValue('Y'.$cellIndex,"");
                    $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                }
               $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
               
               //cycle AREA
               $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex);

               if($value->is_oc == "0")
                {
                    $active_sheet->setCellValue('R'.$cellIndex,$value->operating_time_limit_cyc);
                    $active_sheet->setCellValue('S'.$cellIndex,"Cyc");
                    $active_sheet->setCellValue('U'.$cellIndex,$value->remove_due_cyc);
                    $active_sheet->setCellValue('V'.$cellIndex,"Cyc");
                    $active_sheet->setCellValue('W'.$cellIndex,$value->tsn_tso_current_cyc);
                    $active_sheet->setCellValue('X'.$cellIndex,"Cyc");
                    $active_sheet->setCellValue('Y'.$cellIndex,$value->time_available_cyc);
                    $active_sheet->setCellValue('Z'.$cellIndex,"Cyc");
                }
                else
                {
                    $active_sheet->setCellValue('R'.$cellIndex,"");
                    $active_sheet->setCellValue('S'.$cellIndex,"OC");
                    $active_sheet->setCellValue('U'.$cellIndex,"");
                    $active_sheet->setCellValue('V'.$cellIndex,"OC");
                    $active_sheet->setCellValue('W'.$cellIndex,"");
                    $active_sheet->setCellValue('X'.$cellIndex,"OC");
                    $active_sheet->setCellValue('Y'.$cellIndex,"");
                    $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                }
               $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
               
               //SUB SUB PART
               $no=1;
               foreach($data_sub_sub_part as $value2)
               {
                   if($value2->id_sub_part == $value->id)
                   {
                       $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex,false);
                       $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
                       $active_sheet->setCellValue('A'.$cellIndex,$no);
                       $active_sheet->setCellValue('B'.$cellIndex,$value2->nama);
                       $active_sheet->setCellValue('C'.$cellIndex,$value2->part_number);
                        $active_sheet->setCellValue('D'.$cellIndex,$value2->serial_number);
                        if(strtotime($value2->date_of_mnf_sub_sub_part) == false && strtotime($value->date_of_mnf_last_insp) == false)
                        {
                            $value2->date_of_mnf_last_insp = null;
                        }
                        else if(strtotime($value2->date_of_mnf_sub_sub_part) != false && strtotime($value->date_of_mnf_last_insp)!= false)
                        {
                            if(strtotime($value2->date_of_mnf_sub_sub_part) > strtotime($value->date_of_mnf_last_insp))
                            {
                                $value2->date_of_mnf_last_insp = $value2->date_of_mnf_sub_sub_part;
                            }
                            else
                            {
                                $value2->date_of_mnf_last_insp = $value->date_of_mnf_last_insp;
                            }
                        }
                        else if(strtotime($value2->date_of_mnf_sub_sub_part) == false && strtotime($value->date_of_mnf_last_insp)!= false)
                        {
                            $value2->date_of_mnf_last_insp = $data_engine->date_of_mnf_last_insp;
                        }
                        else if(strtotime($value2->date_of_mnf_sub_sub_part) != false && strtotime($value->date_of_mnf_last_insp)== false)
                        {
                            $value2->date_of_mnf_last_insp = $value2->date_of_mnf_sub_sub_part;
                        }
                        else
                        {
                            $value2->date_of_mnf_last_insp = null;
                        }
                        
                        
                        if($value2->date_of_mnf_last_insp != "00-00-0000" && strtotime($value2->date_of_mnf_last_insp) != false)
                        {
                            $date_of_mnf_last_insp = explode('-', $value2->date_of_mnf_last_insp);
                            $active_sheet->setCellValue('E'.$cellIndex,$date_of_mnf_last_insp[0]);
                            $active_sheet->setCellValue('F'.$cellIndex,"-");
                            $active_sheet->setCellValue('G'.$cellIndex,$date_of_mnf_last_insp[1]);
                            $active_sheet->setCellValue('H'.$cellIndex,"-");
                            $active_sheet->setCellValue('I'.$cellIndex,$date_of_mnf_last_insp[2]);
                        }
                        else
                        {
                            $active_sheet->setCellValue('G'.$cellIndex,"-");
                        }
                        if($value2->installation_date != "00-00-0000")
                        {
                            $installation_date = explode('-', $value2->installation_date);
                            $active_sheet->setCellValue('J'.$cellIndex,$installation_date[0]);
                            $active_sheet->setCellValue('K'.$cellIndex,"-");
                            $active_sheet->setCellValue('L'.$cellIndex,$installation_date[1]);
                            $active_sheet->setCellValue('M'.$cellIndex,"-");
                            $active_sheet->setCellValue('N'.$cellIndex,$installation_date[2]);
                        }
                        else
                        {
                            $active_sheet->setCellValue('L'.$cellIndex,"-");
                        }
                        $active_sheet->setCellValue('O'.$cellIndex,$value2->installation_ac_tsn);
                        $active_sheet->setCellValue('P'.$cellIndex,$value2->installation_comp_tsn);
                        $active_sheet->setCellValue('Q'.$cellIndex,"Hrs");
                        if($value->task == "0")
                        {
                            $active_sheet->setCellValue('T'.$cellIndex,"");

                        }
                        else
                        {
                            $active_sheet->setCellValue('T'.$cellIndex,$value2->task);
                        }
                        if($value->is_oc == "0")
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,$value2->operating_time_limit_hrs);
                            $active_sheet->setCellValue('S'.$cellIndex,"Hrs");
                            $active_sheet->setCellValue('U'.$cellIndex,$value2->remove_due_hrs);
                            $active_sheet->setCellValue('V'.$cellIndex,"Hrs");
                            $active_sheet->setCellValue('W'.$cellIndex,$value2->tsn_tso_current_hrs);
                            $active_sheet->setCellValue('X'.$cellIndex,"Hrs");
                            $active_sheet->setCellValue('Y'.$cellIndex,$value2->time_available_hrs);
                            $active_sheet->setCellValue('Z'.$cellIndex,"Hrs");
                        }
                        else
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,"");
                            $active_sheet->setCellValue('S'.$cellIndex,"OC");
                            $active_sheet->setCellValue('U'.$cellIndex,"");
                            $active_sheet->setCellValue('V'.$cellIndex,"OC");
                            $active_sheet->setCellValue('W'.$cellIndex,"");
                            $active_sheet->setCellValue('X'.$cellIndex,"OC");
                            $active_sheet->setCellValue('Y'.$cellIndex,"");
                            $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                        }
                       $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);

                       //cycle AREA
                       $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
                       $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex,false);
                       if($value->is_oc == "0")
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,$value2->operating_time_limit_cyc);
                            $active_sheet->setCellValue('S'.$cellIndex,"Cyc");
                            $active_sheet->setCellValue('U'.$cellIndex,$value2->remove_due_cyc);
                            $active_sheet->setCellValue('V'.$cellIndex,"Cyc");
                            $active_sheet->setCellValue('W'.$cellIndex,$value2->tsn_tso_current_cyc);
                            $active_sheet->setCellValue('X'.$cellIndex,"Cyc");
                            $active_sheet->setCellValue('Y'.$cellIndex,$value2->time_available_cyc);
                            $active_sheet->setCellValue('Z'.$cellIndex,"Cyc");
                        }
                        else
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,"");
                            $active_sheet->setCellValue('S'.$cellIndex,"OC");
                            $active_sheet->setCellValue('U'.$cellIndex,"");
                            $active_sheet->setCellValue('V'.$cellIndex,"OC");
                            $active_sheet->setCellValue('W'.$cellIndex,"");
                            $active_sheet->setCellValue('X'.$cellIndex,"OC");
                            $active_sheet->setCellValue('Y'.$cellIndex,"");
                            $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                        }
                       $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
                       $no++;
                   }
               }
               
               $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
               
           }
           else
           {
               $no=1;
               $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
               foreach($data_sub_sub_part as $value2)
               {
                   if($value2->id_sub_part == $value->id)
                   {
                       $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex,false);
                       $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
                       $active_sheet->setCellValue('A'.$cellIndex,$no);
                       $active_sheet->setCellValue('B'.$cellIndex,$value2->nama);
                       $active_sheet->setCellValue('C'.$cellIndex,$value2->part_number);
                        $active_sheet->setCellValue('D'.$cellIndex,$value2->serial_number);
                        if(strtotime($value2->date_of_mnf_sub_sub_part) == false && strtotime($value->date_of_mnf_last_insp) == false)
                        {
                            $value2->date_of_mnf_last_insp = null;
                        }
                        else if(strtotime($value2->date_of_mnf_sub_sub_part) != false && strtotime($value->date_of_mnf_last_insp)!= false)
                        {
                            if(strtotime($value2->date_of_mnf_sub_sub_part) > strtotime($value->date_of_mnf_last_insp))
                            {
                                $value2->date_of_mnf_last_insp = $value2->date_of_mnf_sub_sub_part;
                            }
                            else
                            {
                                $value2->date_of_mnf_last_insp = $value->date_of_mnf_last_insp;
                            }
                        }
                        else if(strtotime($value2->date_of_mnf_sub_sub_part) == false && strtotime($value->date_of_mnf_last_insp)!= false)
                        {
                            $value2->date_of_mnf_last_insp = $data_engine->date_of_mnf_last_insp;
                        }
                        else if(strtotime($value2->date_of_mnf_sub_sub_part) != false && strtotime($value->date_of_mnf_last_insp)== false)
                        {
                            $value2->date_of_mnf_last_insp = $value2->date_of_mnf_sub_sub_part;
                        }
                        else
                        {
                            $value2->date_of_mnf_last_insp = null;
                        }
                        
                        if($value2->date_of_mnf_last_insp != "00-00-0000" && strtotime($value2->date_of_mnf_last_insp) != false)
                        {
                            $date_of_mnf_last_insp = explode('-', $value2->date_of_mnf_last_insp);
                            $active_sheet->setCellValue('E'.$cellIndex,$date_of_mnf_last_insp[0]);
                            $active_sheet->setCellValue('F'.$cellIndex,"-");
                            $active_sheet->setCellValue('G'.$cellIndex,$date_of_mnf_last_insp[1]);
                            $active_sheet->setCellValue('H'.$cellIndex,"-");
                            $active_sheet->setCellValue('I'.$cellIndex,$date_of_mnf_last_insp[2]);
                        }
                        else
                        {
                            $active_sheet->setCellValue('G'.$cellIndex,"-");
                        }
                        if($value2->installation_date != "00-00-0000")
                        {
                            $installation_date = explode('-', $value2->installation_date);
                            $active_sheet->setCellValue('J'.$cellIndex,$installation_date[0]);
                            $active_sheet->setCellValue('K'.$cellIndex,"-");
                            $active_sheet->setCellValue('L'.$cellIndex,$installation_date[1]);
                            $active_sheet->setCellValue('M'.$cellIndex,"-");
                            $active_sheet->setCellValue('N'.$cellIndex,$installation_date[2]);
                        }
                        else
                        {
                            $active_sheet->setCellValue('L'.$cellIndex,"-");
                        }
                        $active_sheet->setCellValue('O'.$cellIndex,$value2->installation_ac_tsn);
                        $active_sheet->setCellValue('P'.$cellIndex,$value2->installation_comp_tsn);
                        $active_sheet->setCellValue('Q'.$cellIndex,"Hrs");
                        if($value2->task == "0")
                        {
                            $active_sheet->setCellValue('T'.$cellIndex,"");

                        }
                        else
                        {
                            $active_sheet->setCellValue('T'.$cellIndex,$value2->task);
                        }
                        if($value2->is_oc == "0")
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,$value2->operating_time_limit_hrs);
                            $active_sheet->setCellValue('S'.$cellIndex,"Hrs");
                            $active_sheet->setCellValue('U'.$cellIndex,$value2->remove_due_hrs);
                            $active_sheet->setCellValue('V'.$cellIndex,"Hrs");
                            $active_sheet->setCellValue('W'.$cellIndex,$value2->tsn_tso_current_hrs);
                            $active_sheet->setCellValue('X'.$cellIndex,"Hrs");
                            $active_sheet->setCellValue('Y'.$cellIndex,$value2->time_available_hrs);
                            $active_sheet->setCellValue('Z'.$cellIndex,"Hrs");
                        }
                        else
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,"");
                            $active_sheet->setCellValue('S'.$cellIndex,"OC");
                            $active_sheet->setCellValue('U'.$cellIndex,"");
                            $active_sheet->setCellValue('V'.$cellIndex,"OC");
                            $active_sheet->setCellValue('W'.$cellIndex,"");
                            $active_sheet->setCellValue('X'.$cellIndex,"OC");
                            $active_sheet->setCellValue('Y'.$cellIndex,"");
                            $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                        }
                       $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);

                       //cycle AREA
                       $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
                       $this->getLaporanUdaraRowStyle($active_sheet, $cellIndex,false);
                       if($value2->is_oc == "0")
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,$value2->operating_time_limit_cyc);
                            $active_sheet->setCellValue('S'.$cellIndex,"Cyc");
                            $active_sheet->setCellValue('U'.$cellIndex,$value2->remove_due_cyc);
                            $active_sheet->setCellValue('V'.$cellIndex,"Cyc");
                            $active_sheet->setCellValue('W'.$cellIndex,$value2->tsn_tso_current_cyc);
                            $active_sheet->setCellValue('X'.$cellIndex,"Cyc");
                            $active_sheet->setCellValue('Y'.$cellIndex,$value2->time_available_cyc);
                            $active_sheet->setCellValue('Z'.$cellIndex,"Cyc");
                        }
                        else
                        {
                            $active_sheet->setCellValue('R'.$cellIndex,"");
                            $active_sheet->setCellValue('S'.$cellIndex,"OC");
                            $active_sheet->setCellValue('U'.$cellIndex,"");
                            $active_sheet->setCellValue('V'.$cellIndex,"OC");
                            $active_sheet->setCellValue('W'.$cellIndex,"");
                            $active_sheet->setCellValue('X'.$cellIndex,"OC");
                            $active_sheet->setCellValue('Y'.$cellIndex,"");
                            $active_sheet->setCellValue('Z'.$cellIndex,"OC");
                        }
                       $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
                       $no++;
                   }
               }
               $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount);
           }
            
      }
      $this->checkIfNewPageLaporanUdara($page_index,$active_sheet,$cellIndex,$rowCount,true);
      
      
      /* SET COLUMN WIDTH */
      $active_sheet->getColumnDimension('A')->setWidth(3.140625);
      $active_sheet->getColumnDimension('B')->setWidth(19.85546875);
      $active_sheet->getColumnDimension('C')->setWidth(12.42578125);
      $active_sheet->getColumnDimension('D')->setWidth(10.140625);
      $active_sheet->getColumnDimension('E')->setWidth(3.28515625);
      $active_sheet->getColumnDimension('F')->setWidth(0.85546875);
      $active_sheet->getColumnDimension('G')->setWidth(3.140625);
      $active_sheet->getColumnDimension('H')->setWidth(1);
      $active_sheet->getColumnDimension('I')->setWidth(4.28515625);
      $active_sheet->getColumnDimension('J')->setWidth(2.42578125);
      $active_sheet->getColumnDimension('K')->setWidth(1.28515625);
      $active_sheet->getColumnDimension('L')->setWidth(2.42578125);
      $active_sheet->getColumnDimension('M')->setWidth(0.85546875);
      $active_sheet->getColumnDimension('N')->setWidth(4.85546875);
      $active_sheet->getColumnDimension('O')->setWidth(7);
      $active_sheet->getColumnDimension('P')->setWidth(6.85546875);
      $active_sheet->getColumnDimension('Q')->setWidth(3);
      $active_sheet->getColumnDimension('R')->setWidth(5.28515625);
      $active_sheet->getColumnDimension('S')->setWidth(4.28515625);
      $active_sheet->getColumnDimension('T')->setWidth(3.85546875);
      $active_sheet->getColumnDimension('U')->setWidth(14.5703125);
      $active_sheet->getColumnDimension('V')->setWidth(3.42578125);
      $active_sheet->getColumnDimension('W')->setWidth(7.5703125);
      $active_sheet->getColumnDimension('X')->setWidth(3.5703125);
      $active_sheet->getColumnDimension('Y')->setWidth(7.5703125);
      $active_sheet->getColumnDimension('Z')->setWidth(3);
      $active_sheet->getColumnDimension('AA')->setWidth(7);
      $active_sheet->getColumnDimension('AB')->setWidth(6);
      $active_sheet->getColumnDimension('AC')->setWidth(6.140625);
      
      
      
      
      /* HEADER */
      
       $active_sheet->getStyle('A1:B6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A1:B6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A1:AC1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      
      $active_sheet->getStyle('A2:B4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('A2:B4')->getFont()->setSize(10);
      $active_sheet->getStyle('A2:B4')->getFont()->setName('Arial Black');
      $active_sheet->getStyle('A2:B4')->getFont()->setBold(true);
      
      $active_sheet->setCellValue('A2',"KOARMATIM");
      $active_sheet->mergeCells('A2:B2');
      
      $active_sheet->setCellValue('A3',"WING UDARA");
      $active_sheet->mergeCells('A3:B3');
      
      $active_sheet->setCellValue('A4',"SUSDALITAS");
      $active_sheet->mergeCells('A4:B4');
      
      
      
      
      
      $active_sheet->setCellValue('C3',"AIRCRAFT MAJOR COMPONENT STATUS");
      $active_sheet->mergeCells('C3:U4');
      $active_sheet->getStyle('C3:U3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('C3:U3')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
      $active_sheet->getStyle('C3:U3')->getFont()->setBold(true);
      $active_sheet->getStyle('C3:U3')->getFont()->setSize(18);
      $active_sheet->getStyle('C3:U3')->getFont()->setName('Bookman Old Style');
      
      
      
      
      
      $active_sheet->getStyle('V1:Y6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('V1:Y6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('Z1:AC6')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('Z1:AC6')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('V1:W4')->getFont()->setBold(true);
      $active_sheet->getStyle('V1:W4')->getFont()->setSize(8);
      $active_sheet->getStyle('V1:W4')->getFont()->setName('Arial');
      $active_sheet->getStyle('Z1:AA5')->getFont()->setBold(true);
      $active_sheet->getStyle('Z1:AA5')->getFont()->setSize(8);
      $active_sheet->getStyle('Z1:AA5')->getFont()->setName('Arial');
      $active_sheet->getStyle('X1:Y4')->getFont()->setSize(8);
      $active_sheet->getStyle('X1:Y4')->getFont()->setName('Arial');
      $active_sheet->getStyle('AB1:AC5')->getFont()->setSize(8);
      $active_sheet->getStyle('AB1:AC5')->getFont()->setName('Arial');
      
      $active_sheet->setCellValue('V1',"ENG. Type");
      $active_sheet->mergeCells('V1:W1');
      $active_sheet->setCellValue('X1',"$eng_type");
      $active_sheet->mergeCells('X1:Y1'); 
      
      $active_sheet->setCellValue('Z1',"Date");
      $active_sheet->mergeCells('Z1:AA1');
      $active_sheet->setCellValue('AB1',"$date");
      $active_sheet->mergeCells('AB1:AC1');
     
      $active_sheet->setCellValue('V2',"A/C. REG");
      $active_sheet->mergeCells('V2:W2');
      $active_sheet->setCellValue('X2',"$ac_reg");
      $active_sheet->mergeCells('X2:Y2');
      
      $active_sheet->setCellValue('Z2',"A/C T.T");
      $active_sheet->mergeCells('Z2:AA2');
      $active_sheet->setCellValue('AB2',"$ac_tt");
      $active_sheet->mergeCells('AB2:AC2');
      
      $active_sheet->setCellValue('V3',"ENG. S/N");
      $active_sheet->mergeCells('V3:W3');
      $active_sheet->setCellValue('X3',"$eng_sn");
      $active_sheet->mergeCells('X3:Y3');
      
      $active_sheet->setCellValue('Z3',"ENG. T.T");
      $active_sheet->mergeCells('Z3:AA3');
      $active_sheet->setCellValue('AB3',"$eng_tt");
      $active_sheet->mergeCells('AB3:AC3');
      
      $active_sheet->setCellValue('V4',"A/C. OWNER");
      $active_sheet->mergeCells('V4:W4');
      $active_sheet->setCellValue('X4',"$ac_owner");
      $active_sheet->mergeCells('X4:Y4');
      
      $active_sheet->setCellValue('Z4',"ENG. CYL");
      $active_sheet->mergeCells('Z4:AA4');
      $active_sheet->setCellValue('AB4',"$eng_cyl");
      $active_sheet->mergeCells('AB4:AC4');
      
      $active_sheet->setCellValue('Z5',"ENG. TSO");
      $active_sheet->mergeCells('Z5:AA5');
      $active_sheet->setCellValue('AB5',"$eng_tso");
      $active_sheet->mergeCells('AB5:AC5');
      
      
      
      
      

      
     $headerColumnStyle = array(
        'font'  => array(
            'bold'  => true,
            'size'  => 8,
            'name'  => 'Arial'
        ),
        'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => '000000'),
                        ),
                'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_DOUBLE,
			'color' => array('argb' => '000000'),
                        ),
                
        ),
        'alignment' => array(
		'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
	),
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('argb' => 'C0C0C0')
        )
       );
      
      $active_sheet->getStyle('A7:AC8')->applyFromArray($headerColumnStyle);
      
      $active_sheet->setCellValue('A7',"NO");
      $active_sheet->mergeCells('A7:A8');
      
      $active_sheet->setCellValue('B7',"DESIGNATION");
      $active_sheet->mergeCells('B7:B8');
      
      $active_sheet->setCellValue('C7',"PART NUMBER");
      $active_sheet->mergeCells('C7:C8');
      
      $active_sheet->setCellValue('D7',"SERIAL NO");
      $active_sheet->mergeCells('D7:D8');
      
      $active_sheet->setCellValue('E7',"DATE OF\nMNF./LAST INSP");
      $active_sheet->mergeCells('E7:I8');
      $active_sheet->getStyle('E7:I8')->getAlignment()->setWrapText(true);
      
      
      $active_sheet->setCellValue('J7',"INSTALLATION ON/AT");
      $active_sheet->mergeCells('J7:Q7');
      $active_sheet->setCellValue('J8',"DATE");
      $active_sheet->mergeCells('J8:N8');
      $active_sheet->setCellValue('O8',"A/C TSN");
      $active_sheet->setCellValue('P8',"COMP TSM");
      $active_sheet->mergeCells('P8:Q8');
      
      $active_sheet->setCellValue('R7',"OPERATING\nTIME LIMIT");
      $active_sheet->mergeCells('R7:S8');
      $active_sheet->getStyle('R7:S8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('T7',"TASK");
      $active_sheet->mergeCells('T7:T8');
      
      $active_sheet->setCellValue('U7',"REMOVE DUE\nA/C. T.T");
      $active_sheet->mergeCells('U7:V8');
      $active_sheet->getStyle('U7:U8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('W7',"TSN/TSO\nCurrent");
      $active_sheet->mergeCells('W7:X8');
      $active_sheet->getStyle('W7:X8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('Y7',"TIME\nAVAILABLE");
      $active_sheet->mergeCells('Y7:Z8');
      $active_sheet->getStyle('Y7:Z8')->getAlignment()->setWrapText(true);
      
      $active_sheet->setCellValue('AA7',"REMARKS");
      $active_sheet->mergeCells('AA7:AC8');
      
      
      $active_sheet->getStyle('A9:AC9')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A9:AC9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('A9:D9')->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('E9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('I9')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('N9')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('P9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('R9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('T9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('U9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('W9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('Y9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('AA9')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      
      
      $totalPage = count($page_index);
      $i=1;
      foreach($page_index as $page)
      {
          $active_sheet->setCellValue('AB'.$page,"Page $i of $totalPage");
          $i++;
      }
  }
  
  private function getLaporanUdaraRowStyle($active_sheet,$cellIndex,$bold=true)
  {
          $active_sheet->getStyle('A'.$cellIndex.':AC'.$cellIndex)->getFont()->setSize(8);
           $active_sheet->getStyle('B'.$cellIndex)->getFont()->setBold($bold);
           $active_sheet->getStyle('A'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $active_sheet->getStyle('C'.$cellIndex.':N'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $active_sheet->getStyle('Q'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $active_sheet->getStyle('S'.$cellIndex.':T'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $active_sheet->getStyle('V'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $active_sheet->getStyle('X'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
           $active_sheet->getStyle('Z'.$cellIndex)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  }
  
  private function checkIfNewPageLaporanUdara(&$page_index,$active_sheet,&$cellIndex, &$row_count,$end=null)
  {
      if($row_count == 33)
      {
          $row_count =1;
          $this->getBorderLaporanUdara($active_sheet,$cellIndex);
          $cellIndex++;
          $this->getBorderLaporanUdara($active_sheet,$cellIndex);
          $cellIndex++;
          $page_index[] = $cellIndex + 1;
          $this->getLaporanUdaraFooter($active_sheet, $cellIndex);
          $cellIndex+=4;
      }
      else
      {
          $this->getBorderLaporanUdara($active_sheet,$cellIndex);
          $row_count ++;
          $cellIndex ++;
      }
      
      if($row_count != 33 && $end == true)
      {
          $row_count =1;
//          $cellIndex +=1;
           $page_index[] = $cellIndex + 1;
          $this->getLaporanUdaraFooter($active_sheet, $cellIndex);
          $cellIndex+=4;
      }
  }
  
  private function getBorderLaporanUdara($active_sheet,$cellIndex)
  {
       $active_sheet->getStyle('AC'.$cellIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('A'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('A'.$cellIndex.':D'.$cellIndex)->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('E'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('I'.$cellIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('N'.$cellIndex)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('P'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('R'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('T'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('U'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('W'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('Y'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $active_sheet->getStyle('AA'.$cellIndex)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
  }
  
  private function getLaporanUdaraFooter($active_sheet,$start_index)
  {
      $i=$start_index;
      $i1=$start_index+1;
      $i2=$start_index+2;
      $i3=$start_index+3;
      
//      var_dump(array($i,$i1,$i2,$i3));
//      die;
       /*FOOTER*/
      $active_sheet->getStyle('A'.$i.':AC'.$i3)->getBorders()->getOutline()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
      $active_sheet->getStyle('A'.$i.':O'.$i3)->getFont()->setSize(8);
      $active_sheet->getStyle('P'.$i.':AA'.$i)->getFont()->setSize(8);
      $active_sheet->getStyle('P'.$i2.':AA'.$i2)->getFont()->setSize(8);
      $active_sheet->getStyle('AB'.$i1.':AC'.$i1)->getFont()->setSize(8);
      
      $active_sheet->setCellValue('A'.$i,'TASK CODE:');
      $active_sheet->mergeCells('A'.$i.':B'.$i);
      $active_sheet->getStyle('A'.$i.':B'.$i)->getFont()->setUnderline(true);
      $active_sheet->getStyle('A'.$i.':B'.$i)->getFont()->setBold(true);
//      $active_sheet->getStyle('A42:B42')->getFont()->setSize(8);
      $active_sheet->setCellValue('A'.$i1,"(OH) = Overhaul");
      $active_sheet->mergeCells('A'.$i1.':B'.$i1);
      $active_sheet->setCellValue('A'.$i2,"(HSI) = Hot Section Insp.");
      $active_sheet->mergeCells('A'.$i2.':B'.$i2);
      $active_sheet->setCellValue('A'.$i3,"(BC) = Bench Check");
      $active_sheet->mergeCells('A'.$i3.':B'.$i3);
      
      $active_sheet->setCellValue('C'.$i1,"(HST) = Hydrostatic Test");
      $active_sheet->mergeCells('C'.$i1.':D'.$i1);
      $active_sheet->setCellValue('C'.$i2,"(LF) = Life");
      $active_sheet->mergeCells('C'.$i2.':D'.$i2);
      $active_sheet->setCellValue('C'.$i3,"(IN) = Inspection/Check");
      $active_sheet->mergeCells('C'.$i3.':D'.$i3);
      
      $active_sheet->setCellValue('E'.$i1,"(SLL) = Service Life Limit");
      $active_sheet->mergeCells('E'.$i1.':M'.$i1);
      $active_sheet->setCellValue('E'.$i2,"(Hrs) = Hours");
      $active_sheet->mergeCells('E'.$i2.':M'.$i2);
      $active_sheet->setCellValue('E'.$i3,"(Yrs) = Years");
      $active_sheet->mergeCells('E'.$i3.':M'.$i3);
      
      
      
      
      $active_sheet->setCellValue('P'.$i,"Prepared By:");
      $active_sheet->mergeCells('P'.$i.':T'.$i);
      $active_sheet->getStyle('P'.$i.':T'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('P'.$i.':T'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
//      $active_sheet->setCellValue('P'.$i2,"VAL");
      $active_sheet->mergeCells('P'.$i2.':T'.$i2);
      $active_sheet->getStyle('P'.$i2.':T'.$i2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('P'.$i.':T'.$i3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('P'.$i.':T'.$i3)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      
      $active_sheet->setCellValue('U'.$i,"Checked By:");
      $active_sheet->mergeCells('U'.$i.':W'.$i);
      $active_sheet->getStyle('U'.$i.':W'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('U'.$i.':W'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
//      $active_sheet->setCellValue('U'.$i2,"VAL");
      $active_sheet->mergeCells('U'.$i2.':W'.$i2);
      $active_sheet->getStyle('U'.$i2.':W'.$i2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('U'.$i.':W'.$i3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('U'.$i.':W'.$i3)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      
      $active_sheet->setCellValue('X'.$i,"Approved By:");
      $active_sheet->mergeCells('X'.$i.':AA'.$i);
      $active_sheet->getStyle('X'.$i.':AA'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('X'.$i.':AA'.$i)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_DOUBLE);
//      $active_sheet->setCellValue('X'.$i2,"VAL");
      $active_sheet->mergeCells('X'.$i2.':AA'.$i2);
      $active_sheet->getStyle('X'.$i2.':AA'.$i2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
      $active_sheet->getStyle('X'.$i.':AA'.$i3)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      $active_sheet->getStyle('X'.$i.':AA'.$i3)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
      
      $active_sheet->setCellValue('AB'.$i1,'PAGE');
      $active_sheet->mergeCells('AB'.$i1.':AC'.$i1);
      $active_sheet->getStyle('AB'.$i1.':AC'.$i1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  }
  
  
  private function getQueryBarang($golongan,$bidang,$kelompok,$sub_kelompok)
  {
        $query_barang = "";
        if($golongan !=null && $golongan!= "")
        {
            $combined_kode = $golongan.$bidang.$kelompok.$sub_kelompok;
            $query_barang = "AND t.kd_brg LIKE '$combined_kode%'";
        }

        return $query_barang;
  }
}
?>