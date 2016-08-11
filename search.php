<?php
include("connect.php");
$search=$_POST["search"];
$language=$_POST['language'];
$output='';
 	$sql="SELECT COMPANY.COMPANY_ID AS id,COMPANY.DESCRIPTION AS name,LIABILITY.LINE_VALUE AS liability,PROPERTY.LINE_VALUE AS property,
   	EO.LINE_VALUE AS eo,EXCESS.LINE_VALUE AS excess,UMBRELLA.LINE_VALUE AS umbrella
   	FROM 
   	COMPANY,LIABILITY,PROPERTY,EO,EXCESS,UMBRELLA,LINES_OF_BUSINESS
   	WHERE 
    COMPANY.DESCRIPTION LIKE '%".$search."%'
    AND COMPANY.LANGUAGE='$language'
   	AND COMPANY.COMPANY_ID = LINES_OF_BUSINESS.COMPANY_ID
   	AND LIABILITY.LIABILITY_ID = LINES_OF_BUSINESS.LIABILITY_ID
   	AND PROPERTY.PROPERTY_ID = LINES_OF_BUSINESS.PROPERTY_ID
   	AND EO.EO_ID = LINES_OF_BUSINESS.EO_ID
   	AND EXCESS.EXCESS_ID=LINES_OF_BUSINESS.EXCESS_ID
   	AND UMBRELLA.UMBRELLA_ID = LINES_OF_BUSINESS.UMBRELLA_ID
   	ORDER BY COMPANY.COMPANY_ID";
$result=$db->query($sql);
$num=$result->num_rows;
if($num>0)
{
    $output .='<table class="table table-striped table-condensed table-bordered table-rounded">';
    $output .='         <thead>
                                <tr>
                                <th width="45%">Description of Risk</th>
                                <th width="15%">Liability</th>
                                <th width="10%">Property</th>
                                <th width="10%">E&O</th>
                                <th width="10%">Excess</th>
                                <th width="5%">Umbrella</th>
                        </tr>
                        </thead>';
                        while($row=$result->fetch_assoc())
                        {
                        	$output .='
  								<tr>
  									<td>'.$row['name'].'</td>
  									<td>'.parsePdf($row['liability']).'</td>
  									<td>'.parsePdf($row['property']).'</td>
  									<td><img src="pdf.png" width="30" height="30"title='.$row['eo'].'></td>
                			<td><img src="pdf.png" width="30" height="30"title='. $row['excess'].'></td>
                			<td><img src="pdf.png" width="30" height="30"title='.$row['umbrella'].'></td> 

  								</tr>
                        	
                        	';
                        }
                        echo $output;
}
else
{
   echo 'Data Not Found';
}

   function parsePdf($string){
   	$out='';
   if(count($split=preg_split("/\s(and)\s/", "$string"))==1){
   	//if it doesn't contain 'and' , change array to string
   	$split=preg_split("/\s(or)\s/","$string");
   	$out .='<img src="pdf.png" width="30" height="30"title="'.$split[0].'">';
   	return $out;
   }

   else {
   	$out .='<img src="pdf.png" width="30" height="30"title="'.$split[0].'">';
   	$out .='<img src="pdf.png" width="30" height="30"title="'.$split[1].'">';
   	//retrun array
   	return $out;
   } 
}
?>