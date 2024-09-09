<?php

/**
 * make inventory pdf controller
 */
class Make_inventory_pdf extends Controller
{
    
    function index($id = '',$inventory_id = '')
    {
  
        $errors = array();
 
        $inventory = new Inventory_model();
        $rows = $inventory->getAllRows();

        if (empty($rows)) {
            // Handle the case where no inventory records are found
            echo "No Inventory Items were found at this time";
            return;
        }


        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Inventory Records</title>

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
            <h1>Inventory Records</h1>
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
                <tr><th>Item Name</th><th>Description</th><th>Quantity</th><th>Type</th>
                </tr>
                <?php if(isset($rows) && $rows):?>
                     
                    <?php foreach ($rows as $row):?>
                     
                     <tr>
                        <td><?=$row->inventory?></td><td><?=$row->description?></td><td><?=$row->quantity?></td><td><?=$row->type?></td>

                     </tr>

                    <?php endforeach;?>
                    <?php else:?>
                        <tr><td colspan="5"><center>No Inventory Items were found at this time</center></td></tr>
                    <?php endif;?>

            </table>
        </div>
        </body>
        </html>                

        <?php 
    }
}



