<?php
	require 'vendor/autoload.php';
	$productos = 'https://pract6-cecf9.firebaseio.com/productos.json';
	$respuestas = 'https://pract6-cecf9.firebaseio.com/respuestas.json';
	$detalles = 'https://pract6-cecf9.firebaseio.com/detalles.json';
	$usuarios = 'https://pract6-cecf9.firebaseio.com/usuarios.json';

	function getProd($user, $pass, $categoria) {
    	global $productos, $respuestas, $usuarios;
    	$categoria = strtolower($categoria);

    	$ch1 =  curl_init();
    	curl_setopt($ch1, CURLOPT_URL, $productos);
    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch1);

    	if( curl_errno($ch1) ) {
        	echo 'Error: '.curl_errno($ch1);
    	} else {
        	$p=json_decode($response1,true);
    	}
    	curl_close($ch1);

    	$ch2 =  curl_init();
    	curl_setopt($ch2, CURLOPT_URL, $respuestas);
    	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch2);

    	if( curl_errno($ch2) ) {
        	echo 'Error: '.curl_errno($ch2);
    	} else {
        	$r=json_decode($response1,true);
    	}
    	curl_close($ch2);

    	$ch3 =  curl_init();
    	curl_setopt($ch3, CURLOPT_URL, $usuarios);
    	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

    	$response2 = curl_exec($ch3);

    	if( curl_errno($ch3) ) {
        	echo 'Error: '.curl_errno($ch3);
    	} else {
        	$u=json_decode($response2,true);
    	}
    	curl_close($ch3);

    	$resp = array(
        	'code'    => 999,
        	'message' => $r[999],
        	'data'    => '',
        	'status'  => 'error'
    	);

    	if ( array_key_exists($user, $u) ) {
        	if ( $u[$user] === md5($pass) ) {
            	if ( array_key_exists($categoria, $p) ) {
                	$resp['code'] = 200;
                	$resp['message'] = $r[200];
                	$resp['status'] = 'success';
                	$resp['data'] = json_encode($p[$categoria], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            	}
            	else {
                	$resp['code'] = 300;
                	$resp['message'] = $r[300];
            	}
        	}
        	else {
            	$resp['code'] = 501;
            	$resp['message'] = $r[501];
        	}
    	}
    	else {
        	$resp['code'] = 500;
        	$resp['message'] = $r[500];
    	}

    	return $resp;
	}

	function getDetails($user, $pass, $isbn) {
    	global $detalles, $respuestas, $usuarios;

    	$ch1 =  curl_init();
    	curl_setopt($ch1, CURLOPT_URL, $detalles);
    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch1);

    	if( curl_errno($ch1) ) {
        	echo 'Error: '.curl_errno($ch1);
    	} else {
        	$d=json_decode($response1,true);
    	}
    	curl_close($ch1);

    	$ch2 =  curl_init();
    	curl_setopt($ch2, CURLOPT_URL, $respuestas);
    	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch2);

    	if( curl_errno($ch2) ) {
        	echo 'Error: '.curl_errno($ch2);
    	} else {
        	$r=json_decode($response1,true);
    	}
    	curl_close($ch2);

    	$ch3 =  curl_init();
    	curl_setopt($ch3, CURLOPT_URL, $usuarios);
    	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

    	$response2 = curl_exec($ch3);

    	if( curl_errno($ch3) ) {
        	echo 'Error: '.curl_errno($ch3);
    	} else {
        	$u=json_decode($response2,true);
    	}
    	curl_close($ch3);
        $resp = array(
            'code'    => 999,
            'message' => $r[999],
            'data'    => '',
            'status'  => 'error',
            'oferta'  => false
        );

        if ( array_key_exists($user, $u) ) {
            if ( $u[$user] === md5($pass) ) {
                if ( array_key_exists($isbn, $d) ) {
                    $resp['code'] = 201;
                    $resp['message'] = $r[201];
                    $resp['status'] = 'success';
                    $resp['data'] = json_encode($d[$isbn], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
                else {
                    $resp['code'] = 301;
                    $resp['message'] = $r[301];
                }
            }
            else {
                $resp['code'] = 501;
                $resp['message'] = $r[501];
            }
        }
        else {
            $resp['code'] = 500;
            $resp['message'] = $r[500];
        }

        return $resp;
    }

    function updatePassword($user, $pass, $newpass) {
    	global  $respuestas, $usuarios;

    	$ch1 =  curl_init();
    	curl_setopt($ch1, CURLOPT_URL, $usuarios);
    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

    	$response  = curl_exec($ch1);

    	if( curl_errno($ch1) ) {
        	echo 'Error: '.curl_errno($ch1);
    	} else {
        	$u=json_decode($response ,true);
    	}
    	curl_close($ch1);

    	$ch2 =  curl_init();
    	curl_setopt($ch2, CURLOPT_URL, $respuestas);
    	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch2);

    	if( curl_errno($ch2) ) {
        	echo 'Error: '.curl_errno($ch2);
    	} else {
        	$r=json_decode($response1,true);
    	}
    	curl_close($ch2);


    	$resp = array(
        	'code'    => 999,
        	'message' => $r[999],
        	'data'    => '',
        	'status'  => 'error'
    	);

    	if ( array_key_exists($user, $u) ) {
        	if ( $u[$user] === md5($pass) ) {
            	if ( preg_match('/^(?=.*\d)[0-9A-Za-z]{8,50}$/', $newpass) ) {
                	$ch =  curl_init();
                	curl_setopt($ch, CURLOPT_URL, 'https://pract6-cecf9.firebaseio.com/usuarios/'.$user.'.json');
                	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                	curl_setopt($ch, CURLOPT_POSTFIELDS, '"'.md5($newpass).'"');
                	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));

                	$response = curl_exec($ch);

                	$resp['code'] = 400;
                	$resp['message'] = $r[400];
                	$resp['status'] = 'success';
            	}
            	else {
                	$resp['code'] = 502;
                	$resp['message'] = $r[502];
            	}
        	}
        	else {
            	$resp['code'] = 501;
            	$resp['message'] = $r[501];
        	}
    	}
    	else {
        	$resp['code'] = 500;
        	$resp['message'] = $r[500];
    	}
    	return $resp;
	}

	function setProd($user, $pass, $prodJSON) {
    	global  $respuestas, $usuarios, $detalles;
    	$pcre_regex = ' / (?(DEFINE) (?<number> -? (?= [1-9]|0(?!\d) ) \d+ (\.\d+)? ([eE] [+-]? \d+)? ) (?<boolean> true | false | null ) (?<string> " ([^"\\\\]* | \\\\ ["\\\\bfnrt\/] | \\\\ u [0-9a-f]{4} )* " ) (?<array> \[ (?: (?&json) (?: , (?&json) )* )? \s* \] ) (?<pair> \s* (?&string) \s* : (?&json) ) (?<object> \{ (?: (?&pair) (?: , (?&pair) )* )? \s* \} ) (?<json> \s* (?: (?&number) | (?&boolean) | (?&string) | (?&array) | (?&object) ) \s* ) ) \A (?&json) \Z /six ';

    	$ch1 =  curl_init();
    	curl_setopt($ch1, CURLOPT_URL, $usuarios);
    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

    	$response  = curl_exec($ch1);

    	if( curl_errno($ch1) ) {
        	echo 'Error: '.curl_errno($ch1);
    	} else {
        	$u=json_decode($response ,true);
    	}
    	curl_close($ch1);

    	$ch2 =  curl_init();
    	curl_setopt($ch2, CURLOPT_URL, $respuestas);
    	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch2);

    	if( curl_errno($ch2) ) {
        	echo 'Error: '.curl_errno($ch2);
    	} else {
        	$r=json_decode($response1,true);
    	}

    	curl_close($ch2);

    	$ch3 =  curl_init();
    	curl_setopt($ch3, CURLOPT_URL, $detalles);
    	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

    	$response2 = curl_exec($ch3);

    	if( curl_errno($ch3) ) {
        	echo 'Error: '.curl_errno($ch3);
    	} else {
        	$d=json_decode($response2,true);
    	}

    	curl_close($ch3);

    	$resp = array(
        	'code'    => 999,
        	'message' => $r[999],
        	'data'    => '',
        	'status'  => 'error'
    	);

    	if ( array_key_exists($user, $u) ) {
        	if ( $u[$user] === md5($pass) ) {
            	if ( preg_match( $pcre_regex , $prodJSON) ) {
                	$de = json_decode($prodJSON,true);
                	if(array_key_exists(key($de), $d))
                	{
                    	$resp['code'] = 302;
                    	$resp['message'] = $r[302];
                	} else {
                    	$url1 = 'https://pract6-cecf9.firebaseio.com/detalles.json';
                    	$ch1 =  curl_init();
                    	curl_setopt($ch1, CURLOPT_URL, $url1);
                    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                    	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
                    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
                    	curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'PATCH');
                    	curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($de, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    	curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
                    	$response2 = curl_exec($ch1);
                    	$resp['code'] = 202;
                    	$resp['message'] = $r[202];
                    	$resp['status'] = 'success';
                    	$date = date_create();
                    	$cadena_fecha_actual = date_format($date, 'Y-m-d H:i:s');
                    	$resp['data'] = $cadena_fecha_actual;
                	}
            	}
            	else {
                	$resp['code'] = 305;
                	$resp['message'] = $r[305];
            	}
        	}
        	else {
            	$resp['code'] = 501;
            	$resp['message'] = $r[501];
        	}
    	}
    	else {
        	$resp['code'] = 500;
        	$resp['message'] = $r[500];
    	}
    	return $resp;
	}

	function updateProd($user, $pass, $prodJSON) {
    	global  $respuestas, $usuarios, $detalles;
    	$pcre_regex = ' / (?(DEFINE) (?<number> -? (?= [1-9]|0(?!\d) ) \d+ (\.\d+)? ([eE] [+-]? \d+)? ) (?<boolean> true | false | null ) (?<string> " ([^"\\\\]* | \\\\ ["\\\\bfnrt\/] | \\\\ u [0-9a-f]{4} )* " ) (?<array> \[ (?: (?&json) (?: , (?&json) )* )? \s* \] ) (?<pair> \s* (?&string) \s* : (?&json) ) (?<object> \{ (?: (?&pair) (?: , (?&pair) )* )? \s* \} ) (?<json> \s* (?: (?&number) | (?&boolean) | (?&string) | (?&array) | (?&object) ) \s* ) ) \A (?&json) \Z /six ';

    	$ch1 =  curl_init();
    	curl_setopt($ch1, CURLOPT_URL, $usuarios);
    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

    	$response  = curl_exec($ch1);

    	if( curl_errno($ch1) ) {
        	echo 'Error: '.curl_errno($ch1);
    	} else {
        	$u=json_decode($response ,true);
    	}
    	curl_close($ch1);

    	$ch2 =  curl_init();
    	curl_setopt($ch2, CURLOPT_URL, $respuestas);
    	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch2);

    	if( curl_errno($ch2) ) {
        	echo 'Error: '.curl_errno($ch2);
    	} else {
        	$r=json_decode($response1,true);
    	}
    	curl_close($ch2);


    	$ch3 =  curl_init();
    	curl_setopt($ch3, CURLOPT_URL, $detalles);
    	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

    	$response2 = curl_exec($ch3);

    	if( curl_errno($ch3) ) {
        	echo 'Error: '.curl_errno($ch3);
    	} else {
        	$d=json_decode($response2,true);
    	}

    	curl_close($ch3);

    	$resp = array(
        	'code'    => 999,
        	'message' => $r[999],
        	'data'    => '',
        	'status'  => 'error'
    	);

    	if ( array_key_exists($user, $u) ) {
        	if ( $u[$user] === md5($pass) ) {
            	if ( preg_match( $pcre_regex , $prodJSON) ) {
                	$de = json_decode($prodJSON,true);
                	if(strpos($prodJSON, 'Autor') == true || strpos($prodJSON, 'Año') == true ||strpos($prodJSON, 'Editorial') == true ||strpos($prodJSON, 'ISBN') == true ||strpos($prodJSON, 'Nombre') == true ||strpos($prodJSON, 'Precio') == true)
                	{
                    	if(array_key_exists(key($de), $d))
                    	{
                        	$url1 = 'https://pract6-cecf9.firebaseio.com/detalles.json';
                        	$ch1 =  curl_init();
                        	curl_setopt($ch1, CURLOPT_URL, $url1);
                        	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                        	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
                        	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
                        	curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'PATCH');
                        	curl_setopt($ch1, CURLOPT_POSTFIELDS, json_encode($de, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                        	curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
                        	$response2 = curl_exec($ch1);
                        	$resp['code'] = 203;
                        	$resp['message'] = $r[203];
                        	$resp['status'] = 'success';
                        	$date = date_create();
                        	$cadena_fecha_actual = date_format($date, 'Y-m-d H:i:s');
                        	$resp['data'] = $cadena_fecha_actual;

                    	} else {
                        	$resp['code'] = 303;
                        	$resp['message'] = $r[303];
                    	}
                	} else {
                    	$resp['code'] = 304;
                    	$resp['message'] = $r[304];
                	}
            	} else {
                	$resp['code'] = 305;
                	$resp['message'] = $r[305];
            	}
        	} else {
            	$resp['code'] = 501;
            	$resp['message'] = $r[501];
        	}
    	} else {
        	$resp['code'] = 500;
        	$resp['message'] = $r[500];
    	}
    	return $resp;
	}

	function deleteProd($user, $pass, $isbn) {
    	global  $respuestas, $usuarios, $detalles;

    	$ch1 =  curl_init();
    	curl_setopt($ch1, CURLOPT_URL, $usuarios);
    	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);

    	$response  = curl_exec($ch1);

    	if( curl_errno($ch1) ) {
        	echo 'Error: '.curl_errno($ch1);
    	} else {
        	$u=json_decode($response ,true);
    	}
    	curl_close($ch1);

    	$ch2 =  curl_init();
    	curl_setopt($ch2, CURLOPT_URL, $respuestas);
    	curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);

    	$response1 = curl_exec($ch2);

    	if( curl_errno($ch2) ) {
        	echo 'Error: '.curl_errno($ch2);
    	} else {
        	$r=json_decode($response1,true);
    	}
    	curl_close($ch2);


    	$ch3 =  curl_init();
    	curl_setopt($ch3, CURLOPT_URL, $detalles);
    	curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
    	curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);

    	$response2 = curl_exec($ch3);

    	if( curl_errno($ch3) ) {
        	echo 'Error: '.curl_errno($ch3);
    	} else {
        	$d=json_decode($response2,true);
    	}
    	curl_close($ch3);

    	$resp = array(
        	'code'    => 999,
        	'message' => $r[999],
        	'data'    => '',
        	'status'  => 'error'
    	);

    	if ( array_key_exists($user, $u) ) {
        	if ( $u[$user] === md5($pass) ) {
            	if(array_key_exists($isbn, $d)) {
                	$url1 = 'https://pract6-cecf9.firebaseio.com/detalles/'. $isbn.'.json';
                	$ch1 =  curl_init();

                	curl_setopt($ch1, CURLOPT_URL, $url1);
                	curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                	curl_setopt($ch1, CURLOPT_FOLLOWLOCATION, true);
                	curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, false);
                	curl_setopt($ch1, CURLOPT_CUSTOMREQUEST, 'DELETE');

                	$response2 = curl_exec($ch1);

                	$resp['code'] = 204;
                	$resp['message'] = $r[204];
                	$resp['status'] = 'success';

                	$date = date_create();
                	$cadena_fecha_actual = date_format($date, 'Y-m-d H:i:s');
                	$resp['data'] = $cadena_fecha_actual;
            	} else {
                	$resp['code'] = 303;
                	$resp['message'] = $r[303];
            	}
        	} else {
            	$resp['code'] = 501;
            	$resp['message'] = $r[501];
        	}
    	} else {
        	$resp['code'] = 500;
        	$resp['message'] = $r[500];
    	}
    	return $resp;
	}

	$app = new Slim\App();

	$app->get('/',function ($request,$response,$args) {
    	$response->write("Hola mundo!");
    	return $response;
	});

	$app->get("/hola/{nombre}",function($request, $response, $args){
    	$response->write("hola, ". $args["nombre"]);
    	return $response;
	});

	$app->post("/pruebapost",function($request, $response, $args){
    	$reqPost = $request->getParsedBody();
    	$val1 = $reqPost["val1"];
    	$val2 = $reqPost["val2"];
    	$response->write("Valores: ". $val1 . " ". $val2);
    	return $response;
	});

	$app->get("/testjson", function( $request, $response, $args ){
    	$data[0]["nombre"]="Kebyn Cristopher";
    	$data[0]["apellidos"]="Martínez Vásquez";
    	$data[1]["nombre"]="Monica";
    	$data[1]["apellidos"]="Portillo Sánchez";
    	$response->write(json_encode($data, JSON_PRETTY_PRINT));
    	return $response;
	});

	$app->get("/getProd/{user}&{pass}&{categoria}",function($request, $response, $args){
    	$user= $args["user"];
    	$pass = $args["pass"];
    	$categoria = $args["categoria"];
    	$response-> write (json_encode(getProd($user, $pass, $categoria), JSON_PRETTY_PRINT));
    	return $response;
	});

	$app->get("/getDetails/{user}&{pass}&{isbn}",function($request, $response, $args){
    	$user = $args["user"];
    	$pass = $args["pass"];
    	$isbn = $args["isbn"];
    	$response->write( json_encode(getDetails($user, $pass, $isbn),JSON_PRETTY_PRINT));
    	return $response;
	});

	$app->put("/updatePassword/{user}&{pass}&{newPass}",function($request, $response, $args){
    	$user = $args["user"];
    	$pass = $args["pass"];
    	$newPass = $args["newPass"];
    	$response->write( json_encode(updatePassword($user, $pass, $newPass),JSON_PRETTY_PRINT));
    	return $response;
	});

	$app->post("/setProd",function($request, $response, $args){
    	$reqPost = $request->getParsedBody();
    	$user = $reqPost["user"];
    	$pass = $reqPost["pass"];
    	$prodJSON = $reqPost["prodJSON"];
    	$response->write( json_encode(setProd($user, $pass, $prodJSON),JSON_PRETTY_PRINT));
    	return $response;
	});

	$app->put("/updateProd/{user}&{pass}&{prodJSON}",function($request, $response, $args){
    	$user = $args["user"];
    	$pass = $args["pass"];
    	$prodJSON = $args["prodJSON"];
    	$response->write( json_encode(updateProd($user, $pass, $prodJSON),JSON_PRETTY_PRINT));
    	return $response;
	});

	$app->delete("/deleteProd/{user}&{pass}&{isbn}",function($request, $response, $args){
    	$user = $args["user"];
    	$pass = $args["pass"];
    	$isbn = $args["isbn"];
    	$response->write( json_encode(deleteProd($user, $pass, $isbn),JSON_PRETTY_PRINT));
    	return $response;
	});

	$app->run();
?>