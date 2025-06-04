<?php
/**
 * Created by PhpStorm.
 * User: debu
 * Date: 3/5/20
 * Time: 5:26 PM
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Sitemap extends CI_Controller
{
    /**
     * Index Page for this controller.
     *
     */
    function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        $this->load->helper('xml');
    }

    public function index()
    {
        $ci = &get_instance();
        $data['posts'] = $ci->db->query("SELECT DATE(created) as post_date, max(created) as modified FROM posts 
                                        where status = 'Active' AND expiry_date >= '". date('Y-m-d') ."'
                                        GROUP BY DATE(created) ORDER BY post_date desc;")->result();

        header('Content-Type: application/xml; charset=utf-8');

        $this->load->view('frontend/sitemap.xml', $data);
    }

    public function sitemapView()
    {
        $urls = [];
        $time = [];
        $priority = [];
        $urlDate = substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], "post-") + 5);
        $date = explode(".", $urlDate);

        $ci = &get_instance();
        $this->db->select('p.post_slug, p.created, p.hit');
        $ci->db->from('posts as p');
        $ci->db->where('p.status', 'Active');
        $ci->db->where('DATE(created)', $date[0]);
        $ci->db->where('expiry_date >= ', date('Y-m-d'));
        $ci->db->order_by('p.id', 'DESC');
        $posts = $ci->db->get()->result();


        $ci = &get_instance();
        $ci->db->select('max(hit) as max_hit');
        $ci->db->from('posts as p');
        $ci->db->where('p.status', 'Active');
        $ci->db->where('DATE(created)', $date[0]);
        $ci->db->where('expiry_date >= ', date('Y-m-d'));
        $ci->db->order_by('p.id', 'DESC');
        $maxHit = $ci->db->get()->result();

        $maxHit = $maxHit[0]->max_hit ? $maxHit[0]->max_hit : 1;

        $tz = new \Carbon\CarbonTimeZone(1);
        foreach ($posts as $key => $post) {
            $urls[] = base_url() . 'post/' . $post->post_slug;
            $time[] = Carbon\Carbon::parse($post->created)->format('Y-m-d\TH:i:s') . $tz->toOffsetName();
            $priority[] = number_format(($post->hit / $maxHit), 1);
        }
        //ddd();
        header('Content-Type: application/xml; charset=utf-8');
        $this->load->view('frontend/sitemap_view.xml', compact('urls', 'time', 'priority'));
    }


    public function general(){
        $datas = [
            ['slug' => 'buy/car'], ['slug' => 'buy/car/search'],
            ['slug' => 'buy/motorbike'], ['slug' => 'buy/motorbike/search'],
            ['slug' => 'buy/spare-parts'], ['slug' => 'buy/spare-parts/search'],
            ['slug' => 'buy-import/car'], ['slug' => 'buy-import/car/search'],
            ['slug' => 'buy-import/motorbike'], ['slug' => 'buy-import/motorbike/search'],
            ['slug' => 'buy-import/spare-parts'], ['slug' => 'buy-import/spare-parts/search'],
            ['slug' => 'insurance-compare'],['slug' => 'loan-compare'],['slug' => 'post/compare?vehicle=car'],
            ['slug' => 'ask-an-expert'],['slug' => 'online-mechanic'],['slug' => 'diagnostic'],
            ['slug' => 'car-valuation'],['slug' => 'insurance-claim'],['slug' => 'track-your-application'],
            ['slug' => 'seller'],['slug' => 'about-us'],['slug' => 'contact-us'],['slug' => 'blog'],['slug' => 'faq'],
            ['slug' => 'privacy-policy'],['slug' => 'terms-and-conditions'],['slug' => 'finance-for-car'],
            ['slug' => 'insurance-for-car'],['slug' => 'car-valuation'],['slug' => 'vehicle-review'],
        ];

        header('Content-Type: application/xml; charset=utf-8');
        $this->load->view('frontend/sitemap_profile.xml', compact('datas'));
    }

    public function seller(){
        $datas = $this->db->from('cms')
        ->select('post_url as slug')
        ->order_by('users.id', 'ASC')
        ->join('users', 'users.id = cms.user_id', 'left')
        ->join('user_meta', 'user_meta.user_id = users.id', 'left')
        ->where('post_type', 'business')
        ->where('meta_key', 'userLocation')
        ->where('users.status', 'Active')->group_by('users.id')
        ->get()->result_array();


        header('Content-Type: application/xml; charset=utf-8');
        $this->load->view('frontend/sitemap_profile.xml', compact('datas'));
    }

    public function tags(){
        $datas = $this->db->from('product_tags')
            ->select('CONCAT("tag/", product_tags.slug) as slug')
            ->get()->result_array();


        header('Content-Type: application/xml; charset=utf-8');
        $this->load->view('frontend/sitemap_profile.xml', compact('datas'));
    }


}
