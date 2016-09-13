<?php

class desk
{
      
      /*changes are good*/  
    const USER = 'USERNAME';
    const PASS = 'PASSWORD';
    const BASE_URL = 'https://host.ok';


    public function get($href, $json=false, $post=false,$patch=false){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::BASE_URL.$href);
        curl_setopt($ch, CURLOPT_USERPWD, self::USER . ":" . self::PASS);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $post ? curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post)) : $post=false; 
        $patch ? curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH') : $patch=false;
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result=curl_exec ($ch);
        $json ? $r = json_decode($result, true) : $r = $result;
        curl_close ($ch);
        return $r;
    }

    

    public function getNsave($caseID)
    {
        $result = self::get('/api/v2/cases/'.$caseID, true);
        file_put_contents($caseID .'.json', $result);
    }

    public function get_group($groupNumber){
        set_time_limit(3600);
        $username = '';
        $password = '';

        $jsonString = array();
        $jsonString['_embedded'] = "Test";
        $target_url = 'https://'.$groupNumber.'/users';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result=curl_exec ($ch);
        $jsonString = json_decode($result, true);
        curl_close ($ch);
        return $jsonString;
    }

    public function get_groupRF($groupNumber){
        return self::get('/api/v2/groups/'.$groupNumber.'/users');
    }

    /* Input a JSON array from desk API returns an array. */
    public function get_avl_agt($arr){
        $arr = $arr['_embedded']['entries'];
        @$total_agents = 0;
        @$unavail_agt = 0;
        $return = array();
        if(isset($arr) && !empty($arr)){
            foreach($arr as $entry)
            {
                $name = $entry['name'];
                $total_agents++;
                if(isset($entry['available']) && !empty($entry['available']))
                {
                    $available['available_name'] = $entry['name'];
                    $return[]=$available;
                } 
                else
                {   $temp['unavailable_name'] = $name;
                    $return[]=$temp;
                    $unavail_agt++;
                } 
            }
        }
        $return['total_agents'] = $total_agents;
        $return['total_available'] = $total_agents - $unavail_agt;
        $return['total_unavailable'] = $unavail_agt;
        return $return;
    }

    public function get_available_agents()
    {
        @$jsonString = file_get_contents(' deskEJ.json');
        if(isset($jsonString) && !empty($jsonString))
        {
            $parsed_json = json_decode($jsonString, true);
            $entries = $parsed_json['_embedded']['entries'];
            $total_agents = 0;
            $unavail_agt = 0;
            $avail_agt = 0;
            $available = array();
            $result = array();
            if(isset($entries) && !empty($entries)){
                foreach($entries as $entry)
                {
                    $total_agents++;
                    if(isset($entry['available']) && !empty($entry['available']))
                    {
                        $avail_agt++;
                        $available['name'] = $entry['name'];
                        // $available['amt_available'] = $avail_agt;
                        $result[] = $available;
                    } 
                    else
                    {
                        $unavail_agt++;
                        // $available['amt_UNavailable'] = $unavail_agt;
                        // $result[] = $unavail_agt;
                    } 
                }
                
            }
            else
            {
                $total_avail = $total_agents - $unavail_agt;
                echo '<strong>'. $total_avail . '/' . $total_agents . ' available.</strong><br>';
            }
            if(isset($result) && !empty($result)){
                return $result;
            }            
        }
        else 
        {
            echo 'No return.<br>';
        }
    }

    public function get_group_save_file($groupNumber, $online = false){
        set_time_limit(3600);
        $username = '';
        $password = '';
        $jsonString = array();
        $jsonString['_embedded'] = "Test";
        if($online == true) $target_url = $groupNumber; 
        else $target_url = '/api/v2/groups/'.$groupNumber.'/users';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result=curl_exec ($ch);
        curl_close ($ch);
        if($online == true) $jsonData = 'agent_online_check'. '.json';
        else $jsonData = $groupNumber . '.json';
        file_put_contents($jsonData, $result);
    }

    public function get_avl_agt2($arr){
        $arr = $arr['_embedded']['entries'];
        @$total_agents = 0;
        @$unavail_agt = 0;
        $return = array();
        if(isset($arr) && !empty($arr)){
            foreach($arr as $entry)
            {
                $name = $entry['name'];
                $total_agents++;
                if(isset($entry['available']) && !empty($entry['available']))
                {
                    $available['available_name'] = $entry['name'];
                    $return[]=$available;
                } 
                else
                {   $temp['unavailable_name'] = $name;
                    $return[]=$temp;
                    $unavail_agt++;
                } 
            }
        }
        $return['total_agents'] = $total_agents;
        $return['total_available'] = $total_agents - $unavail_agt;
        $return['total_unavailable'] = $unavail_agt;
        return $return;
    }

    public function get_group_name_and_agents($arr){
        $arr = $arr['_embedded']['entries'];
        
        if(isset($arr) && !empty($arr)){
            foreach($arr as $entry)
            {
               echo $entry['name'] . '<br>';
            }
        }
        // return $return;
    }

    public function getCases_saveJSON($group, $unixtime, $target_url = false){
        set_time_limit(3600);
        $username = ' ';
        $password = ' ';
        $jsonString = array();
        $jsonString['_embedded'] = "Test";
        if(isset($target_url) && !empty($target_url)){ 
            $target_url = $target_url;
        }
        else {
                $target_url = ' /api/v2/cases/search?assigned_group=' . $group . '&since_created_at=' . $unixtime;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec ($ch);
        file_put_contents($group.'_cases_'.date('Y-m-d', $unixtime).'.json', $result);
        
        curl_close ($ch);
    }

    public function saveReplies($group, $unixtime, $target_url = false){
        set_time_limit(3600);
        $username = ' ';
        $password = ' ';
        $jsonString = array();
        $jsonString['_embedded'] = "Test";
        if(isset($target_url) && !empty($target_url)){ 
            $target_url = $target_url;
        }
        else {
                $target_url = '/api/v2/cases/search?assigned_group=' . $group . '&since_created_at=' . $unixtime;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec ($ch);
        file_put_contents($group.'_cases_'. $unixtime .'.json', $result);
        
        curl_close ($ch);
    }




    public function updateCase($caseid)
    {

        $m = new MongoClient('mongoHost');
        $collection = $m->selectCollection('Desk', 'cases_that_begin_with_q');
        $options = array("upsert" => true);
        $find = array('id' => $caseid);
        $newdata = array('$set' =>
                    array(
                        "external_id" => 'cookie monsters trashcan',
                        "description" => 'Friday July1st cookie monster was part of the help desk.'
                    )
                );
        $collection->update($find, $newdata, $options);
    }
    
    public function findCase($caseid)
    {
        $arr = array();
        $m = new MongoClient('mongoHost'); // IMPORTANT
        $db = $m->selectDB('Desk');
        $collection = new MongoCollection($db, 'cases_that_begin_with_q');
        $query = array('id' => $caseid);
        $cursor = $collection->find($query);
        foreach ($cursor as $doc)
        {
            return $doc;
        }

    }
    
    public function getRelated($caseid, $node)
    {
        $d = new desk();
        $a = '/api/v2/';
        $h = '/href/';
        switch ($node)
        {
            case 'message':             $r = $d->get($a.'/cases/'.$caseid.'/'.$node);  break;
            case 'labels':              $r = $d->get($a.'/cases/'.$caseid.'/'.$node);  break;
            case 'assigned_user':       
                $r = findCase($caseid);
                $r = $d->get($r['_links']['assigned_user']['href']);
                break; 
            case 'macro_preview':       $r = $d->get($a.'/cases/'.$caseid.'/macros/preview');  break; #Method Not Allowed :/
            case 'replies':             $r = $d->get($a.'/cases/'.$caseid.'/'.$node);  break;
            case 'customer':            
                $r = findCase($caseid); 
                $r = $d->get($r['_links']['customer']['href']);
                break;
            case 'assigned_group':      $r = $d->get($a.$node);  
                $r = findCase($caseid); 
                $r = $d->get($r['_links']['assigned_group']['href']);
                break;
            // case 'locked_by':           $r = $d->get($a.$node);  break;
            // case 'history':             $r = $d->get($a.$node.$h);  break;
            case 'case_links':          $r = $d->get($a.$node.'/links');  break;
            case 'attachments':         $r = $d->get($a.$node.$h);  break;
            case 'draft':               $r = $d->get($a.$node.'/replies/draft');  break;
            case 'notes':               $r = $d->get($a.$node.$h);  break; 
            case 'self':                $r = $d->get($a.$node);  break; 
            default:
               $r='nope! something went wrong in getRelated() method :( ';
                break;
        }
        return $r;        
    }










}