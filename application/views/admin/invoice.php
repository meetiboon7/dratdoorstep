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

                            <td>
                                <?php 
                                /*
                                    if($city_id == 1){
                                ?>
                                <h3>Nisarg Wellness Pvt. Ltd</h3>
                                624 Gala Empire,<br>
                                Nr. TV Tower,<br>
                                Opp. Doordarshan,<br>
                                Drive in Road, Ahmedabad - 380054<br>
                                CIN : U74999GJ2016PTC09489<br>
                                <?php
                                    }else{
                               */ ?>    
                               <b> <lable>Nisarg Wellness Pvt. Ltd</lable></b><br>
                                11, Dipavali Society,<br>
                                Nr. Amrapali Complex,<br>
                                Karelibaug, Vadodara-390018<br>
                               Mo- 8000126666<br>
                                CIN : U74999GJ2016PTC09489<br>
                                <?php /* } */?>
                                <?php// echo $date;?>
                            </td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
           <td  colspan="2" style="text-align: center;padding-right: 64px;">
                                <h2 ><u>Receipt</u></h2>
                            </td>
           </tr>
            <!--  <tr >
                

<td colspan="2" style="text-align: left;" > <lable><b>Receipt No: <?php echo $extra_invoice_id;?></b></lable></td>

</tr> -->
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <lable><b>Receipt No: <?php echo $extra_invoice_id;?></b></lable><br>
                         <?php echo $name;?><br>
                                <?php echo $address_1." ".$address_2;?><br>
                                <?php echo "Date: ".date('d-m-Y',strtotime($date));?>
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

                <td style="padding-bottom: 15%;">
                    <?php
                    //$appointment_book_id;
                    if($appointment_book_id!='')
                    {
                      // echo " Consulting Charges";
                       echo $list_data;
                    }
                    elseif($book_nurse_id!='' || $book_laboratory_test_id!='')
                    {
                       // echo "Service Charges";
                        echo $list_data;
                    }
                    ?>
                   
                </td>
                
                <td>
                   <?php echo  number_format((float)$tot, 2, '.', '');?> ₹
                </td>
            </tr>
            
            
<tr class="item">
                <td>
                    Discount
                </td>
                
                <td>
                    <?php echo number_format((float)$dis, 2, '.', '');?> ₹
                </td>
            </tr>
             <?php
                if($amount !=0)
                {
                    ?>
            <tr class="item">
                <td>
                   <?php echo $note; ?>
                </td>
               
                     <td>
                        <?php echo  number_format((float)$amount, 2, '.', '');?> ₹
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
                    00.00 ₹
                </td>
            </tr>
            
            
            
            <tr class="total">
                <td></td>
                
                <td>
                   Total: <?php echo   number_format((float)$tot-$dis+$amount, 2, '.', '');?> ₹
                </td>
            </tr>
        </table>
<div class="row" style="font-size: 9px;
    text-align: center;">This is computer generated invoice.No signature required.</div>
    </div>
</body>
</html>
