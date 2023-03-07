<?php

class TemplateEngine {
    protected $templateDir;
    protected $cacheDir;
    protected $options = array();

    public function __construct($templateDir, $cacheDir, $options = array()) {
        $this->templateDir = $templateDir;
        $this->cacheDir = $cacheDir;
        $this->options = $options;
    }

    public function render($template, $vars = array()) {
        $templateFile = $this->templateDir . '/' . $template . '.php';
        $cacheFile = $this->cacheDir . '/' . $template . '.cache';

        if (!file_exists($templateFile)) {
            throw new Exception('Template file not found: ' . $templateFile);
        }

        if ($this->options['cache'] && file_exists($cacheFile)) {
            $timestamp = filemtime($templateFile);
            if (filemtime($cacheFile) >= $timestamp) {
                return file_get_contents($cacheFile);
            }
        }

        $template = new Template($templateFile);
        foreach ($vars as $key => $value) {
            $template->$key = $value;
        }

        $output = $template->render();

        if ($this->options['cache']) {
            file_put_contents($cacheFile, $output);
        }

        include $output;
    }
}

class Template {
    protected $file;
    protected $vars = array();

    public function __construct($file) {
        $this->file = $file;
    }

    public function __get($key) {
        return $this->vars[$key];
    }

    public function __set($key, $value) {
        $this->vars[$key] = $value;
    }

    public function render() {
        extract($this->vars);
        ob_start();
        include $this->file;
        return ob_get_clean();
    }
}