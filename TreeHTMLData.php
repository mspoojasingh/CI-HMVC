
<?php  
$con=mysqli_connect("localhost","root","root","test");
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$sql2="SELECT a.id as id, a.parent as parent_id, a.title, b.title as parent_title FROM `njunw_team_chart` as a 
LEFT JOIN `njunw_team_chart` as b on b.id = a.parent order by a.id ASC";
$data2 = array();
    if ($result2=mysqli_query($con,$sql2))
    {
      while ($row=mysqli_fetch_assoc($result2))
      {
        $data2[] = $row;
      }
      
    }


function buildTree(array $elements, $parentId = 0) {

    static $calls = -1;
    static $max_calls = 0;
    $calls++;
    if ($calls > $max_calls)$max_calls = $calls;
    $branch = array();
    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            $calls--;
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

function htmlChildTree(array $tree) {

    echo "<ul>";
    foreach ($tree as $tr) {
      echo "<li>".$tr['title']."</li>";
      if(isset($tr['children']))htmlChildTree($tr['children']);
    }
    echo "</ul>";
}




$tree = buildTree($data2);
htmlChildTree($tree);


mysqli_close($con);

?>
