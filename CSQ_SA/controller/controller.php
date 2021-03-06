<?php
class Controller {
	private $request = null;
	private $template = '';
	private $viewOuter = null;
	var $mysqli;
	var $logger;
	
	public function __construct($request, $pLog) {
		$this->logger = $pLog;
		$this->viewOuter = new View ();
		$this->request = $request;
		$this->template = ! empty ( $request ['view'] ) ? $request ['view'] : 'default';
		$this->mysqli = new sqlhelper ( $this->logger );
	}
	
	public function display() {
		$questionListModel = new QuestionListModel ( $this->mysqli, $this->logger );
		$questionModel = new QuestionModel ( $this->mysqli, $this->logger );
		$answerModel = new AnswerModel ( $this->mysqli, $this->logger );
		$categoryModel = new CategoryModel ( $this->mysqli, $this->logger );
		$userModel = new UserModel ( $this->mysqli, $this->logger );
		$quizModel = new QuizModel ( $this->mysqli, $this->logger );
		$ratingModel = new RatingModel ( $this->mysqli, $this->logger );
		$sessionModel = new SessionModel ( $this->mysqli, $this->logger );
		$quizListModel = new QuizListModel ( $this->mysqli, $this->logger );
		$tagModel = new TagModel ( $this->mysqli, $this->logger );
		$answerModel = new AnswerModel ( $this->mysqli, $this->logger );
		$registrationModel = new RegistrationModel ( $this->mysqli, $this->logger );
		$userscoreModel = new UserScoreModel ( $this->mysqli, $this->logger );
		$moderationModel = new ModerationModel( $this->mysqli, $this->logger );
		$reportModel = new ReportModel( $this->mysqli, $this->logger );
		
		
		$sessionModel->sec_session_start();
		
		$_SESSION ['current_view'] = $this->template;
		
				
		$viewInner = new View ();
		
		switch ($this->template) {

			case 'about' :
			case 'question' :case 'login' : case 'user' : case 'solution' : case 'questionlist' : case 'myquestions' :
			case 'mycontent' : case 'myquizzes' : case 'quizdetail' : case 'quizstart' : case 'quizend' : case 'categorylist' :
			case 'logout' : case 'error' : case 'register' : case 'processLogin' : case 'processChangepassword' : case 'processRegistration' :
			case 'newquestion' : case 'generatequiz' : case 'editquestion' : case 'processNewQuestion' : case 'processGenerateQuiz':
			case 'log': case 'questionpool': case 'processEditQuestion' :
			case 'default' :
				include("controllers/".$this->template.".php");
				break;
			default:
				include("controllers/default.php");
				break;
		}
		
		// loads the head, css etc.
		$this->viewOuter->setTemplate ( 'skeleton' );
		$this->viewOuter->assign ( 'csq_footer', 'Die Wissensplattform' );
		$this->viewOuter->assign ( 'csq_content', $viewInner->loadTemplate () );
		// Return the whole page now
		return $this->viewOuter->loadTemplate ();
	}
}
?>
