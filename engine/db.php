<?php
    require_once(dirname(__DIR__, 1).'/config/config.php');

    // соединение с БД
    try{
        $dbConnection = new PDO("mysql:dbname=".NAME_DB."; host=".HOST_DB, USER_DB, PASS_DB);
    }
    catch(PDOException $e){
        die($e->getMessage());
    }

    // Функция для генерации случайной строки
    function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    // проверить существование пользователя
    public function existsUser($user){
        $query = $dbConnection->prepare('select count(*) as count from `users` where `login` = :user');
        $query->execute(['user' => $user]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];
        return intval($count) === 1;
    }

    // проверка авторизации
    public function isAuthorization($user, $password){
        $password = md5(md5($password));
        $query = $dbConnection->prepare('select count(*) as count from `users` where `user_login` = :user and `user_password`=:password');
        $query->execute(['user' => $user, 'password' => $password]);
        $count = $query->fetch(PDO::FETCH_ASSOC)['count'];
        return intval($count) === 1;
    }
 
    if(isset($_POST['login']))
    {
        if(existsUser($_POST['login']))
        {
            if(isAuthorization($_POST['login'], $_POST['password'])){
                // Генерируем случайное число и шифруем его
                $hash = md5(generateCode(10));
        
                if(!empty($_POST['not_attach_ip']))
                {
                    // Если пользователя выбрал привязку к IP
                    // Переводим IP в строку
                    $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
                }
                
                // Записываем в БД новый хеш авторизации и IP
                mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'"); 
                // Ставим куки
                setcookie("id", $data['user_id'], time()+60*60*24*30, "/");
                setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true); // httponly !!! 
                // Переадресовываем браузер на страницу проверки нашего скрипта
                header("Location: check.php"); exit();
            }
        }
    }
?>