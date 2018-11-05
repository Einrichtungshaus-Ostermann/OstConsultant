<?php



namespace OstConsultant\Listeners\Controllers;

use Enlight_Event_EventArgs as EventArgs;
use Enlight_Controller_Action as Controller;





class Frontend
{

	/**
	 * ...
	 *
	 * @var string
	 */

	protected $viewDir;



    /**
     * ...
     *
     * @var array
     */

    protected $configuration;





    /**
	 * ...
	 *
	 * @param string   $viewDir
     * @param array    $configuration
	 */

	public function __construct( $viewDir, array $configuration )
	{
		// set params
		$this->viewDir       = $viewDir;
		$this->configuration = $configuration;
	}



    /**
     * ...
     *
     * @param EventArgs $arguments
     *
     * @return void
     */

    public function onPostDispatch( EventArgs $arguments )
    {
        /* @var $controller Controller */
        $controller     = $arguments->get('subject');
        $request        = $controller->Request();
        $view           = $controller->View();
        $controllerName = $request->getControllerName();








        // add template dir
        $view->addTemplateDir( $this->viewDir );
    }

}
