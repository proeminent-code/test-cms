<?php


class Request
{
    /**
     *  Get COOKIE Super Global
     * @var array
     */
    public $cookie;

    /**
     *  Get REQUEST Super Global
     * @var array
     */
    public $request;

    /**
     *  Get FILES Super Global
     * @var array
     */
    public $files;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $this->request = ($_REQUEST);
        $this->cookie = $this->clean($_COOKIE);
        $this->files = $this->clean($_FILES);
    }

    /**
     *  Get value for server
     *
     * @param string $key
     * @return string
     */
    public function server(string $key = '') {
        return isset($_SERVER[strtoupper($key)]) ? $this->clean($_SERVER[strtoupper($key)]) : $this->clean($_SERVER);
    }

    /**
     *  Get Method
     *
     * @return string
     */
    public function getMethod() {
        return strtoupper($this->server('REQUEST_METHOD'));
    }

    /**
     *  Returns the client IP addresses.
     *
     * @return string
     */
    public function getClientIp() {
        return $this->server('REMOTE_ADDR');
    }

    /**
     *  Get url
     *
     * @return string
     */
    public function getUrl() {
        return str_replace('url=', '', $this->server('QUERY_STRING'));
    }

    /**
     * Clean Data
     *
     * @param  string|array  $data
     * @return string
     */
    public function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                // Delete key
                unset($data[$key]);

                // Set new clean key
                $data[$this->clean($key)] = $this->clean($value);
            }
        } else {
            $data = htmlspecialchars($data, ENT_COMPAT, 'UTF-8');
        }

        return $data;
    }
}


?>