<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Gallery_frontview
 * @author Kanny
 */
class Gallery_frontview extends MX_Controller {
    //put your code here
    
    const PhotoCaption = false;
    const AlbumCaption = true;

    // Setting Name         = array( Width, Height);
    public $AlbumThumb      = array(208, 200); // Width x Height
    public $PhotoThumb      = array(205, 170); // Width x Height
    public $LightBoxSize    = array(850, 550); // Width x Height

    function __construct() {
        parent::__construct();
        $this->load->model('Gallery_model');
        $this->load->library('form_validation');
        $this->load->helper('gallery');        
    }

    

    public function getPhotoByAlbum() {
                
        //echo $this->getSettings('limit');                  
        $slug       = $this->uri->segment(2);
        $album      = $this->db->select('id')->get_where('gallery_albums', ['slug' => $slug])->row();
        $album_id   = $album->id;
        $results    = $this->db->get_where('gallery', ['album_id' => $album_id, 'type' => 'Photo'])->result();


        $table = '';
        $table .= '<link rel="stylesheet" href=" ' . base_url() . '/assets/lib/plugins/lightbox/css/lightbox.min.css">';
        $table .= (count($results) === 0) ? '<div class="alert alert-warning" role="alert">No Photo Found!</div>' : '';
        $table .= '<ul class="photoAlbum clearfix" id="album">';

        foreach ($results as $result) {
            $table .= '<li>';
           
            $table .= '<a class="example-image-link" 
                             href="' . $this->getPhoto($result->photo, '/uploads/gallery/', true) . '" 
                             data-lightbox="example-set" 
                             data-title="'.$result->description.'">';
            $table .= $this->getPhoto($result->photo, '/uploads/gallery/');
            $table .= '<p>'.$result->title.'</p>';
            $table .= '</a>';
            
            $table .= '</li>' . "\r\n";
        }

        $table .= '</ul>' . "\r\n";
        $table .= '<script src="'. base_url() . './assets/lib/plugins/lightbox/js/lightbox-plus-jquery.min.js"></script>' . "\r\n";
        $table .= "<script> lightbox.option({ 'resizeDuration': 200, 'wrapAround': true  }) </script>";
        return $table;
    }  
    
    
    
    public function getVideoByAlbum() {
                
        //echo $this->getSettings('limit');                  
        $slug       = $this->uri->segment(2);
        $album      = $this->db->select('id')->get_where('gallery_albums', ['slug' => $slug])->row();
        $album_id   = $album->id;
        $results    = $this->db->get_where('gallery', ['album_id' => $album_id, 'type' => 'Video'])->result();
        return $results;
    }
    
    public function getVideo( $video_id = 0){
      //  dd($video_id);
        $video = $this->db->select('*')
                ->get_where('gallery', [ 'photo' => $video_id, 'type' => 'Video'])
                ->row();        
        echo  '<iframe width="100%" height="350" src="https://www.youtube.com/embed/'.$video->photo.'?autoplay=1" frameborder="0" allowfullscreen=""></iframe>';
    }
    
    public function videoGallery() {
        $results      = $this->db->get_where('gallery_albums', ['type' => 'Video'])->result();
        
        $table = '';
        $table .= (count($results) === 0) ? 'No Photo Found!' : '';

        $table .= '<ul class="photoGallery clearfix">';

        foreach ($results as $result) {
            $table .= '<li><a href="video_gallery/' . $result->slug . '">';

            $table .= $this->getPhoto($result->thumb, '/uploads/gallery/albums/');

            $title = $result->name;

            $table .= '<div class="caption">';
            $table .= $result->name;
            $table .= ' (';
            $table .= $this->countAlbumPhoto($result->id);
            $table .= ')</div>';
            $table .= '</a></li>';
        }

        $table .= '</ul>';
        //dd($table);
        return $table;
    }
    
    public function PhotoGallery() {
        $results      = $this->db->get_where('gallery_albums', ['type' => 'Photo'])->result();
        
        $table = '';
        $table .= (count($results) === 0) ? 'No Photo Found!' : '';

        $table .= '<ul class="photoGallery clearfix">';

        foreach ($results as $result) {
            $table .= '<li><a href="photo_gallery/' . $result->slug . '">';

            $table .= $this->getPhoto($result->thumb, '/uploads/gallery/albums/');

            $title = $result->name;

            $table .= '<div class="caption">';
            $table .= $result->name;
            $table .= ' (';
            $table .= $this->countAlbumPhoto($result->id);
            $table .= ')</div>';
            $table .= '</a></li>';
        }

        $table .= '</ul>';
        //dd($table);
        return $table;
    }
    
    public function countAlbumPhoto($id = 0) {
        return $this->db->get_where('gallery', ['album_id' => $id])->num_rows();
    }
    
    public function getPhoto($photoName, $path, $link = false) {
        $photoDir   = dirname(BASEPATH) . $path;
        $src        = base_url() . $path;
        
        if ($link) {            
            if($photoName && file_exists($photoDir . $photoName)){
                return $src.$photoName;
            }else{
                return $src.'no-thumb.gif';
            }
        }

        if ($photoName && file_exists($photoDir . $photoName)) {
            return '<img src="'. $src . $photoName . '" class="img-responsive lazyload">';
        } else {
            return '<img src="' . $src . 'no-thumb.gif' . '" class="img-responsive lazyload">';
        }
    }                     
    
}
