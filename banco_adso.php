
<?php

$banco_adso = [

["ID" => "1", "nombre" => "Willinton Mendoza", "numero_cuenta" => "12345", "saldo" => "100000", "password" => "2001"],
["ID" => "2", "nombre" => "Maryuris Linares", "numero_cuenta" => "123456", "saldo" => "90000", "password" => "2002"],
["ID" => "3", "nombre" => "Janeth Torres", "numero_cuenta" => "1234567", "saldo" => "60000", "password" => "2003"],
["ID" => "4", "nombre" => "Briand Camargo", "numero_cuenta" => "12345678", "saldo" => "50000", "password" => "2004"],
["ID" => "5", "nombre" => "Kimberly Rincones", "numero_cuenta" => "123456789", "saldo" => "70000", "password" => "2005"],

];

$usuario_encontrado = false;
$usuario_actual = null;
$posicion_actual = null;
$retiros = [];
$transferencias = [];

while (true){

echo ("INICIO DE SESION \n");

$user = readline("Ingrese su usuario: ");
$password = readline("Ingrese su contraseña: ");

foreach ($banco_adso as $posicion => $usuario){

        if($user == $usuario["numero_cuenta"] && $password == $usuario["password"]){

         $usuario_encontrado = true;
	     $usuario_actual = $usuario;
		 $posicion_actual = $posicion;
	    echo("Bienvenido " . $usuario["nombre"] . "\n");
		
	  break;
		}
}

if($usuario_encontrado == false){

	echo ("Numero de cuenta o contraseña incorrecto \n");
	echo ("\n");

}else{

while(true){

echo ("\n--- BANCO ADSO ---\n");
echo ("1. Consultar saldo\n");
echo ("2. Realizar retiro\n");
echo ("3. Realizar transferencia\n");
echo ("4. Consultar retiros\n");
echo ("5. Consultar transferencias\n");
echo ("6. Salir\n");

$opcion = readline("Seleccione una opción: ");

switch ($opcion) {

        case 1: echo ("Su saldo actual es: $" . $usuario_actual["saldo"] . "\n");
            break;

        case 2: while (true) {

				$retiro = readline("Ingrese el monto a retirar: ");
				$password = readline("ingrese su contraseña: ");

				if($password == $usuario_actual["password"]){
		
         		
			
				 if ($retiro <= 0) {

           			 echo ("El valor debe ser mayor que 0\n");
					 echo ("\n");

         		} elseif ($retiro > $usuario_actual["saldo"]) {

            		echo "No puede retirar un valor mayor al saldo actual\n";

         		} else {

            		$usuario_actual["saldo"] = $usuario_actual["saldo"] - $retiro;

					$retiros[] = [
    				"usuario" => $usuario_actual["nombre"],
   					"cuenta" => $usuario_actual["numero_cuenta"],
    				"valor" => $retiro,
    				"fecha" => date("Y-m-d H:i:s")];

            		echo "Retiro realizado exitosamente\n";
            		echo "Nuevo saldo: $" . $usuario_actual["saldo"] . "\n";
					echo ("\n");

            				break 2;
        		}
				}else{
					echo ("contraseña incorrecta \n");
					echo ("\n");
					
				}
    			}
				
        case 3: $password = readline("Ingrese su contraseña: ");

   			 if ($password == $usuario_actual["password"]) {

        		$numero_cuenta = readline("Ingrese el numero de cuenta a enviar: ");

        		$cuenta_encontrada = false;
        		$posicion_destino = null;

        foreach ($banco_adso as $posicion => $usuario) {

            if ($numero_cuenta == $usuario["numero_cuenta"]) {

                $cuenta_encontrada = true;
                $posicion_destino = $posicion;

                break;
            }
        }

        if ($cuenta_encontrada == false) {

            echo ("La cuenta destino no existe.\n");

        } elseif ($numero_cuenta == $usuario_actual["numero_cuenta"]) {

            echo ("No puedes transferir dinero a tu propia cuenta.\n");

        } else {

            $transferencia = readline("Ingrese el monto a transferir: ");

            if ($transferencia <= 0) {

                echo ("El valor debe ser mayor que 0.\n");

            } elseif ($transferencia > $usuario_actual["saldo"]) {

                echo ("No tiene suficiente saldo para realizar la transferencia.\n");

            } else {

                $usuario_actual["saldo"] = $usuario_actual["saldo"] - $transferencia;

                $banco_adso[$posicion_destino]["saldo"] = $banco_adso[$posicion_destino]["saldo"] + $transferencia;

				$transferencias[] = [
    			"cuenta_origen" => $usuario_actual["numero_cuenta"],
    			"cuenta_destino" => $numero_cuenta,
    			"valor" => $transferencia,
    			"fecha" => date("Y-m-d H:i:s")];

                echo ("Transferencia realizada exitosamente.\n");
                echo ("Monto transferido: $" . $transferencia . "\n");
                echo ("Nuevo saldo: $" . $usuario_actual["saldo"] . "\n");
            }
        }

    	} else {

        	echo ("Contraseña incorrecta.\n");
    	}

    		break;

        case 4:echo ("Consultar retiros\n");


			$cantidad_retiros = 0;
    		$total_retirado = 0;

    	foreach ($retiros as $retiro) {

        if ($retiro["cuenta"] == $usuario_actual["numero_cuenta"]) {

            $cantidad_retiros++;
            $total_retirado = $total_retirado + $retiro["valor"];

            echo ("Retiro #" . $cantidad_retiros . "\n");
            echo ("Valor retirado: $" . $retiro["valor"] . "\n");
            echo ("Fecha: " . $retiro["fecha"] . "\n");
            echo ("--------------------------\n");
        }
    }

    	echo ("Número total de retiros: " . $cantidad_retiros . "\n");
    	echo ("Valor total retirado: $" . $total_retirado . "\n");

    	break;

        case 5:echo ("Consultar transferencias\n");

			$cantidad_transferencias = 0;
    		$total_transferido = 0;

    foreach ($transferencias as $transferencia) {

        if ($transferencia["cuenta_origen"] == $usuario_actual["numero_cuenta"]) {

            $cantidad_transferencias++;

            $total_transferido = $total_transferido + $transferencia["valor"];

            echo ("Transferencia #" . $cantidad_transferencias . "\n");
            echo ("Cuenta destino: " . $transferencia["cuenta_destino"] . "\n");
            echo ("Valor transferido: $" . $transferencia["valor"] . "\n");
            echo ("Fecha: " . $transferencia["fecha"] . "\n");
            echo ("--------------------------\n");
        }
    }

    		echo ("Cantidad total de transferencias: " . $cantidad_transferencias . "\n");
    		echo ("Valor total transferido: $" . $total_transferido . "\n");

				break;

        case 6: echo ("Gracias por utilizar Banco ADSO\n");
            break 2;

        default: echo ("Opción incorrecta \n");
    }
  }
}  

}
?>
