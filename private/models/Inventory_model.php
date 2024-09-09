<?php

/**
 * Inventory Model
 */
class Inventory_model extends Model
{
    protected $table = 'inventory';

	protected $allowedColumns = [
        'inventory',
        'description',
        'quantity',
        'type',
        'factory_id',
        'inventory_id',

    ];

    protected $beforeInsert = [
        'make_factory_id',
        'make_inventory_id',
        'make_user_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];


    public function validate($DATA)
    {
        $this->errors = array();

        //check for inventory name
        if(empty($DATA['inventory']) || !preg_match('/^[a-z A-Z0-9]+$/', $DATA['inventory']))
        {
            $this->errors['inventory'] = "Only letters & numbers allowed in inventory name";
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

    public function make_inventory_id($data)
    {
        
        $data['inventory_id'] = random_string(60);
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

    public function getAllRows()
    {
        $query = "SELECT * FROM $this->table";
        $data = $this->query($query);

        // Run functions after select
        if (is_array($data) && property_exists($this, 'afterSelect')) {
            foreach ($this->afterSelect as $func) {
                $data = $this->$func($data);
            }
        }

        return $data;
    }

 
}