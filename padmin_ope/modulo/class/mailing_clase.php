<?php
require "../../config.php";
include("../../class/conexion.php");
require '../../class/phpmailer/class.phpmailer.php';
date_default_timezone_set('America/Santiago');

class mailing
{
	private $id_lis;
	private $nombre_lis;

	function __construct(){
		
	}



	public function recupera_id(){
		$conexion = new conexion();
		$consulta="SELECT id_lis FROM lista_lista ORDER BY id_lis DESC LIMIT 0,1";
		$conexion->consulta($consulta);
		$fila = $conexion->extraer_registro_unico();
		$id = $fila['id_lis'];
		$conexion->cerrar();
		return $id;
    }

    public function recupera_id_campana(){
		$conexion = new conexion();
		$consulta="SELECT id_cam FROM campania_campania ORDER BY id_cam DESC LIMIT 0,1";
		$conexion->consulta($consulta);
		$fila = $conexion->extraer_registro_unico();
		$id = $fila['id_cam'];
		$conexion->cerrar();
		return $id;
    }

    public function recupera_titulo_campana($codigo){
		$conexion = new conexion();
		$consulta="SELECT titulo_cam_pla FROM campana_plantilla_campana WHERE codigo_cam_pla = ? AND id_est_cam_pla = 1";
		$conexion->consulta_form($consulta,array($codigo));
		$fila = $conexion->extraer_registro_unico();
		$titulo_cam_pla = $fila['titulo_cam_pla'];
		$conexion->cerrar();
		return $titulo_cam_pla;
    }

    public function recupera_email_vendedor($id){
		$conexion = new conexion();
		$consulta = "SELECT correo_vend FROM vendedor_vendedor WHERE id_usu = ?";
		$conexion->consulta_form($consulta,array($id));
		$fila = $conexion->extraer_registro_unico();
		$correo_vend = utf8_decode($fila["correo_vend"]);		
		$conexion->cerrar();
		return $correo_vend;
    }

    public function recupera_nombre_vendedor($id){
		$conexion = new conexion();
		$consulta = "SELECT nombre_vend, apellido_paterno_vend FROM vendedor_vendedor WHERE id_usu = ?";
		$conexion->consulta_form($consulta,array($id));
		$fila = $conexion->extraer_registro_unico();
		$nombre_vend = utf8_decode($fila["nombre_vend"]." ".$fila["apellido_paterno_vend"]);		
		$conexion->cerrar();
		return $nombre_vend;
    }


    public function calcula_cantidad_mensual_mails($cant_a_enviar){
    	$mes_actual = date("n");
    	$anio_actual = date("Y");
		$conexion = new conexion();
		$consulta = "SELECT SUM(cantidad_cam) AS cant_enviados FROM campania_campania WHERE MONTH(fecha_cam)=".$mes_actual." AND YEAR(fecha_cam) = ".$anio_actual."";
		$conexion->consulta($consulta);
		$fila = $conexion->extraer_registro_unico();
		$cantidad_enviados_mes = $fila["cant_enviados"];
		
		// busca parámetro cantidad
		$consulta = "SELECT valor_par FROM parametro_parametro WHERE id_par = 109";
		$conexion->consulta($consulta);
		$fila = $conexion->extraer_registro_unico();
		$tope_mensual = $fila["valor_par"];
		$conexion->cerrar();
		// calcula
		$total_envios = $cantidad_enviados_mes + $cant_a_enviar;
		if($total_envios > $tope_mensual) {
			return $total_envios;
		} else {
			return 1;
		}
		
    }


    public function mailing_insert_campana($id_usu,$fecha,$asunto,$enlace_imagen,$titulo_plantilla,$cantidad,$ids){
        $conexion = new conexion();

        $contador = 0;

        $cantidad_total_enviados = 0;

        while($contador <= $cantidad ){
        	$consulta = "SELECT correo_cor_lis FROM lista_correo_lista WHERE id_lis = ?";
        	$conexion->consulta_form($consulta,array($ids[$contador]));
        	$cant_lista = $conexion->total();
        	$cantidad_total_enviados = $cantidad_total_enviados + $cant_lista;
        	$contador++;
        }

        
        $consulta = "INSERT INTO campania_campania VALUES(?,?,?,?,?,?,?)";
		$conexion->consulta_form($consulta,array(0,$id_usu,$fecha,$asunto,$enlace_imagen,$titulo_plantilla,$cantidad_total_enviados));
		$conexion->cerrar();
    }


    public function verifica_envio_repetido($id_usu,$fecha,$asunto,$enlace,$plantilla_cam,$cantidad,$id_emp){
    	$conexion = new conexion();
    	$consulta = "SELECT id_cam FROM campania_campania ORDER BY id_cam DESC LIMIT 0,1";
		$conexion->consulta($consulta);
		$fila = $conexion->extraer_registro_unico();
		$id_cam = $fila["id_cam"];

		$fecha_dia = date("Y-m-d",strtotime($fecha));

		if ($id_cam<>'') {
			$consulta = "
        		SELECT 
        			cam.id_cam 
        		FROM
        			campania_campania AS cam,
        			campania_lista_campania AS cam_lis
        		WHERE
        			cam.id_usu = ".$id_usu." AND
        			cam.asunto_cam = '".$asunto."' AND
        			DATE(cam.fecha_cam) = '".$fecha_dia."' AND 
        			cam.cantidad_cam = ".$cantidad." AND
        			cam_lis.id_cam = ".$id_cam." AND 
        			cam_lis.id_lis IN (".$id_emp.")";
			$conexion->consulta($consulta);
			$existe_anterior = $conexion->total();
		}

        
		return $existe_anterior;
    }



