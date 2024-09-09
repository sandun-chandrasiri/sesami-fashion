<?php

/**
 * Debit Model
 */
class Debit extends Model
{
    protected $table = 'debit';

	protected $allowedColumns = [
        'name',
        'description',
        'amount',
        'status',
    ];

    protected $beforeInsert = [
        'make_factory_id',
        'make_name_id',
        'make_user_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];


    public function validate($DATA)
    {
        $this->errors = array();

        //check for name
        if(empty($DATA['name']) || !preg_match('/^[a-z A-Z]+$/', $DATA['name']))
        {
            $this->errors['name'] = "Only letters are allowed in name";
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

    public function make_name_id($data)
    {
        
        $data['name_id'] = random_string(60);
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

    public function getTotalPayableAmount()
    {
        $query = "SELECT SUM(amount) AS total FROM debit WHERE factory_id = :factory_id AND status = 'payable'";
        $arr['factory_id'] = $_SESSION['USER']->factory_id;

        $result = $this->query($query, $arr);
        return $result[0]->total;
    }

    public function getTotalPaidAmount()
    {
        $query = "SELECT SUM(amount) AS total FROM debit WHERE factory_id = :factory_id AND status = 'paid'";
        $arr['factory_id'] = $_SESSION['USER']->factory_id;

        $result = $this->query($query, $arr);
        return $result[0]->total;
    }


    

 
}