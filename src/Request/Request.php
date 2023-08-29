<?php
namespace agregalel\router_php\Request;

class Request
{
    private $uri;
    private $method;
    private $params;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = $_REQUEST;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return QueryParams
     */
    public function getQuery() {
        $query = new QueryParams();
        foreach ($_GET as $key => $value){
            $query->$key = $value;
        }
        return $query;
    }

    public function getPost()
    {
        $post = new PostRequest();
        foreach ($_POST as $key => $value){
            $post->$key = $value;
        }
        return $post;
    }

    public function getFile()
    {
        $file = new FileRequest();
        foreach ($_FILES as $key => $value){
            $file->$key = $value;
        }
        return $file;
    }
}
