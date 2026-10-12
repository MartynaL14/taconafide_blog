<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularz</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #74ebd5, #acb6e5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        .form-box {
            background: #fff;
            padding: 30px 25px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 420px;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"],
        input[type="tel"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="tel"]:focus {
            border-color: #5b7cfa;
            box-shadow: 0 0 0 3px rgba(91, 124, 250, 0.15);
            outline: none;
        }

        button {
            background: #5b7cfa;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        button:hover {
            background: #4b68df;
        }

        .message {
            margin-top: 20px;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background: #dff5e6;
            color: #207a3d;
            border: 1px solid #bfe8cc;
        }

        .error {
            background: #fdeaea;
            color: #b42318;
            border: 1px solid #f7c7c7;
        }
    </style>
</head>

<body>

    <div class="form-box">
        <h2>FORMULARZ</h2>

        <form method="POST" action="">
            <input type="text" name="imie" id="imie" placeholder="Podaj imię" required>
            <input type="text" name="nazwisko" id="nazwisko" placeholder="Podaj nazwisko" required>
            <input type="tel" name="tel" id="tel" placeholder="Podaj numer telefonu" required>
            <button type="submit" name="submit">Wyślij formularz</button>
        </form>

        <?php
        if (isset($_POST["submit"])) {
            $connect = mysqli_connect("localhost", "root", "", "formularze");

            if (!$connect) {
                echo '<div class="message error">Błąd połączenia z bazą danych.</div>';
            } else {
                $imie = trim($_POST['imie']);
                $nazwisko = trim($_POST['nazwisko']);
                $tel = trim($_POST['tel']);

                if (empty($imie) || empty($nazwisko) || empty($tel)) {
                    echo '<div class="message error">Wszystkie pola muszą być wypełnione.</div>';
                } else {
                    $zapytanie = $connect->prepare("INSERT INTO zgloszenia (imie, nazwisko, tel) VALUES (?, ?, ?)");
                    $zapytanie->bind_param("sss", $imie, $nazwisko, $tel);

                    if ($zapytanie->execute()) {
                        echo '<div class="message success">Dane zostały zapisane!</div>';
                    } else {
                        echo '<div class="message error">Błąd: ' . htmlspecialchars($connect->error) . '</div>';
                    }

                    $zapytanie->close();
                }

                mysqli_close($connect);
            }
        }
        ?>
    </div>

</body>

</html>