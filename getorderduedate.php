<?php


$intent=$_GET['int'];
$host='localhost';
$user='id2243824_jude';
$password='ajk1407';
$database='id2243824_raveg';
error_reporting(0);


$connection=mysqli_connect($host,$user,$password,$database);
$count="SELECT COUNT(Name) FROM Users where Active=1";
$post_count=mysqli_query($connection,$count);
$answer= mysqli_fetch_array($post_count);
if($answer[0]==0){
    $myObj = new stdClass();
    $myObj->res="There was an authentication error. Kindly reauthenticate";
    $myJSON = json_encode($myObj);
    echo $myJSON;
}
else{
if($intent=='GetOrderDueDate'){
$dd=$_GET['dd'];
$sql = "SELECT * FROM Parts where job_number=$dd";
$post_results=mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($post_results);
$result = $row['due_date'];
$myObj = new stdClass();
if(strlen($result)>0){
$myObj->res = "The due date is ".$result;
}
else{
$myObj->res="I could not find any such order";
}
$myJSON = json_encode($myObj);
echo $myJSON;
}

if($intent=='GetCustomer'){
$order=$_GET['dd'];
$sql = "SELECT * FROM Orders where order_id=$order";
$post_results=mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($post_results);
$result = $row['customer'];
$myObj = new stdClass();
if(strlen($result)>0){
$myObj->res = "The customer is ".$result;
}
else{
$myObj->res="I could not find any such order";
}
$myJSON = json_encode($myObj);
echo $myJSON;
}

if($intent=='GetPartsInOrder'){
$order=$_GET['dd'];
$count="SELECT COUNT(part_number) FROM Parts where order_id=$order";
$post_count=mysqli_query($connection,$count);
$answer= mysqli_fetch_array($post_count);
$sql = "SELECT part_number FROM Parts where order_id=$order";
$post_results=mysqli_query($connection,$sql);
if($answer[0]==1)
{
$results= "There is ".$answer[0]." part. It is ";
}
else{
$results= "There are ".$answer[0]." parts. They are ";
}
while($row = mysqli_fetch_array($post_results)){
	$results=$results.$row['part_number']." , ";
}
$myObj = new stdClass();
if($answer[0]>0){
$myObj->res = $results;
}
else{
$myObj->res="I could not find any such order";
}
$myJSON = json_encode($myObj);
echo $myJSON;
}

if($intent=='GetPendingOrders'){
$count="SELECT COUNT(order_id) FROM Orders where status=1";
$post_count=mysqli_query($connection,$count);
$answer= mysqli_fetch_array($post_count);
$sql = "SELECT order_id FROM Orders where status=1";
$post_results=mysqli_query($connection,$sql);
if($answer[0]==1){
$results= "There is ".$answer[0]." order. It is ";
}
else{
$results= "There are ".$answer[0]." orders. Top five are are ";
}
$i=1;
while($i<=5){
$row = mysqli_fetch_array($post_results);
	$results=$results."<say-as interpret-as='characters'>";
        $results=$results.$row['order_id']."</say-as><break time='0.5s'/>";
$i=$i+1;

}
$myObj = new stdClass();
if($answer[0]>0){
$myObj->res = $results;
}
else{
$myObj->res = "There are no pending orders";
}
$myJSON = json_encode($myObj);
echo $myJSON;
}
if($intent=='JobsOnHold'){
$count="SELECT COUNT(job_number) FROM Parts where OnHold=1";
$post_count=mysqli_query($connection,$count);
$answer= mysqli_fetch_array($post_count);
$sql = "SELECT job_number FROM Parts where OnHold=1";
$post_results=mysqli_query($connection,$sql);

if($answer[0]==1){
$results= "There is ".$answer[0]." job. It is ";
}
else{
$results= "There are ".$answer[0]." jobs. They are ";
}
$i=1;
while($i<=5){
$row = mysqli_fetch_array($post_results);
	$results=$results."<say-as interpret-as='characters'>";
        $results=$results.$row['job_number']."</say-as><break time='0.5s'/>";
$i=$i+1;

}
$myObj = new stdClass();
if($answer[0]>0){
$myObj->res = $results;
}
else{
$myObj->res = "There are no pending jobs";
}
$myJSON = json_encode($myObj);
echo $myJSON;
}
if($intent=='JobsEnteredToday'){
$date=date('Y-m-d');
$count="SELECT COUNT(job_number) FROM Parts where EntryDate='$date'";
$post_count=mysqli_query($connection,$count);
$answer= mysqli_fetch_array($post_count);
$sql = "SELECT job_number FROM Parts where EntryDate='$date'";

$post_results=mysqli_query($connection,$sql);
if($answer[0]==1){
$results= "There is ".$answer[0]." job. It is ";
}
else{
$results= "There are ".$answer[0]." jobs. Top 5 are ";
}
$i=1;
while($i<=5){
$row = mysqli_fetch_array($post_results);
	$results=$results."<say-as interpret-as='characters'>";
        $results=$results.$row['job_number']."</say-as><break time='0.5s'/>";
$i=$i+1;

}
$myObj = new stdClass();
if($answer[0]>0){
$myObj->res = $results;
}
else{
$myObj->res = "There are no pending jobs";
}
$myJSON = json_encode($myObj);
echo $myJSON;
}
if($intent=='JobsDueNextWeek'){
$date1=date('Y-m-d');
$date=date('Y-m-d');
$date2=date('Y-m-d', strtotime($date. ' + 1 week'));
$count="SELECT COUNT(job_number) FROM Parts where due_date between '$date1' and '$date2'";
$post_count=mysqli_query($connection,$count);
$answer= mysqli_fetch_array($post_count);
$sql = "SELECT job_number FROM Parts where due_date between '$date1' and '$date2'";

$post_results=mysqli_query($connection,$sql);
if($answer[0]==1){
$results= "There is ".$answer[0]." job. It is ";
}
else{
$results= "There are ".$answer[0]." jobs. They are ";
}
while($row = mysqli_fetch_array($post_results)){
	$results=$results."<say-as interpret-as='characters'>";
        $results=$results.$row['job_number']."</say-as><break time='0.5s'/>";


}
$myObj = new stdClass();
if($answer[0]>0){
$myObj->res = $results;
}
else{
$myObj->res = "There are no pending jobs";
}
$myJSON = json_encode($myObj);
echo $myJSON;
}
/*if($intent=='GetQuantity'){
$order=$_GET['dd'];
$sql = "SELECT * FROM Parts where order_id=$order";
$post_results=mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($post_results);
$result = $row['part_number'];
$myObj = new stdClass();
$myObj->res = $result;
$myJSON = json_encode($myObj);
echo $myJSON;
}*/
}
mysqli_close($connection);


?>