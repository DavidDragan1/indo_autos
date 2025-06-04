<?php


class Blog_frontend extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Blog_model');
        $this->load->helper('blog');
        $this->load->library('form_validation');
    }

    public function index(){
        $latest_posts = $this->Blog_model->front_data();
        $trendings = $this->Blog_model->front_data([], 'data', 4, 0 , 'blogs.hit');
        $featureds = $this->Blog_model->front_data(['blogs.is_featured' => 1], 'data', 4, 0 , 'blogs.id');

        $temp = getCmsPage('blog');
        $data = array(
            'latest_posts' => $latest_posts,
            'trendings' => $trendings,
            'featureds' => $featureds,
            'meta_title' => $temp['meta_title'],
            'meta_description' => $temp['meta_description'],
            'meta_keywords' => $temp['meta_keywords'],
        );

        $this->viewFrontContentNew( 'blog/public/blog', $data);
    }

    public function viewFrontContentNew($view, $data = []){
        if ($view === "frontend/404") {
            $this->load->view("frontend/404");
        } else {
            $this->load->view('frontend/new/header', $data);
            $this->load->view($view, $data);
            $this->load->view('frontend/new/footer');
        }
    }


    public function category($tag_slug = null){
        $category = '';
        $base_url = 'blog/category';
        $condition = [];
        $q = $this->input->get('search');
        if (!empty($category_slug)){
            $category = $this->db->get_where('blog_category', ['slug' => $category_slug])->row();
            if (empty($category)){
                $this->viewFrontContentNew('frontend/404');
                return false;
            }
            $base_url .= '/'.$category->slug;
            $condition = ['blogs.category_id' => $category->id];
        }

        $page = !empty($this->input->get('page')) ?  intval($this->input->get('page')) : 1;
        $limit = 12;
        $target = empty($q) ? site_url($base_url).'?page' : site_url($base_url).'?search='.$q.'page' ;
        $start = ($page - 1) * $limit;

        $total = $this->Blog_model->front_category($condition, 'count', 0, 0 , 'blogs.id', $q);

        $posts =   $this->Blog_model->front_category($condition, 'data', $limit, $start , 'blogs.id', $q);

        $trendings = $this->Blog_model->front_data([], 'data', 4, 0 , 'blogs.hit');
        $featureds = $this->Blog_model->front_data(['blogs.is_featured' => 1], 'data', 4, 0 , 'blogs.id');
        $categories = $this->db->select('name, id, slug')->get('blog_category')->result();

        $temp = getCmsPage('blog/category');
        $data = array(
            'posts' => $posts,
            'pagination' => getAjaxPaginator($total, $page, $target, $limit),
            'meta_title' => empty($category) ? $temp['meta_title'] : $category->seo_title,
            'meta_description' => empty($category) ? $temp['meta_description'] : $category->seo_description,
            'meta_keywords' => empty($category) ? $temp['meta_keywords'] : $category->seo_keyword,
            'trendings' => $trendings,
            'featureds' => $featureds,
            'categories' => $categories
        );

        $this->viewFrontContentNew( 'blog/public/blog_category', $data);
    }

    public function tag($tag_slug){

            $tag = $this->db->get_where('blog_tags', ['slug' => $tag_slug])->row();
            if (empty($tag)){
                $this->viewFrontContentNew('frontend/404');
                return false;
            }

        $q = $this->input->get('search');
        $page = !empty($this->input->get('page')) ?  intval($this->input->get('page')) : 1;
        $limit = 12;
        $target = empty($q) ? site_url('blog/tag/'.$tag->slug).'?page' : site_url('blog/tag/'.$tag->slug).'?search='.$q.'page';
        $start = ($page - 1) * $limit;

        $total = $this->Blog_model->front_tag(['blog_tag_ids.tag_id' => $tag->id], 'count', 0, 0, $q);

        $posts =   $this->Blog_model->front_tag(['blog_tag_ids.tag_id' => $tag->id], 'data', $limit, $start, $q );

        $trendings = $this->Blog_model->front_data([], 'data', 4, 0 , 'blogs.hit');
        $featureds = $this->Blog_model->front_data(['blogs.is_featured' => 1], 'data', 4, 0 , 'blogs.id');

        $data = array(
            'posts' => $posts,
            'pagination' => getAjaxPaginator($total, $page, $target, $limit),
            'meta_title' => $tag->meta_title,
            'meta_description' => $tag->meta_description,
            'trendings' => $trendings,
            'featureds' => $featureds,
            'tag' => $tag
        );

        $this->viewFrontContentNew( 'blog/public/blog_category', $data);
    }

    public function single( $slug = null ){
        $this->db->select('blogs.*, blog_category.name as category_name, blog_category.slug as category_slug');
        $this->db->select("CONCAT(users.first_name, ' ' , users.last_name) as user_name");
        $this->db->join('users', 'users.id = blogs.user_id', 'LEFT');
        $this->db->join('blog_category', 'blog_category.id = blogs.category_id', 'LEFT');
        $post    = $this->db->get_where('blogs', ['blogs.post_url' => $slug, 'blogs.status' => 'Publish'])->row();
        if($post){
            $trendings = $this->Blog_model->front_data([], 'data', 4, 0 , 'blogs.hit');
            $featureds = $this->Blog_model->front_data(['blogs.is_featured' => 1], 'data', 4, 0 , 'blogs.id');

            $new_post = array(
                'post' => $post,
                'trendings' => $trendings,
                'featureds' => $featureds,
                'meta_title' => $post->seo_title,
                'meta_description' => $post->seo_description,
                'meta_keywords' => $post->seo_keyword,
                'tags' => $this->tagsData($post->id)
            );


            $this->viewFrontContentNew('blog/public/blog_details', $new_post );
        } else {
            $this->viewFrontContentNew('frontend/404' );
        }
    }

    private function tagsData($post_id = 0)
    {
        $this->db->where('bti.blog_id', $post_id);
        $this->db->join('blog_tags as t', 't.id = bti.tag_id');
        $this->db->from('blog_tag_ids as bti');
        return $this->db->get()->result();
    }

}