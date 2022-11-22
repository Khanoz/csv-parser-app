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
use App\Library\NewCsvValue;
use App\Library\DataToCompare;
echo "<br>";
?>

        <div class="container">
            <form id="form5" action="{{route('loadData')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf <!-- {{ csrf_field() }} -->
            <table class="table table-bordered table-striped" id="tablePag">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th><?php echo $idColName0; ?> </th>
                        <th><?php echo $ColName0; ?> </th>
                        <th><?php echo $idColName1; ?> </th>
                        <th><?php echo $ColName1;?> </th>
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
                                <input type="text" id="isAutoComplete<?php echo $i;?>" name="isAutoComplete" style="display: none;" value="0">
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
        <script src="js/compare.js"></script>

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
            let sortedNames = arrName;//.sort();
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
                document.getElementById("isAutoComplete"+inputIndex).value="1";
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
