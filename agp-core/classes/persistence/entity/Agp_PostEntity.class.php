<?php

class Agp_PostEntity extends Agp_Entity {
    private $post_author;
    private $post_date;
    private $post_date_gmt;
    private $post_content;
    private $post_title;
    private $post_excerpt;
    private $post_status;
    private $comment_status;
    private $ping_status;
    private $post_password;
    private $post_name;
    private $to_ping;
    private $pinged;
    private $post_modified;
    private $post_modified_gmt;
    private $post_content_filtered;
    private $post_parent;
    private $guid;
    private $menu_order;
    private $post_type;
    private $post_mime_type;
    private $comment_count;
    private $filter;
    
    public function __construct($data) {
        $default = array(
            'ID' => $data->ID, 
            'post_author' => NULL,
            'post_date' => NULL,
            'post_date_gmt' => NULL,
            'post_content' => NULL,
            'post_title' => NULL,
            'post_excerpt' => NULL,
            'post_status' => NULL,
            'comment_status' => NULL,
            'ping_status' => NULL,
            'post_password' => NULL,
            'post_name' => NULL,
            'to_ping' => NULL,
            'pinged' => NULL,
            'post_modified' => NULL,
            'post_modified_gmt' => NULL,
            'post_content_filtered' => NULL,
            'post_parent' => NULL,
            'guid' => NULL,
            'menu_order' => NULL,
            'post_type' => NULL,
            'post_mime_type' => NULL,
            'comment_count' => NULL,
            'filter' => NULL,
        );

        parent::__construct($data, $default); 
    }

    public function getPost_author() {
        return $this->post_author;
    }

    public function getPost_date() {
        return $this->post_date;
    }

    public function getPost_date_gmt() {
        return $this->post_date_gmt;
    }

    public function getPost_content() {
        return $this->post_content;
    }

    public function getPost_title() {
        return $this->post_title;
    }

    public function getPost_excerpt() {
        return $this->post_excerpt;
    }

    public function getPost_status() {
        return $this->post_status;
    }

    public function getComment_status() {
        return $this->comment_status;
    }

    public function getPing_status() {
        return $this->ping_status;
    }

    public function getPost_password() {
        return $this->post_password;
    }

    public function getPost_name() {
        return $this->post_name;
    }

    public function getTo_ping() {
        return $this->to_ping;
    }

    public function getPinged() {
        return $this->pinged;
    }

    public function getPost_modified() {
        return $this->post_modified;
    }

    public function getPost_modified_gmt() {
        return $this->post_modified_gmt;
    }

    public function getPost_content_filtered() {
        return $this->post_content_filtered;
    }

    public function getPost_parent() {
        return $this->post_parent;
    }

    public function getGuid() {
        return $this->guid;
    }

    public function getMenu_order() {
        return $this->menu_order;
    }

    public function getPost_type() {
        return $this->post_type;
    }

    public function getPost_mime_type() {
        return $this->post_mime_type;
    }

    public function getComment_count() {
        return $this->comment_count;
    }

    public function getFilter() {
        return $this->filter;
    }

    public function setPost_author($post_author) {
        $this->post_author = $post_author;
        return $this;
    }

    public function setPost_date($post_date) {
        $this->post_date = $post_date;
        return $this;
    }

    public function setPost_date_gmt($post_date_gmt) {
        $this->post_date_gmt = $post_date_gmt;
        return $this;
    }

    public function setPost_content($post_content) {
        $this->post_content = $post_content;
        return $this;
    }

    public function setPost_title($post_title) {
        $this->post_title = $post_title;
        return $this;
    }

    public function setPost_excerpt($post_excerpt) {
        $this->post_excerpt = $post_excerpt;
        return $this;
    }

    public function setPost_status($post_status) {
        $this->post_status = $post_status;
        return $this;
    }

    public function setComment_status($comment_status) {
        $this->comment_status = $comment_status;
        return $this;
    }

    public function setPing_status($ping_status) {
        $this->ping_status = $ping_status;
        return $this;
    }

    public function setPost_password($post_password) {
        $this->post_password = $post_password;
        return $this;
    }

    public function setPost_name($post_name) {
        $this->post_name = $post_name;
        return $this;
    }

    public function setTo_ping($to_ping) {
        $this->to_ping = $to_ping;
        return $this;
    }

    public function setPinged($pinged) {
        $this->pinged = $pinged;
        return $this;
    }

    public function setPost_modified($post_modified) {
        $this->post_modified = $post_modified;
        return $this;
    }

    public function setPost_modified_gmt($post_modified_gmt) {
        $this->post_modified_gmt = $post_modified_gmt;
        return $this;
    }

    public function setPost_content_filtered($post_content_filtered) {
        $this->post_content_filtered = $post_content_filtered;
        return $this;
    }

    public function setPost_parent($post_parent) {
        $this->post_parent = $post_parent;
        return $this;
    }

    public function setGuid($guid) {
        $this->guid = $guid;
        return $this;
    }

    public function setMenu_order($menu_order) {
        $this->menu_order = $menu_order;
        return $this;
    }

    public function setPost_type($post_type) {
        $this->post_type = $post_type;
        return $this;
    }

    public function setPost_mime_type($post_mime_type) {
        $this->post_mime_type = $post_mime_type;
        return $this;
    }

    public function setComment_count($comment_count) {
        $this->comment_count = $comment_count;
        return $this;
    }

    public function setFilter($filter) {
        $this->filter = $filter;
        return $this;
    }
}
