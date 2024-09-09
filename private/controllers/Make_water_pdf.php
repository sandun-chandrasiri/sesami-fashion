<?php

/**
 * make water pdf controller
 */
class Make_water_pdf extends Controller
{
    
    function index($id = '',$month_id = '')
    {
  
        $errors = array();
 
        $water = new Water_model();
        $rows = $water->getAllRows();

        if (empty($rows)) {
            // Handle the case where no water records are found
            echo "No Water consumption record were found at this time";
            return;
        }


        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Water Records</title>

            <style>
                body {
                    font-family: sans-serif;
                    font-size: 10pt;
                }

                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                th, td {
                    border: 1px solid #ddd;
                    padding: 5px;
                }

                .company-info {
                    text-align: right;
                }

                .customer-info {
                    text-align: left;
                }

                .invoice-info {
                    text-align: right;
                }

                .line-items {
                    border: 1px solid #ddd;
                }

                .line-items th {
                    background-color: #eee;
                }

                .totals {
                    border: 1px solid #ddd;
                    font-weight: bold;
                }

                .payment-info {
                    text-align: left;
                }
            </style>
        </head>
        <body>
            <h1>Water Consumption Records</h1>
            <br>
            <div class="company-info">
                
                <br>
                Nisala Garments Pvt Ltd.<br>
                123 Bandaragama Rd<br>
                Wadduwa 12560<br>
                Phone: 034-000-0000<br>
                Email: info-seasami@gmail.com
            </div>
            <br><br><br>
            <div class="card-group justify-content-center">

                <table class="table table-striped table-hover">
                    <tr><th>Month</th><th>Units used</th>
                    </tr>
                    <?php if(isset($rows) && $rows):?>
                         
                        <?php foreach ($rows as $row):?>
                         
                         <tr>
                            <td><?=$row->month?></td><td><?=$row->units?></td>
                         </tr>

                        <?php endforeach;?>
                        <?php else:?>
                            <tr><td colspan="5"><center>No Water usage records were found at this time</center></td></tr>
                        <?php endif;?>

                </table>
            </div>      
        </body>
        </html>                

        <?php 
    }
}



