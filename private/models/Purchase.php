<?php

/**
 * Purchase Model
 */
class Purchase extends Model
{
    protected $table = 'purchase_orders';

	protected $allowedColumns = [
        'purchase_name',
        'description',
        'category',

    ];

    protected $beforeInsert = [
        'make_factory_id',
        'make_purchase_id',
        'make_user_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];


    public function validate($DATA)
    {
        $this->errors = array();

        //check for purchase name
        if(empty($DATA['purchase_name']) || !preg_match('/^[a-z A-Z0-9]+$/', $DATA['purchase_name']))
        {
            $this->errors['purchase_name'] = "Only letters & numbers allowed in purchase name";
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

    public function make_purchase_id($data)
    {
        
        $data['purchase_id'] = random_string(60);
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

    public function getCategoryCounts()
    {
        $query = "SELECT category, COUNT(*) as count FROM purchase_orders WHERE factory_id = :factory_id GROUP BY category";
        //echo $query; // Add this line to debug
        $arr['factory_id'] = $_SESSION['USER']->factory_id;
        $result = $this->query($query, $arr);
        //$result = $this->query($query);
        return $result;
    }
        

 
}