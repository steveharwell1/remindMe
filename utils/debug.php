<?php
function tablify($res) {
    if ($res->num_rows === 0) {
      echo "<div>no result</div>";
      return;
    }
    for ($i=0; $i < $res->num_rows; $i++) { 
      $row = $res->fetch_assoc();
      if ($i === 0){
        echo '<table><thead><tr>';
        foreach ($row as $key => $value) {
          echo '<th>'.$key.'</th>';
        }
        echo '</tr></thead><tbody>';
      }
      echo '<tr>';
      foreach ($row as $key => $value) {
        echo '<td>'.$value.'</td>';
      }
      echo '</tr>';
    }
    echo '</tbody></table>';
  }