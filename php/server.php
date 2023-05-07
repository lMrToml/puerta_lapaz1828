<?php
    $dir = __DIR__;

    $sound = "new_area.mp3";
    if (count($argv) > 1)
    {
        for ($i=1; $i < count($argv); $i++)
        { 
            $partes = explode("=", $argv[$i]);
            if ($partes[0] == "sound")
            {
                $sound = $partes[1];
            }
        }
    }

    // Crea un socket del servidor en el puerto 9875
    $server_socket = socket_create(AF_INET, SOCK_STREAM, 0);
    try {
        if (!socket_bind($server_socket, '0.0.0.0', 9875)) {
            throw new Exception('No se pudo unir el socket al puerto');
        }
        socket_listen($server_socket);
        echo "Server open in 9875\n";
        while (true)
        {
            // Espera a que se conecte un cliente
            $client_socket = socket_accept($server_socket);

            // Ejecuta el comando de Linux
            exec("mpg321 $dir../sonidos/$sound");

            // Cierra la conexión
            socket_close($client_socket);
        }
        socket_close($server_socket);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
?>

