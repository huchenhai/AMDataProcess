<?php
include("connect.php");

include("Classes/PHPExcel/IOfactory.php");

$objPHPExcel=PHPExcel_IOFactory::load('programmertest2016.xlsx');
$worksheet=$objPHPExcel->setActiveSheetIndexByName('Data');

	$highestRow=$worksheet->getHighestRow();
	$higestCol=$worksheet->getHighestColumn();
	//echo $highestRow."<br>".$higestCol;
	for($row=2;$row<=$highestRow;$row++)
	{   $i=0;
	    for($col='A';$col!='J';$col++)
	    {
		$rowvalue[$i] = $worksheet->getCell($col.$row)->getValue();
		$i++;
	    }

        $dbvalue=array('id'=>$rowvalue[0],'name'=>$rowvalue[2],'language'=>$rowvalue[3]
        ,'liability'=>$rowvalue[4],'property'=>$rowvalue[5],'eo'=>$rowvalue[6],'excess'=>$rowvalue[7],
        'umbrella'=>$rowvalue[8]);
        //set tempory value
   
        $dbvalue['liability']=setDbValue($db,'LIABILITY','LIABILITY_ID',$rowvalue[4]);
        $dbvalue['property']=setDbValue($db,'PROPERTY','PROPERTY_ID',$rowvalue[5]);
        $dbvalue['eo']=setDbValue($db,'EO','EO_ID',$rowvalue[6]);
        $dbvalue['excess']=setDbValue($db,'EXCESS','EXCESS_ID',$rowvalue[7]);
        $dbvalue['umbrella']=setDbValue($db,'UMBRELLA','UMBRELLA_ID',$rowvalue[8]);
        //insert into database
        $sql="INSERT INTO COMPANY(COMPANY_ID,DESCRIPTION,LANGUAGE) VALUES('$dbvalue[id]','$dbvalue[name]','$dbvalue[language]') ";
        $result=$db->query($sql);
        $linesql="INSERT INTO LINES_OF_BUSINESS(LIABILITY_ID,PROPERTY_ID,EO_ID,EXCESS_ID,UMBRELLA_ID,COMPANY_ID)
        VALUES('$dbvalue[liability]','$dbvalue[property]','$dbvalue[eo]','$dbvalue[excess]','$dbvalue[umbrella]','$dbvalue[id]')";
        $result=$db->query($linesql);

        
        // foreach ($dbvalue as $key => $value) {
        // 	# code...
        // 	echo $value."@";
        // }
        // echo "<br>";
        


	}

     
	
function setDbValue($db,$table,$field,$value){
   $sql="SELECT $field FROM $table WHERE LINE_VALUE='$value'";
   $result=$db->query($sql);
   $row=$result->fetch_assoc();
   return $row[$field];
}



?>