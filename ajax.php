<?php
include('db_con.php');

$sql = "SELECT * FROM messages m  JOIN users u ON m.user_id = u.user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_row = $stmt->rowCount();

$output = '
<table
     <tr>
     <th>name</th>
     <th>Message</th>
     <th>edit</th>
     <th>delete</th>
     
     </tr>
';

//var_dump($messages);

if($total_row > 0){
    foreach ($messages as $row) {
        $output.= '
        <tr>
          <td>'.$row["user_name"].'</td>
          <td>'.$row["user_message"].'</td>
          <td>
          <button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["user_id"].'">edit</button>
</td>
          <td>
          <button type="button" name="delete" class="btn btn-primary btn-xs delete" id="'.$row["user_id"].'">delete</button>
</td>
        </tr>
        ';

    }

}
else {
    echo 'Dad';
}
//var_dump($messages);

$output.='</table>';

echo $output;


?>