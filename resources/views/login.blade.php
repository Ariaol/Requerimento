<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste de Autenticação Moodle</title>
</head>
<body>
    <h2>Autenticação Moodle</h2>
    <form action="http://127.0.0.1:8000/api/auth/moodle" method="POST">
        @csrf
        <label for="username">Nome de Usuário:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Autenticar</button>
    </form>
</body>
</html>
