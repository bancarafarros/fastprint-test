<?php
class MStatus extends CI_Model
{
    public function getDataStatus()
    {
        return $this->db->get('status');
    }
}
