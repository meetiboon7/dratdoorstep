<?php
// include 'connection.php';
// session_start();

// $app=$_POST['app'];
//  $query="select * from extra_invoice where extra_invoice_id=$app";
// $fire=mysql_query($query) or die(mysql_error());
// while($k=mysql_fetch_array($fire)){
// $p=$k['patient_id'];
// $tot=$k['price'];
// //$dis=$k['discount'];
// $list=$k['list'];
// $date=$k['date'];


// }

// $get="select * from patient where patient_id=$p";
// $get1=mysql_query($get,$connect);
// while($r=mysql_fetch_array($get1)){
// $name=$r[1];
// $add=$r[2];
// $city=$r[4];
// }
/*echo "<pre>";
print_r($address_data);
echo $address_data[address_1];*/

// $address_1=$address_data['address_1'];
// $address_2=$address_data['address_2'];
// echo "<pre>";
// print_r($address_data);
// exit;
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>DrAtDoorstep - An Innovative Health Care Solution!</title>
    
    
    <style>
    .invoice-box{
        max-width:800px;
        margin:auto;
        padding:30px;
        border:1px solid #eee;
        box-shadow:0 0 10px rgba(0, 0, 0, .15);
        font-size:16px;
        line-height:24px;
        font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color:#555;
    }
    
    .invoice-box table{
        width:100%;
        line-height:inherit;
        text-align:left;
    }
    
    .invoice-box table td{
        padding:5px;
        vertical-align:top;
    }
    
    .invoice-box table tr td:nth-child(2){
        text-align:right;
    }
    
    .invoice-box table tr.top table td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.top table td.title{
        font-size:45px;
        line-height:45px;
        color:#333;
    }
    
    .invoice-box table tr.information table td{
        padding-bottom:40px;
    }
    
    .invoice-box table tr.heading td{
        background:#eee;
        border-bottom:1px solid #ddd;
        font-weight:bold;
    }
    
    .invoice-box table tr.details td{
        padding-bottom:20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom:1px solid #eee;
    }
    
    .invoice-box table tr.item.last td{
        border-bottom:none;
    }
    
    .invoice-box table tr.total td:nth-child(2){
        border-top:2px solid #eee;
        font-weight:bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td{
            width:100%;
            display:block;
            text-align:center;
        }
        
        .invoice-box table tr.information table td{
            width:100%;
            display:block;
            text-align:center;
        }
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img  src="<?php echo base_url(); ?>assets/media/photo.png" >
                            </td>
<td style="text-align: left;padding-right: 64px;">
                                <h2 >Receipt</h2>
                            </td>
                            <td>
                               <!--  <?php 
                                    if($city == 139){
                                ?>
                                <h3>Nisarg Wellness Pvt. Ltd</h3>
                                624 Gala Empire,<br>
                                Nr. TV Tower,<br>
                                Opp. Doordarshan,<br>
                                Drive in Road, Ahmedabad - 380054<br>
                                CIN : U74999GJ2016PTC09489<br>
                                <?php
                                    }else{
                                ?>    
                                <h3>Nisarg Wellness Pvt. Ltd</h3>
                                11, Dipavali Society,<br>
                                Nr. Amrapali Complex,<br>
                                Karelibaug, Vadodara-390018<br>
                                8000126666<br>
                                CIN : U74999GJ2016PTC09489<br>
                                <?php } ?> -->
                                 <b> <lable>Nisarg Wellness Pvt. Ltd</lable></b><br>
                                11, Dipavali Society,<br>
                                Nr. Amrapali Complex,<br>
                                Karelibaug, Vadodara-390018<br>
                               Mo- 8000126666<br>
                                CIN : U74999GJ2016PTC09489<br>
                                <?php// echo $date;?>
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
             <!-- <tr >
<td colspan="2" style="text-align: left;" > <h2>Invoice No: <?php echo $app;?></h2></td>


</tr> -->
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                          <td>
                                <lable><b>Receipt No: <?php echo $invoice_data['package_book_id'];?></b></lable><br>
                         <?php echo $invoice_data['first_name']." ".$invoice_data['last_name'];?><br>
                                <?php //echo $extra_invoice['address'];
                                echo $invoice_data['address_1'].",".$invoice_data['address_2'];
                                ?><br>
                                
                                <?php echo "Date: ".date('d-m-Y',strtotime($invoice_data['created_date']));?>
                            </td>
                            
                            <!--<td>
                                Acme Corp.<br>
                                John Doe<br>
                                john@example.com
                            </td>-->
                        </tr>
                    </table>
                </td>
            </tr>
            
            <!--<tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                    Check #
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    Check
                </td>
                
                <td>
                    1000
                </td>
            </tr>-->
            
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    <?php echo $invoice_data['service_type'] ;?>
                </td>
            
                <td>
                   <?php echo $invoice_data['fees'] ;?> Rs
                </td>
            </tr>
            
            
<tr class="item">
              
                <td>
                    Discount
                </td>
                
                <td>
                   0 Rs
                </td>
            </tr>
            
            <?php
            // echo "<pre>";
            // print_r($extra_invoice);
                if($invoice_data[amount] !=0)
                {
                    ?>
            <tr class="item">
                <td>
                   <?php echo $address_data[note]; ?>
                </td>
               
                     <td>
                        <?php echo  number_format((float)$invoice_data[amount], 2, '.', '');?> ₹
                     </td>
                  
            </tr>
            <?php
                }
               ?>

<tr class="item">
                <td>
                    Tax
                </td>
                
                <td>
                    00.00 Rs
                </td>
            </tr>
            
            
            
            <tr class="total">
                <td></td>
                
                <td>
                   <?php //echo $extra_invoice['price'];?>
                    Total: <?php echo   number_format($invoice_data['fees'], 2, '.', '');?> ₹
                </td>
            </tr>
        </table>
<div class="row" style="font-size: 9px;
    text-align: center;">This is computer generated invoice.No signature required.</div>
    </div><br>
    <center>
    <a href="<?php echo base_url()."package_list"?>" style="color: #3F4254;
    background-color: #d7dae7;
    border-color: #d7dae7;" >Back</a>
</center>
    </div>
</body>

</html>
