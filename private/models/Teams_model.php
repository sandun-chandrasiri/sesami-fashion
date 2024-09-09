<?php

/**
 * Teams Model
 */
class Teams_model extends Model
{
    protected $table = 'teams';

	protected $allowedColumns = [
        'team',
        'date',
    ];

    protected $beforeInsert = [
        'make_factory_id',
        'make_team_id',
        'make_user_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];


    public function validate($DATA)
    {
        $this->errors = array();

        //check for team name
        if(empty($DATA['team']) || !preg_match('/^[a-z A-Z0-9]+$/', $DATA['team']))
        {
            $this->errors['team'] = "Only letters & numbers allowed in team name";
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

    public function make_team_id($data)
    {
        
        $data['team_id'] = random_string(60);
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