    public function mailing_insert_envio_masivo($id_cam,$id_emp,$cantidad,$asunto,$enlace,$plantilla_cam,$nombre_vend,$email_vend,$id_usu,$fecha,$descripcion){
        $conexion = new conexion();

		// die("--->".$consulta." - ".$existe_anterior);

        function contains($needle, $haystack) {
		    return strpos($haystack, $needle) !== false;
		}

        $contador = 0;
		

        $contador_errores = 0;

        while($contador <= $cantidad ){
   //      	$consulta = "INSERT INTO campana_destinatario_campana VALUES(?,?,?)";
			// $conexion->consulta_form($consulta,array(0,$id_emp[$contador],$id_cam));

	  //       $consulta = "INSERT INTO propietario_observacion_propietario VALUES(?,?,?,?,?)";
			// $conexion->consulta_form($consulta,array(0,$id_emp[$contador],$id_usu,$fecha,$descripcion));
			$array_to = '[';

			$consulta = "SELECT correo_cor_lis FROM lista_correo_lista WHERE id_lis = ?";
			$conexion->consulta_form($consulta,array($id_emp[$contador]));
			$fila_consulta = $conexion->extraer_registro();
            if(is_array($fila_consulta)){
                foreach ($fila_consulta as $fila) {
                	$email1 = utf8_decode($fila["correo_cor_lis"]);
					$email1 = str_replace(" ","", $email1);
					$email1 = str_replace("\t","", $email1);
					$email1 = str_replace("?","", $email1);
					$email1 = strtolower($email1);
					$email1 = trim($email1);
					if ($email1<>'') {
						if (filter_var($email1, FILTER_VALIDATE_EMAIL)) {
							if (contains($email1, $array_to)) {
								# no hace nada
							} else {
								$array_to .= '{"email": "'.$email1.'"},';
								// $array_to .= '{"email": "brunomailcasa@gmail.com"},';
							}
					// $array_to .= '{"email": "'.$email1.'", "name": "'.$nombre_pro.'"},';
						}
					}
                }
            }

            // aquí debe hacer el envío de cada lista
            $array_to = substr($array_to, 0, -1);

        	$array_to .= ']';

        	$asunto_codificado = utf8_encode($asunto);
		
			// enviar el mail
			$curl = curl_init();

			$email_from_masivo = "sociales@icpacifico.cl";
			$nombre_from_masivo = "Costanera Pacífico";

			$reply_to_masivo = "contactoventas@icpacifico.cl";

			$fields = '{
			  "personalizations": [
			    {
			      "to": [{"email": "'.$email_vend.'", "name": "'.$nombre_vend.'"}],
			      "bcc": '.$array_to.',
			      "dynamic_template_data": {
			        "subject": "'.$asunto_codificado.'",
			        "link_image": "'.$enlace.'"
			      },
			      "subject": "'.$asunto_codificado.'"
			    }
			  ],
			  "from": {
			    "email": "'.$email_from_masivo.'",
			    "name": "'.$nombre_from_masivo.'"
			  },
			  "reply_to": {
			    "email": "'.$reply_to_masivo.'",
			    "name": "Costanera Pacífico"
			  },
			  "asm":{
			        "group_id":15609
			  },
			  "template_id": "'.$plantilla_cam.'"
			}';

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $fields,
			  CURLOPT_HTTPHEADER => array(
			    "authorization: Bearer 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",
			    "content-type: application/json"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			  // echo "---------cURL Error #:" . $err;
				// $conexion->cerrar();
			  	// return "error:" . $err;
			} else {
				
				if ($response<> '') {
					// $consulta = "DELETE FROM campania_campania WHERE id_cam = ?";
					// $conexion->consulta_form($consulta,array($id_cam));
					// return "3>" . $response;
					$contador_errores++;
				} else {
					// aca hace la inserción de la campañas
					// $today = date("Y-m-d");
					$consulta = "INSERT INTO campania_lista_campania VALUES(?,?,?)";
					$conexion->consulta_form($consulta,array(0,$id_emp[$contador],$id_cam));

			  //       $conexion->cerrar();
					// return "1>" . $response;
				}
			}

            $contador++;
			// $nombre_pro = utf8_decode(trim($fila["nombre_pro"])." ".trim($fila["apellido_paterno_pro"]));		
			
        }

        if($contador_errores==0){
        	$conexion->cerrar();
			return "1>" . $response;
        } else {
        	$conexion->cerrar();
        	return "3>" . $response;
        }
    }
}
?>