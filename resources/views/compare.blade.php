<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/compare.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    </head>
    <body>
<?php
        /*<div class="loader"></div>

flush();*/
Class DataToCompare{
    public $real;
    public $dirty;

    public function __construct($r, $d){
        $this->real = $r;
        $this->dirty = $d;
    }
}
Class NewCsvValue{
    public $file0Field;
    public $file1Field;
    public $idFile0;
    public $idFile1;
    public $isValid;
    public $time;

    public function __construct($file0Field, $Id0){
        $this->file0Field = $file0Field;
        $this->idFile0 = $Id0;
        $this->file1Field = "";
        $this->idFile1 = "";
        $this->isValid = False;
        $this->time = date("Y-m-d h:i:sa");
    }

    public function addEqualField($file1Field, $Id1){
        $this->file1Field = $file1Field;
        $this->idFile1 = $Id1;
        $this->isValid = True;
        $this->time = date("Y-m-d h:i:sa");
    }
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


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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
$file0Name = $_POST['fileName0'];
$file1Name = $_POST['fileName1'];
$file0Column = $_POST['file0'];
$file1Column = $_POST['file1'];
$file0ColumnToLink = $_POST['columnLink0'];
$file1ColumnToLink = $_POST['columnLink1'];

$col0 = chr($file0Column + 65);
$col1 = chr($file1Column + 65);
$linkCol0 = chr($file0ColumnToLink + 65);
$linkCol1 = chr($file1ColumnToLink + 65);



$path1 = "uploads/".$file1Name;
$reader1 = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Csv"); //new ReaderXlsx();
$spreadsheet1 = $reader1 -> load($path1);
$sheet1 = $spreadsheet1 -> getActiveSheet();

$worksheetInfo1 = $reader1 -> listWorksheetInfo($path1);
$totalRows1 = $worksheetInfo1[0]['totalRows'];

$path0 = "uploads/".$file0Name;
$reader0 = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Csv"); //new ReaderXlsx();
$spreadsheet0 = $reader0 -> load($path0);
$sheet0 = $spreadsheet0 ->  getActiveSheet();

$worksheetInfo0 = $reader0 -> listWorksheetInfo($path0);
$totalRows0 = $worksheetInfo0[0]['totalRows'];

//Get data to compare first:

$dataToCompareArray = array();
$realValueArray = array();
$idArray = array();
for($j = 2; $j <= $totalRows1; $j++){
    $realValueToCompare = $sheet1->getCell("{$col1}{$j}")->getValue();
    $realValueToCompare = clean_strings_accents($realValueToCompare);
    $realValueToCompare = utf8_decode($realValueToCompare);
    $realValueToCompare = remove_accents($realValueToCompare);
    array_push($realValueArray, $realValueToCompare);

    $dirtyValueToCompare = strtolower($realValueToCompare);
    $value = new DataToCompare($realValueToCompare, $dirtyValueToCompare);
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
    $realValue = clean_strings_accents($realValue);
    $realValue = utf8_decode($realValue);
    $realValue = remove_accents($realValue);
    
    $dirtyValue = strtolower($realValue);
    $dirtyValue = strip_stopwords($dirtyValue, $replaceCharacters);

    $id0 = $sheet1->getCell("{$linkCol0}{$row0}")->getValue();
    $newValue = new NewCsvValue($realValue, $id0);
    for($row1 = $range; $row1 < count($dataToCompareArray); $row1++){
        $realValueToCompare = $dataToCompareArray[$row1]->real;
        $dirtyValueToCompare = $dataToCompareArray[$row1]->dirty;
        $dirtyValueToCompare = strip_stopwords($dirtyValueToCompare, $replaceCharacters);

        $sim = similar_text($dirtyValue, $dirtyValueToCompare, $perc);
        if($perc >= 95){
            $range = $row1 - 50;
            if($range < 0){
                $range = 0;
            } 
            $id1 = $sheet1->getCell("{$linkCol1}{$row1}")->getValue();
            $newValue->addEqualField($realValueToCompare, $id1);
            break;
            }
        }
    array_push($valuesArray, $newValue);
}


?>

        <div class="container">
            <form id="form5" action="{{route('testcsv')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf <!-- {{ csrf_field() }} -->
            <table class="table table-bordered table-striped" id="tablePag">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th><?php echo $sheet1->getCell("{$linkCol0}1")->getValue(); ?> </th>
                        <th><?php echo $sheet1->getCell("{$col0}1")->getValue(); ?> </th>
                        <th><?php echo $sheet1->getCell("{$linkCol1}1")->getValue(); ?> </th>
                        <th><?php echo $sheet1->getCell("{$col1}1")->getValue(); ?> </th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php 
                    for($i = 0;$i < count($valuesArray); $i++){
                        echo "<tr>";
                            ?>
                            <td>
                                <p id=<?php echo "i".$i; ?>><?php echo $i ?></p>
                            </td>
                            
                            <td>
                                <p id=<?php echo "idFile0".$i; ?>><?php echo $valuesArray[$i]->idFile0 ?></p>
                            </td>

                            <td>
                                <p id=<?php echo "fieldFile0".$i; ?>><?php echo $valuesArray[$i]->file0Field ?></p>
                            </td>

                            <td>
                                <p id=<?php echo "toCompareId".$i; ?>><?php echo $valuesArray[$i]->idFile1 ?></p>
                            </td>
                            <td>
                                <input type="text" name="toCompare" id=<?php echo "toCompare".$i; ?> class="ui-widget" value="<?php echo $valuesArray[$i]->file1Field ?>" placeholder="..."/>
                                <ul class="list<?php echo $i; ?>"></ul>
                            </td>
                            <td>
                                <p id=<?php echo "time".$i; ?>><?php echo $valuesArray[$i]->time ?></p>
                            </td>
                            <?php
                            $data = $valuesArray[$i]->idFile0 . '|' . $valuesArray[$i]->file0Field . '|' . $valuesArray[$i]->idFile1 . '|' . $valuesArray[$i]->file1Field;
                            echo "<td>" . "<input id='" . $i . "input' name='inputTest[]' class='form-check-input' type='checkbox' value='". $data . "'";
                            if($valuesArray[$i]->isValid == True){
                                echo " checked";
                            }
                            echo "></td>";
                            ?>
                            <?php
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            
            
            
            </form>
            <button type="buton" onclick="isChecked(<?php echo count($valuesArray); ?>)" name="databtn">Guardar cambios</button>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
        <script>
            /*$(document).ready(function() {
                $('#tablePag').DataTable();
            });*/
        </script>
        <script src="js/compare.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <script type="text/javascript">
            

            class InputName{
                constructor(id, element, index){
                    this.id = id;
                    this.element = element;
                    this.index = index;
                }
            }

            let arrId = 
                <?php echo '["' . implode('", "', $idArray) . '"]' ?>;
            let arrName = 
                <?php echo '["' . implode('", "', $realValueArray) . '"]' ?>;
            let iterations = 
                <?php echo count($valuesArray)?>;

            let sortedNames = arrName.sort();
            //reference
            let inputArray = [];
            for(var it = 0; it < iterations; it++){
                    let input = new InputName(document.getElementById("toCompareId"+it), document.getElementById("toCompare"+it), it);
                    inputArray[it] = input;
                    //Execute function on keyup
                    
                    input.element.addEventListener("keyup", (e) => {
                        removeElements();
                        if( (input.element.value === "" || input.element.value === null) && input.id.value != ""){
                            input.id.innerHTML = "";
                        }
                        if( input.element.value.length < 3){
                            return;
                        }
                        //loop through above array
                        //Initially remove all elements ( so if user erases a letter or adds new letter then clean previous outputs)
                        
                        for (var i = 0; i < sortedNames.length; i++) {
                            //convert input to lowercase and compare with each string
                            var lw = sortedNames[i].toLowerCase();
                            if (
                            lw.includes(input.element.value.toLowerCase()) &&
                            input.element.value != ""
                            ) {
                            //create li element
                            let listItem = document.createElement("li");
                            //One common class name
                            listItem.classList.add("list-items");
                            listItem.style.cursor = "pointer";
                            listItem.setAttribute("onclick", "displayNames('" + sortedNames[i] + "', " + input.index + ", " + i + ")");
                            //Display matched part in bold
                            let word = sortedNames[i].substr(0, input.element.value.length);
                            word += sortedNames[i].substr(input.element.value.length);
                            //display the value in array
                            listItem.innerHTML = word;
                            document.querySelector(".list"+input.index).appendChild(listItem);
                            }
                        }
                    });
                }
            function displayNames(value, inputIndex, arrayIndex) {
                //input.element.value = value;
                var input = inputArray[inputIndex];
                input.element.value = value;
                id = arrId[arrayIndex];
                input.id.innerHTML = id;
                removeElements();
            }
            function removeElements() {
                //clear all the item
                let items = document.querySelectorAll(".list-items");
                items.forEach((item) => {
                    item.remove();
                });
            }
        </script>
    </body>
    <?php
    //session(['data2' => $valuesArray]);
    //$_SESSION['data'] = $valuesArray;
    unset($reader1);
    unset($spreadsheet1);
    unset($sheet1);
    unset($worksheetInfo1);


    unset($reader0);
    unset($spreadsheet0);
    unset($sheet0);
    unset($worksheetInfo0);
    ?>
</html>
