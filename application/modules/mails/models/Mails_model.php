<?php defined('BASEPATH') or exit('No direct script access allowed');
use Illuminate\Database\Capsule\Manager as DB;
class Mails_model extends Fm_model
{

    public $table = 'mails';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_mails($user_id = 0, $access = false, $start = 0, $limit = 0)
    {
        if (!$access) {
            $this->db->where('reciever_id', $user_id);
        }
        $this->db->where('mail_type !=', 'Reply');
        $this->db->order_by($this->id, $this->order);
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get($this->table)->result();
    }

    /*
     * Get  Mail List of limited position
     * @param int $user_id
     * @param boolean $access
     * @param int $start
     * @param int $limit
     * @return array $this->db->get($this->table)->result()
     * Calling Form 'mails/index'
     */

    function get_trader_mails($user_id = 0, $access = false, $start = 0, $limit = 0)
    {

        if (!$access) {
            $this->db->where('reciever_id', $user_id)->where('receiver_delete', 0);
        }
        $this->db->where('mail_type !=', 'Reply');
        $this->db->order_by($this->id, $this->order);
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get($this->table)->result();
    }
    /*
     * Count Total Row
     * @param int $user_id
     * @param boolean $access
     * @return int $this->db->count_all_results($this->table)
     * Calling form 'mails/index','mails/api_index'
     */

    function get_mails_total($user_id = 0, $access = false)
    {
        if (!$access) {
            $this->db->where('reciever_id', $user_id);
        }
        $this->db->where('mail_type !=', 'Reply');
        return $this->db->count_all_results($this->table);
    }


    // get all
    function get_all_sent_mails()
    {
        $this->db->where('sender_id', getLoginUserData('user_id'));
        $this->db->order_by('created', 'desc');
        return $this->db->get($this->table)->result();
    }
    /*Get all trade sent mail count
         * @param int $userId
         * @return int $allSentMailsCount
         * Calling From mails/sent
         */
    function getTradeMailsSentTotal($userId = 0){
        $allSentMailsCount = DB::table($this->table)
                            ->where('sender_id',getLoginUserData('user_id'))
                            ->where('sender_delete', 0)
                            ->orderByDesc('created')
                            ->count();
        return $allSentMailsCount;
    }

    function get_all_sent_mails_trader($user_id = 0,$start = 0,$limit = 0)
    {

        $this->db->where('sender_id', getLoginUserData('user_id'))->where('sender_delete', 0);
        $this->db->order_by('created', 'desc');
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get($this->table)->result();
    }

