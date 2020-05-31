
    <?php
        $mysqli=new mysqli("localhost","root","","kk");
        $mysqli->set_charset("utf8");
        session_start();
        if (isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST['enter']))
        {
            $l=$_POST["login"];
            $p=$_POST["password"];
            $stmt=$mysqli->prepare("Select * from users where login=?");
            $stmt->bind_param('s', $l);
            $stmt->execute();
            $res = $stmt->get_result();
            $k=$res->num_rows;
            if ($k==1)
            {
                $i=$res->fetch_row();
                $salt=$i[5];
                $a=$i[6];
                $hp=md5(md5($p).$salt);
                $stmt1=$mysqli->prepare("Select * from users where (login=? and password=?)");
                $stmt1->bind_param('ss', $l, $hp);
                $stmt1->execute();
                $res1 = $stmt1->get_result();
                $k=$res1->num_rows;
                if ($k==1) {$_SESSION['user']=$l; $_SESSION['adm']=$a; header('Location: home.php'); } else echo "Такого пользователя не существует";
                $stmt1->close();
            }
            else echo "Такого пользователя не существует";
            $stmt->close();
        }
    ?>