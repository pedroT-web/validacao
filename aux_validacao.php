<?php
echo '<h1>aux_validacao-php</h1>';

function fnValidarNomeCompleto(string $nome): bool
{
    if (empty($nome)) {
        echo "<h3>O nome não pode estar vazio</h3><br>";
        return false;
    }

    // Valida se é uma string
    if (!is_string($nome)) {
        echo '<h3>não é string</h3><br>';
        return false;
    }

    // Ele procura se é numero, ele converte e valida se é numero, mas serve apenas para NUMEROS!!
    if (is_numeric($nome)) {
        echo '<h3>ele é um número!</h3><br>';
        return false;
    }

    // valida se tem numeros no nome
    if (ctype_digit($nome)) {
        echo '<h3>ele tem numeros ali tmb</h3><br>';
        return false;
    }

    if(!ctype_space($nome)){
        echo '<h3>O nome não está completo</h3><br>';
        return false;
    }

    // Valida se contém caracteres especiais
    $caracteresEspeciais = '/[!@#$%^&*(),.?":{}|<>]/';
    if (preg_match($caracteresEspeciais, $nome)) {
        echo '<h3>o Nome contém caracteres especiais</h3><br>';
        return false;
    }


    return true;
}

function fnValidarIdade($idade): bool
{
    if (empty($idade)) {
        echo "<h3>Idade não pode estar vazia</h3><br>";
        return false;
    }
    // valida se é numero
    if (!is_numeric($idade)) {
        echo '<h3>Não é numero</h3><br>';
        return false;
    }

    $idade = (int) $idade;
    // Valida se a idade é menor do que 18 anos
    if ($idade < 18) {
        echo '<h3>Idade menor do que 18 anos, não pode tirar carta</h3><br>';
        return false;
    }
    return true;
}

function fnValidarDataNasc($dataNascimento, $idade): bool
{
    if (empty($dataNascimento)) {
        echo "<h3>Data de nascimento não pode estar vazia</h3><br>";
        return false;
    }
    // Converte para int
    $dataNascimento = (int) $dataNascimento;
    // define o local aonde quer buscar a data atual
    date_default_timezone_set('America/Sao_Paulo');
    // Busca a data atual
    $dataAtual = date('Y-m-d');
    // Converte a data atula para inteiro
    $dataAtual = (int) $dataAtual;

    // Faz a conta para validar se a idade confere com o periodo de nascimento
    $validacao = $dataAtual - $dataNascimento;

    // Valida se a data de nascimento é maior que a data atual
    if ($dataNascimento > $dataAtual) {
        echo "<h3>data de nascimento Inválida</h3><br>";
        return false;
    }

    // Valida se a idade equivale a data de nascimento
    if ($validacao != $idade) {
        echo '<h3>Idade não equivale a data de nascimento</h3><br>';
        return false;
    }

    return true;
}

// Validando de o arquivo foi chamado atráves do POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);

    /**
     * não pode conter caracter especial
     * não pode ser numero
     * não pode estar vazio
     */

    fnValidarNomeCompleto($_POST['nome']);
    fnValidarIdade($_POST['idade']);
    fnValidarDataNasc($_POST['data_nasc'], $_POST['idade']);
}

// Impede que pessoas abram o arquivo diretamente
if ($_SERVER['REQUEST_METHOD'] != 'POST' && empty($_GET)) {
    header('Location:./index.php');
}
