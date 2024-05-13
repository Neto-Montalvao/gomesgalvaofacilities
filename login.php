<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

</head>
<style>
    body{
        width: 100vw;
        height: 90vh;

    }
    form{
        width: 50vw;
        height: 50vh;
        font-size: 25px;
        margin: auto;
        position: relative;
        top: 30vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    input{
        font-size: 25px;
        width: 225px;
        height: 50px;
    }
    button{
        width: 50px;
        height: 50px;
    }
</style>
<body>
    <form action="admin.php" method="post">
        <label for="user">Usuário <input type="text" name="user"></label>
        <label for="senha">Senha <input type="password" name="senha"></label>        
        <button type="submit">Entrar</button>
    </form>
</body>
</html>