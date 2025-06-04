<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Blog_model extends Fm_model
{

    public $table = 'blogs';
    public $id = 'id';
    public $status = 'status';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {

        if (!empty($q)) {
            $this->db->or_like('post_title', $q);
            $this->db->or_like('post_url', $q);
            $this->db->or_like('description', $q);
            $this->db->or_like('seo_title', $q);
            $this->db->or_like('seo_keyword', $q);
            $this->db->or_like('seo_description', $q);
        }
        $this->db->from($this->table);

        return $this->db->count_all_results();

    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('blogs.*, blog_category.name as category_name');
        $this->db->order_by('blogs.id', 'DESC');
        if (!empty($q)) {
            $this->db->or_like('blogs.post_title', $q);
            $this->db->or_like('blogs.post_url', $q);
            $this->db->or_like('blogs.description', $q);
            $this->db->or_like('blogs.seo_title', $q);
            $this->db->or_like('blogs.seo_keyword', $q);
            $this->db->or_like('blogs.seo_description', $q);

            $this->db->limit($limit, $start);

        }
        $this->db->join('blog_category', 'blog_category.id = blogs.category_id', 'LEFT');
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);

        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function front_data($where = [], $mode = 'data', $limit = 4, $offset = 0, $orderField = 'blogs.id', $q = '')
    {
        $this->db->select('blogs.id, blogs.post_title, blogs.post_url, blogs.description, blogs.thumb, blogs.created');
        $this->db->select("CONCAT(users.first_name, ' ' , users.last_name) as user_name");
        $this->db->join('users', 'users.id = blogs.user_id', 'LEFT');
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('blogs.post_title', $q);
            $this->db->or_like('blogs.post_url', $q);
            $this->db->or_like('blogs.description', $q);
            $this->db->or_like('blogs.seo_title', $q);
            $this->db->or_like('blogs.seo_keyword', $q);
            $this->db->or_like('blogs.seo_description', $q);
            $this->db->group_end();
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('blogs.status', 'Publish');
        if (!empty($orderField)) {
            $this->db->order_by($orderField, 'DESC');
        }
        if ($mode == 'data') {
            $this->db->limit($limit, $offset);
            return $this->db->get('blogs')->result();
        } else {
            return $this->db->get('blogs')->num_rows();
        }


    }

    function front_category($where = [], $mode = 'data', $limit = 4, $offset = 0, $orderField = 'blogs.id', $q = '')
    {
        $this->db->select('blogs.id, blogs.post_title, blogs.post_url, blogs.description, blogs.thumb, blogs.created');
        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('blogs.post_title', $q);
            $this->db->or_like('blogs.post_url', $q);
            $this->db->or_like('blogs.description', $q);
            $this->db->or_like('blogs.seo_title', $q);
            $this->db->or_like('blogs.seo_keyword', $q);
            $this->db->or_like('blogs.seo_description', $q);
            $this->db->group_end();
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('blogs.status', 'Publish');
        if (!empty($orderField)) {
            $this->db->order_by($orderField, 'DESC');
        }
        if ($mode == 'data') {
            $this->db->limit($limit, $offset);
            return $this->db->get('blogs')->result();
        } else {
            return $this->db->get('blogs')->num_rows();
        }

    }

    function front_tag($where = [], $mode = 'data', $limit = 4, $offset = 0, $q = null)
    {
        $this->db->select('blogs.id, blogs.post_title, blogs.post_url, blogs.description, blogs.thumb, blogs.created');
        $this->db->join('blog_tag_ids', 'blog_tag_ids.blog_id = blogs.id');

        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('blogs.post_title', $q);
            $this->db->or_like('blogs.post_url', $q);
            $this->db->or_like('blogs.description', $q);
            $this->db->or_like('blogs.seo_title', $q);
            $this->db->or_like('blogs.seo_keyword', $q);
            $this->db->or_like('blogs.seo_description', $q);
            $this->db->group_end();
        }
        if (!empty($where)) {
            $this->db->where($where);
        }
        $this->db->where('blogs.status', 'Publish');

        $this->db->order_by('blogs.id', 'DESC');

        if ($mode == 'data') {
            $this->db->limit($limit, $offset);
            return $this->db->get('blogs')->result();
        } else {
            return $this->db->get('blogs')->num_rows();
        }

    }


}