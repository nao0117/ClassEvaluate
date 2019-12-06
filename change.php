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
<h2>データ受け取り完了</h2>

<?php
$class = $_POST['kougi'];
$evaluation = $_POST['evaluation'];
$comment = $_POST['comment'];
/*入力フォームでmethodをpostに指定しているため＄＿POSTによって受け取る。入力したテキストはnameという名前で送信されているので＄_POST['name']となる*/

print ("次のデータを受け取りました<br />");
print ("$class<br />");
print ("$evaluation<br />");
print ("$comment<br />");

// SQL文を作成
$sql = "UPDATE evaluate2 SET evaluation=:evaluation,comment=:comment WHERE class=:class";
$stmt = $pdo->prepare($sql);
// 更新する値と該当のIDを配列に格納する
$params = array(':evaluation' => $evaluation, ':class' => $class, ':comment' => $comment);
// クエリ実行（データを取得）
$stmt->execute($params);
?>
<?php
$sql = "SELECT * FROM evaluate2";
$res = $pdo->query($sql);
?>
<h3>授業一覧</h3>
<p>授業総数</p>
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

<p><a href="index.php">トップへ戻る</a></p>
</body>
