

function isChecked(range){
    for(var i = 0; i < range; i ++){
        var input = document.getElementById(i+"input");

        var pId0 = document.getElementById("idFile0"+i).innerHTML;
        var pField0 = document.getElementById("fieldFile0"+i).innerHTML;
        var pId1 = document.getElementById("toCompareId"+i).innerHTML;
        var pField1 = document.getElementById("toCompare"+i).value;
        var isAutoComplete = document.getElementById("isAutoComplete"+i).value;

        if (pId1 != "" && !input.checked){
            input.checked = "checked";
        }
        if(pId1 == "" && input.checked){
            input.checked = "";
        } 

        input.value = pId0 + "|" + pField0 + "|" + pId1 + "|" + pField1 + "|" + isAutoComplete;
    }
    document.getElementById("form5").submit();
}