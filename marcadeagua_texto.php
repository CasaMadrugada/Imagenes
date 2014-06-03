<?php

function marcadeagua_texto_ttf($imagen, $texto, $copia = true)
{
	list($ancho, $alto, $tipo) = getimagesize($imagen);

	switch ( $tipo )
	{
		case IMAGETYPE_JPEG: //image/jpg image/jpeg
			$nueva_imagen = imagecreatefromjpeg( $imagen );
			break;
		case IMAGETYPE_PNG: //image/png
			$nueva_imagen = imagecreatefrompng( $imagen );
			break;
		case IMAGETYPE_GIF: //image/gif
			$nueva_imagen = imagecreatefromgif( $imagen );
			break;
		default:
			return FALSE;
	}

	$color = imagecolorallocate($nueva_imagen, 10, 10, 255);

	//Indicamos el nombre/archivo de la fuente.
	//debes indicar la ruta correcta
	$fuente = 'fuente.ttf';

	//devuelve las coordenadas de la caja que rodea el texto
	$caja_texto = imagettfbbox(10, 0, $fuente, $texto);
	$ancho_texto = $caja_texto[2]-$caja_texto[0];
	$alto_texto = $caja_texto[1]-$caja_texto[5];

	$texto_x = abs($caja_texto[6]);
	$texto_y = $alto_texto;
	imagettftext($nueva_imagen, 10, 0, $texto_x, $texto_y, $color, $fuente, $texto);

	$nombre_archivo = $imagen;
	if ( strpos($nombre_archivo, '/') )
	{
		$nombre_archivo = explode('/', $imagen);
		$nombre_archivo = end($nombre_archivo);
	}

	if ( $copia )
		$nombre_archivo = 'copia_'.$nombre_archivo;

	$calidad_imagen = 90;
	switch ( $tipo ){
		case IMAGETYPE_JPEG: //image/jpg image/jpeg
			imagejpeg($nueva_imagen, 'imagenes/'.$nombre_archivo, $calidad_imagen);
			break;
		case IMAGETYPE_PNG: //image/png
			imagepng($nueva_imagen, 'imagenes/'.$nombre_archivo, $calidad_imagen/10);
			break;
		case IMAGETYPE_GIF: //image/gif
			imagegif($nueva_imagen, 'imagenes/'.$nombre_archivo, $calidad_imagen);
			break;
		default:
			return FALSE;
	}

	imagedestroy($nueva_imagen);
}

?>
