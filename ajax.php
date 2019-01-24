<?php
include('db_con.php');

$sql = "SELECT * FROM messages m  JOIN users u ON m.user_id = u.user_id JOIN images i ON i.user_id = u.user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total_row = $stmt->rowCount();

$output = '
<table class="table table-striped table-bordered"
     <tr>
     <th>Name</th>
     <th>Message</th>
     <th>Edit</th>
     <th>Delete</th>
     <th>Image</th>
     
     </tr>
';

//var_dump($messages);

if($total_row > 0){
    foreach ($messages as $row) {
        $output.= '

        <tr>
          <td width="40%">'.$row["user_name"].'</td>
          <td width="40%">'.$row["user_message"].'</td>
          <td width="10%">
          <button type="button" name="edit" class="btn btn-primary btn-xs edit" id="'.$row["user_id"].'">edit</button>
</td>
          <td width="10%">
          <button type="button" name="delete" class="btn btn-primary btn-xs delete" id="'.$row["user_id"].'">delete</button>
</td>
          <td>
          <img src="files/'.$row["user_image_name"].'"class="img-thumbnail" width="100" height="100" onclick="window.open(this.src)"/>
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