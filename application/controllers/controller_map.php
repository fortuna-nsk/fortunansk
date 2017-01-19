<?php

class Controller_Map extends Controller
{
	function __construct()
	{
		$this->model = new Model_Map();
		$this->view = new View();
	}
	
	function action_get_coords()
	{
		$this->model->get_coords();		
	}
	
	function action_get_data_by_coords()
	{
		$this->model->get_data_by_coords();
	}
	
	function action_map_tolist()
	{
		$data = $this->model->map_tolist();		
		$this->view->generate('product_compact_view.php', 'template_view.php', $data);
	}
}

?>