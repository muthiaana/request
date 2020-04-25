  <?php

  defined('BASEPATH') OR exit('No direct script access allowed');

  class Kalendar extends Core_Controller {

      function __construct(){
        parent::__construct();
        $this->_Authorization();
        $this->load->model('Fullcalendar_model');
      }

      function index()
      {
        $data['title'] = 'Kalendar';

        $username = $this->session->userdata('username');
        $data['user'] = $this->db->get_where('ecrm_users', ['username' => $username])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('calendar/fullcalendar', $data);
        $this->load->view('templates/footer');
      }

      function load()
      {
        $event_data = $this->Fullcalendar_model->fetch_all_event();
        foreach($event_data->result_array() as $row)
          {
           $data[] = array(
            'id' => $row['id'],
            'title' => $row['title'],
            'start' => $row['start_event'],
            'end' => $row['end_event']
           );
          }
      echo json_encode($data);
      }


      function insert()
      {
        if($this->input->post('title'))
          {
           $data = array(
            'title'  => $this->input->post('title'),
            'start_event'=> $this->input->post('start'),
            'end_event' => $this->input->post('end')
           );
           $this->Fullcalendar_model->insert_event($data);
          }
       }

       
       function update()
       {
        if($this->input->post('id'))
          {
           $data = array(
            'title'   => $this->input->post('title'),
            'start_event' => $this->input->post('start'),
            'end_event'  => $this->input->post('end')
           );
            $this->Fullcalendar_model->update_event($data, $this->input->post('id'));
          }
       }


       function delete()
       {
        if($this->input->post('id')){
           $this->Fullcalendar_model->delete_event($this->input->post('id'));
          }
       }

      }

?>