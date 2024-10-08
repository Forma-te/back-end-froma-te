<?php

function generatePassword()
{
    // Números aleatórios
    $numbers = str_shuffle('0123456789');

    // Caracteres especiais
    $specialCharacters = str_shuffle('!@#$%*-');

    // Junta os números e caracteres especiais
    $characters = $numbers . $specialCharacters;

    // Embaralha e pega apenas 8 caracteres
    $password = substr(str_shuffle($characters), 0, 8);

    // Retorna a senha
    return $password;
}

function sanitizeString($string)
{
    // Valores informados
    $what = ['ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º', 'Ã', 'Õ', '&'];

    // Valores a serem substituídos
    $by = ['a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', 'A', 'O', ''];

    // String Formatada
    return str_replace($what, $by, $string);
}

function createUrl($string)
{
    //Retira os acentos
    $url = sanitizeString($string);

    //Deixa o texto em minusculo retira todos encodes html
    return str_replace(' ', '-', strtolower(filter_var($url, FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
}

if (!function_exists('convertItemsOfArrayToObject')) {
    function convertItemsOfArrayToObject(array $items): array
    {
        $items = array_map(function ($item) {
            $stdClass = new \stdClass();
            foreach ($item as $key => $value) {
                $stdClass->{$key} = $value;
            }
            return $stdClass;
        }, $items);

        return $items;
    }
}
