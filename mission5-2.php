<!DOCTYPE html>
<html lang = "ja">
<head>
    <mata charset ="UTF-8">
    <title>mission5-01</title>
</head>
<?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

    $sql = "CREATE TABLE IF NOT EXISTS tbdata"
        ." ("
        . "id INT AUTO_INCREMENT PRIMARY KEY,"
        . "name char(32),"
        . "comment TEXT,"
        . "password char(32)"
        .");";
    $stmt = $pdo->query($sql);
?>
<body>
        <?php
        //編集部
        if(!empty($_POST["editsub"])&&!empty($_POST["deleteid"])){
            $sql='SELECT * FROM tbdata';
            $stmt=$pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach($results as $row){
                if($row['id']==$_POST["deleteid"]){
                    if($row['password']==$_POST["deletepass"]){
                    $editid = $row['id'];
                    $editname= $row['name'];
                    $editcom = $row['comment'];}
                else {echo"パスワードが異なります<br>";}
                }
            }
            }
        if(!empty($_POST["editid"])&&!empty($_POST["name"]) && !empty($_POST["comment"])){
        $id = $_POST["editid"]; //変更する投稿番号
        $name = $_POST["name"]; 
        $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
        $sql = 'UPDATE tbdata SET name=:name,comment=:comment WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        }
        //入力部
        else if(!empty($_POST["name"]) && !empty($_POST["comment"]))
       {
        $sql = $pdo -> prepare("INSERT INTO tbdata(name, comment, password)  VALUES (:name, :comment, :password)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':password', $password, PDO::PARAM_STR);
        $name = $_POST["name"];
        $comment = $_POST["comment"];        
        $password = $_POST["password"];        
        $sql -> execute();
       }
       //削除部
           if(!empty($_POST["deleteid"])&&!empty($_POST["deletesub"])){
                $id = $_POST["deleteid"];
                $pass =    $_POST["deletepass"];
                $sql = 'delete from tbdata where id=:id and password=:password';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':id',$id, PDO::PARAM_INT);
                $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
                $stmt->execute();
           }
        ?>
        【　投稿フォーム　]
    <form action="" method="post">
        
        　　　　名前:<input type="text" name="name" placeholder="名前"value="<?php echo $editname;?>">
        <br>
        　　コメント:<input type="text" name="comment" placeholder="コメント"value="<?php echo $editcom;?>">
        <br>
        　パスワード:<input type="text" name="password" placeholder="パスワード">
        <br>
        <input type="submit" name="submit">
        <br>
        【　編集・削除フォーム　】
        <br>
        
        　　対象番号:<input type="number" name="deleteid"placeholder="対象番号">
        <br>
        　パスワード:<input type="text" name="deletepass"placeholder="パスワード">
        <br>
        <input type="submit" name="deletesub" value="削除">
        <input type="submit" name="editsub" value="編集">
        <input type="hidden"name="editid"value="<?php echo $editid;?>">
        <br>
        -------------------------------------------------------------------------
           <br>
           【　投稿一覧　】<br>
    </form>
  
</body>
</html>
  <?php
       //表示部 
        $sql = 'SELECT * FROM tbdata';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            echo $row['id'].',';
            echo $row['name'].',';
            echo $row['comment'].','.'<br>';
            echo "<hr>";
            }
      ?>