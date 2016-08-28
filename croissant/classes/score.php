<?php

/*Update by Dalia 01/04*/

	//use files
	require_once('connection.php');
	require_once('exceptions.php');
	require_once('user.php');
	require_once('question.php');
	require_once('answer.php');
	
	class ScoreToConference extends Connection
	{
		//attribute
		private $right_answers;
		private $user;
		private $time;
		private $answer;
		
		
		//methods
		public function get_right_answers() { return $this->right_answers;}
		public function set_right_answers($value) { $this->right_answers = $value; }			
		public function get_user() { return $this->user; }
		public function set_user($value) { $this->user = $value; }
		public function get_time() { return $this->time;}
		public function set_time($value) { $this->time = $value;}
		public function get_answer() { return $this->answer;}
		public function set_answer($value) { $this->answer = $value;}
		
		
		
		//Constructor
		function __construct()
		{
			//if no arguments received, create a new empty object
			if(func_num_args() == 0)
			{
				$this->user = new User();
				$this->right_answers = 0;				
			}			
		}
	}
	
?>