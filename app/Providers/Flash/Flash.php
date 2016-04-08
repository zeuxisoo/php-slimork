<?php
namespace App\Providers\Flash;

use Slim\Flash\Messages as Messages;

class Flash extends Messages {

    // Message handle method
    public function setTypeMessage($type, $message) {
        $this->addMessage($type, $message);
    }

    public function getTypeMessage($type) {
        $error_messages = $this->getMessage($type);
        $first_message  = is_array($error_messages) === true ? array_shift($error_messages) : null;

        return $first_message;
    }

    // Getter and Setter for error and success messages
    public function setError($message = "") {
        return $this->setTypeMessage('error', $message);
    }

    public function getError() {
        return $this->getTypeMessage('error');
    }

    public function setSuccess($message = "") {
        return $this->setTypeMessage('success', $message);
    }

    public function getSuccess() {
        return $this->getTypeMessage('success');
    }

    // Simple method
    public function error($message = "") {
        if (empty($message) === true) {
            return $this->getError();
        }

        $this->setError($message);
    }

    public function success($message = "") {
        if (empty($message) === true) {
            return $this->getSuccess();
        }

        $this->setSuccess($message);
    }

}
