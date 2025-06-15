<?php

class JobSubject {
    private $observers = [];

    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function notify($jobData) {
        foreach ($this->observers as $observer) {
            $observer->update($jobData);
        }
    }
}

?>

