<?php

/**
 * Team Leaders Model
 */
class TeamLeaders_model extends Model
{
    protected $table = 'team_teamleaders';

	protected $allowedColumns = [
        'user_id',
        'factory_id',
        'team_id',
        'disabled',
        'date',
    ];

    protected $beforeInsert = [
        'make_factory_id',
    ];

    protected $afterSelect = [
        'get_user',
    ];

    public function make_factory_id($data)
    {
        if(isset($_SESSION['USER']->factory_id)){
            $data['factory_id'] = $_SESSION['USER']->factory_id;
        }
        return $data;
    }

    public function get_user($data)
    {
        
        $user = new User();
        foreach ($data as $key => $row) {
            // code...
            if(isset($row->user_id)){
                $result = $user->where('user_id',$row->user_id);
                $data[$key]->user = is_array($result) ? $result[0] : false;
            }
        }
       
        return $data;
    }

    

 
}