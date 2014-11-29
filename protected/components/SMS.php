<?php
class SMS {
    private $_login = 'blackman';
    private $_password = 'dark555';
    private $_sourceAddress = 'SMS Info';

    public function send($to, $message)
    {
        $url = 'http://gateway.api.sc/get/?user='.urlencode($this->_login).'&pwd='.urlencode($this->_password).'&sadr='.urlencode($this->_sourceAddress).'&dadr='.urlencode($to).'&text='.urlencode($message);
        return file_get_contents($url);
    }
}