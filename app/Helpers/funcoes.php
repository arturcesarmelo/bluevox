<?php

function collections($param) {
   $collections = [];

   $collections['dias_semana'] = [
      1 => 'Segunda',
      2 => 'Terça',
      3 => 'Quarta',
      4 => 'Quinta',
      5 => 'Sexta',
      6 => 'Sábado',
      7 => 'Domingo',
   ];

   return $collections[$param];
}

function csvToArray($file_path) {
   // $content = \File::get($file_path);
   // $outArray = explode("\\r\\n", $content);
   $row = 1;
   $arr = [];
   if (($handle = fopen($file_path, "r")) !== FALSE) {
       while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $arr[] = $data;
       }
       fclose($handle);
   }
   return $arr;
}