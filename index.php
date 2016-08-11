<?php
   include("connect.php");
    $lan='E';
   	$sql="SELECT COMPANY.COMPANY_ID AS id,COMPANY.DESCRIPTION AS name,LIABILITY.LINE_VALUE AS liability,PROPERTY.LINE_VALUE AS property,
   	EO.LINE_VALUE AS eo,EXCESS.LINE_VALUE AS excess,UMBRELLA.LINE_VALUE AS umbrella
   	FROM COMPANY,LIABILITY,PROPERTY,EO,EXCESS,UMBRELLA,LINES_OF_BUSINESS
   	WHERE COMPANY.LANGUAGE='$lan'
   	AND COMPANY.COMPANY_ID = LINES_OF_BUSINESS.COMPANY_ID
   	AND LIABILITY.LIABILITY_ID = LINES_OF_BUSINESS.LIABILITY_ID
   	AND PROPERTY.PROPERTY_ID = LINES_OF_BUSINESS.PROPERTY_ID
   	AND EO.EO_ID = LINES_OF_BUSINESS.EO_ID
   	AND EXCESS.EXCESS_ID=LINES_OF_BUSINESS.EXCESS_ID
   	AND UMBRELLA.UMBRELLA_ID = LINES_OF_BUSINESS.UMBRELLA_ID
   	ORDER BY COMPANY.COMPANY_ID
   	 ";
   	   $result=$db->query($sql);
       $total=$result->num_rows;
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
<!DOCTYPE html>
    <head>
        <title>AM Test, Chenhai</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.3/css/bootstrap.min.css" integrity="sha384-MIwDKRSSImVFAZCVLtU0LMDdON6KVCrZHyVQQj6e8wIEJkW4tvwqXrbMIya1vriY" crossorigin="anonymous">
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>
    <body>
      <h1>Chenhai Hu test</h1>
        <div class="container" style="margin-top:30px;">
        	   <div class="col-md-10" style="padding-left:30px;">
             
               	<input name="option" id="option"type="text">
               	<input type="button" value="submit" id="button">
               	<select name="language" id="language"><option value="E">English</option><option value="F">French</option></select>
           
        	   </div>
                <div class="col-md-10 col-md-offset-1">
                <div class="container" id ="result" style="padding-top:30px;">
                <table class="table table-striped table-condensed table-bordered table-rounded">
                   <thead>
                                <tr>
                                <th width="45%">Description of Risk</th>
                                <th width="10%">Liability</th>
                                <th width="10%">Property</th>
                                <th width="10%">E&O</th>
                                <th width="10%">Excess</th>
                                <th width="5%">Umbrella</th>
                        </tr>
                        </thead>
                   <tbody>
                   	<?php while($row=$result->fetch_assoc()): ?>
       					 <tr>
              			  	 <td><?php  echo $row['name']; ?></td>
              
                			
                			<td>
                                <? echo parsePdf($row['liability']); ?>
                			</td>
                		
               				<td><? echo parsePdf($row['property']); ?></td>
                			<td><img src="pdf.png" width="30" height="30"title=<? echo $row['eo'] ?>></td>
                			<td><img src="pdf.png" width="30" height="30"title=<? echo $row['excess'] ?>></td>
                			<td><img src="pdf.png" width="30" height="30"title=<? echo $row['umbrella'] ?>></td> 
        				</tr>
					<?php endwhile; ?>
					</tbody>
               </table>
               </div>
         </div>
       </div>
        </body>
        
</html>
<script>
$(document).ready(function(){
   $('#option').keyup(search);
   $( "#language" ).change(search);
   function search(){
   	var txt = $('#option').val();
   	var language = $('#language option:selected').val();
   	if(txt!='')
   	{
      $.ajax({
         url:"search.php",
         method:"post",
         data:{search:txt,language:language},
         dataType:"text",
         success:function(data)
         {
         	$('#result').html(data);
         }
   		});
   	}
   	else{
   		$.ajax({
         url:"search.php",
         method:"post",
         data:{search:'',language:language},
         dataType:"text",
         success:function(data)
         {
         	$('#result').html(data);
         }
   		});
   	}
   }

});
</script>
