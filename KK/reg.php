 <html> 
    <?php
        $mysqli=new mysqli("localhost","root","","kk");
        $mysqli->set_charset("utf8");
        function GenerateSalt ($n=3)
        {
            $key='';
            $pattern='1234567890abcdefghijklmnopqrstuvwxyz.,*_-=+';
            $counter= strlen($pattern)-1;
            for ($i=0; $i<$n; $i++)
            {
                $key .= $pattern{rand(0,$counter)};
            }
            return $key;
        }
        if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['name']) && $_POST['login']!='' && $_POST['password']!='')
        {
            $l=strip_tags(trim($_POST['login']));
            $p=strip_tags(trim($_POST['password']));
            $n=strip_tags(trim($_POST['name']));
            #$er=false;
            $stmt=$mysqli->prepare("Select  ID_user from users where login=?");
            $stmt->bind_param('s', $l);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows==0) {
                $salt=GenerateSalt();
                $hashed_pass=md5(md5($p).$salt);
                $a=0;
                $stmt1=$mysqli->prepare("INSERT into users values (null, ?,?,?,now(),?,?)");
                #echo $l.'<br>'.$p.'<br>'.$n.'<br>'.$hashed_pass;
                $stmt1->bind_param('ssssi', $l, $hashed_pass, $n, $salt, $a);
                $stmt1->execute();
                $stmt1->close();
                header('Location: enter.php') ;
            }
            else {
                echo "Пользователь с таким логином уже существует"."<br>"; 
                ?> <a href='reg_form.php'> Попробовать снова</a> <?php
            }
            $stmt->close();
            mysqli_close($mysqli);
        }
    ?>
</html>