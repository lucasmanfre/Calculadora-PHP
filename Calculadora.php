<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Concert+One&display=swap" rel="stylesheet">

    <?php

    session_start();

    $nr1 = 0;
    $nr2 = 0;
    $resultado = 0;
    $calcular = 0;

    function fat($num1)
    {
        $fatores = 1;
        for ($i = $num1; $i > 1; $i--) {
            $fatores *= $i;
        }
        return $fatores;
    }

    if (!isset($_SESSION['historico'])) {
        $_SESSION['historico'] = array();
    }

    if (!isset($_SESSION['memoria'])) {
        $_SESSION['memoria'] = array('nr1' => 0, 'nr2' => 0, 'calcular' => 'somar');
    }

    if (isset($_GET['nr1'], $_GET['nr2'], $_GET['calcular'])) {
        $nr1 = $_GET['nr1'];
        $nr2 = $_GET['nr2'];
        $calcular = $_GET['calcular'];

        switch ($calcular) {
            case 'somar':
                $resultado = $nr1 + $nr2;
                break;
            case 'subtrair':
                $resultado = $nr1 - $nr2;
                break;
            case 'multiplicar':
                $resultado = $nr1 * $nr2;
                break;
            case 'dividir':
                $resultado = $nr1 / $nr2;
                break;
            case 'fatorar':
                $resultado = fat($nr1);
                break;
            case 'potencia':
                $resultado = pow($nr1, $nr2);
                break;
        }

        $_SESSION['historico'][] = array(
            'nr1' => $nr1,
            'nr2' => $nr2,
            'calcular' => $calcular,
            'resultado' => $resultado
        );
    }

    if (isset($_GET['limpar_historico'])) {
        $_SESSION['historico'] = array();
    }

    if (isset($_GET['memoria'])) {
        $_SESSION['memoria'] = array('nr1' => $nr1, 'nr2' => $nr2, 'calcular' => $calcular);
    }

    ?>



</head>

<body>
    <form>
        <div class="cabecalho">
            <h1>Calculadora</h1>
        </div>
        <div class="div-num">
            <h2>Primeiro número</h2>
            <input class="input" type="number" required name="nr1" value=<?php echo $nr1; ?> />
            <h2>Segundo número</h2>
            <input class="input" placeholder="Segundo número" type="number" required name="nr2"
                value=<?php echo $nr2; ?> />
            <br />
            <br>
        </div>
        <div class="btn-calculo">
            <select name="calcular">
                <option value="somar" <?php echo ($calcular == 'somar') ? 'selected' : ''; ?>>Soma</option>
                <option value="subtrair" <?php echo ($calcular == 'subtrair') ? 'selected' : ''; ?>>Subtração</option>
                <option value="multiplicar" <?php echo ($calcular == 'multiplicar') ? 'selected' : ''; ?>>Multiplicação
                </option>
                <option value="dividir" <?php echo ($calcular == 'dividir') ? 'selected' : ''; ?>>Divisão</option>
                <option value="fatorar" <?php echo ($calcular == 'fatorar') ? 'selected' : ''; ?>>Fatoração</option>
                <option value="potencia" <?php echo ($calcular == 'potencia') ? 'selected' : ''; ?>>Potência</option>
            </select>
        </div>
        <div class="btn-finalizar">
            <br /><br />
            <input type="submit" class="botao-calcular" value="=" />

            <input type="submit" class="botao-calcular" name="limpar_historico" value="Limpar Histórico" />

            <input type="submit" class="botao-calcular" name="memoria" value="M" />
        </div>

    </form>


    <h1>Histórico</h1>
    <table>
        <tr>
            <th>Numero 1</th>
            <th>Numero 2</th>
            <th>Operação</th>
            <th>Resultado</th>
        </tr>
        <?php foreach ($_SESSION['historico'] as $operação) : ?>
        <tr>
            <td><?php echo $operação['nr1']; ?></td>
            <td><?php echo $operação['nr2']; ?></td>
            <td><?php echo $operação['calcular']; ?></td>
            <td><?php echo is_array($operação['resultado']) ? implode(', ', $operação['resultado']) : $operação['resultado']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <style>
    body {
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #5c0808;
        font-size: 50px;
        border-radius: 20px;
        font-family: "Permanent Marker", cursive;
        font-weight: 400;
        font-style: normal;
        text-align: center;
    }

    h1:hover {

        color: #cc0000;
    }

    .div-num {
        display: flex;
        gap: 20px;
        justify-content: center;
    }

    h2 {
        font-family: "Concert One", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    /* ------- BOTAO DE INPUT ------- */
    .input {
        border: none;
        outline: none;
        border-radius: 15px;
        padding: 1em;
        background-color: #ccc;
        box-shadow: inset 2px 5px 10px rgba(0, 0, 0, 0.3);
        transition: 300ms ease-in-out;
    }

    .input:focus {
        background-color: white;
        transform: scale(1.05);
        box-shadow: 13px 13px 100px #969696,
            -13px -13px 100px #ffffff;
    }

    /* ---------------------------- */

    /* ------- BOTAO DE CALCULO ------- */

    .btn-calculo {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        height: 40px;
    }

    select {
        padding: 7px 40px 7px 12px;
        border: 1px solid #E8EAED;
        border-radius: 5px;
        background: #ccc;
        box-shadow: 0 1px 3px -2px #9098A9;
        cursor: pointer;
        font-family: inherit;
        font-size: 16px;
        transition: all 150ms ease;
    }

    /* ---------------------------- */

    /* ------- OUTROS BOTÕES ------- */

    .btn-finalizar {
        display: flex;
        justify-content: center;
        margin: 20px;
        gap: 10px;
    }

    .botao-calcular {
        background-color: #ccc;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: box-shadow 0.3s ease;
        font-size: 16px;
    }

    .botao-calcular:hover {
        background-color: #be8927;
    }

    .botao-calcular:active {
        box-shadow: 0 0 10px rgb(227, 120, 67);
    }

    /* ---------------------------- */

    /* ------- TABELA ------- */

    table,
    th,
    td {
        border: 1px solid black;
    }

    table {
        border-collapse: collapse;
        margin: auto;
    }

    th,
    td {
        padding: 10px;
        text-align: center;
        width: 120px;
    }

    th {
        font-weight: bold;
    }


    tr:nth-child(even) {
        background-color: #DCEBE6;
    }

    tr:hover:nth-child(1n + 2) {
        background-color: #085F63;
        color: #fff;
    }

    /* ---------------------------- */
    </style>

</body>

</html>