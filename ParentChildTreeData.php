
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
    if ($calls > $max_calls)
        $max_calls = $calls;
    foreach ($elements as $element) {//print_r($element);die;
        if ($element['parent_id'] == $parentId) {
            /*if($parentId){
              echo str_repeat('-->',$calls);
            }
            echo $element['title']."<br>";*/
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

$tree = buildTree($data2);
print_r( $tree );

/*foreach ($tree as $key => $value) {
  echo $value['title'];
  if(!empty($value['children']))
  {
    print_r($value['children']);
  }
}*/
mysqli_close($con);

?>
