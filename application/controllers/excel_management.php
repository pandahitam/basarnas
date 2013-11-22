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
  
    public function exportLaporanUnkerTotalAset($unitkerja,$kd_lokasi,$tahun)
    {
      $excel = new PHPExcel();
      $active_sheet = $excel->getActiveSheet();
      $unitkerja = urldecode($unitkerja);

      
      
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
       $query = "select ur_sskel,kd_lokasi,no_aset,kd_brg,type,merk,kondisi,kategori_aset,rph_aset,kuantitas,tgl_prl from
                (
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Peralatan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_alatbesar as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi, 'Angkutan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_angkutan as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,'-','-','Bangunan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_bangunan as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,type,merk,kondisi,'Senjata' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_senjata as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','DIL' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from ext_asset_dil as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Perairan' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_perairan as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Ruang' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from ext_asset_ruang as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                UNION
                select a.ur_sskel,t.kd_lokasi,t.no_aset,t.kd_brg,'-','-','-','Tanah' as kategori_aset,rph_aset,kuantitas,YEAR(tgl_prl) as tgl_prl from asset_tanah as t
                LEFT JOIN ref_subsubkel as a on t.kd_brg = a.kd_brg
                where t.kd_lokasi = '".$kd_lokasi."' and YEAR(t.tgl_buku) = '".$tahun."'
                ) as result


                ";
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
}
?>