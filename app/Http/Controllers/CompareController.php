<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//TODO: memory limit y tiempo limite

class CompareController extends Controller
{
    
    function compare(Request $request)
    {
        $hola = new \App\Library\DataToCompare("a0", "b");
        $trimValues = "\0\t\n\x0B\r";
        $replaceCharacters = array(
            'and' => '', '&' => '',
            'el' => '', 'los' => '',
            'la' => '', 'las' => '',
            'de' => '',
            'en' => '',
            'by' => '', 
            'at' => '',
            'del' => '', 
            'con' => '',
            'on' => '',
            'in' => '',
            'the' => '',
            ',' => '', '.' => '', ':' => '', ';' => '', '-' => '', '_' => '',
        
        );
        
        $file0Name = $request->fileName0;
        $file1Name = $request->fileName1;
        $file0Column = $request->file0;
        $file1Column = $request->file1;
        $file0ColumnToLink = $request->columnLink0;
        $file1ColumnToLink = $request->columnLink1;

        $col0 = chr($file0Column + 65);
        $col1 = chr($file1Column + 65);
        $linkCol0 = chr($file0ColumnToLink + 65);
        $linkCol1 = chr($file1ColumnToLink + 65);
        
        
        
        $path1 = "uploads/".$file1Name;
        $reader1 = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $spreadsheet1 = $reader1 -> load($path1);
        $sheet1 = $spreadsheet1 -> getActiveSheet();
        
        $worksheetInfo1 = $reader1 -> listWorksheetInfo($path1);
        $totalRows1 = $worksheetInfo1[0]['totalRows'];
        
        $path0 = "uploads/".$file0Name;
        $reader0 = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        $spreadsheet0 = $reader0 -> load($path0);
        $sheet0 = $spreadsheet0 ->  getActiveSheet();
        
        $worksheetInfo0 = $reader0->listWorksheetInfo($path0);
        $totalRows0 = $worksheetInfo0[0]['totalRows'];
        
       
        
        $idColName0 = $sheet0->getCell("{$linkCol0}1")->getValue();
        $ColName0 = $sheet0->getCell("{$col0}1")->getValue();
        $idColName1 = $sheet1->getCell("{$linkCol1}1")->getValue();
        $ColName1 = $sheet1->getCell("{$col1}1")->getValue();
 //Get data to compare first:
        $dataToCompareArray = array();
        $realValueArray = array();
        $idArray = array();
        for($j = 2; $j <= $totalRows1; $j++){
            $realValueToCompare = $sheet1->getCell("{$col1}{$j}")->getValue();
            $realValueToCompare = $this->clean_strings_accents($realValueToCompare);
            $realValueToCompare = utf8_decode($realValueToCompare);
            $realValueToCompare = $this->remove_accents($realValueToCompare);
            array_push($realValueArray, $realValueToCompare);
        
            $dirtyValueToCompare = strtolower($realValueToCompare);
            $dirtyValueToCompare = $this->strip_stopwords($dirtyValueToCompare, $replaceCharacters);
            $value = new \App\Library\DataToCompare($realValueToCompare, $dirtyValueToCompare);
            array_push($dataToCompareArray, $value);
        
        
            $id1 = $sheet1->getCell("{$linkCol1}{$j}")->getValue();
            array_push($idArray, $id1);
        
            //inverted index
            //$dataToCompare = explode(" ", $dirtyValueToCompare);
        }
        
        
        
        $valuesArray = array();
        $range = 0;
        for ($row0 = 2; $row0 <= $totalRows0; $row0++){
            
            $realValue = $sheet0->getCell("{$col0}{$row0}")->getValue();
            $realValue = $this->clean_strings_accents($realValue);
            $realValue = utf8_decode($realValue);
            $realValue = $this->remove_accents($realValue);
            
            $dirtyValue = strtolower($realValue);
            $dirtyValue = $this->strip_stopwords($dirtyValue, $replaceCharacters);
        
            $id0 = $sheet0->getCell("{$linkCol0}{$row0}")->getValue();
            
            $newValue = new \App\Library\NewCsvValue($realValue, $id0);
            for($row1 = $range; $row1 < count($dataToCompareArray); $row1++){
                $realValueToCompare = $dataToCompareArray[$row1]->real;
                $dirtyValueToCompare = $dataToCompareArray[$row1]->dirty;
                $dirtyValueToCompare = $this->strip_stopwords($dirtyValueToCompare, $replaceCharacters);
        
                $sim = similar_text($dirtyValue, $dirtyValueToCompare, $perc);
                if($perc >= 95){
                    if($range < 0){
                        $range = 0;
                    } 
                    $id1 = $idArray[$row1];
                    $newValue->addEqualField($realValueToCompare, $id1);
                    break;
                }
                else{
                    $dirtyValueToCompare = str_replace("hotel", "", $dirtyValueToCompare);
                    $dirtyValuetmp = str_replace("hotel", "", $dirtyValue);

                    
                    $dirtyValueToCompare = str_replace("cozumel", "", $dirtyValueToCompare);
                    $dirtyValuetmp = str_replace("cozumel", "", $dirtyValue);

                    
                    $dirtyValueToCompare = str_replace("cancun", "", $dirtyValueToCompare);
                    $dirtyValuetmp = str_replace("cancun", "", $dirtyValue);

                    
                    $dirtyValueToCompare = str_replace("playa del carmen", "", $dirtyValueToCompare);
                    $dirtyValuetmp = str_replace("playa del carmen", "", $dirtyValue);
                    $sim = similar_text($dirtyValuetmp, $dirtyValueToCompare, $perc);
                    if($perc >= 95){
                        $id1 = $idArray[$row1];
                        $newValue->addEqualField($realValueToCompare, $id1);
                        break;
                    }
                }
            }
                
            array_push($valuesArray, $newValue);
        }
        return view('compare', compact('valuesArray', 'idColName0', 'ColName0', 'idColName1', 'ColName1', 'idArray', 'realValueArray'));
    }



    
    
