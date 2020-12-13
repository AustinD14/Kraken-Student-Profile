<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>title</title>
</head>
<body>
<?php
try{
    $pdo = new PDO(
        'mysql:host=localhost;dbname=Student_Profile;charset=utf8',
        'pma',
        '123456'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
}catch(PDOException $Exception){
    die('Connection Error：' .$Exception->getMessage());
}
try{
    $sql = "SELECT * FROM Student_Profile.items";
    $stmh = $pdo->prepare($sql);
    $stmh->execute();
}catch(PDOException $Exception){
    die('Connection_Error：' .$Exception->getMessage());
}
?>
<table><tbody>
    <tr><th>ID</th><th>u_name</th></tr>
<?php
    while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
?>
    <tr>
        <th><?=htmlspecialchars($row['id'])?></th>
        <th><?=htmlspecialchars($row['u_name'])?></th>
    </tr>
<?php
    }
    $pdo = null;
?>
</tbody></table>
</body>
</html>