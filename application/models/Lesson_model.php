<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_model extends CI_Model {
   public function Mlist(){
    $this->db->select('lessons.lesson_id,lesson_name,lesson_description,user_count');
    $this->db->from('lessons');
    //$this->db->where('lesson_status', 'in');
    //$this->db->join('user_lessons', 'lessons.lesson_id = user_lessons.user_lesson_id', 'left');
    //$this->db->group_by("lessons.lesson_id");
    $query = $this->db->get(); 
    return $data = $query->result_array();
   }

   public function  MlessonInOut($data){
    return $this->db->insert('user_lessons',$data); 
   }
   public function MupdateUserCount($lesson_status,$lesson_id){
    if($lesson_status=='in'){
        $this->db->set('user_count', 'user_count+1', FALSE);
    }else if($lesson_status=='out'){
        $this->db->set('user_count', 'user_count-1', FALSE);
    }
    $this->db->where('lesson_id', $lesson_id);
    $this->db->update('lessons');
    return $this->getLessonUserCount($lesson_id);
   }

   public function getLessonUserCount($lesson_id){
    $this->db->select('user_count');
    $this->db->where('lesson_id', $lesson_id);
    $res1 = $this->db->get('lessons');
        $res2 = $res1->result_array();
        $user_count = $res2[0]['user_count'];
        return $user_count;
   }
}

?>