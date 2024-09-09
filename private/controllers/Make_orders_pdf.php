<?php

/**
 * make orders pdf controller
 */
class Make_orders_pdf extends Controller
{
    
    function index($id = '',$order_id = '')
    {
  
        $errors = array();
 
        $orders = new Order();
        $row = $orders->first('order_id',$id);

        if ($row === false) {
            // Handle the case where the order with the specified ID doesn't exist
            echo "Order not found";
            return;
        }


        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Invoice</title>

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
            <h1>Invoice</h1>
            <br>
            <div class="company-info">
                
                <br>
                Nisala Garments Pvt Ltd.<br>
                123 Bandaragama Rd<br>
                Wadduwa 12560<br>
                Phone: 034-000-0000<br>
                Email: info-seasami@gmail.com
            </div>

            <div class="customer-info">
                Bill To:<br>
                <?= $row->customer_name ?><br>
                <?= $row->address_line_one ?><br>
                <?= $row->address_line_two ?><br>
                Phone: <?= $row->contact ?><br>
                Email: <?= $row->email ?>
            </div>

            <div class="invoice-info">
                Invoice Number: <?= $row->id ?><br>
                Invoice Date: 2023-12-08<br>
                Payment Type: <?= $row->payment_type ?>
            </div>
            <br>
            <br>
            <table class="line-items">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $row->order_name ?></td>
                        <td><?= $row->category ?></td>
                        <td><?= $row->description ?></td>
                        <td><?= $row->quantity ?></td>
                        <td>LKR <?= $row->total ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4">Grand Total</th>
                        <th>LKR <?= $row->total ?></th>
                    </tr>
                </tfoot>
            </table>
        </body>
        </html>                

        <?php 
    }
}