    // get all children mail
    function get_all_child_mails($id)
    {
        $this->db->where('parent_id', $id);
        $this->db->order_by('created', 'asc');
        $children = $this->db->get($this->table)->result();
        foreach ($children as $child) {
            $child->attachments = get_all_attachments($child->id);
        }
        return $children;
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function mark_as_read($id)
    {
        $this->db->set('status', 'Read');
        $this->db->where($this->id, $id);
        $this->db->update($this->table);
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $id = $this->db->insert_id();
    }

    // get all
    function get_mails_api($user_id = 0, $access = false, $start = 0, $limit = 0, $type=null)
    {
        $baseUrl = base_url();
        $this->db->select('mails.id, mails.parent_id, mails.mail_type, mails.sender_id, mails.reciever_id, mails.mail_from, mails.mail_to, mails.subject, mails.body');
        $this->db->select('mails.status, important, log, DATE_FORMAT(mails.created, "%d %M %Y") as created, folder_id');

        if ($type == 'sent') {
            $this->db->select("CONCAT('$baseUrl',IF(`receiver`.`oauth_provider` = 'web',IF(`receiver`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`receiver`.role_id = '4', `receiver`.profile_photo, `receiver`.user_profile_image)) as profile_image");
        } else {
            $this->db->select("CONCAT('$baseUrl',IF(`sender`.`oauth_provider` = 'web',IF(`sender`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`sender`.role_id = '4', `sender`.profile_photo, `sender`.user_profile_image)) as profile_image");
        }

        if (!$access) {
            $this->db->group_start();
            if ($type == 'sent') {
                $this->db->where("(sender_id = '$user_id' && sender_delete = '0')");
            } else {
                $this->db->where("(`reciever_id` = '$user_id' && `receiver_delete` = '0')");
            }
            $this->db->group_end();
        }
        if ($type == 'sent') {
            $this->db->join('users as receiver', 'receiver.id = reciever_id', 'LEFT');
        } else {
            $this->db->join('users as sender', 'sender.id = sender_id', 'LEFT');
        }

        $this->db->where('mail_type !=', 'Reply');
        $this->db->order_by($this->id, $this->order);
        if ($limit) {
            $this->db->limit($limit, $start);
        }
        return $this->db->get($this->table)->result();
    }

    function get_mails_total_api($user_id = 0, $access = false, $type=null)
    {
        if (!$access) {
            $this->db->group_start();

            if ($type == 'sent') {
                $this->db->where("(sender_id = '$user_id' && sender_delete = '0')");
            } else {
                $this->db->where("(`reciever_id` = '$user_id' && `receiver_delete` = '0')");
            }

            $this->db->group_end();
        }
        $this->db->where('mail_type !=', 'Reply');
        return $this->db->count_all_results($this->table);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where('id', $id);

        return $this->db->update($this->table, $data);
    }

    function update_by_parent_id($id, $data)
    {
        $this->db->where('parent_id', $id);

        return $this->db->update($this->table, $data);
    }

    // get all
    function get_child_mails_api($parent = 0, $user_id = 0)
    {
        $baseUrl = base_url();
        $this->db->select('mails.id, mails.parent_id, mails.mail_type, mails.sender_id, mails.reciever_id, mails.mail_from, mails.mail_to, mails.subject, mails.body');
        $this->db->select('mails.status, mails.important, mails.log, DATE_FORMAT(mails.created, "%d %M %Y") as created, mails.folder_id');
        $this->db->select("coalesce(
        CONCAT('$baseUrl', IF(`receiver`.`oauth_provider` = 'web',IF(`receiver`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`receiver`.role_id = '4', `receiver`.profile_photo, `receiver`.user_profile_image)),
        CONCAT('$baseUrl', IF(`sender`.`oauth_provider` = 'web',IF(`sender`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`sender`.role_id = '4', `sender`.profile_photo, `sender`.user_profile_image))
        ) as profile_image");
        $this->db->join('mails as parent', 'parent.id = mails.parent_id', 'INNER');
        $this->db->join('users as sender', "sender.id = parent.sender_id AND parent.sender_id != $user_id", 'LEFT');
        $this->db->join('users as receiver', "receiver.id = parent.reciever_id AND parent.reciever_id != $user_id", 'LEFT');
        $this->db->where('mails.parent_id ', $parent);
        $this->db->order_by($this->id, 'ASC');
        return $this->db->get($this->table)->result();
    }

    // get all
    function get_parent_mails_api($id = 0, $user_id = 0)
    {
        $baseUrl = base_url();
        $this->db->select('mails.id, parent_id, mail_type, sender_id, reciever_id, mail_from, mail_to, subject, body');
        $this->db->select('mails.status, important, log, DATE_FORMAT(mails.created, "%d %M %Y") as created, folder_id');
        $this->db->select("coalesce(
        CONCAT('$baseUrl', IF(`receiver`.`oauth_provider` = 'web',IF(`receiver`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`receiver`.role_id = '4', `receiver`.profile_photo, `receiver`.user_profile_image)),
        CONCAT('$baseUrl', IF(`sender`.`oauth_provider` = 'web',IF(`sender`.`role_id` = '4', 'uploads/company_logo/', 'uploads/users_profile/'),''), IF(`sender`.role_id = '4', `sender`.profile_photo, `sender`.user_profile_image))
        ) as profile_image");
        $this->db->join('users as sender', "sender.id = sender_id AND sender.id != $user_id", 'LEFT');
        $this->db->join('users as receiver', "receiver.id = reciever_id AND receiver.id != $user_id", 'LEFT');
        $this->db->where('mails.id ', $id);
        $this->db->group_start();
        $this->db->where("(`reciever_id` = '$user_id' && `receiver_delete` = '0')");
        $this->db->or_where("(sender_id = '$user_id' && sender_delete = '0')");
        $this->db->group_end();
        return $this->db->get($this->table)->row();
    }
// get total rows
    function total_rows_byVender($q = NULL, $user_id = 0)
    {
        if ($user_id) {
            $this->db->where('receiver_id', $user_id);
        }
        if ($q) {
            $this->db->like('title', $q);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function mark_as_read_parent_with_child($id,$markAs,$segment)
    {
       $condition =  $segment === 'Sent' ?  '!=':'=';
        $this->db->query("UPDATE mails as parent
                                LEFT JOIN mails as child ON (parent.id = child.parent_id)
                                SET parent.`status` = '$markAs', child.`status` = IF(child.mail_to $condition parent.mail_to, '$markAs', child.`status`)
                                WHERE parent.id = '$id' ");
    }

}