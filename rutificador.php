<pre><?php 

/**
 * FUNCION `FORMATO_RUT`
 * Esta función da formato al rut añadiendo puntos o guión
 * rut: debe ser en formato 11222333-4 o 112223334
 **/
function formato_rut($rut){

    if(strlen($rut) >= 8){
        $exp = explode("-", $rut);
        if(isset($exp[1])){
            $rutsdv = $exp[0];
            $dv = $exp[1];
        }else{
            $rutsdv = substr($rut, 0, -1);
            $dv = substr($rut, -1);
        }
        $newrut = number_format($rutsdv, 0, '', '.');
    
        return $newrut.'-'.$dv;
    }
    return 'FORMATO DE RUT INVALIDO';
}

$rut = '17725690-0';

$url = 'https://www.nombrerutyfirma.com/rut?term='.formato_rut($rut);

$ch   = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$respuesta = curl_exec($ch);
curl_close($ch); 

$DOM = new DOMDocument();

libxml_use_internal_errors(true);
$DOM->loadHTML($respuesta);
libxml_use_internal_errors(false);

$DOM->preserveWhiteSpace = false;

$table = $DOM->getElementsByTagName('table');

$tbody = $table->item(0)->getElementsByTagName('tbody');

foreach ($tbody as $datos)
{
    // Recuperamos la información desde el TAG: TD
    $td = $datos->getElementsByTagName('td');
    // Imprimimos los resultados
    echo $td->item(0)->nodeValue.','; // Nombre completo
    echo $td->item(1)->nodeValue.','; // RUT
    echo $td->item(2)->nodeValue.','; // Genero (VAR o MUJ)
    echo $td->item(3)->nodeValue.','; // Dirección
    echo $td->item(4)->nodeValue; // Ciudad
    echo '<br />';
}
?></pre>
