<?

namespace AdminForm;

class AdminForm extends \Framework\Forms\Form {

	const FORM_ACTION = 'admin/submit';

	const TITLE_LABEL = 'Title';
	const TITLE_NAME = 'title';
	const TITLE_REQUIRE_MESSAGE = 'Title field should be filled.';

	const TEXT_LABEL = 'Text';
	const TEXT_NAME = 'text';
	const TEXT_REQUIRE_MESSAGE = 'Text field should be filled.';

	const SUBMIT_LABEL = 'Submit';
	const SUBMIT_NAME = 'submit';

	public function initialize() {
		$this->setAction(self::FORM_ACTION);

		// title
		$element = new \Phalcon\Forms\Element\Text(self::TITLE_NAME, array('id' => self::TITLE_NAME));
		$element->setLabel(self::TITLE_LABEL);
		$element->addValidators(array(
			new \Phalcon\Validation\Validator\PresenceOf(array(
					'message' => self::TITLE_REQUIRE_MESSAGE))
		));
		$this->add($element);

		// text
		$element = new \Phalcon\Forms\Element\TextArea(self::TEXT_NAME, array('id' => self::TEXT_NAME));
		$element->setLabel(self::TEXT_LABEL);
		$element->addValidators(array(
			new \Phalcon\Validation\Validator\PresenceOf(array(
					'message' => self::TEXT_REQUIRE_MESSAGE))
		));
		$this->add($element);

		// submit
		$element = new \Phalcon\Forms\Element\Submit(self::SUBMIT_NAME, array('id' => self::SUBMIT_NAME));
		$element->setLabel(self::SUBMIT_LABEL);
		$this->add($element);
	}

}
