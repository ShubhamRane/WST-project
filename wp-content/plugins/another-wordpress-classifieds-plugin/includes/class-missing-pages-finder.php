<?php

function awpcp_missing_pages_finder() {
    return new AWPCP_Missing_Pages_Finder( $GLOBALS['wpdb'] );
}

class AWPCP_Missing_Pages_Finder {

    private $db;

    public function __construct( $db ) {
        $this->db = $db;
    }

    public function find_page_with_shortcode( $shortcode ) {
        $query = 'SELECT ID, post_title, post_status ';
        $query.= 'FROM ' . $this->db->posts . ' ';
        $query.= "WHERE post_content LIKE '%%%s%%' ";
        $query.= "AND post_status NOT IN ('inherit') ";

        $sql = $this->db->prepare( $query, $shortcode );

        $pages = $this->db->get_results( $sql );

        return count( $pages ) === 1 ? $pages[0] : null;
    }

    public function find_broken_page_id_references() {
        $plugin_pages = awpcp_get_plugin_pages_info();

        $registered_pages = array_keys( awpcp_pages() );
        $referenced_pages = array_keys( $plugin_pages );

        // pages that are registered in the code but no referenced in the DB
        $pages_not_referenced = array_diff( $registered_pages, $referenced_pages );
        $pages_not_used = array_diff( $referenced_pages, $registered_pages );
        $registered_pages_ids = awpcp_get_page_ids_by_ref( $registered_pages );

        $query = 'SELECT posts.ID post, posts.post_status status ';
        $query.= 'FROM ' . $this->db->posts . ' AS posts ';
        $query.= "WHERE posts.ID IN (" . join( ",", $registered_pages_ids ) . ") AND posts.post_type = 'page' ";

        $existing_pages = $this->db->get_results( $query, OBJECT_K );
        $missing_pages = array( 'not-found' => array(), 'not-published' => array(), 'not-referenced' => array() );

        foreach ( $plugin_pages as $page_ref => $page_info ) {
            if ( in_array( $page_ref, $pages_not_used ) ) {
                continue;
            }

            $page = isset( $existing_pages[ $page_info['page_id'] ] ) ? $existing_pages[ $page_info['page_id'] ] : null;

            if ( is_object( $page ) && isset( $page->status ) && $page->status != 'publish' ) {
                $page->page = $page_ref;
                $page->id = $page_info['page_id'];

                $missing_pages['not-published'][] = $page;
            } else if ( is_null( $page ) ) {
                $page = new stdClass;

                $page->page = $page_ref;
                $page->id = $page_info['page_id'];
                $page->post = null;
                $page->status = null;

                $missing_pages['not-found'][] = $page;
            }
        }

        // if a page is registered in the code but there is no reference of it
        // in the database, include a dummy object to represent it.
        foreach ( $pages_not_referenced as $page ) {
            $item = new stdClass();
            $item->page = $page;
            $item->id = null;
            $item->post = null;
            $item->status = null;

            $missing_pages['not-referenced'][] = $item;
        }

        return $missing_pages;
    }
}
