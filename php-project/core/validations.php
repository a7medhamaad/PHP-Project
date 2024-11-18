 <?php
 function requiredVal($input){
    if(empty($input)){
        return false;
    }else{
        return true;
    }
 }

 function  minVal($input,$length){
    if(strlen($input)<$length){
        return false;
    }else{
        return true;
    }
}


function  maxVal($input,$length){
    if(strlen($input)>=$length){
        return false;
    }else{
        return true;
    }
}

function emailVal($email){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        return true;
    }else {
        return false;
    }
}