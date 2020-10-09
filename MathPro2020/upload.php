<html>
<head>
<meta charset="utf-8">
<title>Upload</title>
</head>
<body>
<?php

//一時的なファイル名を定義する
$tempfile = $_FILES['fname']['tmp_name'];
//本来のファイル名を定義する
$filename =$_FILES['fname']['name'];

//パラメータが届いているか確認
if(isset($_POST['section'])){
    //ディレクトリパラメータで保存ディレクトリを振り分ける
    $paradir = $_POST['section'];

    switch($paradir){
        //パラメータごとに保存するディレクトリを設定する
        case '1':
            $uploaddir = 'upload/kinoho';//帰納法
            break;
        case '2':
            $uploaddir = 'upload/bibun';//微分
            break;
        case '3':
            $uploaddir = 'upload/sekibun';//積分
            break;
        default:
            $uploaddir = 'upload';
            break;

    }
    //対応するパスを作成する
    $uploadfile = $uploaddir. '/'.basename($_FILES['fname']['name']);

}

//POSTメソッドでリクエストされたか確認
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //php.iniで設定されているファイルサイズを越えた場合
    if($_FILES['fname']['error'] === 2){
        echo 'ファイルサイズが大きいです。';
    
    //ファイルが選ばれているかをファイルサイズで確認
    } else if($_FILES['fname']['size'] === 0){
        echo 'ファイルを選択してください。';
    
        //ファイル形式を判定
    } else if($_FILES['fname']['type'] !== 'image/png' && $_FILES['fname']['type'] !== 'image/jpeg' && $_FILES['fname']['type'] !== 'application/pdf'){
        echo 'ファイル形式を変更してください。';
    
    //0であれば、正常に動いているため、アップロードをする
    } else if($_FILES['fname']['error'] === 0){
        move_uploaded_file($tempfile , $uploadfile );
        echo $filename . "をアップロードしました。";
    
    } else {
        echo "ファイルをアップロードできません。";
    }

} else {
    echo '不正なアクセスです。';
} 

/*
ver2.0で変更されたソースコード
保存ディレクトリ
$uploaddir = 'upload';
保存先のパスを作成する
$uploadfile = $uploaddir. '/'.basename($_FILES['fname']['name']);

//ファイルが存在しているかを確認している
if (is_uploaded_file($tempfile)) {
    if ( move_uploaded_file($tempfile , $uploadfile )) {
	echo $filename . "をアップロードしました。";
    } else {
        echo "ファイルをアップロードできません。";
    }
} else {
    echo "ファイルが選択されていません。";
}

使い方
move_uploaded_file($tmpfile, $uploadfile)
説明：第1引数は一時的なファイル名を指定する。第2引数はアップロードするファイルパスを指定する。
*/

?>
    <br>
    <button type='button'><a href="upload.html">戻る</a></button>
</body>
</html>
