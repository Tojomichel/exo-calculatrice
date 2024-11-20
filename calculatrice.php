<!doctype html>
<html lang="fr">

<head>
    <meta charsat="utf-8">
    <title>Calculatrice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #fff9c4, #ffe082, #ffca28, #ffc107);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-size: cover;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 500px;
            max-width: 100%;
        }

        h2 {
            text-align: center;
            color: #007BFF;
        }

        form {
            margin-top: 20px;
        }

        form p {
            margin-bottom: 15px;
        }

        input[type="text"], select {
            width: calc(100% - 20px);
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"], input[typr="button"] {
            width: 100%;
            background-color: #3c57dc;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 10px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #3725d3;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            background-color: #f1f1f1;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        ul li:nth-child(odd) {
            background-color: #e9ecef;
        }

        .result {
            background-color: #e9ffe9;
            padding: 10px;
            border: 1px solid #c3e6c3;
            border-radius: 4px;
            margin-top: 10px;
            color: #155724;
        }

        .clear-btn {
            margin-top: 15px;
            background-color: #dc3545;
        }

        .clear-btn:hover {
            background-color: #a71d2a;
        }
    </style>
</head>

<body>
    <div class="container">
    <h2>Calculatrice</h2>
    <?php
    session_start();

    if (!isset($_SESSION['history'])){
        $_SESSION['history'] = [];
    }

    if (isset($_POST['submit'])) {
        $n1 = $_POST['n1'];
        $n2 = $_POST['n2'];
        $choice = $_POST['choice'];
        $result = "";

        if (is_numeric ($n1) && is_numeric($n2)) {
            switch ($choice) {
                case "1":
                    $result = $n1 + $n2;
                    $symbole = '+';
                    break;
                case "2":
                    $result = $n1 - $n2;
                    $symbole = '-';
                    break;
                case "3":
                    $result = $n1 * $n2;
                    $symbole = '*';
                    break;
                case "4":
                    if ($n2 != 0) {
                        $result = $n1 / $n2;
                        $symbole = '/';
                    } else {
                        $result = "erreur! division par zéro";
                        $symbole = '?';
                    }
                    break;
                default:
                    $result = "veuillez saisir des nombres à calculer ou l'opération à effectuer";
                    $symbole = '?';
            }
            $operation = [
                "n1" => $n1,
                "n2" => $n2,
                "symbole" => $symbole,
                "result" => $result
            ];
            $_SESSION['history'][] = $operation;
        } else {
            $result = "veuillez saisir des nombres valides";
        }
        echo "Résultat: " . $result;
    }
    ?>

    <form method="post">
        <p>Nombre 1 <input type="text" name="n1"></p>
        <p>Nombre 2 <input type="text" name="n2"></p>
        <select name="choice">
            <option value=""> Choisissez une operation </option>
            <option value="1">Addition </option>
            <option value="2"> Soustraction </option>
            <option value="3"> Multiplication </option>
            <option value="4"> Division </option>
        </select>
        <input type="submit" name="submit" value="effectuer le calcul">
    </form>

    <h3>Historique des calculs</h3>
    <?php
    if (!empty($_SESSION['history'])) {
        echo "<ul>";
        foreach ($_SESSION['history'] as $calc) {
            echo "<li>" . htmlspecialchars($calc['n1']) . " " . htmlspecialchars($calc['symbole']) . " " . htmlspecialchars($calc['n2']) . " " . "=" . htmlspecialchars($calc['result']) . "</li>";
        }
        echo "</ul>";
    }
    ?>

    <form method = "post">
        <input type = "submit" name = "clear" value = "effacer l'historique">
    </form>

    <?php
    if (isset($_POST['clear'])) {
        $_SESSION['history'] = [];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    ?>
    </div>
</body>

</html>