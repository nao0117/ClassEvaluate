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
<?php
$class = $_POST['kougi'];
//print("$class");

/*入力フォームでmethodをpostに指定しているため＄＿POSTによって受け取る。入力したテキストはnameという名前で送信されているので＄_POST['name']となる*/

print ("$classの評価は以下の通りです。<br />");
$sql = "SELECT * FROM evaluate2 WHERE class = :class";
// プリペアドステートメントを作成
$stmt = $pdo->prepare($sql);
// プレースホルダと変数をバインド
$stmt -> bindParam(":class",$class);
$stmt -> execute(); //実行

// データを取得
$rec = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<body>
<h1><?php echo $title; ?></h1>
<h2>「<?php echo "$class"; ?>」検索結果</h2>

<table>
  <tr>
    <th>登録番号</th>
    <th>講義名</th>
    <th>評価点</th>
    <th>教師名</th>
    <th>コメント</th>
  </tr>
<?php
  echo "<tr>";
  echo "<td>$rec[num]</td>";
  echo "<td>$rec[class]</td>";
  echo "<td>$rec[evaluation]</td>";
  echo "<td>$rec[name]</td>";
  echo "<td>$rec[comment]</td>";
  echo "</tr>";
?>
</table>

<p><a href="index.php">トップへ戻る</a></p>
</body>
