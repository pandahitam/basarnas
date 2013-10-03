<?php
ini_set('MAX_EXECUTION_TIME', -1);

class Excel_Management extends CI_Controller{
  public function __construct(){
  	parent::__construct();

 		if ($this->my_usession->logged_in == FALSE){
 			echo "window.location = '".base_url()."user/index';";
 			exit;
                }
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
      $this->load->library('PHPExcel');
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
//            var_dump($selectedColumn);
//            var_dump(count($selectedColumn));
//            die;
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
}
?>