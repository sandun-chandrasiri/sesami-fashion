<?php

/**
 * Orders Model
 */
class Order extends Model
{
    protected $table = 'orders';

	protected $allowedColumns = [
        'order_name',
        'description',
        'category',
        'status',
        'customer_name',
        'address_line_one',
        'address_line_two',
        'contact',
        'email',
        'payment_type',
        'quantity',
        'total',
        'order_id',
        'customer_id',//
    ];

    protected $beforeInsert = [
        'make_factory_id',
        'make_order_id',
        'make_user_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];


    public function validate($DATA)
    {
        $this->errors = array();

        //check for order name
        if(empty($DATA['order_name']) || !preg_match('/^[a-z A-Z0-9]+$/', $DATA['order_name']))
        {
            $this->errors['order_name'] = "Only letters & numbers allowed in order name";
        }
 
        if(count($this->errors) == 0)
        {
            return true;
        }

        return false;
    }

    public function make_factory_id($data)
    {
        if(isset($_SESSION['USER']->factory_id)){
            $data['factory_id'] = $_SESSION['USER']->factory_id;
        }
        return $data;
    }

    public function make_user_id($data)
    {
        if(isset($_SESSION['USER']->user_id)){
            $data['user_id'] = $_SESSION['USER']->user_id;
        }
        return $data;
    }

    public function make_order_id($data)
    {
        
        $data['order_id'] = random_string(60);
        return $data;
    }

    public function get_user($data)
    {
        
        $user = new User();
        foreach ($data as $key => $row) {
            // Check if user_id property exists before accessing it
            if (property_exists($row, 'user_id')) {
                $result = $user->where('user_id', $row->user_id);
                $data[$key]->user = is_array($result) ? $result[0] : false;
            } else {
                // Handle the case where user_id is not defined for the current row
                $data[$key]->user = false;
            }
            // previous code...
            //$result = $user->where('user_id',$row->user_id);
            //$data[$key]->user = is_array($result) ? $result[0] : false;
        }
       
        return $data;
    }

    public function getOrderStatusCounts()
    {
        $query = "SELECT status, COUNT(*) as count FROM orders WHERE factory_id = :factory_id GROUP BY status";
        //echo $query; // Add this line to debug
        $arr['factory_id'] = $_SESSION['USER']->factory_id;
        $result = $this->query($query, $arr);
        //$result = $this->query($query);
        return $result;
    }
    

 
}