<?php 
session_start();
include '../core/functions.php';
include '../core/validations.php';
 $errors=[];

// echo '<pre>';
// print_r($_SERVER);

// echo '</pre>';

if( checkRequestMethod("POST") &&  checkPostInput('name')){
//  echo '<pre>';
//     var_dump($_POST);
// echo '</pre>';
  
foreach($_POST as $key=> $value){
    $$key = sanitizeInput($value);
}

// if we need to show date we input it we should uncomment this line 
// $name =sanitizeInput($_POST['name']);
// $email =sanitizeInput($_POST['email']);
// $password =sanitizeInput($_POST['password']);
// echo $name ;
// echo "<br>";
// echo $email;

//name validation 
if(!requiredVal($name)){
    $errors[]= "name is required";
}elseif(!minVal($name,3)){
    $errors[]= "name must greater than 3";
}elseif(!maxVal( $name,20)){
    $errors[]= "name must be less than 20";
} 
//email validation
if(!requiredVal($email)){
    $errors[]= "email is required";
}elseif(!emailVal($email)){
    $errors[]= "type a valide email";
}
 //password validation 
if(!requiredVal($password)){
    $errors[]= "pass is required";
}elseif(!minVal($password,6)){
    $errors[]= "pass must greater than 6";
}elseif(!maxVal( $password,20)){
    $errors[]= "pass must be less than 20";
} 


 if(empty($errors)){
    $users_file=fopen("../data/users.csv","a+");
    $data=[$name,$email,sha1($password)];
    fputcsv($users_file,$data);
    //redirect
    $_SESSION['auth'] = [
        'name' => $name,
        'email' => $email
    ];
    // $_SESSION['auth'] = [
    //     'name' => $name,
    //     'email' => $email
    // ];
    
    redirect("../index.php");

 }else{
    $_SESSION['errors']=$errors;
   redirect("../register.php");
 } 
echo "<br>";
 var_dump($errors); 

}else{
    echo "not support method";
} 