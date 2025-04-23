<?php
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>404 - Página não encontrada</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background-color: #0f0f0f;
            color: #ffffff;
            font-family: "Segoe UI", Roboto, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 120px;
            font-weight: bold;
            color: #ff4b4b;
        }
        h2 {
            font-size: 28px;
            margin-top: 20px;
            color: #cccccc;
        }
        p {
            font-size: 18px;
            margin-top: 10px;
            color: #999999;
        }
        a {
            margin-top: 30px;
            display: inline-block;
            background-color: #ff4b4b;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #e13a3a;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 72px;
            }
            h2 {
                font-size: 22px;
            }
            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <h1>404</h1>
    <h2>Página não encontrada</h2>
    <p>Desculpe, não conseguimos encontrar o que você procurava.</p>
    <a href="/">Voltar para a Página Inicial</a>
</body>
</html>
  