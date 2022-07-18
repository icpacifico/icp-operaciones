<?php
require "../../config.php";
require "../../class/conexion.php";
$conexion = new conexion();

$data = conexion::select("SELECT pro.id_pro,
                            pro.rut_pro,       
                            CONCAT(pro.nombre_pro,' ',pro.nombre2_pro,' ',pro.apellido_paterno_pro,' ',pro.apellido_materno_pro) AS cliente       
                            FROM   
                                cotizacion_cotizacion AS cot 		
                            INNER JOIN propietario_propietario AS pro ON cot.id_pro = pro.id_pro		
                            LEFT JOIN vendedor_vendedor AS vend ON vend.id_vend = cot.id_vend                            
                            WHERE vend.id_vend = 14 
                            ORDER BY  pro.id_pro				 	
                            LIMIT 0, 50");
// $data = conexion::select("SELECT * FROM vendedor_vendedor");
// $count = conexion::select("SELECT  count(*) AS conteo
// FROM   
// cotizacion_cotizacion AS cot 		
// INNER JOIN propietario_propietario AS pro ON cot.id_pro = pro.id_pro		
// LEFT JOIN vendedor_vendedor AS vend ON vend.id_vend = cot.id_vend

//  WHERE vend.id_vend = 14 	
//  ORDER BY  pro.id_pro
// LIMIT 0, 50");                            

$acum;
for ($i=0; $i < count($data); $i++) { 
    $acum[$i] = $data[$i];
}

// $output = array(
//     "draw"   => 1,
//     "recordsTotal"  => intval($count[0]['conteo']),
//     "recordsFiltered"  =>  intval($count[0]['conteo']),
//     "data" => $data
// );
var_dump(json_encode($acum));
// header('Content-Type: application/json');

// echo json_encode($output);
// {
//     "draw": 1,
//     "recordsTotal": 57,
//     "recordsFiltered": 57,
//     "data": [
//         [
//             "Angelica",
//             "Ramos",
//             "System Architect",
//             "London",
//             "9th Oct 09",
//             "$2,875"
//         ],
//         [
//             "Ashton",
//             "Cox",
//             "Technical Author",
//             "San Francisco",
//             "12th Jan 09",
//             "$4,800"
//         ],
//         ...
//     ]
// }