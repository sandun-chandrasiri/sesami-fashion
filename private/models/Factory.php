<?php

/**
 * Factory Model
 */
class Factory extends Model
{

	protected $allowedColumns = [
        'factory',
        'date',
    ];

    protected $beforeInsert = [
        'make_factory_id',
        'make_user_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];


    public function validate($DATA)
    {
        $this->errors = array();

        //check for factory name
        if(empty($DATA['factory']) || !preg_match('/^[a-zA-Z ]+$/', $DATA['factory']))
        {
            $this->errors['factory'] = "Only letters & spaces allowed in factory name";
        }
 
        if(count($this->errors) == 0)
        {
            return true;
        }

        return false;
    }

    public function make_user_id($data)
    {
        if(isset($_SESSION['USER']->user_id)){
            $data['user_id'] = $_SESSION['USER']->user_id;
        }
        return $data;
    }

    public function make_factory_id($data)
    {
        
        $data['factory_id'] = random_string(60);
        return $data;
    }

    public function get_user($data)
    {
        
        $user = new User();
        foreach ($data as $key => $row) {
            // code...
            $result = $user->where('user_id',$row->user_id);
            $data[$key]->user = is_array($result) ? $result[0] : false;
        }
       
        return $data;
    }

    

 
}