<?php
//Lógica do app, usando um switch para selecionar a função de acordo com a opção escolhida
if(!isset($_GET['aa'])){
    header("location: index.php");
}else{
    if($_GET['aa'] == 'ok'){
        $input = strip_tags($_POST['input']);
        $option = $_POST['options'];
        $output = "";
        switch($option){
            case "min":
                $output = lower($input);
                break;
            case "mai":
                $output = upper($input);
                break;
            case "ran":
                $output = randomize($input);
                break;
            case "ess":
                $output = addEss($input);
                break;
            case "cam":
                $output = camelCase($input);
                break;
            case "esp":
                $output = space($input);
                break;
            case "mir":
                $output = mirror($input);
                break;
        }
        echo $output;
    }
}

//Funções

//Muda para caixa baixa
function lower($phrase){
    return mb_strtolower($phrase);
}

//Muda para caixa alta
function upper($phrase){
    return mb_strtoupper($phrase);
}

//Monta a frase de novo com as palavras embaralhadas
//Ou embaralha as letras se for só uma palavra
function randomize($phrase){
    $temp = "";
    $tempArray = [];
    $control = sizeof($tempArray);
    $tempPhrase = $phrase;
    $ctl = mb_strlen($tempPhrase);
    if($control > 1){
        $tempArray = explode(" ", $phrase);
        for($i = 0; $i < $control; $i++){
            $r = array_rand($tempArray);
            $temp .= $tempArray[$r] . " ";
            array_splice($tempArray, $r, 1);
        }
    }else{
        //Transformar string em array usando str_split ou mb_str_split
        $tempArray = mb_str_split($phrase,1);
        for($i = 0; $i < $ctl; $i++){
            $r = array_rand($tempArray);
            $temp .= $tempArray[$r];
            array_splice($tempArray, $r, 1);
        }
    }
    return $temp;
}

//Coloca S ou ES no final das palavras
function addEss($phrase){
    $temp = "";
    $tempArray = [];
    $tempArray = explode(" ", $phrase);
    $vowels = ['a','e','i','o','u','é','A','E','I','O','U'];
    foreach($tempArray as $word){
        $last = mb_substr($word, -1);
        if(!in_array($last, $vowels) && $last != "m"){
            $temp .= $word."es ";
        }else if ($last == 'm'){
            $word[-1] = 'n';
            $temp .= $word."s ";
        }else{
            $temp .= $word."s ";
        }
    }
    return $temp;
}

// As funções a seguir estavam dando problemas com caracteres UTF-8 no momento da iteração,
// porque a iteração contava por bites e colocava cada bite separado na nova string.
// Para resolver foi usada a função mb_substr retirando diretamente do argumento passado para
// a função o caractere na posição da iteração e adicionando ele na nova string.

//Aplica caixa alta para os indices ímpares e caixa baixa para os pares da frase
function camelCase($phrase){
    $temp = "";
    $count = mb_strlen($phrase);
    for($i = 0; $i < $count; $i ++){
        if($i % 2 === 0){
            $temp .= upper(mb_substr($phrase, $i, 1));
        }else{
            $temp .= lower(mb_substr($phrase, $i, 1));
        }
    }
    return $temp;
}

//Adiciona um espaço depois de cada caractere
function space($phrase){
    $temp = "";
    $count = mb_strlen($phrase);
    for($i = 0; $i < $count; $i++){
        $temp .= mb_substr($phrase, $i, 1) . " ";
    }
    return $temp;
}

//Inverte a palavra ou frase
function mirror($phrase){
    $temp = "";
    $count = mb_strlen($phrase);
    for($i = $count; $i >= 0; $i--){
        $temp .= mb_substr($phrase, $i, 1);
    }
    return $temp;
}
?>