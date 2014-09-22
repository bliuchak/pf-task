<?

class InitApp {

	public static function initView() {
		$config = \Phalcon\DI::getDefault()->get('config');
		$view = new \Phalcon\Mvc\View();
		$view->setTemplateAfter('main');
		// for escaping in views
		$view->setVar('escaper', new \Phalcon\Escaper());
		$view->setViewsDir($config->view->dir);
		return $view;
	}

	public static function initDb() {
		$config = \Phalcon\DI::getDefault()->get('config');
		$connection = new \Phalcon\Db\Adapter\Pdo\Mysql($config->database->toArray());
		if (getenv('APPLICATION_ENV') == 'devel') {
			$eventsManager = new \Phalcon\Events\Manager();
			$connection->setEventsManager($eventsManager);
		}
		return  $connection;
	}

	public static function initDispatcher() {
		//Create an EventsManager
		$eventsManager = new \Phalcon\Events\Manager();
		$dispatcher = new \Phalcon\Mvc\Dispatcher();
		//Bind the EventsManager to the dispatcher
		$dispatcher->setEventsManager($eventsManager);
		return $dispatcher;
	}

}
