<?php
$title="Teacher Evaluate";
$dsn = 'mysql:host=localhost:8889;dbname=teacher_evaluate;charset=utf8;';
$db_user = 'root';
$db_pass = 'root';

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
} catch (PDOException $e) {
    exit('データベース接続失敗。' . $e->getMessage());
}

?>
<!DOCTYPE html>
<header>
<meta charset="utf-8">
<title><?php echo $title; ?></title>
</header>
<body>
<h1><?php echo $title; ?></h1>
<h2>このサイトでは大学教授の授業の評価・評価の検索が可能です。</h2>

<?php

// SQL文を作成
$sql = "SELECT * FROM evaluate2";
// クエリ実行（データを取得）
$res = $pdo->query($sql);
// 取得したデータを出力

$sql2 = 'SELECT count(*) FROM evaluate2';
$stmt = $pdo->query($sql2);
$row_cnt = $stmt->fetchColumn();
?>
<hr>
<p><a href="./../">トップ</a>→大学授業評価</p>
&nbsp

<h3>授業一覧</h3>
<p>授業総数：<?php echo "$row_cnt"; ?></p>
<table>
  <tr>
    <th>登録番号</th>
    <th>講義名</th>
    <th>評価点</th>
    <th>教師名</th>
    <th>コメント</th>
  </tr>
<?php
foreach( $res as $value ) {
  echo "<tr>";
  echo "<td>$value[num]</td>";
  echo "<td>$value[class]</td>";
  echo "<td>$value[evaluation]</td>";
  echo "<td>$value[name]</td>";
  echo "<td>$value[comment]</td>";
  echo "</tr>";
}
?>

</table>
<br />
<hr>

<h3>授業の評価をする</h3>
<h4>新規追加</h4>
<form action="newevaluate.php" method="post">
  <fieldset>
    <legend>評価の記入</legend>
    <label for="kougi">講義名：</label>

    <input type="text" name="kougi" id="kougi" placeholder="講義名を入力してください">
    <br/>
    <label for="name">教師名：</label>

    <input type="text" name="name" id="name" placeholder="教師名を入力してください">
    <br/>

    <label for="evaluation">評価点：</label>
    <select name="evaluation" id ="evaluation">
    <?php
    for($i=0; $i<101 ;$i+=1){
      if($i == 50){
        echo "<option value=$i selected>50</option>";
      }
      echo "<option value=$i>$i</option>";
    }
    ?>
    </select>
    <br/>
    <label for="comment">コメント：</label>

    <input type="textarea" name="comment" id="comment" placeholder="コメントをどうぞ">
    <br/>

    <input type="submit" value="決定">
    <input type="reset" value="リセット">
  </fieldset>

</form>


<h4>既存の授業</h4>
<form action="change.php" method="post">
  <fieldset>
    <legend>評価の記入</legend>
    <label for="kougi">講義名：</label>
    <select name="kougi" id ="kougi">
    <?php
    $res = $pdo->query($sql);
    foreach( $res as $value ){
      echo "<option value=$value[class] selected>$value[class]</option>";
    }
    ?>
    </select>
    <br/>
    <label for="evaluation">評価点：</label>
    <select name="evaluation" id ="evaluation">
    <?php
    for($i=0; $i<101 ;$i+=1){
      if($i == 50){
        echo "<option value=$i selected>50</option>";
      }
      echo "<option value=$i>$i</option>";
    }
    ?>
    </select>
    <br/>
    <label for="comment">コメント：</label>
    <input type="textarea" name="comment" id="comment" placeholder="コメントをどうぞ">
    <br/>
    <input type="submit" value="決定">
    <input type="reset" value="リセット">
  </fieldset>

</form>


<h3>授業の検索をする</h3>
<form action="search.php" method="post">
  <fieldset>
    <legend>探したい授業を選んでください</legend>
    <label for="kougi">講義名：</label>
    <select name="kougi" id ="kougi">
    <?php
    $res = $pdo->query($sql);
    foreach( $res as $value ){
      echo "<option value=$value[class] selected>$value[class]</option>";
    }
    ?>
    </select>
    <br/>
    <input type="submit" value="決定">

  </fieldset>

</form>
&nbsp
<h3><a href="./../">作品一覧へ</a></h3>
</body>
