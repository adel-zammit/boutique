<?php 

$data = "#06.17.21.10.03#";

$regex ="#0[0-9]\.?[0-9]{2}){4}#";


if(preg_match($regex,$data, $re))
{
    var_dump($re);
    echo "OK";
}
else{
    echo "KO";
}

// --quantifieur--
// [pP] cherche les caractère entre les parenthèses
// + cherche minimum 1 caractère jusqu'à l'infini
// (3) cherche les caractères répeté (*) fois ou de (*, *) tant a tant 
// Platefor(me){3} cherhce les caractère répèter (*){xFois}
//{A-Za-z} 
// #.*# touts les caractère autant de fois 
// | veux dire où
//^ Debut de phrase
//\.$ fin de chaine"
//$data = "Vive La Plateforme !!";

//$regex ="#[pP]la?teforme#";

?>