    function strip_stopwords($str = "", $stopwords = "")
    {
    
      // 1.) break string into words
      // [^-\w\'] matches characters, that are not [0-9a-zA-Z_-']
      // if input is unicode/utf-8, the u flag is needed: /pattern/u
      $words = preg_split('/[^-\w\']+/', $str, -1, PREG_SPLIT_NO_EMPTY);
    
      // 2.) if we have at least 2 words, remove stopwords
      if(count($words) > 1)
      {
        $words = array_filter($words, function ($w) use (&$stopwords) {
          return !isset($stopwords[strtolower($w)]);
          # if utf-8: mb_strtolower($w, "utf-8")
        });
      }
    
      // check if not too much was removed such as "the the" would return empty
      if(!empty($words))
        return implode(" ", $words);
      return $str;
    }
    
    function clean_strings_accents($string){
        $chars = array(
            'á' => 'a',
            'é' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ú' => 'u',
            'ñ' => 'n',
            "'" => '',
            '"' => '');
        $string = strtr($string, $chars);
        return $string;
    }
    
    function remove_accents($string) {
        if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;
    
        $chars = array(
        // Decompositions for Latin-1 Supplement
        chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
        chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
        chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
        chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
        chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
        chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
        chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
        chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
        chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
        chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
        chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
        chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
        chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
        chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
        chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
        chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
        chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
        chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
        chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
        chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
        chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
        chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
        chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
        chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
        chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
        chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
        chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
        chr(195).chr(191) => 'y',
        // Decompositions for Latin Extended-A
        chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
        chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
        chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
        chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
        chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
        chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
        chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
        chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
        chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
        chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
        chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
        chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
        chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
        chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
        chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
        chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
        chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
        chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
        chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
        chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
        chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
        chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
        chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
        chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
        chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
        chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
        chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
        chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
        chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
        chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
        chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
        chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
        chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
        chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
        chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
        chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
        chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
        chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
        chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
        chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
        chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
        chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
        chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
        chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
        chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
        chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
        chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
        chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
        chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
        chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
        chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
        chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
        chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
        chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
        chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
        chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
        chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
        chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
        chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
        chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
        chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
        chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
        chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
        chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
        );
    
        $string = strtr($string, $chars);
    
        return $string;
    }

}

