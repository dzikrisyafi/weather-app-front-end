<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_General extends CI_Model
{
	public function getAll($select, $table)
	{
		$this->db->select($select);
		$this->db->from($table);
		return $this->db->get();
	}

	public function getWhere($select, $where, $table)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where);
		return $this->db->get();
	}

	public function countRows($table, $where = null)
	{
		$this->db->from($table);
		if ($where) $this->db->where($where);
		return $this->db->count_all_results();
	}
}
