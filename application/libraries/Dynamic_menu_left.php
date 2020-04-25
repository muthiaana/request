<?php
/**
 *
 * Dynmic_menu.php
 * Created By InsiteFX
 *
 */
class Dynamic_menu_left {

    private $ci;                // for CodeIgniter Super Global Reference.

    // private $id_menu        = 'id="menu"';    
    // private $class_menu        = 'class="sidebar-menu"';
    // private $class_parent    = 'class="parent"';
    // private $class_last        = 'class="last"';
    // private $li_class = 'class="treeview"';
    // private $ul_class = 'class="treeview-menu"';

    private $id_menu        = 'id="menu"';    
    private $class_menu        = 'class="nav-label"';
    private $class_parent    = 'class="nav-label"';
    private $class_last        = 'class="last"';
    private $li_class = 'class=""';
    private $ul_class = 'class="nav nav-second-level collapse"';
    private $ul_class3 = 'class="nav nav-third-level collapse"';



    // --------------------------------------------------------------------

    /**
     * PHP5        Constructor
     *
     */
    function __construct()
    {
        $this->ci =& get_instance();    // get a reference to CodeIgniter.
        // $this->load->model('m_wsbangun');
    }

    // --------------------------------------------------------------------

    /**
     * build_menu($table, $type)
     *
     * Description:
     *
     * builds the Dynaminc dropdown menu
     * $table allows for passing in a MySQL table name for different menu tables.
     * $type is for the type of menu to display ie; topmenu, mainmenu, sidebar menu
     * or a footer menu.
     *
     * @param    string    the MySQL database table name.
     * @param    string    the type of menu to display.
     * @return    string    $html_out using CodeIgniter achor tags.
     */
    function build_menu($active = null, $usergroup = null)
    {
        // var_dump($usergroup);
        // var_dump($active);
        // $nupMenu = $menuhide['nupMenu'];
        // $bookingMenu = $menuhide['bookingMenu'];

        // $table = 'mgr.v_sysMenuGroup2';       

        $table = "select ROW_NUMBER() OVER (ORDER BY parent_seq, child_seq, mgr.v_sysMenuGroup.MenuID ASC) AS [row_number], ";
        $table .= " * from mgr.v_sysMenuGroup";
        $table .= " where GroupCd ='$usergroup' ";
        $table .= " order by parent_seq, child_seq";

        // var_dump($table);

        // $krit  = array('GroupCd' => 'mgrs');

        $menu = array();
        // var_dump($menu);
        // use active record database to get the menu.
        // $query = $this->ci->db->get($table);
        // $query = $this->ci->db->get_where($table, $krit);
        // var_dump('mulai');
        // var_dump($this->ci->db);
        $query = $this->ci->db->query($table);
        // var_dump($query->result());
        // $query = $this->m_wsbangun->getData_by_query($table);
        // var_dump('selesai');
        // $query = $query->result();
        // var_dump($query);

        if ($query->num_rows() > 0)
        {
            // `id`, `title`, `link_type`, `page_id`, `module_name`, `url`, `uri`, `dyn_group_id`, `position`, `target`, `parent_id`, `show_menu`

            
            // MenuID,Title,URL,ParentMenuID,IconClass,OrderSeq,audit_user,audit_date

            foreach ($query->result() as $row)
            {
                // $menu[$row->row_number]['row_number']   = $row->row_number;
                $menu[$row->row_number]['MenuID']       = $row->MenuID;
                $menu[$row->row_number]['Title']        = $row->Title;
                $menu[$row->row_number]['URL']          = $row->URL;
                $menu[$row->row_number]['ParentMenuID'] = $row->ParentMenuID;
                $menu[$row->row_number]['IconClass']    = $row->IconClass;
                $menu[$row->row_number]['Is_parent']    = $row->Is_parent;
                // $menu[$row->row_number]['level3']       = $row->level3;
                // $menu[$row->row_number]['Is_parent']    = $row->Is_parent;
                $menu[$row->row_number]['PARENT_SEQ']    = $row->PARENT_SEQ;
            }
        }
        $query->free_result();    // The $query result object will no longer be available

        // ----------------------------------------------------------------------     
        // now we will build the dynamic menus.
        // $html_out  = "\t".'<div '.$this->id_menu.'>'."\n";
        // var_dump($menu);exit;
        // var_dump($menu[2]['URL']); exit;

        // var_dump($menu);
        $flag = false;
         $parentId = 0;
        $parentId2 = 0;
        $parentId3 = 0;
        for($j=1; $j<=count($menu);$j++){
            // var_dump($menu[$j]['URL']);
            if($menu[$j]['URL']==$active){
                $parentId = $menu[$j]['ParentMenuID'];
            }
        }
        // var_dump($parentId);
        if($parentId != 0){
            for($j=1; $j<=count($menu);$j++){
            // var_dump($menu[$j]['URL']);
            if($parentId==$menu[$j]['MenuID']){
                $parentId2 = $menu[$j]['ParentMenuID'];
                }
            }

            if($parentId2 !=0){
                for($j=1; $j<=count($menu);$j++){
            // var_dump($menu[$j]['URL']);
                if($parentId2==$menu[$j]['MenuID']){
                    $parentId3 = $menu[$j]['ParentMenuID'];
                    }
                }
            }   

        }
       
		// $html_out = "\t\t".'<ul '.$this->class_menu.'>'."\n";
        $html_out  = '';                        

        // loop through the $menu array() and build the parent menus.
        for ($i = 1; $i <= count($menu); $i++)
        {
            if (is_array($menu[$i]))    // must be by construction but let's keep the errors home
            {

                if ($menu[$i]['ParentMenuID'] == 0)    // are we allowed to see this menu?
                {
                    
                    if ($menu[$i]['Is_parent'] == TRUE)
                    {
                        
                        // CodeIgniter's anchor(uri segments, text, attributes) tag.                        
                        if ($menu[$i]['MenuID'] == $parentId || $menu[$i]['MenuID'] == $parentId2 || $menu[$i]['MenuID'] == $parentId3){
                            $html_out .= "\t\t\t\t".'<li class="active">'.anchor('#', '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span><span class="fa arrow"></span>','','','left');
                        }else{
                            // if($menu[$i]['level3'] == '1'){
                                // $html_out .= "\t\t\t".'<li class="active"'.$this->li_class.'>'.anchor('#', '<i class="'.$menu[$i]['IconClass'].'"></i> b<span>'.$menu[$i]['Title'].'</span><span class="fa arrow"></span>','','','left');
                            // }else{
                                $html_out .= "\t\t\t\t".'<li '.$this->li_class.'>'.anchor('#', '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span><span class="fa arrow"></span>','','','left');
                            // }                            
                        }
                    }
                    else
                    {
                        if($menu[$i]['URL'] == $active || $menu[$i]['MenuID'] == $parentId2){
                            $html_out .= "\t\t\t\t".'<li class="active">'.anchor($menu[$i]['URL'], '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span><span class="fa arrow"></span>','','','left');
                        }else{
                            $html_out .= "\t\t\t\t".'<li '.$this->li_class.'>'.anchor($menu[$i]['URL'], '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span>','','','left');
                        }
                    }

                    // loop through and build all the child submenus.
                    $MenuID = $menu[$i]['MenuID'];
                    // var_dump($MenuID);
                    // $level3 = $menu[$i]['level3'];
                    // var_dump($level3);
                    $html_out .= $this->get_childs($menu, $MenuID, $active,'2');


                    $html_out .= '</li>'."\n";
                }
            }
            else
            {
                exit (sprintf('menu nr %s must be an array', $i));
            }
        }

        // $html_out .= "\t\t".'</ul>' . "\n";
        // $html_out .= "\t".'</div>' . "\n";

        return $html_out;
    }  
    function build_menuMGM($active = null, $usergroup = null)
    {
        // var_dump($usergroup);
        // var_dump($active);
        // $nupMenu = $menuhide['nupMenu'];
        // $bookingMenu = $menuhide['bookingMenu'];

        // $table = 'mgr.v_sysMenuGroup2';       

        $table = "select ROW_NUMBER() OVER (ORDER BY parent_seq, child_seq, mgr.v_sysMenuMGMGroup.MenuID ASC) AS [row_number], ";
        $table .= " * from mgr.v_sysMenuMGMGroup";
        $table .= " where GroupCd ='$usergroup' ";
        $table .= " order by parent_seq, child_seq";

        // var_dump($table);

        // $krit  = array('GroupCd' => 'mgrs');

        $menu = array();
        // var_dump($menu);
        // use active record database to get the menu.
        // $query = $this->ci->db->get($table);
        // $query = $this->ci->db->get_where($table, $krit);
        // var_dump('mulai');
        // var_dump($this->ci->db);
        $query = $this->ci->db->query($table);
        // $query = $this->m_wsbangun->getData_by_query($table);
        // var_dump('selesai');
        // $query = $query->result();
        // var_dump($query);exit();s

        if ($query->num_rows() > 0)
        {
            // `id`, `title`, `link_type`, `page_id`, `module_name`, `url`, `uri`, `dyn_group_id`, `position`, `target`, `parent_id`, `show_menu`

            
            // MenuID,Title,URL,ParentMenuID,IconClass,OrderSeq,audit_user,audit_date

            foreach ($query->result() as $row)
            {
                // $menu[$row->row_number]['row_number']   = $row->row_number;
                $menu[$row->row_number]['MenuID']       = $row->MenuID;
                $menu[$row->row_number]['Title']        = $row->Title;
                $menu[$row->row_number]['URL']          = $row->URL;
                $menu[$row->row_number]['ParentMenuID'] = $row->ParentMenuID;
                $menu[$row->row_number]['IconClass']    = $row->IconClass;
                $menu[$row->row_number]['Is_parent']    = $row->Is_parent;                
                $menu[$row->row_number]['PARENT_SEQ']    = $row->PARENT_SEQ;
            }
        }
        $query->free_result();    // The $query result object will no longer be available

        // ----------------------------------------------------------------------     
        // now we will build the dynamic menus.
        // $html_out  = "\t".'<div '.$this->id_menu.'>'."\n";
        // var_dump($menu);exit;
        // var_dump($menu[2]['URL']); exit;

        // var_dump($active);
        $flag = false;
        $parentId = 0;
        $parentId2 = 0;
        $parentId3 = 0;
        for($j=1; $j<=count($menu);$j++){
            // var_dump($menu[$j]['URL']);
            if($menu[$j]['URL']==$active){
                $parentId = $menu[$j]['ParentMenuID'];
            }
        }
        // var_dump($parentId);
        if($parentId != 0){
            for($j=1; $j<=count($menu);$j++){
            // var_dump($menu[$j]['URL']);
            if($parentId==$menu[$j]['MenuID']){
                $parentId2 = $menu[$j]['ParentMenuID'];
                }
            }

            if($parentId2 !=0){
                for($j=1; $j<=count($menu);$j++){
            // var_dump($menu[$j]['URL']);
                if($parentId2==$menu[$j]['MenuID']){
                    $parentId3 = $menu[$j]['ParentMenuID'];
                    }
                }
            }   

        }

        // $html_out = "\t\t".'<ul '.$this->class_menu.'>'."\n";
        $html_out  = '';                        

        // loop through the $menu array() and build the parent menus.
        for ($i = 1; $i <= count($menu); $i++)
        {
            if (is_array($menu[$i]))    // must be by construction but let's keep the errors home
            {
                if ($menu[$i]['ParentMenuID'] == 0)    // are we allowed to see this menu?
                {
                    
                    if ($menu[$i]['Is_parent'] == TRUE)
                    {
                        
                        // CodeIgniter's anchor(uri segments, text, attributes) tag.                        
                        if ($menu[$i]['MenuID'] == $parentId || $menu[$i]['MenuID'] == $parentId2 || $menu[$i]['MenuID'] == $parentId3){
                            $html_out .= "\t\t\t".'<li class="active">'.anchor('#', '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].'</span><span class="fa arrow"></span>','','','left');
                        }else{
                            $html_out .= "\t\t\t".'<li '.$this->li_class.'>'.anchor('#', '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].'</span><span class="fa arrow"></span>','','','left');
                        }
                    }
                    else
                    {
                        if($menu[$i]['URL'] == $active){
                            $html_out .= "\t\t\t\t".'<li class="active">'.anchor($menu[$i]['URL'], '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].'</span>','','','left');
                        }else{
                            $html_out .= "\t\t\t\t".'<li '.$this->li_class.'>'.anchor($menu[$i]['URL'], '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].'</span>','','','left');
                        }
                    }

                    // loop through and build all the child submenus.
                    $MenuID = $menu[$i]['MenuID'];
                    $html_out .= $this->get_childs($menu, $MenuID, $active,'2');


                    $html_out .= '</li>'."\n";
                }
            }
            else
            {
                exit (sprintf('menu nr %s must be an array', $i));
            }
        }

        // $html_out .= "\t\t".'</ul>' . "\n";
        // $html_out .= "\t".'</div>' . "\n";

        return $html_out;
    }  
	/**
     * get_childs($menu, $parent_id) - SEE Above Method.
     *
     * Description:
     *
     * Builds all child submenus using a recurse method call.
     *
     * @param    mixed    $menu    array()
     * @param    string    $parent_id    id of parent calling this method.
     * @return    mixed    $html_out if has subcats else FALSE
     */
    function get_childs($menu, $ParentMenuID, $active,$level)
    {
        $html_out  = '';
        
        $has_subcats = FALSE;
        // var_dump($level3);
        $parentId = 0;
        $parentId2 = 0;
        $parentId3 = 0;
        $third_level = '';
         for($j=1; $j<=count($menu);$j++){
            // var_dump($menu[$j]['URL']);
            if($menu[$j]['URL']==$active){
                $parentId = $menu[$j]['ParentMenuID'];
            }
        }

        if($level=='3'){
                // var_dump($ParentMenuID);
            for($j=1; $j<=count($menu);$j++){
                if($menu[$j]['ParentMenuID'] == $ParentMenuID){
                    $parentId2 = 100;
                }

            }
          }
        
          if($parentId2=100){
            if($level==3){
                $html_out .= "\t\t\t\t\t".'<ul '.$this->ul_class3.'>'."\n";    
            }else{
                $html_out .= "\t\t\t\t\t".'<ul '.$this->ul_class.'>'."\n";    
            }
            
        }else{
            $html_out .= "\t\t\t\t\t".'<ul '.$this->ul_class.'>'."\n";
        }
        
        
        
        for ($i = 1; $i <= count($menu); $i++)
        {
            
            if ($menu[$i]['ParentMenuID'] == $ParentMenuID)    // are we allowed to see this menu?
            {
                
                $has_subcats = TRUE;
// var_dump($ParentMenuID);
                if ($menu[$i]['Is_parent'] == TRUE) {
                    // }     
                    // var_dump($parentId);
                    // var_dump($menu[$i]['MenuID']);
                    if($menu[$i]['URL'] == $active || ($menu[$i]['Is_parent'] == TRUE && $menu[$i]['MenuID'] == $parentId) ){
                            
                            $html_out .= "\t\t\t\t\t\t".'<li class="active">'.anchor('#', '<i class="'.$menu[$i]['IconClass'].'"></i>'.$menu[$i]['Title'].' <span class="fa arrow"></span>','','','left');
           
                    }else {
                            
                            $html_out .= "\t\t\t\t\t\t".'<li>'.anchor('#', '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span><span class="fa arrow"></span>','','','left');  

                    }

                } else {                                        
                    if($menu[$i]['URL'] == $active){
                            $html_out .= "\t\t\t\t\t\t".'<li class="active">'.anchor($menu[$i]['URL'], '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span>','','','left');
                        // }
                        
                    }else{                        
                        if($parentId3 !=0 ){
                            $html_out .= '<ul class="nav nav-third-level">';  
                            $html_out .= "\t\t\t\t\t\t".'<li>'.anchor($menu[$i]['URL'], '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span>','','','left');
                            $html_out .= '</ul>';    
                        } else {
                            
                                $html_out .= "\t\t\t\t\t\t".'<li>'.anchor($menu[$i]['URL'], '<i class="'.$menu[$i]['IconClass'].'"></i><span>'.$menu[$i]['Title'].' </span>','','','left');
                        }                        
                    }                    
                }

                $html_out .= $this->get_childs($menu, $menu[$i]['MenuID'], $active,'3');

                $html_out .= '</li>' . "\n";
                // $html_out .= "\t\t\t\t\t".'</ul>' . "\n";
            }
        }
        $html_out .= "\t\t\t\t\t".'</ul>' . "\n";
        // $html_out .= "\t\t\t\t".'</div>' . "\n";

        return ($has_subcats) ? $html_out : FALSE;
    }
}
// ------------------------------------------------------------------------
// End of Dynamic_menu Library Class.

// ------------------------------------------------------------------------
/* End of file Dynamic_menu.php */
/* Location: ../application/libraries/Dynamic_menu.php */  