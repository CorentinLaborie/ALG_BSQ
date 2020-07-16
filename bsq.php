<?php

function MinCheck($anArray)
{
  $min = $anArray[0];
    foreach ($anArray as $value) {
        if ($min > $value)
        {
            $min = $value;
        }
    }
    return $min;
}

function MapCheck($cellule, $NO = 0, $N = 0, $O = 0)
{
  return $cellule != 0 ? MinCheck([$NO, $N, $O]) + $cellule : 0;
}

function Traitement($path) {
  // Get Datas //
  $brutDatas = file_get_contents($path);

  // Creation variable //
    $datas = explode("\n", $brutDatas);

  $lineNb = intval($datas[0]);
  $lineLen = strlen($datas[1]);
  array_shift($datas);
  $Map = $datas;
        
  // LOGIQUE //
    // Attribuer des valeurs ('.' = 1 && "o" = 0) pour la map //
      $MapWorkStep1 = str_replace(".", "1", $Map);
      $workedMap = str_replace("o", "0",$MapWorkStep1);

    // Chercher le plus gros carre //
      $lineIndex = 0;
      $x1 = null;
      $y1 = null;
      $maximum = 0;
      
      foreach ($workedMap as $line)
      {
        for ($i = 0; $i < $lineLen; $i++)
        {
            $NordOuest = isset($arr[$lineIndex - 1][$i - 1]) ? intval($arr[$lineIndex - 1][$i - 1]) : 0;
            $Nord = isset($arr[$lineIndex - 1][$i]) ? intval($arr[$lineIndex - 1][$i]) : 0;
            $Ouest = isset($arr[$lineIndex][$i - 1]) ? intval($arr[$lineIndex][$i - 1]) : 0;

            $arr[$lineIndex][$i] = MapCheck(intval($line[$i]), $NordOuest, $Nord, $Ouest);

            if ($maximum < $arr[$lineIndex][$i])
            {
              $maximum = $arr[$lineIndex][$i];
              $x1 = $i;
              $y1 = $lineIndex;
            }
        }
        $lineIndex++;
      }
    // AFFICHAGE //
      $BiggestCarre = ["taille" => $maximum, "x" => $x1, "y" => $y1];
      $FinalMap = [];
      for ($a = 1; $a<count($Map); $a++)
      {
        $FinalMap[$a-1] = str_split($Map[$a]);
      }
      for ($i = 0; $i < $BiggestCarre['taille']; $i++)
      {
        for ($j = 0; $j < $BiggestCarre['taille']; $j++ )
        {
          $FinalMap[$BiggestCarre['y'] - $i][$BiggestCarre['x'] - $j] = 'x';
        }
      }
      foreach ($FinalMap as $value) {
        $toSTR = implode("", $value);
        echo $toSTR."\n";
    }

}


Traitement($argv[1]);