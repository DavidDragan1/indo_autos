<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Admin_controller
{

    // private $user_id;
    // private $role_id;

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

        $has_permission = checkPermission('dashboard/quickview', $this->role_id);
        $checkParent = $this->db->query("SELECT
                                            users.role_id
                                        FROM
                                            roles
                                            JOIN users ON roles.user_id = users.id 
                                        WHERE
                                            roles.id = $this->role_id")
            ->row();
        $parentRole = isset($checkParent->role_id) && !empty($checkParent->role_id) ? $checkParent->role_id : $this->role_id;
        if ($parentRole == 11) {
            redirect(site_url(Backend_URL . 'loan-provider'));
        } else if ($parentRole == 12) {
            redirect(site_url(Backend_URL . 'insurance-provider'));
        } else if ($parentRole == 8) {
            redirect(site_url(Backend_URL . 'mechanic'));
        } else if ($parentRole == 6) {
            redirect(site_url(Backend_URL . 'profile'));
        } else if ($parentRole == 14) {
            redirect(site_url(Backend_URL . 'driver'));
        } else if ($parentRole == 15) {
            redirect(site_url(Backend_URL . 'shipping'));
        } else if ($parentRole == 16) {
            redirect(site_url(Backend_URL . 'clearing'));
        } else if ($parentRole == 17) {
            redirect(site_url(Backend_URL . 'verifier'));
        } else if ($has_permission) {
            $this->getAdminBoard();
        } else {
            $this->getSellerBoard();
        }
    }

    private function getAdminBoard()
    {
        $comingExpirePost = $this->db
            ->select('expiry_date, title')
            ->where('status', 'Active')
            ->where('expiry_date >=', date('Y-m-d'))
            ->limit(5, 0)
            ->get('posts')
            ->result();


        $carCondiction = $this->db->select('id, condition')->get_where('posts', ['status' => 'Active'])->result();

        $total_user = $this->db->where('status', 'Active')->where('role_id', 5)->count_all_results('users');
        $total_usercount = $this->db->where('status', 'Active')->count_all_results('users');
        $total_vendor = $this->db->where('status', 'Active')->where('role_id', 4)->count_all_results('users');

        // post condition
        $carNew = $this->db->where('status', 'Active')->where('condition', 'New')->where('expiry_date >=', date('Y-m-d'))->count_all_results('posts');
        $carNigerianUsed = $this->db->where('status', 'Active')->where('condition', 'Nigerian used')->where('expiry_date >=', date('Y-m-d'))->count_all_results('posts');
        $carForeignUsed = $this->db->where('status', 'Active')->where('condition', 'Foreign used')->where('expiry_date >=', date('Y-m-d'))->count_all_results('posts');

        $runningPost = $this->db->where('status', 'Active')->where('expiry_date >=', date('Y-m-d'))->count_all_results('posts');
        $expiredPost = $this->db->where('status', 'Active')->where('expiry_date <=', date('Y-m-d'))->count_all_results('posts');

        $totalBrand = $this->db->where('Type', 'Brand')->count_all_results(' brands');

        $data = [
            'upComoingExpire' => $comingExpirePost,
            'carCondiction' => $carCondiction,
            'carNew' => $carNew,
            'carNigerianUsed' => $carNigerianUsed,
            'carForeignUsed' => $carForeignUsed,
            'post_qty' => $this->countPostByType(),
            'total_brand' => $totalBrand,
            'runningPost' => $runningPost,
            'expiredPost' => $expiredPost,
            'allHits' => $this->hitCount(),
            'total_users' => $total_usercount,
            'totalVendor' => $total_vendor,
            'totalUser' => $total_user,
        ];

        $data['sellers_phone'] = $this->db
            ->where_in('role_id', [4, 5])
            ->not_like('contact', '+', 'after')
            ->count_all_results('users');

        $data['sellers'] = $this->db
            ->select('id,first_name,last_name,role_id,email,contact,contact1,contact2')
            ->where_in('role_id', [4, 5])
            ->not_like('contact', '+', 'after')
            ->limit(25)
            ->order_by('id', 'DESC')
            ->get('users')
            ->result();


        $data['s_type'] = array(
            4 => 'Trade Seller',
            5 => 'Private Seller',
        );
        $data['start'] = 0;

        $this->viewAdminContent('index', $data);
    }


    private function getSellerBoard()
    {

        $latestPost = $this->db
            ->select('posts.id,posts.title,vehicle_types.name, posts.created, posts.sold_date, posts.status, posts.pricein, 
            posts.priceindollar, posts.priceinnaira, posts.post_slug, post_photos.photo')
            ->join('vehicle_types', 'vehicle_types.id = posts.vehicle_type_id', 'LEFT')
            ->join('post_photos', "post_photos.post_id = posts.id AND post_photos.featured = 'Yes'", 'LEFT')
            ->where('user_id', $this->user_id)
            ->order_by('posts.id', 'DESC')
            ->group_by('posts.id')
            ->limit(8)
            ->get('posts')
            ->result();

        $totalCar = $this->db->where('user_id', $this->user_id)->where('vehicle_type_id', 1)->count_all_results('posts');
        $totalMotorbike = $this->db->where('user_id', $this->user_id)->where('vehicle_type_id', 3)->count_all_results('posts');
        $totalParts = $this->db->where('user_id', $this->user_id)->where('vehicle_type_id', 4)->count_all_results('posts');

        $userEmail = $this->db->where('reciever_id', $this->user_id)->count_all_results('mails');

        $chartCarData = [];
        for ($i = 1; $i <= 12; $i++) {
            $count = $i + 1;
            $m = new DateTime(date("F", mktime(0, 0, 0, $i, 10)));
            $firstDayOfMonth = $m->modify('first day of this month')->format('Y-m-d H:i:s');
            $nextm = new DateTime(date("F", mktime(0, 0, 0, $count, 10)));
            $lastDayOfMonth = $nextm->modify('first day of this month')->format('Y-m-d H:i:s');
            $chartCarData[] = $this->db->where(['user_id' => getLoginUserData('user_id')])
                ->where('created >=', $firstDayOfMonth)
                ->where('created <', $lastDayOfMonth)
                ->from('posts')->count_all_results();
        }
        /// pp(json_encode($chartCarData));
        ///  pp($this->report_for_dashboard(getLoginUserData('user_id'), 'posts', 'hit', '2020', 'SUM','created'));
        $seller_data = [
            'latestPost' => $latestPost,
            'email' => $userEmail,
            'totalCar' => $totalCar,
            'totalMotorbike' => $totalMotorbike,
            'totalParts' => $totalParts,
            'chart_data' => json_encode($chartCarData),
            'view' => $this->report_for_dashboard(getLoginUserData('user_id'), 'posts', 'hit', date('Y'), 'SUM', 'created'),
            'impressions' => $this->report_for_dashboard(getLoginUserData('user_id'), 'posts', 'impressions', date('Y'), 'SUM', 'created'),
            'sold' => $this->report_for_dashboard(getLoginUserData('user_id'), 'posts', 'id', date('Y'), 'COUNT', 'sold_date'),
            'mails' => $this->report_for_dashboard(getLoginUserData('user_id'), 'mails', 'id', date('Y'), 'COUNT', 'created'),
            'most_viewed_cars' => $this->report_for_most_view(getLoginUserData('user_id'), date('Y'))
        ];
        $this->viewAdminContentPrivate('backend/trade/template/dashboard', $seller_data);
    }

    private function hitCount()
    {
        $this->db->where('status', 'Active');
        if (!in_array($this->role_id, [1, 2])) {
            $this->db->where('user_id', $this->user_id);
        }
        return $this->db->count_all_results('posts');
    }

    private function countPostByType()
    {
        $sub_query = 'SELECT COUNT(*) FROM `posts` WHERE vehicle_type_id = vehicle_types.id';

        $this->db->select("id,name,({$sub_query}) as qty");
        $posts = $this->db->get('vehicle_types')->result();
        $array = range(1, 10);
        foreach ($posts as $post) {
            $array[$post->id] = $post->qty;
        }
        return $array;
    }

    private function report_for_dashboard($user_id, $table, $colum, $year, $mode = 'SUM', $join_cloum = 'created', $month = 0, $week = 0)
    {
        $whereField = 'user_id';
        if ($table == 'mails') $whereField = 'reciever_id';
        $data = [];
        if (!empty($month)) {
            $from_date = "$year-$month-01";
            $end_date = "$year-$month-01";
            $format = "%a, %d";
            $whereCondition = "a.Date between '$from_date' and last_day('$end_date')";
            if (!empty($week)) {
                $format = "%a";
                if ($week == 1) {
                    $from_date = "$year-$month-01";
                    $end_date = "$year-$month-07";
                } elseif ($week == 2) {
                    $from_date = "$year-$month-08";
                    $end_date = "$year-$month-14";
                } elseif ($week == 3) {
                    $from_date = "$year-$month-15";
                    $end_date = "$year-$month-21";
                } else {
                    $from_date = "$year-$month-22";
                    $end_date = "$year-$month-31";
                }

                $whereCondition = "a.Date between '$from_date' and '$end_date'";
            }


            $data = $this->db->query("
            select DATE_FORMAT(a.Date,'$format') as date ,
                   coalesce($mode($colum), 0) as `row`
            from (
                select last_day('$from_date') - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
                from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
            ) as a 
            LEFT JOIN $table ON date($table.$join_cloum) = a.Date AND $table.$whereField = $user_id
            where $whereCondition GROUP BY a.Date order by a.Date ;
            ")->result_array();
        }
        else {

            $data = $this->db->query("
            select DATE_FORMAT(a.Date,'%b') as date ,
                   coalesce($mode($colum), 0) as `row`
            from (
                select DATE('$year-01-01') + INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
                from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
                cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
            ) as a 
            LEFT JOIN $table ON date($table.$join_cloum) = a.Date AND $table.$whereField = $user_id
            where a.Date between date('$year-01-01') and date('$year-12-31') GROUP BY MONTH(a.Date) order by a.Date ;
            ")->result_array();
        }

        //pp($this->db->last_query());

        return ['key' => array_column($data, 'date'), 'data' => array_column($data, 'row')];
    }

    private function report_for_most_view($user_id, $year, $month = 0, $week = 0)
    {
        $this->db->select('title as name, hit as y');
        $this->db->from('posts');
        $this->db->where("YEAR(created) = '$year'");
        if (!empty($month)) {
            $this->db->where("MONTH(created) = '$month'");
        }

        if (!empty($week)) {
            if ($week == 1) {
                $from_date = "$year-$month-01";
                $end_date = "$year-$month-07";
            } elseif ($week == 2) {
                $from_date = "$year-$month-08";
                $end_date = "$year-$month-14";
            } elseif ($week == 3) {
                $from_date = "$year-$month-15";
                $end_date = "$year-$month-21";
            } else {
                $from_date = "$year-$month-22";
                $end_date = "$year-$month-31";
            }
            $this->db->where("DATE(created) between '$from_date' and '$end_date'");
        }

        if (!empty($user_id)) {
            $this->db->where('posts.user_id', $user_id);
        }
        $this->db->order_by('hit', 'DESC');
        $this->db->limit(5);
        $data = $this->db->get()->result_array();
        return ['data' => empty($data) ? [['name' => 'No Data', 'y' => 0]] : $data];

    }

    public function report()
    {
        $section = $this->input->post('section');
        $month = $this->input->post('month');
        $year = $this->input->post('year');
        $week = $this->input->post('week');

        $data = [];
        if ($section == 'view') {
            $data = $this->report_for_dashboard(getLoginUserData('user_id'), 'posts', 'hit', $year, 'SUM', 'created', $month, $week);
        } elseif ($section == 'impressions') {
            $data = $this->report_for_dashboard(getLoginUserData('user_id'), 'posts', 'impressions', $year, 'SUM', 'created', $month, $week);
        } elseif ($section == 'sold') {
            $data = $this->report_for_dashboard(getLoginUserData('user_id'), 'posts', 'id', $year, 'COUNT', 'sold_date', $month, $week);
        } elseif ($section == 'mails') {
            $data = $this->report_for_dashboard(getLoginUserData('user_id'), 'mails', 'id', $year, 'COUNT', 'created', $month, $week);
        } elseif ($section == 'most_viewed_cars') {
            $data = $this->report_for_most_view(getLoginUserData('user_id'), $year, $month, $week);
        }

        echo json_encode($data, JSON_NUMERIC_CHECK);
    }


}
